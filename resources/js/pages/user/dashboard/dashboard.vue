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
