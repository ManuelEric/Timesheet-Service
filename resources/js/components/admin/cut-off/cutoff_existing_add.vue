<script setup>
import { showNotif } from '@/helper/notification'
import { rules } from '@/helper/rules'
import ApiService from '@/services/ApiService'

const props = defineProps({ id: Array })
const emit = defineEmits(['close', 'reload'])

const formData = ref()
const form = ref({
  activity_id: props.id,
  start_date: null,
  end_date: null,
})

const submit = async () => {
  console.log(form)

  const { valid } = await formData.value.validate()
  if (valid) {
    try {
      const res = await ApiService.post('api/v1/payment/cut-off/add', form.value)

      if (res) {
        log
        showNotif('success', res.message, 'bottom-end')
      }
    } catch (error) {
      if (error?.response?.data?.errors) {
        const validationErrors = error.response.data.errors
        let errorMessage = 'Validation errors:'

        // Merge validation errors
        for (const key in validationErrors) {
          if (validationErrors.hasOwnProperty(key)) {
            errorMessage += `\n${key}: ${validationErrors[key].join(', ')}`
          }
        }
        showNotif('error', errorMessage, 'bottom-end')
      }
    } finally {
      emit('reload')
      emit('close')
    }
  }
}
</script>

<template>
  <VCard title="Add to Cut-Off">
    <VCardText>
      {{ form }}
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
              density="compact"
              :rules="rules.required"
            ></VTextField>
          </VCol>
          <VCol cols="6">
            <VTextField
              v-model="form.end_date"
              type="date"
              label="End Date"
              density="compact"
              :rules="rules.required"
            ></VTextField>
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
