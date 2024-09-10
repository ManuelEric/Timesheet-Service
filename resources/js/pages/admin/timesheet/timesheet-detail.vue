<script setup>
import TimesheetDetail from '@/components/admin/timesheet/timesheet-detail.vue'
import UserDetail from '@/components/admin/timesheet/user-detail.vue'
const props = defineProps({ id: Number })
const timesheet_id = props.id
const reload = ref(false)

provide('reloadData', reload)
provide('updateReload', value => {
  reload.value = value
})
</script>

<template>
  <UserDetail :id="timesheet_id" />
  <TimesheetDetail :id="timesheet_id" />
</template>
