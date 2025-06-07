// import Echo from 'laravel-echo'
// import Pusher from 'pusher-js'
// import { configureEcho } from "@laravel/echo-vue";


// export const echo= ()=> {
//     configureEcho({
//         broadcaster: 'reverb',
//         forceTLS: false,
//     })
// }

// // resources/js/echo.ts

import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

(window as any).Pusher = Pusher;


export const echo = new Echo({
  broadcaster: 'reverb',
  key: import.meta.env.VITE_REVERB_APP_KEY,
  wsHost: import.meta.env.VITE_REVERB_HOST || window.location.hostname,
  wsPort: Number(import.meta.env.VITE_REVERB_PORT) || 6001,
  forceTLS: false,
  encrypted: false,
  disableStats: true,
  enabledTransports: ['ws', 'wss'],

});
