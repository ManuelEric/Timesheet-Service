<script setup>
import ApiService from '@/services/ApiService'
import { rules } from '@/helper/rules'
import { showNotif } from '@/helper/notification'

const props = defineProps({ title: String })
const emit = defineEmits(['close'])

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
    try {
      const res = await ApiService.post(url, form.value)
      console.log(res)
      if (res) {
        showNotif('success', res.message, 'bottom-end')
      }
    } catch (error) {
      // console.log(error)
      const err = error?.response?.data?.errors
      showNotif('error', err, 'bottom-end')
    } finally {
      emit('close')
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
              density="compact"
              :rules="rules.required"
              :loading="loading"
              :disabled="loading"
            ></VAutocomplete>
          </VCol>
          <VCol cols="6">
            <VTextField
              v-model="form.date"
              type="date"
              label="Date"
              placeholder="Date"
              density="compact"
              :rules="rules.required"
            />
          </VCol>
          <VCol cols="6">
            <VTextField
              v-model="form.fee"
              type="number"
              label="Additional Fee"
              placeholder="Additional Fee"
              density="compact"
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
