import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.axios.defaults.withCredentials = true; // Enable sending cookies
window.axios.defaults.headers.common['Accept'] = 'application/json';
