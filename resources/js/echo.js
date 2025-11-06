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

setTimeout(() => {
    const currentUserId = document.querySelector('meta[name="user-id"]')?.content;
    
    console.log('Initializing Echo listeners for user:', currentUserId);
    
    if (currentUserId) {
        console.log('Subscribing to private channel: user.' + currentUserId);
        
        window.Echo.private(`user.${currentUserId}`)
            .listen('NewNotification', (e) => {
                console.log('Private notification received on user.' + currentUserId + ':', e);
                
                
                fetch('/user-notifications') 
                    .then(response => response.json())
                    .then(data => {
                        if (data.notifications && data.notifications.length > 0) {
                            
                            for (let notif of data.notifications) {
                                const notifInfo = JSON.parse(notif.notif_info);
                                
                                console.log(' Checking notification:', {
                                    type: notifInfo.NotifType,
                                    to: notif.to,
                                    currentUser: currentUserId,
                                    match: notif.to == currentUserId,
                                    readAt: notif.read_at
                                });
                                
                                
                                if (notifInfo.NotifType === 'IncomingCall' && 
                                    notif.to == currentUserId && 
                                    notif.read_at === null) {
                                    
                                    console.log('CONDITIONS MET - Showing incoming call popup for user', currentUserId);
                                    if (typeof showIncomingCall === 'function') {
                                        showIncomingCall(
                                            notif.id,
                                            notifInfo.caller_name,
                                            notifInfo.room_name
                                        );
                                    } else {
                                        console.error('showIncomingCall function not found');
                                    }
                                    break;
                                }
                                
                                
                                if (notifInfo.NotifType === 'CallDeclined' && 
                                    notif.to == currentUserId && 
                                    notif.read_at === null) {
                                    
                                    console.log('Call declined by:', notifInfo.decliner_name);
                                    
                                    // Show call declined notification popup
                                    if (typeof window.showCallDeclinedNotification === 'function') {
                                        window.showCallDeclinedNotification(notifInfo.decliner_name);
                                    } else {
                                        // Fallback to alert if function not available
                                        alert(notifInfo.decliner_name + ' declined your call.');
                                    }
                                    
                                    // Refresh notifications
                                    fetch('/user-notifications', {
                                        method: 'GET'
                                    }).catch(err => console.error('Failed to refresh notifications:', err));
                                    
                                    break;
                                }
                                
                                // Handle call accepted notification
                                if (notifInfo.NotifType === 'CallAccepted' && 
                                    notif.to == currentUserId && 
                                    notif.read_at === null) {
                                    
                                    console.log('Call accepted by:', notifInfo.accepter_name);
                                    
                                    // Redirect caller to video room
                                    if (typeof window.handleCallAccepted === 'function') {
                                        window.handleCallAccepted(notifInfo.room_name);
                                    } else {
                                        // Fallback direct redirect
                                        window.location.href = `/video-call/${notifInfo.room_name}`;
                                    }
                                    
                                    break;
                                }
                                
                                // Handle call cancelled notification (for receiver)
                                if (notifInfo.NotifType === 'CallCancelled' && 
                                    notif.to == currentUserId && 
                                    notif.read_at === null) {
                                    
                                    console.log('Call cancelled by caller:', notifInfo.caller_name);
                                    
                                    // Hide incoming call popup if showing
                                    if (typeof hideIncomingCall === 'function') {
                                        hideIncomingCall();
                                    }
                                    
                                    break;
                                }
                                
                                // Handle tutor request accepted notification (for student)
                                if (notifInfo.NotifType === 'Tutor Request Accepted' && 
                                    notif.to == currentUserId && 
                                    notif.read_at === null) {
                                    
                                    console.log('✅ Tutor accepted request from:', notifInfo.tutor_name);
                                    
                                    
                                    
                                    // Reload page to show updated session
                                    window.location.reload();
                                    
                                    break;
                                }
                                
                                // Handle session drop request notification
                                if (notifInfo.NotifType === 'SessionDropRequested' && 
                                    notif.to == currentUserId && 
                                    notif.read_at === null) {
                                    
                                    console.log('📩 Drop session request received from:', notifInfo.requester_name);
                                    
                                    // Refresh notification bell to show the new request
                                    if (typeof window.fetchUserNotifications === 'function') {
                                        window.fetchUserNotifications();
                                    }
                                    
                                    // Play notification sound if available
                                    if (typeof window.playNotificationSound === 'function') {
                                        window.playNotificationSound();
                                    }
                                    
                                    break;
                                }
                                
                                // Handle session dropped notification (confirmed)
                                if (notifInfo.NotifType === 'SessionDropped' && 
                                    notif.to == currentUserId && 
                                    notif.read_at === null) {
                                    
                                    console.log('✅ Session dropped by:', notifInfo.dropped_by);
                                    
                                    // Refresh notification bell and reload page
                                    if (typeof window.fetchUserNotifications === 'function') {
                                        window.fetchUserNotifications();
                                    }
                                    
                                    // Reload page to update session display
                                    setTimeout(() => {
                                        window.location.reload();
                                    }, 1000);
                                    
                                    break;
                                }
                                
                                // Handle session drop request denied notification
                                if (notifInfo.NotifType === 'SessionDropRequestDenied' && 
                                    notif.to == currentUserId && 
                                    notif.read_at === null) {
                                    
                                    console.log('❌ Drop request denied by:', notifInfo.denied_by);
                                    
                                    // Refresh notification bell
                                    if (typeof window.fetchUserNotifications === 'function') {
                                        window.fetchUserNotifications();
                                    }
                                    
                                    // Play notification sound if available
                                    if (typeof window.playNotificationSound === 'function') {
                                        window.playNotificationSound();
                                    }
                                    
                                    break;
                                }
                                
                                // Handle session updated notification (automatic update after call)
                                if (notifInfo.NotifType === 'SessionUpdated' && 
                                    notif.to == currentUserId && 
                                    notif.read_at === null) {
                                    
                                    console.log('✅ Session automatically updated:', {
                                        num_session: notifInfo.num_session,
                                        total_session: notifInfo.total_session
                                    });
                                    
                                    // Refresh notification bell
                                    if (typeof window.fetchUserNotifications === 'function') {
                                        window.fetchUserNotifications();
                                    }
                                    
                                    // Reload page to show updated session count
                                    setTimeout(() => {
                                        console.log('🔄 Reloading page to reflect session update...');
                                        window.location.reload();
                                    }, 1500);
                                    
                                    break;
                                }
                            }
                        }
                    })
                    .catch(err => console.error('Error fetching notifications:', err));
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
        console.log('Public channel notification received (should not trigger call popup):', e);ly
    });
