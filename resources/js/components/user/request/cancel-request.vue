<script setup>
import { showNotif } from '@/helper/notification'
import { rules } from '@/helper/rules'
import ApiService from '@/services/ApiService'

const emit = defineEmits(['close', 'reload'])
const props = defineProps({ data: Object })

const loading = ref(false)
const formData = ref(null)

const form = ref({
  ref_program: props.data.id,
  cancellation_reason: null,
})

const submit = async () => {
  const { valid } = await formData.value.validate()
  if (valid) {
    loading.value = true
    try {
      const res = await ApiService.patch('api/v1/request/' + props.data.id + '/update', form.value)
      if (res) {
        showNotif('success', 'Request has been successfully cancelled', 'bottom-end')
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
</script>

<template>
  <VRow class="justify-center">
    <VCol cols="12">
      <VCard
        title="Cancel Your Request"
        width="500"
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
                <VTextarea
                  label="Reason"
                  v-model="form.cancellation_reason"
                  variant="solo"
                  :rules="rules.required"
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
