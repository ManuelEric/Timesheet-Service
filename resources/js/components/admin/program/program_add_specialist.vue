<script setup>
import { showNotif } from '@/helper/notification'
import { rules } from '@/helper/rules'
import ApiService from '@/services/ApiService'

const props = defineProps({ selected: Object })
const emit = defineEmits(['close', 'reload'])

const loading = ref(false)
const tutor_selected = ref([])
const tutor_list = ref([])
const subjects = ref([])
const package_list = ref([])
const pic_list = ref([])
const inhouse_mentor = ref([])
const duration_readonly = ref(false)
const require = props.selected[0]?.require?.toLowerCase()
const has_npwp = ref(null)

const formData = ref()
const form = ref({
  ref_id: props.selected.map(item => item.id),
  mentortutor_email: null,
  subject_id: null,
  inhouse_id: null,
  package_id: null,
  duration: '',
  tax: null,
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

const getSubject = async (item, uuid = null, npwp = 0) => {
  form.value.subject_id = null

  // check NPWP
  has_npwp.value = npwp
  form.value.tax = npwp == 1 ? 2.5 : 3

  if (require == 'mentor') {
    form.value.subject_id = item[0]?.subjects[0]?.id
    form.value.individual_fee = item[0]?.subjects[0]?.fee_individual
  } else {
    try {
      const res = await ApiService.get('api/v1/user/mentor-tutors/' + uuid + '/subjects')
      if (res) {
        subjects.value = res
      }
    } catch (error) {
      console.error(error)
    }
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
        selected.value = []
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
// End Functions

onMounted(() => {
  getTutor()
  getTutor(true)
  getPackage()
  getPIC()
})
</script>

<template>
  <VCard
    width="650"
    prepend-icon="ri-send-plane-line"
    title="Assign to External Mentor"
  >
    <VCardText>
      <VForm
        @submit.prevent="submit"
        ref="formData"
        validate-on="input"
      >
        <VRow>
          <VCol
            md="12"
            cols="12"
          >
            <VAutocomplete
              variant="solo"
              clearable
              v-model="tutor_selected"
              label="Mentor Name"
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
              @update:modelValue="getSubject(tutor_selected.roles, tutor_selected.uuid, tutor_selected.has_npwp)"
            ></VAutocomplete>
            <v-alert
              :color="has_npwp == 1 ? 'success' : 'error'"
              icon="ri-error-warning-line"
              class="py-2 mt-2"
              v-if="has_npwp != null"
            >
              <small> Mentor {{ has_npwp == 1 ? 'already' : 'don`t' }} have NPWP </small>
            </v-alert>
          </VCol>
          <VCol
            md="8"
            cols="12"
          >
            <VAutocomplete
              variant="solo"
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
              @update:modelValue="checkPackage"
            ></VAutocomplete>
          </VCol>
          <VCol
            md="4"
            cols="7"
          >
            <VTextField
              type="number"
              variant="solo"
              clearable
              :label="+form.duration / 60 ? '' + form.duration / 60 + ' Hours' : 'Minutes'"
              :readonly="duration_readonly"
              v-model="form.duration"
              :rules="rules.required"
            />
          </VCol>
          <VCol
            md="7"
            cols="5"
          >
            <VTextField
              type="number"
              variant="solo"
              clearable
              label="Fee/hours (Gross)"
              v-model="form.individual_fee"
              :rules="rules.required"
            />
          </VCol>
          <VCol
            md="5"
            cols="5"
          >
            <VTextField
              type="number"
              variant="solo"
              clearable
              label="Tax"
              v-model="form.tax"
              :rules="rules.required"
            />
          </VCol>
          <VCol
            md="6"
            cols="12"
          >
            <VAutocomplete
              variant="solo"
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
              variant="solo"
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
              variant="solo"
            ></VTextarea>
          </VCol>
        </VRow>

        <VCardActions class="mt-5">
          <VBtn
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
