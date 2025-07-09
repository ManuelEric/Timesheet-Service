<script setup>
import { showNotif } from '@/helper/notification'
import { rules } from '@/helper/rules'
import ApiService from '@/services/ApiService'
import ApiServiceCRM from '@/services/ApiServiceCRM'

const props = defineProps({ selected: Object })
const emit = defineEmits(['close', 'reload'])

const loading = ref(false)
const tutor_selected = ref([])
const tutor_list = ref([])
const stream_list = ref([])
const stream_selected = ref(null)
const package_list = ref([])
const pic_list = ref([])
const inhouse_mentor = ref([])
const duration_readonly = ref(false)
const require = props.selected[0]?.require?.toLowerCase()
const fee_nett = ref(null)

const formData = ref()
const form = ref({
  ref_id: props.selected.map(item => item.id),
  mentortutor_email: null,
  subject_id: null,
  inhouse_id: null,
  package_id: null,
  duration: '',
  tax: 2.5,
  individual_fee: null,
  notes: '',
  pic_id: [],
})

const getTutor = async (inhouse = false) => {
  const role = require == 'mentor' ? 'External Mentor' : require

  const url = inhouse
    ? 'api/v1/user/mentor-tutors?inhouse=true&role=' + require
    : 'api/v1/user/mentor-tutors?role=' + role
  try {
    const res = await ApiService.get(url)
    if (res) {
      if (inhouse) {
        inhouse_mentor.value = Object.values(res)
      } else {
        tutor_list.value = res
      }
    }
  } catch (error) {
    console.error(error)
  }
}

const getStream = async () => {
  const url = 'external-mentor/streams'
  try {
    loading.value = true
    const res = await ApiServiceCRM.get(url)

    if (res) {
      stream_list.value = res
    }
    loading.value = false
  } catch (error) {
    showNotif('error', error.response?.data?.message, 'bottom-end')
    console.error(error)
    loading.value = false
  }
}

const getIndividualFee = async (mentor_id, stream, engagement_type, packages) => {
  try {
    const res = await ApiService.get(
      'api/v1/component/fee/ext-mentor/' + mentor_id + '/' + stream + '/' + engagement_type + '/' + packages,
    )
    if (res.length > 0) {
      // if student more than one, use fee group
      form.value.individual_fee = props.selected.length > 1 ? res.fee_group : res.fee_individual
      if (form.value.individual_fee) {
        checkNettFee()
      } else {
        fee_nett.value = null
      }
    } else {
      showNotif(
        'error',
        "We're sorry, but we couldn't find a tutor fee for the selected curriculum and subject. This may be outside the scope of our current agreement. Please reach out to our HR team for assistance or to explore available options",
        'bottom-end',
      )
    }
  } catch (error) {
    console.error(error)
  }

  checkPackage()
}

const getPackage = async () => {
  try {
    const res = await ApiService.get('api/v1/package/component/list?category=' + require)
    if (res) {
      package_list.value = res
    }
  } catch (error) {
    console.error(error)
  }
}

const checkPackage = () => {
  const package_id = form.value.package_id
  const index = package_list.value.findIndex(item => item.id === package_id)
  let item = package_list.value[index]

  if (item.detail) {
    duration_readonly.value = true
    form.value.duration = item.detail
  } else {
    duration_readonly.value = false
    form.value.duration = null
  }
}

const getPIC = async () => {
  try {
    const res = await ApiService.get('api/v1/user/component/list')
    if (res) {
      pic_list.value = res
    }
  } catch (error) {
    console.error(error)
  }
}

const submit = async () => {
  form.value.mentortutor_email = tutor_selected.value.email

  const { valid } = await formData.value.validate()
  if (valid) {
    loading.value = true
    try {
      const res = await ApiService.post('api/v1/timesheet/create', form.value)
      if (res) {
        showNotif('success', res.message, 'bottom-end')
        emit('reload')
        form.value = {
          ref_id: [],
          mentortutor_email: null,
          subject_id: null, // used when subject fetched from the server
          subject_name: null, // used when subject fetched from own db
          inhouse_id: null,
          package_id: null,
          duration: '',
          notes: '',
          pic_id: [],
          tax: null,
          individual_fee: '',
        }
        tutor_selected.value = []

        window.open('/admin/timesheet/specialist/' + res.data?.timesheet_id, '_blank')
      }
    } catch (error) {
      if (error?.response?.data?.errors) {
        const validationErrors = error.response.data.errors
        showNotif('error', validationErrors, 'bottom-end')
      }
    } finally {
      emit('close')
      loading.value = false
    }
  }
}

