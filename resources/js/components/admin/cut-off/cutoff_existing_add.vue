<script setup>
import { showNotif } from '@/helper/notification'
import { rules } from '@/helper/rules'
import ApiService from '@/services/ApiService'
import moment from 'moment'

const props = defineProps({ id: Array })
const emit = defineEmits(['close', 'reload', 'reset'])

const formData = ref()
const form = ref({
  activity_id: props.id,
  start_date: null,
  end_date: null,
})
const cut_off_date = ref(null)

const handleDate = () => {
  form.value.start_date = moment(cut_off_date.value[0]).format('YYYY-MM-DD')
  form.value.end_date = moment(cut_off_date.value[cut_off_date.value.length - 1]).format('YYYY-MM-DD')
}

const submit = async () => {
  const { valid } = await formData.value.validate()
  if (valid) {
    try {
      const res = await ApiService.post('api/v1/payment/cut-off/add', form.value)

      if (res) {
        // console.log(res)
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
      emit('reset')
    }
  }
}
</script>

<template>
  <VCard title="Add to Cut-Off">
    <VCardText>
      <VForm
        @submit.prevent="submit"
        ref="formData"
      >
        <VRow>
          <VCol cols="12">
            <VDateInput
              v-model="cut_off_date"
              label="Start - End Date"
              variant="solo"
              :rules="rules.required"
              multiple="range"
              @update:modelValue="handleDate"
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
