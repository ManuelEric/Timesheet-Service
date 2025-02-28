<script setup>
import { showNotif } from '@/helper/notification'
import { rules } from '@/helper/rules'
import ApiService from '@/services/ApiService'
import moment from 'moment'

const loading = ref(false)
const formData = ref()
const prop = defineProps({ timesheet_id: Number, activity: String })
const emit = defineEmits(['close', 'reload'])
const updateReload = inject('updateReload')

const form = ref({
  activity: prop?.activity.activity,
  description: prop?.activity.description,
  date: new Date(prop?.activity.start_date),
  start_time: prop?.activity.start_time,
  end_time: prop?.activity.end_time,
  start_date: moment(prop?.activity.start_date).format('YYYY-MM-DD') + ' ' + prop?.activity.start_time + ':00',
  end_date:
    prop?.activity.end_time != 0
      ? moment(prop?.activity.start_date).format('YYYY-MM-DD') + ' ' + prop?.activity.end_time + ':00'
      : null,
  meeting_link: prop?.activity.meeting_link,
})

const submit = async () => {
  const { valid } = await formData.value.validate()
  if (valid) {
    loading.value = true
    try {
      form.value.start_date = moment(form.value.date).format('YYYY-MM-DD') + ' ' + form.value.start_time + ':00'
      form.value.end_date = moment(form.value.date).format('YYYY-MM-DD') + ' ' + form.value.end_time + ':00'

      const res = await ApiService.put(
        'api/v1/timesheet/' + prop.timesheet_id + '/activity/' + prop.activity.id,
        form.value,
      )

      if (res) {
        // console.log(res)'
        showNotif('success', res.message, 'bottom-end')
        emit('reload')
      }
    } catch (error) {
      if (error?.response?.data?.errors) {
        const validationErrors = error.response.data.errors
        let errorMessage = 'Validation errors:'

        // Merge validation errors
        if (typeof validationErrors != 'string') {
          for (const key in validationErrors) {
            if (validationErrors.hasOwnProperty(key)) {
              errorMessage += `\n${key}: ${validationErrors[key].join(', ')}`
            }
          }
          showNotif('error', errorMessage, 'bottom-end')
        } else {
          showNotif('error', error.response.data.errors, 'bottom-end')
        }
      }
    } finally {
      loading.value = false
      emit('close')
      setTimeout(() => {
        updateReload(true)
      }, 3000)
    }
  }
}
</script>

<template>
  <!-- Dialog Content -->
  <VCard title="Edit Activity">
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
              variant="solo"
              :disabled="loading"
              :loading="loading"
            />
          </VCol>
          <VCol cols="12">
            <VTextarea
              v-model="form.description"
              label="Meeting Discussion"
              :rules="rules.required"
              placeholder="Meeting Discussion"
              variant="solo"
              :disabled="loading"
              :loading="loading"
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
              variant="solo"
              :disabled="loading"
              :loading="loading"
              :rules="rules.required"
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
              :rules="rules.required"
              placeholder="Start Time"
              variant="solo"
              :disabled="loading"
              :loading="loading"
              @change="
                form.start_date = moment(prop?.activity.date).format('YYYY-MM-DD') + ' ' + form.start_time + ':00'
              "
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
              variant="solo"
              :disabled="loading"
              :loading="loading"
              @change="form.end_date = moment(prop?.activity.date).format('YYYY-MM-DD') + ' ' + form.end_time + ':00'"
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
              variant="solo"
              :disabled="loading"
              :loading="loading"
            />
          </VCol>
        </VRow>

        <VCardActions class="mt-5">
          <VBtn
            color="error"
            :disabled="loading"
            :loading="loading"
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
            :disabled="loading"
            :loading="loading"
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

<style lang="scss"></style>
