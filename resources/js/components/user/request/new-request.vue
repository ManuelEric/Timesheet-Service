<script setup>
import { showNotif } from '@/helper/notification'
import { rules } from '@/helper/rules'
import ApiService from '@/services/ApiService'
import UserService from '@/services/UserService'
import { onMounted } from 'vue'

const emit = defineEmits(['close', 'reload'])

const loading = ref(false)
const formData = ref(null)
const packageItems = ref([])
const menteeItems = ref([])
const selectedMentee = ref([])
const user = UserService.getUser()

const form = ref({
  clientprog_id: null,
  invoice_id: null,
  student_uuid: null,
  student_name: null,
  student_school: null,
  student_grade: null,
  program_name: null,
  engagement_type: null,
  notes: null,
})

const getMentee = async () => {
  try {
    const res = await ApiService.get('api/v1/mentees')

    if (res) {
      menteeItems.value = res
    }
  } catch (error) {
    console.log(error)
  }
}

const getPackage = async () => {
  try {
    const res = await ApiService.get('api/v1/engagement-type/component/list')

    if (res) {
      packageItems.value = res
    }
  } catch (error) {
    console.log(error)
  }
}

const updateMenteeData = () => {
  form.value.clientprog_id = selectedMentee.value.clientprog_id
  form.value.invoice_id = selectedMentee.value.invoice_id
  form.value.student_uuid = selectedMentee.value.client.uuid
  form.value.student_name = selectedMentee.value.client.first_name + ' ' + selectedMentee.value.client.last_name
  form.value.student_grade = selectedMentee.value.client.grade
  form.value.student_school = selectedMentee.value.client.school_name
  form.value.program_name = selectedMentee.value.program_name
}

const submit = async () => {
  const { valid } = await formData.value.validate()
  if (valid) {
    loading.value = true
    try {
      const res = await ApiService.post('api/v1/request/create', form.value)
      if (res) {
        showNotif('success', 'Request has been successfully created', 'bottom-end')
        emit('reload')
      }
    } catch (error) {
      console.log(error)
    } finally {
      emit('close')
      loading.value = false
    }
  }
}

onMounted(() => {
  getMentee()
  getPackage()
})
</script>

<template>
  <VRow class="justify-center">
    <VCol cols="12">
      <VCard
        title="New Request"
        max-width="500"
        prepend-icon="ri-send-plane-line"
      >
        <VCardText>
          <VForm
            @submit.prevent="submit"
            ref="formData"
            validate-on="input"
          >
            <VRow>
              <VCol cols="12">
                <VAutocomplete
                  variant="solo"
                  clearable
                  v-model="selectedMentee"
                  label="Mentee Name"
                  :items="menteeItems"
                  :item-props="
                    item => ({
                      title: item.client?.first_name + ' ' + item.client?.last_name,
                      subtitle: item.client.school_name,
                    })
                  "
                  :rules="rules.required"
                  :loading="loading"
                  :disabled="loading"
                  @update:model-value="updateMenteeData"
                ></VAutocomplete>
              </VCol>
              <VCol cols="12">
                <VAutocomplete
                  variant="solo"
                  clearable
                  v-model="form.engagement_type"
                  :items="packageItems"
                  :item-props="
                    item => ({
                      title: item.name,
                    })
                  "
                  item-value="id"
                  label="Engagement Type"
                  :rules="rules.required"
                  :loading="loading"
                  :disabled="loading"
                ></VAutocomplete>
              </VCol>
              <VCol cols="12">
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
    </VCol>
  </VRow>
</template>
