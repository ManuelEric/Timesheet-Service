<script setup>
import { showNotif } from '@/helper/notification'
import { rules } from '@/helper/rules'
import ApiService from '@/services/ApiService'
import moment from 'moment'
import { ref } from 'vue'

const emit = defineEmits(['close', 'reload'])

const loading = ref(false)
const formData = ref()
const start_date = ref(null)
const end_date = ref(null)
const form = ref({
  start_date: null,
  end_date: null,
  start_time: null,
  end_time: null,
})

const submit = async () => {
  const { valid } = await formData.value.validate()
  if (valid) {
    loading.value = true
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
      loading.value = false
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
            <div class="d-flex gap-2">
              <VDateInput
                prepend-icon=""
                v-model="start_date"
                input-format="yyyy-mm-dd"
                label="Start Date"
                variant="outlined"
                density="compact"
                :rules="rules.required"
                @update:modelValue="
                  form.start_date = moment(start_date).format('YYYY-MM-DD') + ' ' + form.start_time + ':00'
                "
              />
              <div class="">
                <VTextField
                  v-model="form.start_time"
                  type="time"
                  density="compact"
                  label="Start Time"
                  placeholder="End Time"
                  :rules="rules.required"
                  :loading="loading"
                  :disabled="!start_date || loading"
                  @update:modelValue="
                    form.start_date = moment(start_date).format('YYYY-MM-DD') + ' ' + form.start_time + ':00'
                  "
                />
              </div>
            </div>
            <div class="d-flex gap-2">
              <VDateInput
                prepend-icon=""
                v-model="end_date"
                label="End Date"
                variant="outlined"
                density="compact"
                :rules="rules.required"
                @update:modelValue="form.end_date = moment(end_date).format('YYYY-MM-DD') + ' ' + form.end_time + ':00'"
              />
              <div class="">
                <VTextField
                  v-model="form.end_time"
                  type="time"
                  density="compact"
                  label="Start Time"
                  placeholder="End Time"
                  :rules="rules.required"
                  :loading="loading"
                  :disabled="!end_date || loading"
                  @update:modelValue="
                    form.end_date = moment(end_date).format('YYYY-MM-DD') + ' ' + form.end_time + ':00'
                  "
                />
              </div>
            </div>
          </VCol>
        </VRow>
        <VDivider class="my-3" />
        <VCardActions class="px-0">
          <VBtn
            variant="tonal"
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
            variant="tonal"
            :loading="loading"
            :disabled="loading"
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
