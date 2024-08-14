<script setup></script>

<template>
  <VApp>
    <RouterView />
    <!-- <UpgradeToPro /> -->
  </VApp>
</template>
<style lang="scss">
.v-date-picker-month__day .v-btn.v-date-picker-month__day-btn {
  --v-btn-height: 29px !important;
}
body.swal2-toast-shown .swal2-container.swal2-bottom-end,
body.swal2-toast-shown .swal2-container.swal2-bottom-right {
  z-index: 99999;
}

.layout-wrapper.layout-nav-type-vertical .layout-navbar {
  z-index: 0 !important;
}
</style>
