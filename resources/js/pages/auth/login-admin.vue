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

const vuetifyTheme = useTheme()

const authThemeMask = computed(() => {
  return vuetifyTheme.global.name.value === 'light' ? authV1MaskLight : authV1MaskDark
})

// Start Variable
const formData = ref()
const form = ref({
  email: '',
  password: '',
})

const loading = ref(false)
const isPasswordVisible = ref(false)
// End Variable

// Start Function
const checkLogin = async () => {
  const { valid } = await formData.value.validate()
  if (valid) {
    try {
      loading.value = true
      const res = await ApiService.post('api/v1/auth/token', form.value)
      if (res) {
        // save token
        JwtService.saveToken(res.granted_token)
        UserService.saveUser(res)
        showNotif('success', 'You`ve successfully login.', 'bottom-end')
        setTimeout(() => {
          router.go('/admin/dashboard')
        }, 1500)
      }
      loading.value = false
    } catch (error) {
      if (typeof error.response.data.errors == 'object') {
        showNotif('error', error.response?.data?.errors?.email, 'bottom-end')
      } else {
        showNotif('error', error.response?.data?.errors, 'bottom-end')
      }
      loading.value = false
      console.error(error)
    }
  }
}

// Checking Auth
const checkAuth = () => {
  const is_login = verifyAuth().isAuthenticated.value

  if (is_login) {
    // router.go('/admin/dashboard')
    router.push('/admin/dashboard')
  }
}
// End Function

onMounted(() => {
  // JwtService.destroyToken()
  checkAuth()
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

      <VCardText class="pt-2 text-center">
        <h5 class="text-h5 font-weight-semibold mb-1">Welcome to Timesheet App! 👋🏻</h5>
        <p class="mb-0">Please sign-in to your account and start the adventure</p>
      </VCardText>

      <VCardText>
        <VForm
          @submit.prevent="checkLogin"
          ref="formData"
          validate-on="input"
          fast-fail
        >
          <VRow>
            <VCol cols="12">
              <!-- email  -->
              <VTextField
                v-model="form.email"
                label="Email"
                type="email"
                class="mb-3"
                :rules="rules.email"
              />

              <!-- password -->
              <VTextField
                v-model="form.password"
                label="Password"
                placeholder="············"
                :type="isPasswordVisible ? 'text' : 'password'"
                :append-inner-icon="isPasswordVisible ? 'ri-eye-off-line' : 'ri-eye-line'"
                @click:append-inner="isPasswordVisible = !isPasswordVisible"
                class="mb-5"
                :rules="rules.required"
              />

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
          </VRow>
        </VForm>
      </VCardText>
    </VCard>
  </div>
</template>

<style lang="scss">
@use '@core-scss/pages/page-auth.scss';
</style>
