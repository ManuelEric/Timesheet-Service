<script setup>
import { showNotif } from '@/helper/notification'
import { rules } from '@/helper/rules'
import ApiService from '@/services/ApiService'
import moment from 'moment'

const emit = defineEmits(['close', 'reload'])

const formData = ref()
const form = ref({
  start_date: null,
  end_date: null,
})
const cut_off_date = ref(null)

const handleDate = () => {
  form.value.start_date = moment(cut_off_date.value[0]).format('YYYY-MM-DD')
  form.value.end_date = moment(cut_off_date.value[cut_off_date.value.length - 1]).format('YYYY-MM-DD')
  console.log(form.value)
}

const submit = async () => {
  const { valid } = await formData.value.validate()
  if (valid) {
    try {
      const res = await ApiService.post('api/v1/payment/cut-off/create', form.value)
      if (res) {
        showNotif('success', res.message, 'bottom-end')
      }
    } catch (error) {
      var err = error?.response?.data?.errors
      if (error?.response?.data?.errors?.end_date) {
        err = error?.response?.data?.errors?.end_date[0]
      }

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
          <VCol cols="12">
            <VDateInput
              v-model="cut_off_date"
              variant="solo"
              label="Start - End Date"
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
