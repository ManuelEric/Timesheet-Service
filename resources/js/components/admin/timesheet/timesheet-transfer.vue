<script setup>
import { confirmBeforeSubmit, showNotif } from '@/helper/notification'
import { rules } from '@/helper/rules'
import { router } from '@/plugins/router'
import ApiService from '@/services/ApiService'

const formData = ref()
const prop = defineProps({ timesheet_id: Number, require: String })
const emit = defineEmits(['close', 'reload'])
const tutor_list = ref([])
const tutor_selected = ref([])
const subjects = ref([])
const require = prop.require.toLowerCase()
const loading = ref(false)

const form = ref({
  mentortutor_email: null,
  subject_id: null,
})

const getTutor = async () => {
  const url = 'api/v1/user/mentor-tutors?role=' + require
  loading.value = true
  try {
    const res = await ApiService.get(url)
    if (res) {
      tutor_list.value = res
    }
  } catch (error) {
    console.error(error)
  } finally {
    loading.value = false
  }
}

const getSubject = async (item, uuid = null) => {
  form.value.subject_id = null

  if (require == 'mentor') {
    form.value.subject_id = item[0].subjects[0].id
  } else {
    loading.value = true
    try {
      const res = await ApiService.get('api/v1/user/mentor-tutors/' + uuid + '/subjects')
      if (res) {
        subjects.value = res
      }
    } catch (error) {
      console.error(error)
    } finally {
      loading.value = false
    }
  }
}

const submit = async () => {
  emit('close')
  form.value.mentortutor_email = tutor_selected.value.email
  const { valid } = await formData.value.validate()
  const confirm = await confirmBeforeSubmit('Are you sure you want to change the owner?')
  if (valid && confirm) {
    loading.value = true
    try {
      const res = await ApiService.patch('api/v1/timesheet/' + prop.timesheet_id + '/void/', form.value)
      if (res) {
        showNotif('success', res.message, 'bottom-end')
        router.push({ path: '/admin/timesheet/' + res.data.timesheet_id })
        // emit('reload')
        form.value = {
          mentortutor_email: null,
          subject_id: null,
        }
        tutor_selected.value = []

        setTimeout(() => {
          router.go(0)
        }, 1000)
      }
    } catch (error) {
      console.log(error)
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

onMounted(() => {
  getTutor()
})
</script>

<template>
  <VCard
    class="mx-auto my-8"
    elevation="16"
    width="450"
  >
    <VForm
      ref="formData"
      validate-on="input"
      @submit.prevent="submit"
    >
      <VCardItem>
        <VCardTitle> Timesheet Ownership Transfer </VCardTitle>
        <VCardSubtitle> Change Timesheet Handler </VCardSubtitle>
      </VCardItem>

      <VCardText>
        <VRow>
          <VCol md="12">
            <VAutocomplete
              clearable
              v-model="tutor_selected"
              label="Mentor/Tutor"
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
              @update:modelValue="getSubject(tutor_selected.roles, tutor_selected.uuid)"
            ></VAutocomplete>
          </VCol>
          <VCol
            md="12"
            v-if="prop.require?.toLowerCase() == 'tutor'"
          >
            <VAutocomplete
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
        </VRow>
      </VCardText>
      <VCardActions class="mx-3 mb-3">
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
          Save Changes
          <VIcon
            icon="ri-save-line"
            class="ms-3"
          />
        </VBtn>
      </VCardActions>
    </VForm>
  </VCard>
</template>
