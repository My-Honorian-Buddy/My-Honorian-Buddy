import Echo from 'laravel-echo';

import Pusher from 'pusher-js';
window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'reverb',
    key: import.meta.env.VITE_REVERB_APP_KEY,
    wsHost: import.meta.env.VITE_REVERB_HOST,
    wsPort: import.meta.env.VITE_REVERB_PORT ?? 80,
    wssPort: import.meta.env.VITE_REVERB_PORT ?? 443,
    forceTLS: (import.meta.env.VITE_REVERB_SCHEME ?? 'https') === 'https',
    enabledTransports: ['ws', 'wss'],
    authEndpoint: '/broadcasting/auth',
    auth: {
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
        }
    }
});

function createToastContainer() {
    if (document.getElementById('realtime-toast-container')) {
        return document.getElementById('realtime-toast-container');
    }
    
    const container = document.createElement('div');
    container.id = 'realtime-toast-container';
    container.style.cssText = `
        position: fixed;
        top: 80px;
        right: 20px;
        z-index: 9999;
        display: flex;
        flex-direction: column;
        gap: 10px;
        max-width: 400px;
    `;
    document.body.appendChild(container);
    return container;
}

function getNotificationIcon(type) {
    const icons = {
        'SessionCompletionRequest': '✅',
        'Tutor Request Accepted': '🎉',
        'Tutor Request Rejected': '❌',
        'IncomingCall': '📞',
        'CallAccepted': '✅',
        'CallDeclined': '📵',
        'CallCancelled': '🚫',
        'CompleteSession': '🎓',
        'SessionReminder': '⏰',
        'SessionDropped': '🗑️',
        'SessionDropRequestDenied': '❌',
        'BanRequest': '⚠️',
        'BanReportSubmitted': '📋',
        'PointsUpdated': '⭐',
        'RewardRedemption': '🎁'
    };
    return icons[type] || '📬';
}

function getNotificationTitle(type) {
    const titles = {
        'SessionCompletionRequest': 'Session Completion Request',
        'Tutor Request Accepted': 'Request Accepted!',
        'Tutor Request Rejected': 'Request Declined',
        'IncomingCall': 'Incoming Call',
        'CallAccepted': 'Call Accepted',
        'CallDeclined': 'Call Declined',
        'CallCancelled': 'Call Cancelled',
        'CompleteSession': 'Session Completed',
        'SessionReminder': 'Session Starting Soon',
        'SessionDropped': 'Session Dropped',
        'SessionDropRequestDenied': 'Drop Request Denied',
        'BanRequest': 'Ban Request',
        'BanReportSubmitted': 'Report Submitted',
        'PointsUpdated': 'Points Updated',
        'RewardRedemption': 'Reward Redemption'
    };
    return titles[type] || 'New Notification';
}

function showRealtimeToast(type, message, actionUrl = null) {
    const toastContainer = createToastContainer();
    
    const toast = document.createElement('div');
    toast.className = 'realtime-toast';
    toast.style.cssText = `
        background: white;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        padding: 16px;
        min-width: 300px;
        display: flex;
        align-items: start;
        gap: 12px;
        border-left: 4px solid #3b82f6;
        animation: slideIn 0.3s ease-out;
    `;
    
    toast.innerHTML = `
        <div style="font-size: 24px; flex-shrink: 0;">${getNotificationIcon(type)}</div>
        <div style="flex: 1;">
            <div style="font-weight: 600; color: #1f2937; margin-bottom: 4px;">${getNotificationTitle(type)}</div>
            <div style="font-size: 14px; color: #6b7280;">${message}</div>
            ${actionUrl ? `<a href="${actionUrl}" style="display: inline-block; margin-top: 8px; color: #3b82f6; text-decoration: none; font-size: 14px; font-weight: 500;">View Details →</a>` : ''}
        </div>
        <button onclick="this.parentElement.remove()" style="background: none; border: none; font-size: 24px; color: #9ca3af; cursor: pointer; flex-shrink: 0; padding: 0; line-height: 1;">×</button>
    `;
    
    toastContainer.appendChild(toast);
    
    // Play notification sound
    playNotificationSound();
    
    // Auto-remove after 5 seconds
    setTimeout(() => {
        toast.style.animation = 'slideOut 0.3s ease-in';
        setTimeout(() => toast.remove(), 300);
    }, 5000);
}

function playNotificationSound() {
    try {
        const sound = new Audio('/sounds/chatify/new-message-sound.mp3');
        sound.volume = 0.5;
        sound.play().catch(e => console.log('Sound play prevented:', e));
    } catch (e) {
        console.log('Could not play sound:', e);
    }
}

