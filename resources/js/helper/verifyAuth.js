import ApiService from "@/services/ApiService"
import JwtService from "@/services/JwtService"
import UserService from "@/services/UserService"
import { ref } from "vue"

export const verifyAuth = () => {
  const isAuthenticated = ref(!!JwtService.getToken())

  const checkMe = async () => {
    if (JwtService.getToken()) {
      try {
        const data = await ApiService.get('check')

        UserService.saveUser(data.data)
      } catch (error) {
        UserService.destroyUser()
        JwtService.destroyToken()
        console.error(error)
      }
    }
  }

  return {
    isAuthenticated,
    checkMe,
  }
}
