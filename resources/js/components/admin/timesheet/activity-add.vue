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

const resetForm = () => {
  form.value = {
    activity: null,
    description: null,
    date: null,
    start_time: null,
    end_time: null,
    start_date: null,
    end_date: null,
    meeting_link: null,
  }
}

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
      showNotif('error', error.response.data.errors, 'bottom-end')
    } finally {
      resetForm()
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
              variant="solo"
            />
          </VCol>
          <VCol cols="12">
            <VTextarea
              v-model="form.description"
              label="Meeting Discussion"
              placeholder="Meeting Discussion"
              variant="solo"
              :loading="loading"
              :disabled="loading"
              :rules="rules.required"
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
              :loading="loading"
              :disabled="loading"
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
              variant="solo"
              class="mb-3"
              :loading="loading"
              :disabled="loading"
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
              variant="solo"
              :loading="loading"
              :disabled="loading"
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
              variant="solo"
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
            type="submit"
            color="success"
            :loading="loading"
            :disabled="loading"
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
