require('./bootstrap');
// require('./echo');

// JQuery
window.$ = window.jQuery = require('jquery');
window.Popper = require('popper.js').default;

// Sweet Alert
window.Swal = require('sweetalert2');

/*
// Axios
window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
// window.axios.defaults.withCredentials = true;
let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}
*/