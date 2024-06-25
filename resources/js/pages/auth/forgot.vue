<script setup>
import { router } from '@/plugins/router'
import { rules } from '@/helper/rules'
import { showNotif } from '@/helper/notification'
import ApiService from '@/services/ApiService'
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
const formData = ref()
const form = ref({
  email: '',
})

const loading = ref(false)
const time = ref(0)
const isDisabled = ref(false)
// End Variable

// Start Function
const forgotPassword = async () => {
  const { valid } = await formData.value.validate()
  if (valid) {
    loading.value = true
    try {
      const res = await ApiService.post('api/v1/auth/forgot-password', form.value)
      console.log(res)
      if (res) {
        var currentDate = new Date()
        var newDate = new Date(currentDate.getTime() + 20 * 1000)

        //   Save in localStorage
        localStorage.setItem('new_date', Math.floor(newDate.getTime() / 1000))

        // diff new date - current date
        time.value = Math.floor(newDate.getTime() / 1000) - Math.floor(currentDate.getTime() / 1000)

        isDisabled.value = true
      }
      loading.value = false
    } catch (error) {
      console.log(error)
      showNotif('error', 'You`re email is not found.', 'bottom-end')
      loading.value = false
    }
  }
}

const endCountDown = () => {
  time.value = 0
  isDisabled.value = false
}
// End Function

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
        <VForm
          @submit.prevent="forgotPassword"
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
                :disabled="isDisabled"
                :rules="rules.email"
              />

              <!-- login button -->
              <VBtn
                block
                type="submit"
                :loading="loading"
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

            <!-- login instead -->
            <VCol
              cols="12"
              class="text-center text-base"
            >
              <VDivider class="mb-3" />
              <span>I've Remembered</span>
              <RouterLink
                class="text-primary ms-2"
                to="login"
              >
                Sign in Now
              </RouterLink>
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
