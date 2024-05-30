<script setup>
import VerticalNavSectionTitle from '@/@layouts/components/VerticalNavSectionTitle.vue'
import VerticalNavGroup from '@layouts/components/VerticalNavGroup.vue'
import VerticalNavLink from '@layouts/components/VerticalNavLink.vue'
</script>

<template>
  <!-- 👉 Dashboards -->
  <VerticalNavLink
    :item="{
      title: 'Dashboard',
      icon: 'ri-home-smile-line',
      to: '/admin/dashboard',
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
      title: 'Mentor/Tutor',
      icon: 'ri-user-6-line',
      to: '/admin/tutor',
    }"
  />

  <VerticalNavLink
    :item="{
      title: 'Programs',
      icon: 'ri-honour-line',
      to: '/admin/program',
    }"
  />

  <VerticalNavLink
    :item="{
      title: 'Timesheet',
      icon: 'ri-calendar-todo-line',
      to: '/admin/timesheet',
    }"
  />

  <VerticalNavGroup
    :item="{
      title: 'Cut Off',
      icon: 'ri-scissors-cut-line',
    }"
  >
    <VerticalNavLink
      :item="{
        title: 'Unpaid',
        icon: 'ri-calendar-todo-line',
        to: '/admin/unpaid',
      }"
    />

    <VerticalNavLink
      :item="{
        title: 'Paid',
        icon: 'ri-calendar-todo-line',
        to: '/admin/paid',
      }"
    />
  </VerticalNavGroup>

  <VerticalNavLink
    :item="{
      title: 'Account Settings',
      icon: 'ri-user-settings-line',
      to: '/admin/account-settings',
    }"
  />
</template>