// Check Nett
const checkNettFee = () => {
  const nett = form.value.individual_fee * (1 - form.value.tax / 100)
  fee_nett.value = Math.trunc(nett)
}

// Check Gross
const checkGrossFee = () => {
  const gross = fee_nett.value / (1 - form.value.tax / 100)
  form.value.individual_fee = Math.trunc(gross)
}
// End Functions

onMounted(() => {
  getStream()
  getTutor()
  getTutor(true)
  getPackage()
  getPIC()
})
</script>

<template>
  <VCard
    max-width="650"
    prepend-icon="ri-send-plane-line"
    title="Assign to Subject Specialist"
  >
    <VCardText>
      <VForm
        @submit.prevent="submit"
        ref="formData"
        validate-on="input"
      >
        {{ props.selected }}
        <VRow>
          <VCol
            md="6"
            cols="12"
          >
            <VAutocomplete
              density="compact"
              clearable
              v-model="tutor_selected"
              label="Subject Specialist Name"
              :items="tutor_list"
              :item-props="
                item => ({
                  title: item.full_name,
                  subtitle: item.roles.map(role => role.name).join(', '),
                })
              "
              :rules="rules.required"
              :loading="loading"
              :disabled="loading"
            ></VAutocomplete>
          </VCol>
          <VCol
            md="6"
            cols="12"
          >
            <VAutocomplete
              density="compact"
              clearable
              label="Stream"
              v-model="stream_selected"
              :items="stream_list"
              item-title="stream_name"
              item-value="stream_name"
              :loading="loading"
              :disabled="loading"
            ></VAutocomplete>
          </VCol>
          <VCol
            md="8"
            cols="8"
          >
            <VAutocomplete
              density="compact"
              clearable
              label="Package"
              v-model="form.package_id"
              :items="package_list"
              :item-props="
                item => ({
                  title: item.package != null ? item.type_of + ' - ' + item.package : item.type_of,
                  subtitle: item.detail ? item.detail / 60 + ' Hours' : 'Customizable',
                })
              "
              item-value="id"
              :rules="rules.required"
              :loading="loading"
              :disabled="loading"
              @update:modelValue="
                getIndividualFee(tutor_selected.uuid, stream_selected, form.engagement_type, form.package_id)
              "
            ></VAutocomplete>
          </VCol>
          <VCol
            md="4"
            cols="4"
          >
            <VTextField
              density="compact"
              type="number"
              clearable
              :label="+form.duration / 60 ? '' + form.duration / 60 + ' Hours' : 'Minutes'"
              :readonly="duration_readonly"
              v-model="form.duration"
              :rules="rules.required"
            />
          </VCol>
          <VCol
            md="4"
            cols="7"
          >
            <VTextField
              type="number"
              clearable
              label="Fee/hours (Nett)"
              v-model="fee_nett"
              density="compact"
              :rules="rules.required"
              @update:model-value="checkGrossFee"
            />
          </VCol>
          <VCol
            md="4"
            cols="5"
          >
            <VTextField
              type="number"
              clearable
              label="Tax"
              v-model="form.tax"
              :rules="rules.required"
              density="compact"
              @update:model-value="checkGrossFee"
            />
          </VCol>
          <VCol
            md="4"
            cols="12"
          >
            <v-tooltip
              activator="parent"
              location="top"
            >
              Fee Gross is automatically calculated based on the entered Net Fee and Tax Rate.
            </v-tooltip>
            <VTextField
              type="number"
              clearable
              label="Fee/hours (Gross)"
              v-model="form.individual_fee"
              density="compact"
              readonly
              :rules="rules.required"
              @update:model-value="checkNettFee"
            />
          </VCol>
          <VCol
            md="6"
            cols="12"
          >
            <VAutocomplete
              density="compact"
              clearable
              v-model="form.inhouse_id"
              label="Inhouse Mentor"
              :items="inhouse_mentor"
              :item-props="
                item => ({
                  title: item.full_name,
                })
              "
              item-value="uuid"
              :loading="loading"
              :disabled="loading"
              :rules="rules.required"
            ></VAutocomplete>
          </VCol>
          <VCol
            md="6"
            cols="12"
          >
            <VAutocomplete
              density="compact"
              multiple
              clearable
              chips
              label="PIC"
              v-model="form.pic_id"
              :items="pic_list"
              item-title="full_name"
              item-value="id"
              :loading="loading"
              :disabled="loading"
              :rules="rules.required"
            ></VAutocomplete>
          </VCol>
          <VCol md="12">
            <VTextarea
              label="Notes"
              v-model="form.notes"
            ></VTextarea>
          </VCol>
        </VRow>

        <VCardActions class="mt-5 px-0">
          <VBtn
            variant="tonal"
            color="error"
            type="button"
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
