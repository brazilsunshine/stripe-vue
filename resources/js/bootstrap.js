import _ from 'lodash';
window._ = _;

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

import axios from 'axios';
window.axios = axios; // This line assigns the imported Axios library to the axios property of the window object. This makes Axios available globally in the browser.
window.axios.defaults.withCredentials = true; // This enables sending cookies and authentication headers in cross-origin requests.
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'; // This line sets a default header for all Axios requests. It adds the X-Requested-With header with the value XMLHttpRequest. This is often used by servers to identify AJAX requests.

let token = document.head.querySelector('meta[name="csrf-token"]'); // This line looks for a meta tag in the document's head with a name attribute of csrf-token. This is often used by servers to verify that the request is coming from a trusted source.

if (token) { // If token has a value, it sets a default header for all Axios requests. It adds the X-CSRF-TOKEN header with the value of the content attribute of the token meta tag.
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
} // if the token variable does not contain a value. It logs an error message to the console with a link to the Laravel documentation on how to add a CSRF token.

// Overall, this code is setting up some default configurations for Axios requests and adding a CSRF token
// if it exists on the page. It's often used in web applications built with Laravel, a popular PHP framework.



/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo';

// import Pusher from 'pusher-js';
// window.Pusher = Pusher;

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: import.meta.env.VITE_PUSHER_APP_KEY,
//     wsHost: import.meta.env.VITE_PUSHER_HOST ?? `ws-${import.meta.env.VITE_PUSHER_APP_CLUSTER}.pusher.com`,
//     wsPort: import.meta.env.VITE_PUSHER_PORT ?? 80,
//     wssPort: import.meta.env.VITE_PUSHER_PORT ?? 443,
//     forceTLS: (import.meta.env.VITE_PUSHER_SCHEME ?? 'https') === 'https',
//     enabledTransports: ['ws', 'wss'],
// });