// Update notification badge in nav-bar
function updateNotificationBadge() {
    fetch('/user-notifications')
        .then(response => response.json())
        .then(data => {
            const unreadCount = data.notifications?.filter(n => n.read_at === null).length || 0;
            let badge = document.getElementById('notification-badge');
            
            if (unreadCount > 0) {
                if (!badge) {
                    // Create badge if it doesn't exist
                    const bellContainer = document.querySelector('.notification-bell-container');
                    if (bellContainer) {
                        badge = document.createElement('span');
                        badge.id = 'notification-badge';
                        badge.className = 'absolute -top-1 -right-1 bg-red-600 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center border-2 border-white';
                        bellContainer.appendChild(badge);
                    }
                }
                
                if (badge) {
                    badge.textContent = unreadCount > 9 ? '9+' : unreadCount;
                    badge.classList.remove('hidden');
                    badge.style.display = 'flex';
                }
            } else {
                if (badge) {
                    badge.classList.add('hidden');
                    badge.style.display = 'none';
                }
            }
            
            console.log('📊 Badge updated - Unread count:', unreadCount);
        })
        .catch(err => console.error('Failed to update notification badge:', err));
}

// Add CSS animations
const style = document.createElement('style');
style.textContent = `
    @keyframes slideIn {
        from {
            transform: translateX(400px);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    
    @keyframes slideOut {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(400px);
            opacity: 0;
        }
    }
    
    .realtime-toast:hover {
        box-shadow: 0 6px 16px rgba(0,0,0,0.2);
    }
    
    .realtime-toast button:hover {
        color: #4b5563 !important;
    }
`;
document.head.appendChild(style);

window.showRealtimeToast = showRealtimeToast;
window.updateNotificationBadge = updateNotificationBadge;

// Function to reload workspace content
function reloadWorkspaceContent() {
    // Check if we're on the workspace page
    if (window.location.pathname === '/workspace') {
        console.log('🔄 Reloading workspace content...');
        window.location.reload();
    }
}

