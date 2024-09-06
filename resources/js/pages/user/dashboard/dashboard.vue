<script setup>
import ApiService from '@/services/ApiService'
import moment from 'moment'
import { Qalendar } from 'qalendar'

const monthNow = ref(moment().format('MMMM'))
const monthModel = ref(moment().format('YYYY-MM'))

const loading = ref(false)
const events = ref([])
const summarize = ref(null)

const config = ref({
  defaultMode: 'month',
  style: {
    colorSchemes: {
      eduall: {
        color: '#fff',
        backgroundColor: '#0000FF',
      },
    },
  },
})

const getActivity = async month => {
  loading.value = true
  try {
    const res = await ApiService.get('api/v1/timesheet/component/activity/' + month.toLowerCase())

    if (res) {
      events.value = res
    }
  } catch (error) {
    console.log(error.response)
  } finally {
    loading.value = false
  }
}

const getSummarize = async month => {
  month = moment(month).format('MMMM')
  loading.value = true
  try {
    const res = await ApiService.get('api/v1/summarize/' + month.toLowerCase())

    if (res) {
      summarize.value = res
    }
  } catch (error) {
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
    const month = moment(dateNew).format('MMMM')

    getActivity(month)
  }
}

onMounted(() => {
  getActivity(monthNow.value)
  getSummarize(monthModel.value)
})
</script>

<template>
  <VRow>
    <VCol
      cols="12"
      md="6"
    >
      <VCard title="My Calendar">
        <VCardText>
          <Qalendar
            :events="events"
            :config="config"
            :is-loading="loading"
            @updated-period="changePeriod"
          />
        </VCardText>
      </VCard>
    </VCol>
    <VCol
      cols="12"
      md="6"
    >
      <VCard>
        <VCardText>
          <div class="d-flex justify-between align-center">
            <h3 class="font-weight-light w-100">Summaries</h3>
            <div>
              <input
                type="month"
                class="py-1 px-2 border rounded mb-2"
                v-model="monthModel"
                @change="getSummarize(monthModel)"
              />
            </div>
          </div>
          <VRow>
            <VCol cols="6">
              <VCard title="Total Activity">
                <VCardText>
                  <h2 class="text-primary">{{ summarize?.activity }} Activities</h2>
                </VCardText>
              </VCard>
            </VCol>
            <VCol cols="6">
              <VCard title="Total Hours">
                <VCardText>
                  <h2 class="text-primary">{{ summarize?.total_hours / 60 }} Hours</h2>
                </VCardText>
              </VCard>
            </VCol>
          </VRow>
        </VCardText>
      </VCard>
    </VCol>
  </VRow>
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
