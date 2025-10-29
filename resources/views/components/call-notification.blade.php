<div id="incoming-call-popup" class="hidden fixed inset-0 bg-black/70 z-[9999] flex items-center justify-center backdrop-blur-sm">
    <div class="bg-gradient-to-br from-gray-800 to-gray-900 rounded-2xl shadow-2xl p-8 max-w-md w-full mx-4 animate-slideUp">
        
        
        <div class="flex justify-center mb-6">
            <div class="relative">
                <div class="absolute inset-0 bg-green-500/30 rounded-full animate-ping"></div>
                <div class="relative bg-green-500 rounded-full p-5 shadow-lg">
                    <svg class="w-12 h-12 text-white animate-pulse" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M20.01 15.38c-1.23 0-2.42-.2-3.53-.56a.977.977 0 00-1.01.24l-1.57 1.97c-2.83-1.35-5.48-3.9-6.89-6.83l1.95-1.66c.27-.28.35-.67.24-1.02-.37-1.11-.56-2.3-.56-3.53 0-.54-.45-.99-.99-.99H4.19C3.65 3 3 3.24 3 3.99 3 13.28 10.73 21 20.01 21c.71 0 .99-.63.99-1.18v-3.45c0-.54-.45-.99-.99-.99z"/>
                    </svg>
                </div>
            </div>
        </div>

        
        <div class="text-center mb-8">
            <h2 class="text-2xl font-bold text-white mb-2">Incoming Call</h2>
            <p class="text-xl text-gray-300 mb-1" id="caller-name">Unknown</p>
            <p class="text-sm text-gray-400">Video Call</p>
        </div>

        
        <div class="flex justify-center gap-1 mb-8">
            <span class="w-1 h-6 bg-green-400 rounded-full animate-pulse" style="animation-delay: 0s;"></span>
            <span class="w-1 h-10 bg-green-400 rounded-full animate-pulse" style="animation-delay: 0.1s;"></span>
            <span class="w-1 h-8 bg-green-400 rounded-full animate-pulse" style="animation-delay: 0.2s;"></span>
            <span class="w-1 h-12 bg-green-400 rounded-full animate-pulse" style="animation-delay: 0.3s;"></span>
            <span class="w-1 h-8 bg-green-400 rounded-full animate-pulse" style="animation-delay: 0.4s;"></span>
            <span class="w-1 h-10 bg-green-400 rounded-full animate-pulse" style="animation-delay: 0.5s;"></span>
            <span class="w-1 h-6 bg-green-400 rounded-full animate-pulse" style="animation-delay: 0.6s;"></span>
            <span class="w-1 h-6 bg-green-400 rounded-full animate-pulse" style="animation-delay: 0.7s;"></span>
            <span class="w-1 h-6 bg-green-400 rounded-full animate-pulse" style="animation-delay: 0.8s;"></span>
        </div>

        
        <div class="flex gap-4 justify-center">
            <button id="decline-call-btn" class="bg-red-500 hover:bg-red-600 text-white rounded-full p-5 transition-all transform hover:scale-110 shadow-lg">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
            
            <button id="accept-call-btn" class="bg-green-500 hover:bg-green-600 text-white rounded-full p-5 transition-all transform hover:scale-110 shadow-lg animate-bounce">
                <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M20.01 15.38c-1.23 0-2.42-.2-3.53-.56a.977.977 0 00-1.01.24l-1.57 1.97c-2.83-1.35-5.48-3.9-6.89-6.83l1.95-1.66c.27-.28.35-.67.24-1.02-.37-1.11-.56-2.3-.56-3.53 0-.54-.45-.99-.99-.99H4.19C3.65 3 3 3.24 3 3.99 3 13.28 10.73 21 20.01 21c.71 0 .99-.63.99-1.18v-3.45c0-.54-.45-.99-.99-.99z"/>
                </svg>
            </button>
        </div>
    </div>
</div>

<!-- Call Declined/Missed Notification -->
<div id="call-declined-popup" class="hidden fixed inset-0 bg-black/70 z-[9999] flex items-center justify-center backdrop-blur-sm">
    <div class="bg-gradient-to-br from-red-900 to-gray-900 rounded-2xl shadow-2xl p-8 max-w-md w-full mx-4 animate-slideUp">
        
        <div class="flex justify-center mb-6">
            <div class="relative">
                <div class="bg-red-500 rounded-full p-5 shadow-lg">
                    <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </div>
            </div>
        </div>

        
        <div class="text-center mb-8">
            <h2 class="text-2xl font-bold text-white mb-2">Call Declined</h2>
            <p class="text-xl text-gray-300 mb-1" id="decliner-name">Unknown</p>
            <p class="text-sm text-gray-400">declined your call</p>
        </div>

        
        <div class="flex justify-center">
            <button id="close-declined-notification" class="bg-primary hover:bg-accent2 text-accent2 hover:text-primary px-8 py-3 rounded-lg font-bold transition-all border-2 border-black">
                OK
            </button>
        </div>
    </div>
