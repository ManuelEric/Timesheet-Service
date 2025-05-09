<script setup>
import { showNotif } from '@/helper/notification'
import { rules } from '@/helper/rules'
import ApiService from '@/services/ApiService'
import moment from 'moment'

const props = defineProps({ title: String })
const emit = defineEmits(['close', 'reload'])

const formData = ref()
const form = ref({
  timesheet_id: null,
  fee: null,
  date: null,
})
const timesheet_list = ref([])
const loading = ref(false)

const getTimesheet = async () => {
  loading.value = true
  try {
    const res = await ApiService.get('api/v1/timesheet/component/list')
    if (res) {
      timesheet_list.value = res
    }
  } catch (error) {
    console.error(error)
  } finally {
    loading.value = false
  }
}

const submit = async () => {
  const url = props.title == 'bonus' ? 'api/v1/payment/bonus/create' : 'api/v1/payment/additional-fee/create'
  const { valid } = await formData.value.validate()
  if (valid) {
    form.value.date = moment(form.value.date).format('YYYY-MM-DD')
    try {
      const res = await ApiService.post(url, form.value)
      if (res) {
        showNotif('success', res.message, 'bottom-end')
      }
    } catch (error) {
      // console.log(error)
      const err = error?.response?.data?.errors
      showNotif('error', err, 'bottom-end')
    } finally {
      emit('close')
      emit('reload')
    }
  }
}

onMounted(() => {
  getTimesheet()
})
</script>

<template>
  <VCard :title="props.title == 'bonus' ? 'Add Bonus' : 'Additional Fee'">
    <VCardText>
      <VForm
        @submit.prevent="submit"
        ref="formData"
      >
        <VRow>
          <VCol cols="12">
            <VAutocomplete
              v-model="form.timesheet_id"
              label="Timesheet - Package"
              placeholder="Timesheet - Package"
              :items="timesheet_list"
              :item-title="item => item.package_type + ' - ' + item.package_name + ' | ' + item.clients"
              item-value="id"
              :rules="rules.required"
              :loading="loading"
              :disabled="loading"
            ></VAutocomplete>
          </VCol>
          <VCol cols="12">
            <VDateInput
              v-model="form.date"
              prepend-icon=""
              label="Date"
              placeholder="Date"
              :rules="rules.required"
            />
            <VTextField
              v-model="form.fee"
              type="number"
              label="Additional Fee"
              placeholder="Additional Fee"
              :rules="rules.required"
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
