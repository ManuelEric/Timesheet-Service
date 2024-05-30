<script setup>
const isDialogVisible = ref({
  cut_off: false,
  additional_fee: false,
  add_bonus: false,
  add_existing: false,
})

const selected = ref([])
</script>

<template>
  <VCard>
    <VCardTitle>
      <div class="d-flex justify-between align-center">
        <div class="w-100">
          <h4>Pre Cut-Off</h4>
        </div>
      </div>
    </VCardTitle>
    <VCardText>
      <VRow class="my-1">
        <VCol
          cols="3"
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
          cols="3"
          md="3"
        >
          <VAutocomplete
            clearable="true"
            label="Timesheet - Package"
            :items="['Timesheet 1', 'Timesheet 2', 'Timesheet 3']"
            placeholder="Select Timesheet - Package"
            density="compact"
          />
        </VCol>
        <VCol
          cols="6"
          md="7"
          class="text-end"
        >
          <VBtn
            color="warning"
            density="compact"
            class="me-1"
            @click="isDialogVisible.add_existing = true"
            v-if="selected.length > 0"
          >
            <VIcon
              icon="ri-add-box-line"
              class="me-2"
            />
            Add to Existing Cut-Off
          </VBtn>

          <VMenu
            :close-on-content-click="false"
            location="bottom"
          >
            <template v-slot:activator="{ props }">
              <VBtn
                density="compact"
                color="light-primary"
                v-bind="props"
                class="me-1"
              >
                Additional Fee
                <VIcon
                  icon="ri-arrow-down-s-line"
                  class="ms-2"
                />
              </VBtn>
            </template>
            <VList>
              <VListItem>
                <div
                  class="cursor-pointer"
                  @click="isDialogVisible.additional_fee = true"
                >
                  <VIcon
                    icon="ri-wallet-2-line"
                    class="me-2"
                  />
                  Additional Fee
                </div>
              </VListItem>
              <VListItem>
                <div
                  class="cursor-pointer"
                  @click="isDialogVisible.add_bonus = true"
                >
                  <VIcon
                    icon="ri-wallet-3-line"
                    class="me-2"
                  />
                  Add Bonus
                </div>
              </VListItem>
            </VList>
          </VMenu>
          <VBtn
            color="secondary"
            density="compact"
            @click="isDialogVisible.cut_off = true"
          >
            <VIcon
              icon="ri-scissors-cut-line"
              class="me-2"
            />
            Cut-Off
          </VBtn>
        </VCol>
      </VRow>
      <VTable class="text-no-wrap">
        <thead>
          <tr>
            <th
              class="text-uppercase"
              width="1%"
            >
              #
            </th>
            <th
              class="text-uppercase"
              width="1%"
            >
              No
            </th>
            <th class="text-uppercase text-center">Timesheet</th>
            <th class="text-uppercase text-center">Activity</th>
            <th class="text-uppercase text-center">Mentor/Tutor</th>
            <th class="text-uppercase text-center">Date & Time</th>
            <th class="text-uppercase text-center">Time Spent</th>
            <th class="text-uppercase text-center">Fee/Hours</th>
            <th class="text-uppercase text-center">Cut-Offf Status</th>
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
            <td>10 Januari 2024 (14.00 - 15.00)</td>
            <td>60 Minutes</td>
            <td>Rp. 200.000</td>
            <td class="text-center">
              <VChip color="#214223"> Not Yet </VChip>
            </td>
          </tr>
        </tbody>
      </VTable>

      <div class="d-flex justify-center mt-5">
        <VPagination
          v-model="currentPage"
          :length="5"
          color="primary"
        />
      </div>
    </VCardText>

    <!-- Cut-Off Dialog -->
    <VDialog
      v-model="isDialogVisible.cut_off"
      max-width="450"
      persistent
    >
      <VCard title="Cut-Off Date">
        <VCardText>
          <VRow>
            <VCol cols="6">
              <VTextField
                type="date"
                label="Start Date"
                placeholder="Activity"
              />
            </VCol>
            <VCol cols="6">
              <VTextField
                type="date"
                label="End Date"
                placeholder="Activity"
              />
            </VCol>
          </VRow>
          <VDivider class="my-3" />
          <VCardActions>
            <VBtn
              color="error"
              @click="isDialogVisible.cut_off = false"
            >
              <VIcon
                icon="ri-close-line"
                class="me-3"
              />
              Close
            </VBtn>
            <VSpacer />
            <VBtn color="success">
              Save
              <VIcon
                icon="ri-save-line"
                class="ms-3"
              />
            </VBtn>
          </VCardActions>
        </VCardText>
      </VCard>
    </VDialog>

    <!-- Add Existing Dialog -->
    <VDialog
      v-model="isDialogVisible.add_existing"
      max-width="300"
      persistent
      scrollable
    >
      <VCard title="Add to Cut-Off">
        <VCardText>
          <VRow>
            <VCol cols="12">
              <VTextField
                type="date"
                density="compact"
              ></VTextField>
            </VCol>
          </VRow>

          <VDivider class="my-3" />
          <VCardActions>
            <VBtn
              color="error"
              @click="isDialogVisible.add_existing = false"
            >
              <VIcon
                icon="ri-close-line"
                class="me-3"
              />
              Close
            </VBtn>
            <VSpacer />
            <VBtn color="success">
              Save
              <VIcon
                icon="ri-save-line"
                class="ms-3"
              />
            </VBtn>
          </VCardActions>
        </VCardText>
      </VCard>
    </VDialog>
  </VCard>

  <!-- Add Bonus Dialog -->
  <VDialog
    v-model="isDialogVisible.add_bonus"
    max-width="450"
    persistent
  >
    <VCard title="Add Bonus">
      <VCardText>
        <VRow>
          <VCol cols="12">
            <VAutocomplete
              label="Timesheet - Package"
              density="compact"
              placeholder="Timesheet - Package"
              :items="['California', 'Colorado', 'Florida', 'Georgia', 'Texas', 'Wyoming']"
            ></VAutocomplete>
          </VCol>
          <VCol cols="6">
            <VTextField
              type="date"
              label="Date"
              density="compact"
              placeholder="Date"
            />
          </VCol>
          <VCol cols="6">
            <VTextField
              type="number"
              label="Bonus Fee"
              density="compact"
              placeholder="Bonus Fee"
            />
          </VCol>
        </VRow>
        <VDivider class="my-3" />
        <VCardActions>
          <VBtn
            color="error"
            @click="isDialogVisible.add_bonus = false"
          >
            <VIcon
              icon="ri-close-line"
              class="me-3"
            />
            Close
          </VBtn>
          <VSpacer />
          <VBtn color="success">
            Save
            <VIcon
              icon="ri-save-line"
              class="ms-3"
            />
          </VBtn>
        </VCardActions>
      </VCardText>
    </VCard>
  </VDialog>

  <!-- Additional Fee Dialog -->
  <VDialog
    v-model="isDialogVisible.additional_fee"
    max-width="450"
    persistent
  >
    <VCard title="Add Additional Fee">
      <VCardText>
        <VRow>
          <VCol cols="12">
            <VAutocomplete
              label="Timesheet - Package"
              placeholder="Timesheet - Package"
              :items="['California', 'Colorado', 'Florida', 'Georgia', 'Texas', 'Wyoming']"
              density="compact"
            ></VAutocomplete>
          </VCol>
          <VCol cols="6">
            <VTextField
              type="date"
              label="Date"
              placeholder="Date"
              density="compact"
            />
          </VCol>
          <VCol cols="6">
            <VTextField
              type="number"
              label="Additional Fee"
              placeholder="Additional Fee"
              density="compact"
            />
          </VCol>
        </VRow>
        <VDivider class="my-3" />
        <VCardActions>
          <VBtn
            color="error"
            @click="isDialogVisible.additional_fee = false"
          >
            <VIcon
              icon="ri-close-line"
              class="me-3"
            />
            Close
          </VBtn>
          <VSpacer />
          <VBtn color="success">
            Save
            <VIcon
              icon="ri-save-line"
              class="ms-3"
            />
          </VBtn>
        </VCardActions>
      </VCardText>
    </VCard>
  </VDialog>
</template>

<style lang="scss"></style>
