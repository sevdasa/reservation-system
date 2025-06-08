// echo.ts

import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

// Declare the echo instance at the top level
let echo = null;
if (typeof window !== 'undefined') {
  (window as any).Pusher = Pusher;

  // Initialize Echo if running on the client-side
  echo = new Echo({
    broadcaster: 'reverb',
    key: import.meta.env.VITE_REVERB_APP_KEY,
    wsHost: import.meta.env.VITE_REVERB_HOST || window.location.hostname,
    wsPort: Number(import.meta.env.VITE_REVERB_PORT) || 6001,
    forceTLS: false,
    encrypted: false,
    disableStats: true,
    enabledTransports: ['ws', 'wss'],
  });
}

// Export echo outside the conditional block
export { echo };
