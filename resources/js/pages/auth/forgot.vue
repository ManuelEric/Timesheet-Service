<script setup>
import { router } from '@/plugins/router'
import logo from '@images/eduall/eduall.png'
import authV1MaskDark from '@images/pages/auth-v1-mask-dark.png'
import authV1MaskLight from '@images/pages/auth-v1-mask-light.png'
import { useTheme } from 'vuetify'

const form = ref({
  email: '',
  password: '',
})

const time = ref(0)
const isDisabled = ref(false)

const vuetifyTheme = useTheme()

const authThemeMask = computed(() => {
  return vuetifyTheme.global.name.value === 'light' ? authV1MaskLight : authV1MaskDark
})

const forgotPassword = () => {
  var currentDate = new Date()
  var newDate = new Date(currentDate.getTime() + 20 * 1000)

  //   Save in localStorage
  localStorage.setItem('new_date', Math.floor(newDate.getTime() / 1000))

  // diff new date - current date
  time.value = Math.floor(newDate.getTime() / 1000) - Math.floor(currentDate.getTime() / 1000)

  isDisabled.value = true
}

const endCountDown = () => {
  time.value = 0
  isDisabled.value = false
}

onMounted(() => {
  if (localStorage.getItem('new_date')) {
    var newDate = localStorage.getItem('new_date')
    var newTime = newDate - Math.floor(new Date().getTime() / 1000)
    time.value = newTime
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

      <VCardText class="pt-2 text-center">
        <h5 class="text-h5 font-weight-semibold mb-1">Forgot Password</h5>
        <p class="mb-0">Please enter your email address to receive the verification link.</p>
      </VCardText>

      <VCardText>
        <VForm @submit.prevent="forgotPassword">
          <VRow>
            <VCol cols="12">
              <!-- email  -->
              <VTextField
                v-model="form.email"
                label="Email"
                type="email"
                class="mb-3"
                :disabled="isDisabled"
              />

              <!-- login button -->
              <VBtn
                block
                type="submit"
                :disabled="isDisabled"
              >
                Send
              </VBtn>

              <div
                class="text-center mt-4"
                v-if="isDisabled"
              >
                <vue-countdown
                  :time="time * 1000"
                  v-slot="{ seconds }"
                  @end="endCountDown"
                >
                  Please wait to resend verification link: {{ seconds }}
                </vue-countdown>
              </div>
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
