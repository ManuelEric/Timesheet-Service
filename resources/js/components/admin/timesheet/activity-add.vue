<script setup>
const emit = defineEmits(['close'])

const closeDialogContent = () => {
  emit('close')
}

const formInput = ref({
  title: null,
  description: null,
  date: null,
  start_time: null,
  end_time: null,
  status: false,
  fee: null,
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
      <VRow>
        <VCol cols="12">
          <VTextField
            v-model="formInput.title"
            label="Activity Name"
            placeholder="Activity"
          />
        </VCol>
        <VCol cols="12">
          <VTextarea
            v-model="formInput.description"
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
            v-model="formInput.date"
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
            v-model="formInput.start_time"
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
            v-model="formInput.end_time"
            label="End Time"
            placeholder="End Time"
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
    </VCardText>
  </VCard>
</template>

<style lang="scss"></style>
