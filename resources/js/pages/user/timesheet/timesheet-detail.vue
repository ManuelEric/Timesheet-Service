<script setup>
import TimesheetDetail from '@/components/user/timesheet/timesheet-detail.vue'
import UserDetail from '@/components/user/timesheet/user-detail.vue'
import { router } from '@/plugins/router'
const props = defineProps({ id: Number, require: String })
const timesheet_id = props.id
const reload = ref(false)
const void_timesheet = ref(false)

provide('reloadData', reload)
provide('updateReload', value => {
  reload.value = value
})

const checkVoid = value => {
  void_timesheet.value = value
}
</script>

<template>
  <div class="h-auto position-relative">
    <div
      class="overlay"
      v-if="void_timesheet == 'true'"
    >
      <div
        class="bg-secondary"
        style="height: 100%; position: absolute; left: 0; top: 0; z-index: 9998; width: 100%; opacity: 0.6"
      ></div>
      <div
        class="d-flex align-center justify-center"
        style="height: 100%; position: absolute; left: 0; top: 0; z-index: 9999; width: 100%; opacity: 1"
      >
        <div class="text-center">
          <VIcon
            color="white"
            icon="ri-lock-line"
            size="50"
          />
          <h2 class="text-white mt-3">This Timesheet Has Changed Owner</h2>
          <VBtn
            color="light"
            class="mt-4"
            @click="router.push({ path: '/user/timesheet' })"
          >
            Back to List
          </VBtn>
        </div>
      </div>
    </div>

    <UserDetail
      :id="timesheet_id"
      @void="checkVoid"
    />
    <TimesheetDetail
      :id="timesheet_id"
      :require="props.require"
    />
  </div>
</template>
