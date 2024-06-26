<script setup>
import { showNotif } from '@/helper/notification'
import { rules } from '@/helper/rules'
import { verifyAuth } from '@/helper/verifyAuth'
import { router } from '@/plugins/router'
import ApiService from '@/services/ApiService'
import JwtService from '@/services/JwtService'
import UserService from '@/services/UserService'
import logo from '@images/eduall/eduall.png'
import authV1MaskDark from '@images/pages/auth-v1-mask-dark.png'
import authV1MaskLight from '@images/pages/auth-v1-mask-light.png'
import { useTheme } from 'vuetify'

// Theme
const vuetifyTheme = useTheme()
const authThemeMask = computed(() => {
  return vuetifyTheme.global.name.value === 'light' ? authV1MaskLight : authV1MaskDark
})

// Start Variable
const props = defineProps({ token: String, email: String })

const formData = ref()

const form = ref({
  token: '',
  email: '',
  password: '',
  password_confirmation: '',
})

const loading = ref(false)
const exist_email = ref(false)
const exist_password = ref(true)
const isPasswordVisible = ref(false)
// End Variable

// Start Function

// Rules Confirmation Password
const confirmPassword = [
  value => {
    if (value !== form.value.password) return 'Passwords do not match'
    return true
  },
]

// Checking Email
const checkEmail = async () => {
  const { valid } = await formData.value.validate()
  if (valid) {
    loading.value = true
    try {
      const res = await ApiService.post('api/v1/auth/email/checking', {
        email: form.value.email,
      })

      if (res) {
        exist_email.value = true
        if (res.has_password) {
          exist_password.value = true
        } else {
          exist_password.value = false
        }
      }
      loading.value = false
    } catch (error) {
      showNotif('error', 'You`re email is not found!', 'bottom-end')
      console.error(error)
      loading.value = false
    }
  }
}

// Login Process & Save Token
const checkLogin = async () => {
  const { valid } = await formData.value.validate()

  if (valid) {
    loading.value = true
    try {
      if (exist_password.value) {
        const res = await ApiService.post('api/v1/identity/generate-token', {
          email: form.value.email,
          password: form.value.password,
        })

        if (res) {
          // save token
          JwtService.saveToken(res.granted_token)
          UserService.saveUser(res)
          showNotif('success', 'You`ve successfully login.', 'bottom-end')
          setTimeout(() => {
            router.go(0)
          }, 1500)
        }
      } else {
        await createPassword()
      }
      loading.value = false
    } catch (error) {
      form.value.password = ''
      showNotif('error', 'You`re password is wrong.', 'bottom-end')
      console.error(error)
      loading.value = false
    }
  }
}

// Create New Password
const createPassword = async () => {
  try {
    const url = props.token ? 'api/v1/auth/reset-password' : 'api/v1/auth/create-password'
    const res = await ApiService.post(url, form.value)
    if (res) {
      exist_password.value = true
      await checkLogin()
    }
  } catch (error) {
    console.error(error)
  }
}

// Checking Reset Password
const checkResetPassword = () => {
  form.value.email = props.email
  form.value.token = props.token

  exist_email.value = true
  exist_password.value = false
}

// Checking Auth
const checkAuth = () => {
  const is_login = verifyAuth().isAuthenticated.value

  if (is_login) {
    router.push('/user/dashboard')
  }
}
// End Function

onMounted(() => {
  // JwtService.destroyToken()
  checkAuth()
  if (props.token) {
    checkResetPassword()
  }
})
</script>

<template>
  <!-- eslint-disable vue/no-v-html -->

  <div class="auth-wrapper d-flex align-center justify-center pa-4">
    <VCard
      class="auth-card pa-4 pt-7"
      max-width="448"
    >
      <VCardItem class="justify-center">
        <div class="d-flex justify-center mb-5">
          <img
            :src="logo"
            alt="Timesheet - EduALL"
            class="w-50 text-center"
          />
        </div>
        <VCardTitle class="font-weight-semibold text-2xl text-uppercase"> Timesheet App </VCardTitle>
      </VCardItem>

      <VCardText class="pt-2">
        <h5 class="text-h5 font-weight-semibold mb-1">Welcome to Timesheet App! 👋🏻</h5>
        <p class="mb-0">Please sign-in to your account and start the adventure</p>
      </VCardText>

      <VCardText>
        <VForm
          ref="formData"
          @submit.prevent="checkLogin"
          validate-on="input"
          fast-fail
        >
          <VRow>
            <!-- email -->
            <VCol cols="12">
              <VTextField
                v-model="form.email"
                label="Email"
                type="email"
                :disabled="exist_email"
                :rules="rules.email"
              />

              <VBtn
                block
                type="button"
                @click="checkEmail"
                class="mt-4"
                v-if="!exist_email"
                :loading="loading"
                :disabled="loading"
              >
                Check Email
              </VBtn>
            </VCol>

            <!-- exist password -->
            <VCol
              cols="12"
              v-if="exist_email && exist_password"
            >
              <VTextField
                v-model="form.password"
                label="Password"
                placeholder="············"
                :type="isPasswordVisible ? 'text' : 'password'"
                :append-inner-icon="isPasswordVisible ? 'ri-eye-off-line' : 'ri-eye-line'"
                @click:append-inner="isPasswordVisible = !isPasswordVisible"
                :rules="rules.required"
              />

              <!-- forgot password -->
              <div class="d-flex align-center justify-end flex-wrap my-2">
                <router-link
                  to="/user/forgot"
                  class="ms-2 mb-1"
                >
                  Forgot Password?
                </router-link>
              </div>

              <!-- login button -->
              <VBtn
                block
                type="submit"
                :loading="loading"
                :disabled="loading"
              >
                Login
              </VBtn>
            </VCol>

            <!-- new password -->
            <VCol
              cols="12"
              v-if="exist_email && !exist_password"
            >
              <VTextField
                v-model="form.password"
                label="New Password"
                placeholder="············"
                :type="isPasswordVisible ? 'text' : 'password'"
                :append-inner-icon="isPasswordVisible ? 'ri-eye-off-line' : 'ri-eye-line'"
                @click:append-inner="isPasswordVisible = !isPasswordVisible"
                :rules="rules.password"
                class="mb-6"
              />

              <VTextField
                v-model="form.password_confirmation"
                label="Confirmation Password"
                placeholder="············"
                :type="isPasswordVisible ? 'text' : 'password'"
                :append-inner-icon="isPasswordVisible ? 'ri-eye-off-line' : 'ri-eye-line'"
                @click:append-inner="isPasswordVisible = !isPasswordVisible"
                class="mb-6"
                :rules="confirmPassword"
              />

              <!-- login button -->
              <VBtn
                block
                type="submit"
                :loading="loading"
                :disabled="loading"
              >
                Create New Password
              </VBtn>
            </VCol>
          </VRow>
        </VForm>
      </VCardText>
    </VCard>
  </div>
</template>

<style lang="scss">
@use '@core-scss/pages/page-auth.scss';
</style>
