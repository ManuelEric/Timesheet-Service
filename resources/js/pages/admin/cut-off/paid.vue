<script setup>
const isBulkDialogVisible = ref(false)
const isDialogVisible = ref(false)

const selected = ref([])
</script>

<template>
  <VCard>
    <VCardTitle>
      <div class="d-flex justify-between align-center">
        <div class="w-100">
          <h4>Paid Timesheet</h4>
        </div>
      </div>
    </VCardTitle>
    <VCardText>
      <VRow class="my-1">
        <VCol
          cols="12"
          md="3"
        >
          <VAutocomplete
            clearable="true"
            label="Mentor/Tutor"
            :items="['Mentor 1', 'Mentor 2', 'Mentor 3']"
            placeholder="Select Mentor/Tutor"
            density="compact"
          />
        </VCol>
        <VCol
          cols="7"
          md="3"
        >
          <VAutocomplete
            clearable="true"
            label="Cut-Off Payment"
            :items="['January 2024', 'Febuary 2024', 'March 2024']"
            placeholder="Select Cut-Off Payment"
            density="compact"
          />
        </VCol>
        <VCol
          cols="5"
          md="6"
          class="text-end"
        >
          <VBtn
            color="error"
            density="compact"
            class="me-1"
            @click="isBulkDialogVisible = true"
            v-if="selected.length > 0"
          >
            Cancel
          </VBtn>
          <VMenu
            :close-on-content-click="false"
            location="end"
          >
            <template v-slot:activator="{ props }">
              <VBtn
                density="compact"
                color="secondary"
                v-bind="props"
              >
                Action
              </VBtn>
            </template>
            <VList>
              <VListItem>
                <div
                  class="cursor-pointer"
                  @click="isDialogVisible = true"
                >
                  <VIcon
                    icon="ri-pencil-line"
                    class="me-2"
                  />
                  Add Bonus
                </div>
              </VListItem>
              <VListItem>
                <VListItemTitle>
                  <div class="cursor-pointer">
                    <VIcon
                      icon="ri-download-line"
                      class="me-2"
                    />
                    Download Timesheet
                  </div>
                </VListItemTitle>
              </VListItem>
            </VList>
          </VMenu>
        </VCol>
      </VRow>
      <VTable class="text-no-wrap">
        <thead>
          <tr>
            <th class="text-uppercase">#</th>
            <th
              class="text-uppercase"
              width="1%"
            >
              No
            </th>
            <th class="text-uppercase text-center">Timesheet</th>
            <th class="text-uppercase text-center">Activity</th>
            <th class="text-uppercase text-center">Mentor/Tutor</th>
            <th class="text-uppercase text-center">Time Spent</th>
            <th class="text-uppercase text-center">Fee/Hours</th>
            <th class="text-uppercase text-center">Cut-Off Date</th>
            <th class="text-uppercase text-center">Payment Status</th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="i in 5"
            :key="i"
          >
            <td>
              <VCheckbox
                v-model="selected"
                :value="i"
              ></VCheckbox>
            </td>
            <td>{{ i }}</td>
            <td>Lorem Ipsum</td>
            <td>Lorem Ipsum</td>
            <td>Lorem Ipsum</td>
            <td>60 Minutes</td>
            <td>Rp. 200.000</td>
            <td class="text-center">20 Januari 2024</td>
            <td class="text-end">
              <VChip color="success"> Paid </VChip>
            </td>
          </tr>
        </tbody>
        <thead>
          <tr>
            <th colspan="6">Total Fee</th>
            <th colspan="2">Rp. 2.500.000</th>
          </tr>
        </thead>
      </VTable>

      <div class="d-flex justify-center mt-5">
        <VPagination
          :length="5"
          color="primary"
        />
      </div>
    </VCardText>

    <!-- Cut-Off Dialog -->
    <VDialog
      v-model="isDialogVisible"
      max-width="450"
      persistent
    >
      <VCard title="Cut-Off">
        <VCardText>
          <VRow>
            <VCol cols="12">
              <VAutocomplete
                label="Timesheet - Mentor/Tutor"
                placeholder="Timesheet - Mentor/Tutor"
                :items="['California', 'Colorado', 'Florida', 'Georgia', 'Texas', 'Wyoming']"
              ></VAutocomplete>
            </VCol>
            <VCol cols="6">
              <VTextField
                type="date"
                label="Date"
                placeholder="Date"
              />
            </VCol>
            <VCol cols="6">
              <VTextField
                type="number"
                label="Bonus Fee"
                placeholder="Bonus Fee"
              />
            </VCol>
          </VRow>
        </VCardText>
        <VCardActions>
          <VSpacer />
          <VBtn
            color="error"
            @click="isDialogVisible = false"
          >
            Close
          </VBtn>
          <VBtn color="success"> Save </VBtn>
          <VSpacer />
        </VCardActions>
      </VCard>
    </VDialog>
  </VCard>
</template>

<style lang="scss"></style>
