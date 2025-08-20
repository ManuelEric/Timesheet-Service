import { showNotif } from '@/helper/notification'
import axios from 'axios'
import JwtService from './JwtService'
import UserService from './UserService'


const token = JwtService.getToken()

const apiClient = axios.create({
  baseURL: import.meta.env.VITE_API_BASE_URL, // Ganti dengan URL API yang sesuai
  headers: {
    'Content-Type': 'application/json',

    // Jika diperlukan, Anda bisa menambahkan header lain di sini
  },
})

// Interceptor untuk menangani setiap melakukan permintaan
apiClient.interceptors.request.use(
  config => {
    if (token) {
      config.headers.Authorization = `Bearer ${token}`
    }
    
    return config
  },
  error => {
    return Promise.reject(error)
  },
)

// Interceptor untuk menangani setiap menerima permintaan
apiClient.interceptors.response.use(
  response => {
    return response
  },
  error => {

    const status = error.response?.status;

    switch (status) {
      case 401:
        UserService.destroyUser();
        JwtService.destroyToken();
        showNotif('error','Error 401: Unauthorized. Please log in first.','bottom-end')

        router.go(0)
        break;
      case 403:
        showNotif('error','Error 403: Access denied.','bottom-end');
        break;
      case 404:
        showNotif('error','Error 404: Resource not found.','bottom-end');
        break;
      case 502:
        showNotif('error','Error 502: Bad gateway. Your internet connection might be unstable.','bottom-end');
        break;
    }

    return Promise.reject(error)
  },
)

export default {
  // Contoh method untuk mengambil data
  async get(url, data={}) {
    try {
      const response = await apiClient.get(url, data)
      
      return response.data
    } catch (error) {
      return Promise.reject(error);
    }
  },

  // Contoh method untuk mengirim data
  async post(url, data) {
    try {
      const response = await apiClient.post(url, data)
      
      return response.data
    } catch (error) {
      return Promise.reject(error);
    }
  },

  // Contoh method untuk mengirim data PATCH
  async patch(url, data) {
    try {
      const response = await apiClient.patch(url, data)
      
      return response.data
    } catch (error) {
      return Promise.reject(error);
    }
  },

  // Contoh method untuk mengirim data PUT
  async put(url, data) {
    try {
      const response = await apiClient.put(url, data)
      
      return response.data
    } catch (error) {
      return Promise.reject(error);
    }
  },

  async delete(url) {
    try {
      const response = await apiClient.delete(url)
      
      return response.data
    } catch (error) {
      return Promise.reject(error);
    }
  },

  // Tambahkan method lain sesuai kebutuhan Anda
}
