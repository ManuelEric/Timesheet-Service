import axios from 'axios'
import JwtService from './JwtService'


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
    if (error?.response?.status === 401) {
      // Hapus token dari tempat penyimpanan Anda
      UserService.destroyUser();
      JwtService.destroyToken();
      // console.log('Token expired or invalid. Please log in again.');
      router.go(0)
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
