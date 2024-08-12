<script setup>
import { VCard, VCardText } from 'vuetify/lib/components/index.mjs'

const prop = defineProps({ active: Boolean, width: Number })
const emit = defineEmits(['close'])
</script>

<template>
  <section class="position-relative overflow-hidden">
    <div
      class="position-fixed filter-content"
      :class="prop.active ? 'active' : ''"
      :style="{ width: prop.width + 'px' }"
    >
      <div class="d-flex justify-space-between">
        <h3 class="text-secondary">
          <slot name="header">Title</slot>
        </h3>
        <div @click="emit('close')">
          <VIcon
            icon="ri-close-line"
            color="#e08282"
            class="cursor-pointer"
          />
        </div>
      </div>
      <VCard class="mt-3">
        <VCardText>
          <slot name="content">Content</slot>
        </VCardText>
      </VCard>
    </div>
  </section>
</template>

<style lang="scss">
.filter-content {
  height: 100vh;
  top: 0;
  opacity: 0;
  right: -100%;
  z-index: -1;
  background: white;
  box-shadow: -2px 2px 5px 0px rgba(0, 0, 0, 0.3);
  -webkit-box-shadow: -2px 2px 5px 0px rgba(0, 0, 0, 0.3);
  -moz-box-shadow: -2px 2px 5px 0px rgba(0, 0, 0, 0.3);
  padding: 20px;
  transition: all 0.5s ease-in-out;
}

.filter-content.active {
  right: 0;
  opacity: 1;
  z-index: 999;
}
</style>
