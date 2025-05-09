<script setup>
import { showNotif } from '@/helper/notification'
import { rules } from '@/helper/rules'
import ApiService from '@/services/ApiService'

const prop = defineProps(['id', 'item', 'package_id'])
const emit = defineEmits(['close', 'reload'])

const tutor_list = ref([])
const package_list = ref([])
const pic_list = ref([])
const inhouse_mentor = ref([])
const duration_readonly = ref(false)
const loading = ref(true)
const loading_select = ref(true)

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

const getTutor = async (inhouse = false) => {
  loading_select.value = true
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
  } finally {
    loading_select.value = false
  }
}

const getPackage = async () => {
  loading_select.value = true
  try {
    const res = await ApiService.get('api/v1/package/component/list')
    if (res) {
      package_list.value = res
    }
  } catch (error) {
    console.error(error)
  } finally {
    loading_select.value = false
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
  loading_select.value = true
  try {
    const res = await ApiService.get('api/v1/user/component/list')
    if (res) {
      pic_list.value = res
    }
  } catch (error) {
    console.error(error)
  } finally {
    loading_select.value = false
  }
}

const submit = async () => {
  const { valid } = await formData.value.validate()
  if (valid) {
    try {
      const res = await ApiService.put('api/v1/timesheet/' + prop.id + '/update', form.value)
      if (res) {
        form.value = {
          mentortutor_email: null,
          subject_id: null,
          inhouse_id: null,
          package_id: null,
          duration: '',
          notes: '',
          pic_id: [],
        }
        showNotif('success', res.message, 'bottom-end')
        emit('reload')
      }
    } catch (error) {
      // console.log(error)
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
      emit('close')
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
      @click="emit('close')"
    />

    <VCardText>
      <VForm
        @submit.prevent="submit"
        ref="formData"
        validate-on="input"
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
              :loading="loading_select"
              :disabled="loading_select"
            ></VAutocomplete>
          </VCol>
          <VCol md="4">
            <VTextField
              type="number"
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
                  title: item.full_name,
                })
              "
              item-value="uuid"
              :rules="rules.required"
              :loading="loading_select"
              :disabled="loading_select"
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
              :loading="loading_select"
              :disabled="loading_select"
            ></VAutocomplete>
          </VCol>
          <VCol md="12">
            <VTextarea
              density="compact"
              label="Notes"
              v-model="form.notes"
            ></VTextarea>
          </VCol>
        </VRow>

        <VDivider class="my-3 px-0" />
        <VCardActions>
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

<style lang="scss"></style>
