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

// Interceptor untuk menangani setiap permintaan
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

export default {
  // Contoh method untuk mengambil data
  async get(url) {
    try {
      const response = await apiClient.get(url)
      
      return response.data
    } catch (error) {
      throw new Error(`Error fetching data: ${error}`)
    }
  },

  // Contoh method untuk mengirim data
  async post(url, data) {
    try {
      const response = await apiClient.post(url, data)
      
      return response.data
    } catch (error) {
      throw new Error(`Error sending data: ${error}`)
    }
  },

  // Contoh method untuk mengirim data
  async patch(url, data) {
    try {
      const response = await apiClient.patch(url, data)
      
      return response.data
    } catch (error) {
      throw new Error(`Error sending data: ${error}`)
    }
  },

  // Tambahkan method lain sesuai kebutuhan Anda
}
