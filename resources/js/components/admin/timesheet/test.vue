<script setup>
const emit = defineEmits(['close'])

const closeDialogContent = () => {
  emit('close')
}

const formData = ref()
const form = ref({
  activity: null,
  description: null,
  date: null,
  start_time: null,
  end_time: null,
  meeting_link: null,
})
</script>

<template>
  <!-- Dialog Content -->
  <VCard title="New Activity">
    <DialogCloseBtn
      variant="text"
      size="default"
      @click="closeDialogContent"
    />

    <VCardText>
      <VForm
        @submit.prevent="submit"
        ref="formData"
        validate-on="input"
        fast-fail
      >
        <VRow>
          <VCol cols="12">
            <VTextField
              v-model="form.activity"
              label="Activity Name"
              placeholder="Activity"
            />
          </VCol>
          <VCol cols="12">
            <VTextarea
              v-model="form.description"
              label="Description"
              placeholder="Description"
            />
          </VCol>
          <VCol
            md="6"
            cols="12"
          >
            <VTextField
              type="date"
              v-model="form.date"
              label="Date"
              placeholder="Date"
            />
          </VCol>
          <VCol
            md="3"
            cols="6"
          >
            <VTextField
              type="time"
              v-model="form.start_time"
              label="Start Time"
              placeholder="Start Time"
            />
          </VCol>
          <VCol
            md="3"
            cols="6"
          >
            <VTextField
              type="time"
              v-model="form.end_time"
              label="End Time"
              placeholder="End Time"
            />
          </VCol>
          <VCol md="12">
            <VTextField
              type="url"
              v-model="form.meeting_link"
              label="Meeting Link"
              placeholder="Meeting Link"
            />
          </VCol>
        </VRow>
        <VDivider class="my-3" />
        <VCardActions>
          <VBtn
            color="error"
            @click="closeDialogContent"
          >
            <VIcon
              icon="ri-close-line"
              class="me-3"
            />
            Close
          </VBtn>
          <VSpacer />
          <VBtn color="success">
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
