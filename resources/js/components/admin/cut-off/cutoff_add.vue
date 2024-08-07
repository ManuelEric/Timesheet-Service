<script setup>
import ApiService from '@/services/ApiService'
import { rules } from '@/helper/rules'
import { showNotif } from '@/helper/notification'

const emit = defineEmits(['close', 'reload'])

const formData = ref()
const form = ref({
  start_date: null,
  end_date: null,
})

const submit = async () => {
  const { valid } = await formData.value.validate()
  if (valid) {
    try {
      const res = await ApiService.post('api/v1/payment/cut-off/create', form.value)
      if (res) {
        showNotif('success', res.message, 'bottom-end')
      }
    } catch (error) {
      const err = error?.response?.data?.errors
      showNotif('error', err, 'bottom-end')
    } finally {
      emit('close')
      emit('reload')
    }
  }
}
</script>
<template>
  <VCard title="Cut-Off Date">
    <VCardText>
      <VForm
        @submit.prevent="submit"
        ref="formData"
      >
        <VRow>
          <VCol cols="6">
            <VTextField
              v-model="form.start_date"
              type="date"
              label="Start Date"
              :rules="rules.required"
              placeholder="Activity"
            />
          </VCol>
          <VCol cols="6">
            <VTextField
              v-model="form.end_date"
              type="date"
              label="End Date"
              :rules="rules.required"
              placeholder="Activity"
            />
          </VCol>
        </VRow>
        <VDivider class="my-3" />
        <VCardActions>
          <VBtn
            color="error"
            @click="emit('close')"
          >
            <VIcon
              icon="ri-close-line"
              class="me-3"
            />
            Close
          </VBtn>
          <VSpacer />
          <VBtn
            color="success"
            type="submit"
          >
            Save
            <VIcon
              icon="ri-save-line"
              class="ms-3"
            />
          </VBtn>
        </VCardActions>
      </VForm>
    </VCardText>
  </VCard>
</template>
