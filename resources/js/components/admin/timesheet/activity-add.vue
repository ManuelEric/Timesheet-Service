<script setup>
import { showNotif } from '@/helper/notification'
import { rules } from '@/helper/rules'
import ApiService from '@/services/ApiService'

const props = defineProps({ id: String })
const emit = defineEmits(['close'])

const closeDialogContent = () => {
  emit('close')
}

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
    try {
      const res = await ApiService.post('api/v1/timesheet/' + props.id + '/activity', form.value)
      console.log(res)
      if (res) {
        showNotif('success', res.message, 'bottom-end')
        closeDialogContent()
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
      @click="closeDialogContent"
    />

    <VCardText>
      <VForm
        @submit.prevent="submit"
        ref="formData"
        validate-on="input"
      >
        <VRow>
          <VCol cols="12">
            <VTextField
              v-model="form.activity"
              label="Activity Name"
              placeholder="Activity"
              :rules="rules.required"
            />
          </VCol>
          <VCol cols="12">
            <VTextarea
              v-model="form.description"
              label="Description"
              placeholder="Description"
              :rules="rules.required"
            />
          </VCol>
          <VCol
            md="6"
            cols="12"
          >
            <VTextField
              type="date"
              v-model="form.date"
              label="Date"
              placeholder="Date"
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
              placeholder="Start Time"
              :rules="rules.required"
              @change="form.start_date = form.date + ' ' + form.start_time + ':00'"
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
              @change="form.end_date = form.date + ' ' + form.end_time + ':00'"
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
              :rules="rules.url"
            />
          </VCol>
        </VRow>
        <VDivider class="my-3" />
        <VCardActions>
          <VBtn
            type="button"
            color="error"
            @click="closeDialogContent"
          >
            <VIcon
              icon="ri-close-line"
              class="me-3"
            />
            Close
          </VBtn>
          <VSpacer />
          <VBtn
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

<style lang="scss"></style>
