<script setup>
import VerticalNavSectionTitle from '@/@layouts/components/VerticalNavSectionTitle.vue'
import UserService from '@/services/UserService'
import VerticalNavLink from '@layouts/components/VerticalNavLink.vue'
import { onMounted } from 'vue'

const role = ref(null)
const roles = ref(null)
onMounted(() => {
  const user = UserService.getUser()
  role.value = user.role
  roles.value = user.roles
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
      title: 'New Request',
      icon: 'ri-sticky-note-add-line',
      to: '/user/request',
    }"
    v-if="role == 'Mentor'"
  />

  <div class="">
    <VTooltip
      :activator="'parent'"
      :location="'top'"
    >
      Tutoring Timesheet
    </VTooltip>
    <VerticalNavLink
      :item="{
        title: 'Tutoring Timesheet',
        icon: 'ri-calendar-todo-line',
        to: '/user/timesheet/tutoring',
      }"
      v-if="roles?.includes('Tutor')"
    />
  </div>

  <div class="">
    <VTooltip
      :activator="'parent'"
      :location="'top'"
    >
      Specialist Timesheet
    </VTooltip>
    <VerticalNavLink
      :item="{
        title: 'Subject Specialist Timesheet',
        icon: 'ri-calendar-todo-line',
        to: '/user/timesheet/specialist',
      }"
      v-if="roles?.includes('External Mentor') || role == 'Mentor'"
    />
  </div>

  <VerticalNavLink
    :item="{
      title: 'Account Settings',
      icon: 'ri-user-settings-line',
      to: '/user/account-settings',
    }"
  />
</template>
