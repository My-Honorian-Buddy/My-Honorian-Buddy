import axios from 'axios';
window.axios = axios;
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;
window.Echo = new Echo({ 
    broadcaster: 'reverb',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    wsHost: 'random-subdomain.liveshare.vsengsaas.visualstudio.com',
    wsPort: import.meta.env.VITE_PUSHER_PORT ?? 8080,
    wssPort: import.meta.env.VITE_PUSHER_PORT ?? 8080,
    forceTLS:false,
    enabledTransports: ['ws','wss'],
});

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * import.meta.env.VITE_PUSHER_HOST ?? window.location.hostname
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allow your team to quickly build robust real-time web applications.
 */

import './echo';
