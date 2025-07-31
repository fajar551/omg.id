window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
// window.axios.defaults.withCredentials = true;

let csrfToken = document.head.querySelector('meta[name="csrf-token"]');
let authToken = document.head.querySelector('meta[name="auth"]');

if (csrfToken) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = csrfToken.content;
} else {
    console.warn('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

if (authToken) {
    window.axios.defaults.headers.common['Authorization'] = `Bearer ${authToken.content}`;
} else {
    console.warn('Token not defined!');
}