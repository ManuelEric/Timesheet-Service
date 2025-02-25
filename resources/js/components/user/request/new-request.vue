<script setup>
import { rules } from '@/helper/rules'

const emit = defineEmits(['close', 'reload'])

const loading = ref(false)
const formData = ref(null)
const form = ref({
  mentor_id: null,
  mentee_id: null,
  package_name: null,
  notes: null,
})

const submit = async () => {
  const { valid } = await formData.value.validate()
  if (valid) {
    loading.value = true
    try {
    } catch (error) {
      console.log(error)
    } finally {
      loading.value = false
    }
  }
}
</script>

<template>
  <VRow class="justify-center">
    <VCol cols="12">
      <VCard
        title="New Request"
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
              <VCol md="12">
                <VAutocomplete
                  variant="solo"
                  clearable
                  v-model="form.mentee_id"
                  label="Mentee Name"
                  :rules="rules.required"
                  :loading="loading"
                  :disabled="loading"
                ></VAutocomplete>
              </VCol>
              <VCol
                md="12"
                col="12"
              >
                <VAutocomplete
                  variant="solo"
                  clearable
                  v-model="form.package_name"
                  label="Program Name"
                  :rules="rules.required"
                  :loading="loading"
                  :disabled="loading"
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
    </VCol>
  </VRow>
</template>
