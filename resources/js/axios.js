import axios from 'axios';

// Laravel default CSRF cookie: XSRF-TOKEN
// Laravel backend ke liye base URL set karo (agar zarurat ho to)
const axiosInstance = axios.create({
    baseURL: '/', // Agar API prefix hai, use '/api' set karo
    headers: {
        'X-Requested-With': 'XMLHttpRequest',
    },
    withCredentials: true, // CSRF cookie aur session ke liye zaruri
});

// CSRF cookie fetch karna (optional, Laravel me automatically set hoti hai)
// agar zarurat ho to uncomment karo
/*
axiosInstance.get('/sanctum/csrf-cookie').then(response => {
    console.log('CSRF cookie set');
});
*/

export default axiosInstance;