<script setup>
import UserDetail from '@/components/admin/timesheet/user-detail.vue'
import TimesheetDetail from '@/components/admin/timesheet/timesheet-detail.vue'
const props = defineProps({ id: Number })
const timesheet_id = props.id
</script>

<template>
  <UserDetail :id="timesheet_id" />
  <TimesheetDetail :id="timesheet_id" />
</template>
