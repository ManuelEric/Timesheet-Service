<script setup>
import VerticalNavSectionTitle from '@/@layouts/components/VerticalNavSectionTitle.vue'
import UserService from '@/services/UserService'
import VerticalNavLink from '@layouts/components/VerticalNavLink.vue'
import { onMounted } from 'vue'

const role = ref(null)
onMounted(() => {
  const user = UserService.getUser()
  role.value = user.role
})
</script>

<template>
  <!-- 👉 Dashboards -->
  <VerticalNavLink
    :item="{
      title: 'Dashboard',
      icon: 'ri-home-smile-line',
      to: '/user/dashboard',
    }"
  />

  <!-- 👉 Apps & Pages -->
  <VerticalNavSectionTitle
    :item="{
      heading: 'Apps & Pages',
    }"
  />

  <VerticalNavLink
    :item="{
      title: 'Program',
      icon: 'ri-sticky-note-add-line',
      to: '/user/request',
    }"
    v-if="role == 'Mentor'"
  />

  <VerticalNavLink
    :item="{
      title: 'Timesheet',
      icon: 'ri-calendar-todo-line',
      to: '/user/timesheet',
    }"
  />

  <VerticalNavLink
    :item="{
      title: 'Account Settings',
      icon: 'ri-user-settings-line',
      to: '/user/account-settings',
    }"
  />
</template>
