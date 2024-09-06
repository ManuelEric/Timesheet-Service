<script setup>
import VQalendar from '@/components/Qalendar.vue'
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
