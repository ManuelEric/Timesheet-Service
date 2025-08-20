<script lang="ts" setup>
const prop = defineProps(['data', 'title', 'loading'])
const emit = defineEmits(['close', 'delete'])

const closeDialogContent = () => {
  emit('close')
}

const deleteData = () => {
  emit('delete')
}
</script>

<template>
  <!-- Dialog Content -->
  <VCard>
    <DialogCloseBtn
      variant="text"
      size="default"
      @click="closeDialogContent"
    />

    <VCardText class="text-center mt-4">
      <h2 class="my-3 mb-4">Confirmation</h2>
      <h3 class="font-weight-light">
        Are you sure, <br />
        you want to delete this {{ prop.title }} ?
      </h3>
    </VCardText>

    <VCardActions class="mb-3">
      <VSpacer />
      <VBtn
        color="error"
        @click="closeDialogContent"
      >
        <VIcon
          icon="ri-close-line"
          class="me-2"
        />
        Cancel
      </VBtn>
      <VBtn
        color="success"
        :disabled="prop.loading"
        :loading="prop.loading"
        @click="deleteData"
      >
        <VIcon
          icon="ri-check-line"
          class="me-2"
        />
        Yes, Delete
      </VBtn>
      <VSpacer />
    </VCardActions>
  </VCard>
</template>

<style lang="scss"></style>
