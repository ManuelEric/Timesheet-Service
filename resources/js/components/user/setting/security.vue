<script setup>
const formData = ref(null)
const isCurrentPasswordVisible = ref(false)
const isNewPasswordVisible = ref(false)
const isConfirmPasswordVisible = ref(false)

// Rules Confirmation Password
const confirmPassword = [
  value => {
    if (value !== form.value.new_password) return 'Passwords do not match'
    return true
  },
]

import { showLoading, showNotif } from '@/helper/notification'
import { rules } from '@/helper/rules'
import { router } from '@/plugins/router'
import ApiService from '@/services/ApiService'

const passwordRequirements = [
  'Minimum 8 characters long - the more, the better',
  'At least one lowercase character',
  'At least one number, symbol, or whitespace character',
]

const form = ref({
  current_password: null,
  new_password: null,
  new_password_confirmation: null,
})

const submit = async () => {
  const { valid } = await formData.value.validate()
  if (valid) {
    showLoading()
    try {
      const res = await ApiService.patch('api/v1/auth/change-password', form.value)

      if (res) {
        showNotif('success', res.message, 'bottom-end')
        setTimeout(() => {
          router.go(0)
        }, 3000)
      }
    } catch (error) {
      if (typeof error.response.data.errors == 'string') {
        showNotif('error', error.response.data.errors, 'bottom-end')
      } else {
        showNotif('error', error.message, 'bottom-end')
      }
    } finally {
      formData.value.reset()
    }
  }
}
</script>

<template>
  <VRow>
    <!-- SECTION: Change Password -->
    <VCol cols="12">
      <VCard title="Change Password">
        <VForm
          @submit.prevent="submit"
          ref="formData"
        >
          <VCardText>
            <!-- 👉 Current Password -->
            <VRow class="mb-1">
              <VCol
                cols="12"
                md="4"
              >
                <!-- 👉 current password -->
                <VTextField
                  v-model="form.current_password"
                  :type="isCurrentPasswordVisible ? 'text' : 'password'"
                  :append-inner-icon="isCurrentPasswordVisible ? 'ri-eye-off-line' : 'ri-eye-line'"
                  autocomplete="on"
                  label="Current Password"
                  placeholder="············"
                  @click:append-inner="isCurrentPasswordVisible = !isCurrentPasswordVisible"
                  :rules="rules.required"
                />
              </VCol>

              <!-- 👉 New Password -->
              <VCol
                cols="12"
                md="4"
              >
                <!-- 👉 new password -->
                <VTextField
                  v-model="form.new_password"
                  :type="isNewPasswordVisible ? 'text' : 'password'"
                  :append-inner-icon="isNewPasswordVisible ? 'ri-eye-off-line' : 'ri-eye-line'"
                  label="New Password"
                  autocomplete="on"
                  placeholder="············"
                  @click:append-inner="isNewPasswordVisible = !isNewPasswordVisible"
                  :rules="rules.password"
                />
              </VCol>

              <VCol
                cols="12"
                md="4"
              >
                <!-- 👉 confirm password -->
                <VTextField
                  v-model="form.new_password_confirmation"
                  :type="isConfirmPasswordVisible ? 'text' : 'password'"
                  :append-inner-icon="isConfirmPasswordVisible ? 'ri-eye-off-line' : 'ri-eye-line'"
                  autocomplete="on"
                  label="Confirm New Password"
                  placeholder="············"
                  @click:append-inner="isConfirmPasswordVisible = !isConfirmPasswordVisible"
                  :rules="confirmPassword"
                />
              </VCol>
            </VRow>
          </VCardText>

          <!-- 👉 Password Requirements -->
          <VCardText>
            <p class="text-base font-weight-medium">Password Requirements:</p>

            <ul class="d-flex flex-column gap-y-3">
              <li
                v-for="item in passwordRequirements"
                :key="item"
                class="d-flex"
              >
                <div>
                  <VIcon
                    size="7"
                    icon="ri-checkbox-blank-circle-fill"
                    class="me-3"
                  />
                </div>
                <span class="font-weight-medium">{{ item }}</span>
              </li>
            </ul>
          </VCardText>

          <!-- 👉 Action Buttons -->
          <VCardText class="d-flex flex-wrap gap-4 mt-4 justify-center">
            <VBtn type="submit">Save changes</VBtn>

            <VBtn
              type="reset"
              color="secondary"
              variant="outlined"
            >
              Reset
            </VBtn>
          </VCardText>
        </VForm>
      </VCard>
    </VCol>
    <!-- !SECTION -->
  </VRow>
</template>
