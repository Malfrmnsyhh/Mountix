import axios from 'axios';

const apiClient = axios.create({
  baseURL: '/api/v1',
  timeout: 10000,
  headers: {
    'Content-Type': 'application/json',
    'Accept': 'application/json'
  }
});

// Interceptor: Attach JWT token to every request
apiClient.interceptors.request.use((config) => {
  const token = localStorage.getItem('auth_token');
  if (token) {
    config.headers.Authorization = `Bearer ${token}`;
  }
  return config;
});

// Interceptor: Handle 401 errors (token expired)
apiClient.interceptors.response.use(
  (response) => response,
  async (error) => {
    if (error.response?.status === 401) {
      // Clear token and redirect to login if not already there
      if (!window.location.pathname.includes('/login')) {
        localStorage.removeItem('auth_token');
        localStorage.removeItem('user');

        // Fix: bersihkan session cookie server-side agar tidak terjadi
        // auth desynchronization loop antara JWT (localStorage) dan Blade session.
        try {
          const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
          await fetch('/logout', {
            method: 'POST',
            headers: {
              'X-CSRF-TOKEN': csrfToken,
              'Accept': 'application/json',
              'Content-Type': 'application/json'
            }
          });
        } catch (e) {
          // Abaikan error logout, tetap alihkan ke login
          console.warn('Gagal sinkronisasi server logout:', e);
        }

        window.location.href = '/login';
      }
    }
    return Promise.reject(error);
  }
);

export default apiClient;