setTimeout(() => {
    const currentUserId = document.querySelector('meta[name="user-id"]')?.content;
    
    console.log('Initializing Echo listeners for user:', currentUserId);
    
    if (currentUserId) {
        console.log('Subscribing to private channel: user.' + currentUserId);
        
        window.Echo.private(`user.${currentUserId}`)
            .listen('NewNotification', (e) => {
                console.log('🔔 Real-time notification received:', e);
                
                // Update notification badge immediately
                updateNotificationBadge();
                
                fetch('/user-notifications') 
                    .then(response => response.json())
                    .then(data => {
                        if (data.notifications && data.notifications.length > 0) {
                            
                            for (let notif of data.notifications) {
                                const notifInfo = JSON.parse(notif.notif_info);
                                
                                console.log('📝 Checking notification:', {
                                    type: notifInfo.NotifType,
                                    to: notif.to,
                                    currentUser: currentUserId,
                                    match: notif.to == currentUserId,
                                    readAt: notif.read_at
                                });
                                
                                
                                if (notifInfo.NotifType === 'IncomingCall' && 
                                    notif.to == currentUserId && 
                                    notif.read_at === null) {
                                    
                                    // Only show incoming calls created within the last 30 seconds
                                    const notificationTime = new Date(notif.created_at).getTime();
                                    const currentTime = new Date().getTime();
                                    const timeDiff = (currentTime - notificationTime) / 1000; // in seconds
                                    
                                    if (timeDiff <= 30) {
                                        console.log('✅ Showing incoming call popup');
                                        if (typeof showIncomingCall === 'function') {
                                            showIncomingCall(
                                                notif.id,
                                                notifInfo.caller_name,
                                                notifInfo.room_name
                                            );
                                        }
                                    } else {
                                        console.log('⏰ Call too old, marking as read');
                                        fetch(`/notifications/${notif.id}/read`, {
                                            method: 'POST',
                                            headers: {
                                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                            }
                                        }).catch(err => console.error('Failed to mark old call as read:', err));
                                    }
                                    break;
                                }
                                
                                
                                if (notifInfo.NotifType === 'CallDeclined' && 
                                    notif.to == currentUserId && 
                                    notif.read_at === null) {
                                    
                                    console.log('❌ Call declined by:', notifInfo.decliner_name);
                                    
                                    if (typeof window.showCallDeclinedNotification === 'function') {
                                        window.showCallDeclinedNotification(notifInfo.decliner_name);
                                    }
                                    
                                    break;
                                }
                                
                                // Handle call accepted notification
                                if (notifInfo.NotifType === 'CallAccepted' && 
                                    notif.to == currentUserId && 
                                    notif.read_at === null) {
                                    
                                    console.log('✅ Call accepted by:', notifInfo.accepter_name);
                                    
                                    setTimeout(() => {
                                        if (typeof window.handleCallAccepted === 'function') {
                                            window.handleCallAccepted(notifInfo.room_name);
                                        } else {
                                            window.location.href = `/video-call/${notifInfo.room_name}`;
                                        }
                                    }, 1500);
                                    
                                    break;
                                }
                                
                                // Handle call cancelled notification
                                if (notifInfo.NotifType === 'CallCancelled' && 
                                    notif.to == currentUserId && 
                                    notif.read_at === null) {
                                    
                                    console.log('🚫 Call cancelled by:', notifInfo.caller_name);
                                    
                                    if (typeof hideIncomingCall === 'function') {
                                        hideIncomingCall();
                                    }
                                    
                                    break;
                                }
                                
                                // Handle tutor request accepted
                                if (notifInfo.NotifType === 'Tutor Request Accepted' && 
                                    notif.to == currentUserId && 
                                    notif.read_at === null) {
                                    
                                    console.log('🎉 Tutor accepted request from:', notifInfo.tutor_name);
                                    
                                    // Reload workspace after 2 seconds to show new session
                                    setTimeout(() => {
                                        reloadWorkspaceContent();
                                    }, 2000);
                                    
                                    break;
                                }
                                
                                // Handle tutor request rejected
                                if (notifInfo.NotifType === 'Tutor Request Rejected' && 
                                    notif.to == currentUserId && 
                                    notif.read_at === null) {
                                    
                                    console.log('❌ Tutor rejected request from:', notifInfo.tutor_name);
                                    
                                    // Reload workspace after 2 seconds
                                    setTimeout(() => {
                                        reloadWorkspaceContent();
                                    }, 2000);
                                    
                                    break;
                                }
                                
                                // Handle session completion request
                                if (notifInfo.NotifType === 'SessionCompletionRequest' && 
                                    notif.to == currentUserId && 
                                    notif.read_at === null) {
                                    
                                    console.log('✅ Session completion request received');
                                    
                                    // Reload workspace after 2 seconds to show updated session
                                    setTimeout(() => {
                                        reloadWorkspaceContent();
                                    }, 2000);
                                    
                                    break;
                                }
                                
                                // Handle session reminder
                                if (notifInfo.NotifType === 'SessionReminder' && 
                                    notif.to == currentUserId && 
                                    notif.read_at === null) {
                                    
                                    console.log('⏰ Session starting soon');
                                    
                                    break;
                                }
                                
                                // Handle session dropped
                                if (notifInfo.NotifType === 'SessionDropped' && 
                                    notif.to == currentUserId && 
                                    notif.read_at === null) {
                                    
                                    console.log('🗑️ Session dropped by:', notifInfo.dropped_by);
                                    
                                    // Reload workspace after 2 seconds to show session removed
                                    setTimeout(() => {
                                        reloadWorkspaceContent();
                                    }, 2000);
                                    
                                    break;
                                }
                                
                                // Handle session drop request denied
                                if (notifInfo.NotifType === 'SessionDropRequestDenied' && 
                                    notif.to == currentUserId && 
                                    notif.read_at === null) {
                                    
                                    console.log('❌ Session drop request denied');
                                    
                                    // Reload workspace after 2 seconds
                                    setTimeout(() => {
                                        reloadWorkspaceContent();
                                    }, 2000);
                                    
                                    break;
                                }
                                
                                // Handle ban request
                                if (notifInfo.NotifType === 'BanRequest' && 
                                    notif.to == currentUserId && 
                                    notif.read_at === null) {
                                    
                                    console.log('⚠️ Ban request received');
                                    
                                    // Show toast notification
                                    showRealtimeToast(
                                        'BanRequest',
                                        `Admin has requested to ban your session. Reason: ${notifInfo.ban_reason || 'No reason provided'}`,
                                        null
                                    );
                                    
                                    break;
                                }
                                
                                // Handle ban report submitted (for admin)
                                if (notifInfo.NotifType === 'BanReportSubmitted' && 
                                    notif.to == currentUserId && 
                                    notif.read_at === null) {
                                    
                                    console.log('📋 Ban report submitted by tutor');
                                    
                                    // Show toast notification
                                    showRealtimeToast(
                                        'BanReportSubmitted',
                                        `${notifInfo.tutor_name || 'Tutor'} has submitted a ban report for review.`,
                                        '/admin/booked-sessions'
                                    );
                                    
                                    break;
                                }
                                
                                // No need for generic handling - notifications appear in navbar
                                if (notif.to == currentUserId && notif.read_at === null) {
                                    console.log('📬 Generic notification received:', notifInfo.NotifType);
                                    break;
                                }
                            }
                        }
                    })
                    .catch(err => console.error('Failed to fetch notifications:', err));
            })
            .error((error) => {
                console.error('Error subscribing to private channel user.' + currentUserId + ':', error);
            });
    } else {
        console.warn('No user ID found - cannot subscribe to private channel');
    }
}, 100);

window.Echo.channel('new-notification')
    .listen('NewNotification', (e) => {
        console.log('Public channel notification received:', e);
    });
