<script setup>
import ApiService from '@/services/ApiService'

// Start Variable
const selected = ref([])
const dialog = ref(false)

const currentPage = ref(1)
const totalPage = ref()
const keyword = ref()
const data = ref([])
const loading = ref(false)
// End Variable

// Start Function
const getData = async () => {
  const page = '?page=' + currentPage.value
  const search = keyword.value ? '&keyword=' + keyword.value : ''
  try {
    loading.value = true
    const res = await ApiService.get('api/v1/program/list' + page + search)

    if (res) {
      currentPage.value = res.current_page
      totalPage.value = res.last_page
      data.value = res
    }
    loading.value = false
  } catch (error) {
    console.error(error)
    loading.value = false
  }
}

const searchData = async () => {
  currentPage.value = 1
  await getData()
}
// End Function

onMounted(() => {
  getData()
})

const desserts = [
  {
    dessert: 'Frozen Yogurt',
    calories: 159,
    fat: 6,
    carbs: 24,
    protein: 4,
  },
  {
    dessert: 'Ice cream sandwich',
    calories: 237,
    fat: 6,
    carbs: 24,
    protein: 4,
  },
  {
    dessert: 'Eclair',
    calories: 262,
    fat: 6,
    carbs: 24,
    protein: 4,
  },
  {
    dessert: 'Cupcake',
    calories: 305,
    fat: 6,
    carbs: 24,
    protein: 4,
  },
  {
    dessert: 'Gingerbread',
    calories: 356,
    fat: 6,
    carbs: 24,
    protein: 4,
  },
]
</script>

<template>
  <VCard>
    <VCardTitle>
      <div class="d-flex justify-between align-center">
        <div class="w-100">
          <h4>Program Name</h4>
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
            label="Program Name"
            :items="['Program 1', 'Program 2', 'Program 3']"
            placeholder="Select Program Name"
            density="compact"
            variant="solo"
            hide-details
            single-line
            :loading="loading"
            :disabled="loading"
          />
        </VCol>
        <VCol
          cols="12"
          md="3"
        >
          <VTextField
            :loading="loading"
            :disabled="loading"
            append-inner-icon="ri-search-line"
            density="compact"
            label="Search"
            variant="solo"
            hide-details
            single-line
          />
        </VCol>

        <VCol
          cols="12"
          md="6"
          class="text-end"
        >
          <VBtn
            density="compact"
            :color="selected.length > 0 ? 'warning' : 'primary'"
            class="mb-2"
            :disabled="selected.length > 0 ? false : true"
            @click="dialog = true"
          >
            Assign {{ selected.length > 1 ? 'to Group' : '' }}
          </VBtn>
        </VCol>
      </VRow>

      <!-- Start Assign Modal  -->
      <VDialog
        v-model="dialog"
        width="auto"
        persistent
      >
        <VCard
          width="600"
          prepend-icon="ri-send-plane-line"
          title="Assign to Mentor/Tutor"
        >
          <VCardText>
            <VRow>
              <VCol md="12">
                <VAutocomplete
                  density="compact"
                  clearable
                  label="Mentor/Tutor"
                  :items="['California', 'Colorado', 'Florida', 'Georgia', 'Texas', 'Wyoming']"
                ></VAutocomplete>
              </VCol>
              <VCol md="8">
                <VAutocomplete
                  density="compact"
                  clearable
                  label="Package"
                  :items="['California', 'Colorado', 'Florida', 'Georgia', 'Texas', 'Wyoming']"
                ></VAutocomplete>
              </VCol>
              <VCol md="4">
                <VTextField
                  type="number"
                  density="compact"
                  clearable
                  label="Hours"
                />
              </VCol>
              <VCol md="12">
                <VAutocomplete
                  density="compact"
                  multiple
                  clearable
                  chips
                  label="PIC"
                  :items="['California', 'Colorado', 'Florida', 'Georgia', 'Texas', 'Wyoming']"
                ></VAutocomplete>
              </VCol>
              <VCol md="12">
                <VTextarea label="Notes"></VTextarea>
              </VCol>
            </VRow>

            <VDivider class="my-3" />
            <VCardActions>
              <VBtn
                color="error"
                @click="dialog = false"
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
      <!-- End Assign Modal  -->

      <!-- Loader  -->
      <vSkeletonLoader
        class="mx-auto border"
        type="table-thead, table-row@10"
        v-if="loading"
      ></vSkeletonLoader>
      <VTable
        class="table-responsive"
        v-else
      >
        <thead>
          <tr>
            <th
              class="text-uppercase"
              width="1%"
            >
              #
            </th>
            <th class="text-uppercase text-center">Invoice ID</th>
            <th class="text-uppercase text-center">Student/School Name</th>
            <th class="text-uppercase text-center">Program Name</th>
            <th class="text-uppercase text-center">Timesheet</th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="(item, index) in data.data"
            :key="index"
          >
            <td>
              <VCheckbox
                v-model="selected"
                :value="item"
              ></VCheckbox>
            </td>
            <td nowrap>
              <VIcon
                icon="ri-receipt-line"
                class="me-3"
              ></VIcon>
              {{ item.invoice_id }}
            </td>
            <td
              class="text-left"
              nowrap
            >
              <VIcon
                icon="ri-user-line"
                class="me-3"
              ></VIcon>
              {{ item.student_name + ' - ' + item.student_school }}
            </td>
            <td
              class="text-left"
              nowrap
            >
              <VIcon
                icon="ri-bookmark-line"
                class="me-3"
              ></VIcon>
              {{ item.program_name }}
            </td>
            <td class="text-center">
              <VTooltip
                text="Timesheet already exists."
                v-if="item.timesheet_id"
              >
                <template v-slot:activator="{ props }">
                  <VIcon
                    icon="ri-file-check-line"
                    class="mx-1"
                    color="success"
                    v-bind="props"
                  ></VIcon>
                </template>
              </VTooltip>

              <VTooltip
                text="Not Yet"
                v-else
              >
                <template v-slot:activator="{ props }">
                  <VIcon
                    icon="ri-file-close-line"
                    class="mx-1"
                    color="error"
                    v-bind="props"
                  ></VIcon>
                </template>
              </VTooltip>
            </td>
          </tr>
        </tbody>
        <!-- If Nothing Data  -->
        <tfoot v-if="data?.data?.length == 0">
          <tr>
            <td
              colspan="6"
              class="text-center"
            >
              Sorry, no data found.
            </td>
          </tr>
        </tfoot>
      </VTable>

      <div class="d-flex justify-center mt-5">
        <VPagination
          v-model="currentPage"
          :length="totalPage"
          :total-visible="4"
          color="primary"
          density="compact"
          :show-first-last-page="false"
          @update:modelValue="getData"
        />
      </div>
    </VCardText>
  </VCard>
</template>