</div>

<!-- Waiting for Call Response -->
<div id="waiting-call-popup" class="hidden fixed inset-0 bg-black/70 z-[9999] flex items-center justify-center backdrop-blur-sm">
    <div class="bg-gradient-to-br from-blue-900 to-gray-900 rounded-2xl shadow-2xl p-8 max-w-md w-full mx-4 animate-slideUp">
        
        <div class="flex justify-center mb-6">
            <div class="relative">
                <div class="absolute inset-0 bg-blue-500/30 rounded-full animate-ping"></div>
                <div class="relative bg-blue-500 rounded-full p-5 shadow-lg">
                    <svg class="w-12 h-12 text-white animate-pulse" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M20.01 15.38c-1.23 0-2.42-.2-3.53-.56a.977.977 0 00-1.01.24l-1.57 1.97c-2.83-1.35-5.48-3.9-6.89-6.83l1.95-1.66c.27-.28.35-.67.24-1.02-.37-1.11-.56-2.3-.56-3.53 0-.54-.45-.99-.99-.99H4.19C3.65 3 3 3.24 3 3.99 3 13.28 10.73 21 20.01 21c.71 0 .99-.63.99-1.18v-3.45c0-.54-.45-.99-.99-.99z"/>
                    </svg>
                </div>
            </div>
        </div>

        
        <div class="text-center mb-8">
            <h2 class="text-2xl font-bold text-white mb-2">Calling...</h2>
            <p class="text-xl text-gray-300 mb-1" id="calling-name">Unknown</p>
            <p class="text-sm text-gray-400">Waiting for response</p>
        </div>

        
        <div class="flex justify-center gap-1 mb-8">
            <span class="w-1 h-6 bg-blue-400 rounded-full animate-pulse" style="animation-delay: 0s;"></span>
            <span class="w-1 h-10 bg-blue-400 rounded-full animate-pulse" style="animation-delay: 0.1s;"></span>
            <span class="w-1 h-8 bg-blue-400 rounded-full animate-pulse" style="animation-delay: 0.2s;"></span>
            <span class="w-1 h-12 bg-blue-400 rounded-full animate-pulse" style="animation-delay: 0.3s;"></span>
            <span class="w-1 h-8 bg-blue-400 rounded-full animate-pulse" style="animation-delay: 0.4s;"></span>
            <span class="w-1 h-10 bg-blue-400 rounded-full animate-pulse" style="animation-delay: 0.5s;"></span>
            <span class="w-1 h-6 bg-blue-400 rounded-full animate-pulse" style="animation-delay: 0.6s;"></span>
        </div>

        
        <div class="flex justify-center">
            <button id="cancel-waiting-call-btn" class="bg-red-500 hover:bg-red-600 text-white px-6 py-3 rounded-lg font-bold transition-all">
                Cancel Call
            </button>
        </div>
    </div>
</div>

<audio id="ringtone" loop>
    <source src="{{ asset('sounds/ringtone-incoming.mp3') }}" type="audio/mpeg">
    <source src="{{ asset('sounds/chatify/new-message-sound.mp3') }}" type="audio/mpeg">
</audio>

