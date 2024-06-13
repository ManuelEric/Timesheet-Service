<script setup>
const prop = defineProps(['item'])
const emit = defineEmits(['close'])

const closeDialogContent = () => {
  emit('close')
}
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
      <VRow>
        <VCol md="6">
          <VAutocomplete
            density="compact"
            label="Mentor/Tutor"
            :items="['California', 'Colorado', 'Florida', 'Georgia', 'Texas', 'Wyoming']"
          ></VAutocomplete>
        </VCol>
        <VCol md="6">
          <VAutocomplete
            density="compact"
            label="Package"
            :items="['California', 'Colorado', 'Florida', 'Georgia', 'Texas', 'Wyoming']"
          ></VAutocomplete>
        </VCol>
        <VCol md="6">
          <VAutocomplete
            density="compact"
            label="Hours"
            :items="['California', 'Colorado', 'Florida', 'Georgia', 'Texas', 'Wyoming']"
          ></VAutocomplete>
        </VCol>
        <VCol md="6">
          <VAutocomplete
            density="compact"
            label="PIC"
            :items="['California', 'Colorado', 'Florida', 'Georgia', 'Texas', 'Wyoming']"
          ></VAutocomplete>
        </VCol>
        <VCol md="12">
          <VTextarea label="Notes"></VTextarea>
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
