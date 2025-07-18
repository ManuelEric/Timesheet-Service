<script setup>
import { showNotif } from '@/helper/notification'
import { rules } from '@/helper/rules'
import ApiService from '@/services/ApiService'
import moment from 'moment'

const props = defineProps({ id: String })
const emit = defineEmits(['close', 'reload'])

const loading = ref(false)
const formData = ref()
const form = ref({
  activity: null,
  description: null,
  date: null,
  start_time: null,
  end_time: null,
  start_date: null,
  end_date: null,
  meeting_link: null,
})

const submit = async () => {
  const { valid } = await formData.value.validate()
  if (valid) {
    loading.value = true
    try {
      const res = await ApiService.post('api/v1/timesheet/' + props.id + '/activity', form.value)
      // console.log(res)
      if (res) {
        showNotif('success', res.message, 'bottom-end')
      }
    } catch (error) {
      // console.log(error)
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
      } else {
        showNotif('error', error.response.data.message, 'bottom-end')
      }
    } finally {
      loading.value = false
      emit('reload')
      emit('close')
    }
  }
}
</script>

<template>
  <!-- Dialog Content -->
  <VCard title="New Activity">
    <DialogCloseBtn
      variant="text"
      size="default"
      @click="emit('close')"
    />

    <VCardText>
      <VForm
        @submit.prevent="submit"
        ref="formData"
        validate-on="input"
      >
        <VRow>
          <VCol
            cols="12"
            class="d-none"
          >
            <VTextField
              v-model="form.activity"
              label="Activity Name"
              placeholder="Activity"
              :loading="loading"
              :disabled="loading"
              density="compact"
            />
          </VCol>
          <VCol cols="12">
            <VTextarea
              v-model="form.description"
              label="Meeting Discussion"
              placeholder="Meeting Discussion"
              :loading="loading"
              :disabled="loading"
              :rules="rules.required"
              density="compact"
            />
          </VCol>
          <VCol
            md="6"
            cols="12"
          >
            <VDateInput
              v-model="form.date"
              label="Date"
              placeholder="Select Date"
              prepend-icon=""
              :loading="loading"
              :disabled="loading"
              :rules="rules.required"
              variant="outlined"
              density="compact"
            />
          </VCol>
          <VCol
            md="3"
            cols="6"
          >
            <VTextField
              type="time"
              v-model="form.start_time"
              label="Start Time"
              placeholder="Start Time"
              :rules="rules.required"
              class="mb-3"
              :loading="loading"
              :disabled="loading"
              density="compact"
              @change="form.start_date = moment(form.date).format('YYYY-MM-DD') + ' ' + form.start_time + ':00'"
            />
          </VCol>
          <VCol
            md="3"
            cols="6"
          >
            <VTextField
              type="time"
              v-model="form.end_time"
              label="End Time"
              placeholder="End Time"
              :loading="loading"
              :disabled="loading"
              density="compact"
              @change="form.end_date = moment(form.date).format('YYYY-MM-DD') + ' ' + form.end_time + ':00'"
            />
          </VCol>
          <VCol
            md="12"
            cols="12"
          >
            <VTextField
              type="text"
              v-model="form.meeting_link"
              label="Meeting Link"
              placeholder="Meeting Link"
              density="compact"
              :loading="loading"
              :disabled="loading"
            />
          </VCol>
        </VRow>
        <VCardActions class="mt-5">
          <VBtn
            type="button"
            color="error"
            :loading="loading"
            :disabled="loading"
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
            :loading="loading"
            :disabled="loading"
            type="submit"
            color="success"
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

<style scope>
.v-field__field {
  grid-area: field !important;
}
</style>
