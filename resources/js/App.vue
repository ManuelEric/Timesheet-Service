<script setup>
import UpgradeToPro from '@/components/UpgradeToPro.vue'
</script>

<template>
  <VApp>
    <RouterView />
    <!-- <UpgradeToPro /> -->
  </VApp>
</template>

<style>
body.swal2-toast-shown .swal2-container.swal2-bottom-end,
body.swal2-toast-shown .swal2-container.swal2-bottom-right {
  z-index: 99999;
}
</style>
