<script setup>
import VQalendar from '@/components/Qalendar.vue'
import ApiService from '@/services/ApiService'
import moment from 'moment'

const monthModel = ref(moment().format('YYYY-MM'))
const loading = ref(false)
const summarize = ref(null)

const getSummarize = async month => {
  // month = moment(month).format('MMMM')

  loading.value = true
  try {
    const res = await ApiService.get('api/v1/summarize/' + month)

    if (res) {
      summarize.value = res
    }
  } catch (error) {
    console.log(error.response)
  } finally {
    loading.value = false
  }
}

onMounted(() => {
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
          <VQalendar />
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
                <input
                  type="month"
                  class="py-1 px-2 border rounded mb-2"
                  v-model="monthModel"
                  @change="getSummarize(monthModel)"
                />
              </div>
            </div>
          </div>
          <VRow class="mt-4">
            <VCol md="6">
              <VCard>
                <VCardText>
                  <div class="d-flex justify-between align-center">
                    <div class="w-100">
                      <h2>{{ summarize?.program }}</h2>
                      <h4 class="font-weight-light">New Program</h4>
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
            <VCol md="6">
              <VCard>
                <VCardText>
                  <div class="d-flex justify-between align-center">
                    <div class="w-100">
                      <h2>{{ summarize?.timesheet }}</h2>
                      <h4 class="font-weight-light">New Timesheet</h4>
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
            <VCol md="6">
              <VCard>
                <VCardText>
                  <div class="d-flex justify-between align-center">
                    <div class="w-100">
                      <h2>{{ summarize?.activity }}</h2>
                      <h4 class="font-weight-light">New Activity</h4>
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
