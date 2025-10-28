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
                                    
                                    
                                    alert(notifInfo.decliner_name + ' declined your call.');
                                    
                                    
                                    fetch('/user-notifications', {
                                        method: 'GET'
                                    }).catch(err => console.error('Failed to refresh notifications:', err));
                                    
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
