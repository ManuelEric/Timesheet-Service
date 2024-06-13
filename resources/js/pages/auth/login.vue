<script setup>
import { router } from '@/plugins/router'
import logo from '@images/eduall/eduall.png'
import authV1MaskDark from '@images/pages/auth-v1-mask-dark.png'
import authV1MaskLight from '@images/pages/auth-v1-mask-light.png'
import { useTheme } from 'vuetify'

const form = ref({
  email: '',
  password: '',
  confirm_password: '',
})

const exist_email = ref(false)
const exist_password = ref(true)
const isPasswordVisible = ref(false)

const vuetifyTheme = useTheme()

const authThemeMask = computed(() => {
  return vuetifyTheme.global.name.value === 'light' ? authV1MaskLight : authV1MaskDark
})

const checkEmail = () => {
  exist_email.value = true
}

const checkLogin = () => {
  router.push('/user/dashboard')
}
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
        <VForm @submit.prevent="checkLogin">
          <VRow>
            <!-- email -->
            <VCol cols="12">
              <VTextField
                v-model="form.email"
                label="Email"
                type="email"
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
              />

              <!-- remember me checkbox -->
              <div class="d-flex align-center justify-end flex-wrap my-2">
                <a
                  class="ms-2 mb-1"
                  href="javascript:void(0)"
                >
                  Forgot Password?
                </a>
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
                class="mb-6"
              />

              <VTextField
                v-model="form.confirm_password"
                label="Confirmation Password"
                placeholder="············"
                :type="isPasswordVisible ? 'text' : 'password'"
                :append-inner-icon="isPasswordVisible ? 'ri-eye-off-line' : 'ri-eye-line'"
                @click:append-inner="isPasswordVisible = !isPasswordVisible"
                class="mb-6"
              />

              <!-- login button -->
              <VBtn
                block
                type="submit"
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
