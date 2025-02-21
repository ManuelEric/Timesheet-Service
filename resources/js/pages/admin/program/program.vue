<script setup>
import program from '@/components/admin/program/program_add.vue'
import { showNotif } from '@/helper/notification'
import ApiService from '@/services/ApiService'
import debounce from 'lodash/debounce'

// Start Variable
const selected = ref([])
const dialog = ref(false)

const currentPage = ref(1)
const totalPage = ref()
const keyword = ref()
const data = ref([])
const loading = ref(false)
const program_list = ref([])
const program_name = ref()

const formData = ref()
const form = ref({
  ref_id: [],
  mentortutor_email: null,
  subject_id: null,
  inhouse_id: null,
  package_id: null,
  duration: '',
  notes: '',
  pic_id: [],
})

// End Variable

// Start Function
const getData = async () => {
  // reset selected
  selected.value = []

  const page = '?page=' + currentPage.value
  const search = keyword.value ? '&keyword=' + keyword.value : ''
  const program = program_name.value ? '&program_name=' + encodeURIComponent(program_name.value) : ''
  const paginate = '&paginate=true'
  try {
    loading.value = true
    const res = await ApiService.get('api/v1/program/list' + page + search + program + paginate)

    if (res) {
      currentPage.value = res.current_page
      totalPage.value = res.last_page
      data.value = res
    }
    loading.value = false
  } catch (error) {
    showNotif('error', error.response?.data?.message, 'bottom-end')
    console.error(error)
    loading.value = false
  }
}

const getProgram = async () => {
  try {
    const res = await ApiService.get('api/v1/program/component/list')
    if (res) {
      program_list.value = res
    }
  } catch (error) {
    console.error(error)
  }
}

const searchData = debounce(async () => {
  currentPage.value = 1
  await getData()
}, 1000)

// End Function

onMounted(() => {
  getData()
  getProgram()
})
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
            clearable
            v-model="program_name"
            label="Program Name"
            :items="program_list"
            item-title="program_name"
            placeholder="Select Program Name"
            density="compact"
            variant="solo"
            hide-details
            single-line
            :loading="loading"
            :disabled="loading"
            @update:modelValue="getData"
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
            v-model="keyword"
            @input="searchData"
          />
        </VCol>

        <VCol
          cols="12"
          md="6"
          class="text-end"
        >
          <VBtn
            v-tooltip:start="'Generate Timesheet'"
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
        <program
          :selected="selected"
          @close="dialog = false"
          @reload="getData"
        />
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
            <!-- <th class="text-uppercase text-center">Invoice ID</th> -->
            <th class="text-uppercase text-center">Student/School Name</th>
            <th class="text-uppercase text-center">Program Name</th>
            <th class="text-uppercase text-center">Trial</th>
            <th class="text-uppercase text-center">Timesheet</th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="(item, index) in data.data"
            :key="index"
            :class="{ 'bg-secondary': selected.includes(item.id) }"
          >
            <td>
              <VCheckbox
                v-model="selected"
                :value="{
                  id: item.id,
                  require: item.require,
                }"
                v-if="!item.timesheet_id"
              ></VCheckbox>
              <VIcon
                icon="ri-check-line"
                color="success"
                v-else
              ></VIcon>
            </td>
            <!-- <td nowrap>
              <VIcon
                icon="ri-receipt-line"
                class="me-3"
              ></VIcon>
              {{ item.invoice_id }}
            </td> -->
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
              {{ item.free_trial ? '[TRIAL]' : '' }}
              {{ item.program_name }}
            </td>
            <td
              class="text-center"
              nowrap
            >
              <VText v-if="item.free_trial">
                <VIcon
                  icon="ri-check-line"
                  class="mx-1"
                  color="success"
                ></VIcon>
              </VText>

              <VText v-else>
                <VIcon
                  icon="ri-close-line"
                  class="mx-1"
                  color="error"
                ></VIcon>
              </VText>
            </td>
            <td class="text-center">
              <VText v-if="item.timesheet_id">
                <VIcon
                  icon="ri-file-check-line"
                  class="mx-1"
                  color="success"
                ></VIcon>
                <v-tooltip
                  activator="parent"
                  location="top"
                  >Already</v-tooltip
                >
              </VText>

              <VText v-else>
                <VIcon
                  icon="ri-file-close-line"
                  class="mx-1"
                  color="error"
                ></VIcon>
                <v-tooltip
                  activator="parent"
                  location="top"
                  >Not Yet</v-tooltip
                >
              </VText>
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
