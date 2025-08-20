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
const tutor_list = ref([])
const loading = ref(false)
const tutor_name = ref(null)

const getTutorName = async () => {
  loading.value = true
  try {
    const res = await ApiService.get('api/v1/user/mentor-tutors?role=tutor')
    if (res) {
      tutor_list.value = res
    }
  } catch (error) {
    console.error(error)
  } finally {
    loading.value = false
  }
}

const getTimesheet = async () => {
  loading.value = true
  try {
    const res = await ApiService.get('api/v1/timesheet/component/list?terms=' + tutor_name.value)
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
  getTutorName()
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
              v-model="tutor_name"
              label="Tutor Name"
              placeholder="Timesheet - Package"
              :items="tutor_list"
              :item-props="
                item => ({
                  title: item.full_name,
                  subtitle: item.email,
                })
              "
              item-value="full_name"
              :rules="rules.required"
              :loading="loading"
              :disabled="loading"
              @update:model-value="getTimesheet"
              density="compact"
            ></VAutocomplete>
          </VCol>
          <VCol cols="12">
            <VAutocomplete
              v-model="form.timesheet_id"
              label="Timesheet - Package"
              placeholder="Timesheet - Package"
              :items="timesheet_list"
              :item-props="
                item => ({
                  title: item.clients + ' (' + item.package_type + ' - ' + item.package_name + ')',
                  subtitle: moment(item.timesheet_created_at).format('LL'),
                })
              "
              item-value="id"
              :rules="rules.required"
              :loading="loading"
              :disabled="loading"
              density="compact"
            ></VAutocomplete>
          </VCol>
          <VCol cols="12">
            <VDateInput
              v-model="form.date"
              prepend-icon=""
              label="Date"
              placeholder="Date"
              :rules="rules.required"
              variant="outlined"
              density="compact"
            />
            <VTextField
              v-model="form.fee"
              type="number"
              label="Additional Fee"
              placeholder="Additional Fee"
              :rules="rules.required"
              density="compact"
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
