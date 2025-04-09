<script setup>
import { showNotif } from '@/helper/notification'
import ApiService from '@/services/ApiService'
import moment from 'moment'
import { Qalendar } from 'qalendar'

const config = ref({
  defaultMode: 'month',
})

const monthNow = ref(moment().format('YYYY-MM'))

const loading = ref(false)
const events = ref([])
const summarize = ref(null)

const getActivity = async month => {
  loading.value = true
  try {
    const res = await ApiService.get('api/v1/timesheet/component/activity/' + month)

    if (res) {
      events.value = res
    }
  } catch (error) {
    showNotif('error', error.response.data.message, 'bottom-end')
    console.log(error.response)
  } finally {
    loading.value = false
  }
}

const changePeriod = item => {
  if (moment(item.start).format('YYYY-MM-DD') != moment(item.end).format('YYYY-MM-DD')) {
    // Add 7 Days
    const dateNew = new Date(item.start)
    dateNew.setDate(dateNew.getDate() + 7)

    // Format to Month
    const month = moment(dateNew).format('YYYY-MM')

    getActivity(month)
  }
}

onMounted(() => {
  getActivity(monthNow.value)
})
</script>

<template>
  <Qalendar
    :events="events"
    :is-loading="loading"
    :config="config"
    @updated-period="changePeriod"
  />
</template>

<style lang="scss">
@import 'qalendar/dist/style.css';

.qalendar-is-small .calendar-month__weekday.is-today .calendar-month__day-date {
  padding: 2px 9px !important;
}

.qalendar-is-small .calendar-month__event {
  background: rgb(var(--v-theme-primary)) !important;
  width: 8px !important;
  height: 8px !important;
}

.agenda__wrapper .agenda__header .agenda__header-date,
.calendar-month__weekday.is-today .calendar-month__day-date,
.agenda__event {
  background: rgb(var(--v-theme-primary)) !important;
  padding: 5px 10px !important;
}

.agenda__wrapper {
  max-height: 150px;
  overflow: auto;
}
</style>
