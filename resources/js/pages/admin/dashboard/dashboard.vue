<script setup>
import AnalyticsAward from '@/views/dashboard/AnalyticsAward.vue'
import AnalyticsBarCharts from '@/views/dashboard/AnalyticsBarCharts.vue'
import AnalyticsDepositWithdraw from '@/views/dashboard/AnalyticsDepositWithdraw.vue'
import AnalyticsSalesByCountries from '@/views/dashboard/AnalyticsSalesByCountries.vue'
import AnalyticsTotalEarning from '@/views/dashboard/AnalyticsTotalEarning.vue'
import AnalyticsTotalProfitLineCharts from '@/views/dashboard/AnalyticsTotalProfitLineCharts.vue'
import AnalyticsTransactions from '@/views/dashboard/AnalyticsTransactions.vue'
import AnalyticsUserTable from '@/views/dashboard/AnalyticsUserTable.vue'
import AnalyticsWeeklyOverview from '@/views/dashboard/AnalyticsWeeklyOverview.vue'
import CardStatisticsVertical from '@core/components/cards/CardStatisticsVertical.vue'

import { Qalendar } from 'qalendar'

const totalProfit = {
  title: 'Total Profit',
  color: 'secondary',
  icon: 'ri-pie-chart-2-line',
  stats: '$25.6k',
  change: 42,
  subtitle: 'Weekly Project',
}

const newProject = {
  title: 'New Project',
  color: 'primary',
  icon: 'ri-file-word-2-line',
  stats: '862',
  change: -18,
  subtitle: 'Yearly Project',
}

const events = ref([
  {
    title: 'Advanced algebra',
    with: 'Chandler Bing',
    time: { start: '2024-05-16 12:05', end: '2024-05-16 13:35' },
    colorScheme: 'eduall',
    isEditable: false,
    id: '753944708f0f',
    description:
      'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Asperiores assumenda corporis doloremque et expedita molestias necessitatibus quam quas temporibus veritatis. Deserunt excepturi illum nobis perferendis praesentium repudiandae saepe sapiente voluptatem!',
  },
  {
    title: 'Ralph on holiday',
    with: 'Rachel Greene',
    time: { start: '2024-05-10', end: '2024-05-22' },
    colorScheme: 'eduall',
    isEditable: false,
    id: '5602b6f589fc',
  },
])

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

const date = ref(new Date())
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
            <div class="w-50 d-flex justify-end">
              <div>
                <VTextField
                  type="month"
                  density="compact"
                  label="Search"
                  variant="underlined"
                />
              </div>
            </div>
          </div>
          <VRow class="mt-4">
            <VCol md="4">
              <VCard>
                <VCardText>
                  <div class="d-flex justify-between align-center">
                    <div class="w-100">
                      <h2>4</h2>
                      <h6 class="font-weight-light">New Program</h6>
                    </div>
                    <div class="text-end w-25">
                      <VIcon
                        icon="ri-bookmark-3-line"
                        size="30"
                        color="primary"
                      />
                    </div>
                  </div>
                </VCardText>
              </VCard>
            </VCol>
            <VCol md="4">
              <VCard>
                <VCardText>
                  <div class="d-flex justify-between align-center">
                    <div class="w-100">
                      <h2>4</h2>
                      <h6 class="font-weight-light">New Timesheet</h6>
                    </div>
                    <div class="text-end w-25">
                      <VIcon
                        icon="ri-calendar-schedule-line"
                        size="30"
                        color="error"
                      />
                    </div>
                  </div>
                </VCardText>
              </VCard>
            </VCol>
            <VCol md="4">
              <VCard>
                <VCardText>
                  <div class="d-flex justify-between align-center">
                    <div class="w-100">
                      <h2>4</h2>
                      <h6 class="font-weight-light">New Activity</h6>
                    </div>
                    <div class="text-end w-25">
                      <VIcon
                        icon="ri-task-line"
                        size="30"
                        color="warning"
                      />
                    </div>
                  </div>
                </VCardText>
              </VCard>
            </VCol>
          </VRow>
        </VCardText>
      </VCard>
    </VCol>
  </VRow>
</template>

<style>
@import 'qalendar/dist/style.css';

.calendar-month__event {
  background: #bbffa0;
}
</style>
