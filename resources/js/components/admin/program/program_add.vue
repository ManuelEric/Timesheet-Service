<script setup>
import { showNotif } from '@/helper/notification'
import { rules } from '@/helper/rules'
import ApiService from '@/services/ApiService'

const emit = defineEmits(['close', 'reload'])

const loading = ref(false)
const tutor_selected = ref([])
const tutor_list = ref([])
const subjects = ref([])
const package_list = ref([])
const pic_list = ref([])
const inhouse_mentor = ref([])
const duration_readonly = ref(false)

const formData = ref()
const form = ref({
  ref_id: [],
  mentortutor_email: null,
  subject_id: null,
  inhouse_id: null,
  package_id: null,
  duration: '',
  notes: '',
  pic_id: [],
})

const getTutor = async (inhouse = false) => {
  const url = inhouse ? 'api/v1/user/mentor-tutors?inhouse=true' : 'api/v1/user/mentor-tutors'
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
    const res = await ApiService.get('api/v1/package/component/list')
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

const getSubject = async uuid => {
  form.value.subject_id = null
  try {
    const res = await ApiService.get('api/v1/user/mentor-tutors/' + uuid + '/subjects')
    if (res) {
      subjects.value = res
    }
  } catch (error) {
    console.error(error)
  }
}

const submit = async () => {
  loading.value = true

  form.value.mentortutor_email = tutor_selected.value.email
  // console.log(form.value)
  const { valid } = await formData.value.validate()
  if (valid) {
    // set ref id first
    form.value.ref_id = selected.value

    try {
      const res = await ApiService.post('api/v1/timesheet/create', form.value)
      if (res) {
        showNotif('success', res.message, 'bottom-end')
        selected.value = []
        dialog.value = false
        form.value = {
          ref_id: [],
          mentortutor_email: null,
          subject_id: null,
          inhouse_id: null,
          package_id: null,
          duration: '',
          notes: '',
          pic_id: [],
        }
        tutor_selected.value = []
        getData()
      }
    } catch (error) {
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
      }
    } finally {
      loading.value = false
    }
  }
}
// End Function

onMounted(() => {
  getTutor()
  getTutor(true)
  getPackage()
  getPIC()
})
</script>

<template>
  <VCard
    width="600"
    prepend-icon="ri-send-plane-line"
    title="Assign to Mentor/Tutor"
  >
    <VCardText>
      <VForm
        @submit.prevent="submit"
        ref="formData"
        validate-on="input"
      >
        <VRow>
          <VCol md="12">
            <VAutocomplete
              variant="solo"
              clearable
              v-model="tutor_selected"
              label="Mentor/Tutor"
              :items="tutor_list"
              :item-props="
                item => ({
                  title: item.first_name + ' ' + item.last_name,
                  subtitle: item.email,
                })
              "
              :rules="rules.required"
              :loading="loading"
              :disabled="loading"
              @update:modelValue="getSubject(tutor_selected.uuid)"
            ></VAutocomplete>
          </VCol>
          <VCol
            md="12"
            v-if="subjects.length > 0"
          >
            <VAutocomplete
              variant="solo"
              clearable
              v-model="form.subject_id"
              label="Subject Tutoring"
              :items="subjects"
              item-title="subject"
              item-value="id"
              :loading="loading"
              :disabled="loading"
              :rules="rules.required"
            ></VAutocomplete>
          </VCol>
          <VCol md="8">
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
          <VCol md="4">
            <VTextField
              type="number"
              variant="solo"
              clearable
              :label="+form.duration / 60 ? 'Minutes (' + form.duration / 60 + ' Hours)' : 'Minutes'"
              :readonly="duration_readonly"
              v-model="form.duration"
              :rules="rules.required"
            />
          </VCol>
          <VCol md="12">
            <VAutocomplete
              variant="solo"
              clearable
              v-model="form.inhouse_id"
              label="Inhouse Mentor/Tutor"
              :items="inhouse_mentor"
              :item-props="
                item => ({
                  title: item.first_name + ' ' + item.last_name,
                })
              "
              item-value="uuid"
              :loading="loading"
              :disabled="loading"
              :rules="rules.required"
            ></VAutocomplete>
          </VCol>
          <VCol md="12">
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
