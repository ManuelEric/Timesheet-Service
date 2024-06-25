<script setup>
import { showNotif } from '@/helper/notification'
import { rules } from '@/helper/rules'
import { verifyAuth } from '@/helper/verifyAuth'
import { router } from '@/plugins/router'
import ApiService from '@/services/ApiService'
import JwtService from '@/services/JwtService'
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
const props = defineProps({ id: String })

const formData = ref()

const form = ref({
  email: '',
  password: '',
  password_confirmation: '',
})

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
    } catch (error) {
      c
      console.error(error)
    }
  }
}

// Login Process & Save Token
const checkLogin = async () => {
  const { valid } = await formData.value.validate()

  if (valid) {
    try {
      if (exist_password.value) {
        const res = await ApiService.post('api/v1/identity/generate-token', {
          email: form.value.email,
          password: form.value.password,
        })

        if (res) {
          // save token

          JwtService.saveToken(res.granted_token)
          showNotif('success', 'You`ve successfully log-in.', 'bottom-end')
          setTimeout(() => {
            router.go(0)
          }, 1500)
        } else {
          form.value.password = ''
          showNotif('error', 'You`re password is wrong.', 'bottom-end')
        }
      } else {
        createPassword()
      }
    } catch (error) {
      console.error(error)
    }
  }
}

// Create New Password
const createPassword = async () => {
  try {
    const res = await ApiService.post('api/v1/auth/create-password', form.value)
    if (res) {
      checkLogin()
    }
  } catch (error) {
    console.error(error)
  }
}

// Checking Token
const checkToken = () => {}

// Checking Token
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

  if (props.id) {
    checkToken()
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
