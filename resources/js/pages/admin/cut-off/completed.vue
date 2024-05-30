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
          <h4>Completed Cut-Off</h4>
        </div>
      </div>
    </VCardTitle>
    <VCardText>
      <VRow class="my-1">
        <VCol
          cols="12"
          md="2"
        >
          <VAutocomplete
            clearable="true"
            label="Program Name"
            :items="['Program 1', 'Program 2', 'Program 3']"
            placeholder="Select Program Name"
            density="compact"
          />
        </VCol>
        <VCol
          cols="12"
          md="3"
        >
          <VAutocomplete
            clearable="true"
            label="Timesheet - Package"
            :items="['Timesheet 1', 'Timesheet 2', 'Timesheet 3']"
            placeholder="Select Timesheet"
            density="compact"
          />
        </VCol>
        <VCol
          cols="12"
          md="2"
        >
          <VTextField
            type="date"
            density="compact"
            label="Cut-Off Date"
            clearable
          />
        </VCol>
        <VCol
          cols="12"
          md="5"
          class="text-end"
        >
          <VBtn
            color="error"
            density="compact"
            class="me-1"
            @click="isBulkDialogVisible = true"
            v-if="selected.length > 0"
          >
            <VIcon
              icon="ri-close-line"
              class="me-2"
            />
            Cancel
          </VBtn>
          <VMenu
            :close-on-content-click="false"
            location="bottom"
          >
            <template v-slot:activator="{ props }">
              <VBtn
                density="compact"
                color="secondary"
                v-bind="props"
              >
                Action
                <VIcon class="ri-arrow-down-s-line ms-2" />
              </VBtn>
            </template>
            <VList>
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
            <th class="text-uppercase text-center">Cut-Off Status</th>
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
            <td class="text-center">
              <VChip color="success"> Paid </VChip>
            </td>
          </tr>
        </tbody>
        <thead>
          <tr>
            <th colspan="8">Total Fee</th>
            <th
              colspan="2"
              class="text-end"
            >
              Rp. 2.500.000
            </th>
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
  </VCard>
</template>

<style lang="scss"></style>
