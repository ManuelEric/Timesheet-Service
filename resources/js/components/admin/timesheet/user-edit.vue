<script setup>
import { rules } from '@/helper/rules'
import { showNotif } from '@/helper/notification'
import ApiService from '@/services/ApiService'

const prop = defineProps(['id', 'item', 'package_id'])
const emit = defineEmits(['close'])

const tutor_selected = ref([prop.item?.tutormentor_id])
const tutor_list = ref([])
const subjects = ref([])
const package_list = ref([])
const pic_list = ref([])
const inhouse_mentor = ref([])
const duration_readonly = ref(false)
const loading = ref(true)

const formData = ref()
const form = ref({
  mentortutor_email: prop.item?.tutormentor_email,
  subject_id: prop.item?.subject_id,
  inhouse_id: prop.item?.inhouse_id,
  package_id: prop.package_id,
  duration: prop.item?.duration,
  notes: prop.item?.notes,
  pic_id: prop.item?.pic_id,
})

const closeDialogContent = () => {
  emit('close')
}

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

const submit = async () => {
  const { valid } = await formData.value.validate()
  if (valid) {
    try {
      const res = await ApiService.put('api/v1/timesheet/' + prop.id + '/update', form.value)
      if (res) {
        showNotif('success', res.message, 'bottom-end')
        console.log(res)
        form.value = {
          mentortutor_email: null,
          subject_id: null,
          inhouse_id: null,
          package_id: null,
          duration: '',
          notes: '',
          pic_id: [],
        }
        closeDialogContent()
      }
    } catch (error) {
      console.log(error)
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
    }
  }
}

onMounted(() => {
  getTutor(true)
  getPackage()
  getPIC()

  setTimeout(() => {
    loading.value = false
  }, 2000)
})
</script>

<template>
  <!-- Dialog Content -->
  <VCard title="Edit Detail">
    <DialogCloseBtn
      variant="text"
      size="default"
      @click="closeDialogContent"
    />

    <VCardText>
      <VSkeletonLoader
        type="heading, list-item-three-line, actions"
        v-if="loading"
      />
      <VForm
        @submit.prevent="submit"
        ref="formData"
        validate-on="input"
        fast-fail
        v-else
      >
        <VRow>
          <VCol md="8">
            <VAutocomplete
              density="compact"
              clearable
              label="Package"
              v-model="form.package_id"
              :items="package_list"
              :item-props="
                item => ({ title: item.package != null ? item.type_of + ' - ' + item.package : item.type_of })
              "
              item-value="id"
              :rules="rules.required"
              @update:modelValue="checkPackage"
            ></VAutocomplete>
          </VCol>
          <VCol md="4">
            <VTextField
              type="number"
              density="compact"
              clearable
              :label="+form.duration / 60 ? 'Minutes (' + form.duration / 60 + ' Hours)' : 'Minutes'"
              :readonly="duration_readonly"
              v-model="form.duration"
              :rules="rules.required"
            />
          </VCol>
          <VCol md="12">
            <VAutocomplete
              density="compact"
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
              :rules="rules.required"
            ></VAutocomplete>
          </VCol>
          <VCol md="12">
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

        <VDivider class="my-3" />
        <VCardActions>
          <VBtn
            color="error"
            type="button"
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

<style lang="scss"></style>
