/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

import Echo from 'laravel-echo';

window.Pusher = require('pusher-js');

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: process.env.MIX_PUSHER_APP_KEY,
    wsHost: process.env.MIX_PUSHER_APP_HOST,
    wsPort: process.env.MIX_PUSHER_APP_PORT,
    wssPort: process.env.MIX_PUSHER_APP_WSSPORT,
    forceTLS: process.env.MIX_PUSHER_APP_SCHEME === "https",
    encrypted: process.env.MIX_PUSHER_APP_SCHEME === "https",
    // disableStats: true,
    enabledTransports: ['ws', 'wss'],
});