<style>
@keyframes slideUp {
    from {
        opacity: 0;
        transform: translateY(50px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
.animate-slideUp {
    animation: slideUp 0.3s ease-out;
}
</style>

<script>
let currentCallNotification = null;

function showIncomingCall(notifId, callerName, roomName) {
    console.log('🔔 showIncomingCall() called with:', { notifId, callerName, roomName });
    console.log('📍 Called from:', new Error().stack);
    
    currentCallNotification = { notifId, callerName, roomName };
    
    document.getElementById('caller-name').textContent = callerName;
    document.getElementById('incoming-call-popup').classList.remove('hidden');
    
    
    const ringtone = document.getElementById('ringtone');
    ringtone.currentTime = 0;
    ringtone.play().catch(e => console.log('Ringtone play failed:', e));
}

function hideIncomingCall() {
    const popup = document.getElementById('incoming-call-popup');
    const ringtone = document.getElementById('ringtone');
    if (popup) popup.classList.add('hidden');
    if (ringtone) {
        ringtone.pause();
        ringtone.currentTime = 0;
    }
    currentCallNotification = null;
}

// New function to show call declined notification
function showCallDeclinedNotification(declinerName) {
    console.log('📵 Call declined by:', declinerName);
    
    // Hide waiting popup if showing
    hideWaitingForCall();
    
    // Stop calling sound if playing
    if (window.currentOutgoingCall && window.currentOutgoingCall.callingSound) {
        window.currentOutgoingCall.callingSound.pause();
        window.currentOutgoingCall.callingSound.currentTime = 0;
    }
    
    document.getElementById('decliner-name').textContent = declinerName;
    document.getElementById('call-declined-popup').classList.remove('hidden');
    
    // Auto-hide after 5 seconds
    setTimeout(() => {
        hideCallDeclinedNotification();
    }, 5000);
}

function hideCallDeclinedNotification() {
    const popup = document.getElementById('call-declined-popup');
    if (popup) popup.classList.add('hidden');
}

// New function to show waiting for call response
function showWaitingForCall(receiverName, callId, roomName) {
    console.log('⏳ Waiting for call response from:', receiverName);
    
    window.currentWaitingCall = { callId, roomName, receiverName };
    
    document.getElementById('calling-name').textContent = receiverName;
    document.getElementById('waiting-call-popup').classList.remove('hidden');
}

function hideWaitingForCall() {
    const popup = document.getElementById('waiting-call-popup');
    const ringtone = document.getElementById('ringtone');
    
    // Hide popup
    if (popup) popup.classList.add('hidden');
    
    // Stop ringtone
    if (ringtone) {
        ringtone.pause();
        ringtone.currentTime = 0;
    }
    
    // Stop calling sound if exists
    if (window.currentOutgoingCall && window.currentOutgoingCall.callingSound) {
        window.currentOutgoingCall.callingSound.pause();
        window.currentOutgoingCall.callingSound.currentTime = 0;
    }
    
    window.currentWaitingCall = null;
}

// Function to handle call accepted - redirect to room
function handleCallAccepted(roomName) {
    console.log('✅ Call accepted! Redirecting to room:', roomName);
    hideWaitingForCall();
    window.location.href = `/video-call/${roomName}`;
}

// Make functions globally accessible
window.showCallDeclinedNotification = showCallDeclinedNotification;
window.showWaitingForCall = showWaitingForCall;
window.hideWaitingForCall = hideWaitingForCall;
window.handleCallAccepted = handleCallAccepted;


function initCallButtons() {
    const acceptBtn = document.getElementById('accept-call-btn');
    const declineBtn = document.getElementById('decline-call-btn');
    const closeDeclinedBtn = document.getElementById('close-declined-notification');
    const cancelWaitingBtn = document.getElementById('cancel-waiting-call-btn');
    
    if (acceptBtn && !acceptBtn.dataset.listenerAttached) {
        acceptBtn.dataset.listenerAttached = 'true';
        acceptBtn.addEventListener('click', function() {
            console.log('Accept button clicked, currentCallNotification:', currentCallNotification);
            if (!currentCallNotification) {
                console.error('No current call notification');
                return;
            }
            
            
            const notifId = currentCallNotification.notifId;
            const roomName = currentCallNotification.roomName;
            
            hideIncomingCall();
            
            fetch('{{ route("video.call.respond") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    notification_id: notifId,
                    action: 'accept'
                })
            })
            .then(r => r.json())
            .then(data => {
                console.log('Accept response:', data);
                if (data.success && data.redirect) {
                    window.location.href = data.redirect;
                } else if (roomName) {
                    
                    window.location.href = `/video-call/${roomName}`;
                }
            })
            .catch(err => {
                console.error('Accept call error:', err);
                
                if (roomName) {
                    window.location.href = `/video-call/${roomName}`;
                }
            });
        });
    }
    
    if (declineBtn && !declineBtn.dataset.listenerAttached) {
        declineBtn.dataset.listenerAttached = 'true';
        declineBtn.addEventListener('click', function() {
            console.log('Decline button clicked');
            if (!currentCallNotification) {
                console.error('No current call notification');
                return;
            }
            
            
            const notifId = currentCallNotification.notifId;
            
            hideIncomingCall();
            
            fetch('{{ route("video.call.respond") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    notification_id: notifId,
                    action: 'decline'
                })
            })
            .catch(err => console.error('Decline call error:', err));
        });
    }
    
    if (closeDeclinedBtn && !closeDeclinedBtn.dataset.listenerAttached) {
        closeDeclinedBtn.dataset.listenerAttached = 'true';
        closeDeclinedBtn.addEventListener('click', hideCallDeclinedNotification);
    }
    
    if (cancelWaitingBtn && !cancelWaitingBtn.dataset.listenerAttached) {
        cancelWaitingBtn.dataset.listenerAttached = 'true';
        cancelWaitingBtn.addEventListener('click', function() {
            console.log('Cancel waiting call clicked');
            
            // Send cancel notification to receiver
            if (window.currentOutgoingCall) {
                const callData = window.currentOutgoingCall;
                
                fetch('{{ route("video.call.cancel") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        call_id: callData.callId,
                        receiver_id: callData.receiverId || window.currentReceiverId
                    })
                })
                .then(r => r.json())
                .then(data => {
                    console.log('Call cancelled:', data);
                })
                .catch(err => console.error('Cancel call error:', err));
                
                // Stop calling sound
                if (callData.callingSound) {
                    callData.callingSound.pause();
                    callData.callingSound.currentTime = 0;
                }
            }
            
            hideWaitingForCall();
        });
    }
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initCallButtons);
} else {
    initCallButtons();
}
</script>

