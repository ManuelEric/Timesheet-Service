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

body .v-text-field.v-input.v-input--density-default:not(.v-textarea) .v-field__input,
body .v-autocomplete.v-input.v-input--density-default:not(.v-textarea) .v-field__input,
body .v-combobox.v-input.v-input--density-default:not(.v-textarea) .v-field__input,
body .v-file-input.v-input.v-input--density-default:not(.v-textarea) .v-field__input,
body .v-select.v-input.v-input--density-default:not(.v-textarea) .v-field__input {
  min-block-size: 0px !important;
}

.v-text-field .v-input__details {
  padding-inline: 0px;
}

.v-switch--inset .v-switch__track {
  min-width: 0px !important;
  padding: 5px 10px;
}
</style>
