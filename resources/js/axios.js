import axios from 'axios';

// Laravel default CSRF cookie: XSRF-TOKEN
// Laravel backend ke liye base URL set karo (agar zarurat ho to)
const axiosInstance = axios.create({
    baseURL: '/api',
    headers: {
        'X-Requested-With': 'XMLHttpRequest',
    },
});

// Attach token from localStorage if exists
axiosInstance.interceptors.request.use(config => {
    const token = localStorage.getItem('auth_token');
    if (token) {
        config.headers.Authorization = `Bearer ${token}`;
    }
    return config;
});

export default axiosInstance;