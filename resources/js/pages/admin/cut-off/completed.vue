<script setup>
import { confirmBeforeSubmit, showLoading, showNotif } from '@/helper/notification'
import { rules } from '@/helper/rules'
import ApiService from '@/services/ApiService'
import FilterSidebar from '@layouts/components/FilterSidebar.vue'
import moment from 'moment'

const loading = ref(false)
const data = ref([])

const formData = ref()
const downloadDialog = ref(false)
const formDownload = ref({
  cut_off_date: [],
  specific: false,
  timesheet_id: null,
})
const filterActive = ref(false)
const currentPage = ref(1)
const totalPage = ref()
const selected = ref([])
const keyword = ref(null)
const package_id = ref(null)
const package_list = ref([])
const tutor_id = ref(null)
const tutor_list = ref([])
const timesheet = ref([])
const cutOffDate = ref([])

const getData = async () => {
  loading.value = true
  const page = '?page=' + currentPage.value
  const search = keyword.value ? '&keyword=' + keyword.value : ''
  const package_select = package_id.value ? '&package_id=' + package_id.value : ''
  const start_date = cutOffDate.value ? '&start_date=' + moment(cutOffDate.value[0]).format('YYYY-MM-DD') : ''
  const end_date = cutOffDate.value
    ? '&end_date=' + moment(cutOffDate.value[cutOffDate.value.length - 1]).format('YYYY-MM-DD')
    : ''

  try {
    const res = await ApiService.get('api/v1/payment/paid' + page + search + package_select)
    if (res) {
      currentPage.value = res.current_page
      totalPage.value = res.last_page
      data.value = res
    }
  } catch (error) {
    console.error(error)
  } finally {
    loading.value = false
  }
}

const getPackage = async () => {
  loading.value = true
  try {
    const res = await ApiService.get('api/v1/package/component/list')
    if (res) {
      package_list.value = res
      loading.value = false
    }
  } catch (error) {
    loading.value = false
    console.error(error)
  }
}

const getTutor = async () => {
  loading.value = true
  try {
    const res = await ApiService.get('api/v1/user/mentor-tutors')
    if (res) {
      tutor_list.value = res
      loading.value = false
    }
  } catch (error) {
    loading.value = false
    console.error(error)
  }
}

const getTimesheet = async () => {
  loading.value = true
  try {
    const res = await ApiService.get('api/v1/timesheet/component/list')
    if (res) {
      timesheet.value = res
      loading.value = false
    }
  } catch (error) {
    loading.value = false
    console.error(error)
  }
}

const cancelCutOff = async () => {
  const isConfirmed = await confirmBeforeSubmit('Are you sure you want to cancel this activity?')

  const params = {
    activity_id: Object.keys(selected.value).map(key => selected.value[key]),
  }

  if (isConfirmed) {
    loading.value = true
    try {
      const res = await ApiService.patch('api/v1/payment/cut-off/unassign', params)

      if (res) {
        showNotif('success', res.message, 'bottom-end')
        getData()
      }
    } catch (error) {
      showNotif('error', error.response.statusText, 'bottom-end')
      // console.log(error.response)
    } finally {
      loading.value = false
    }
  }
}

const downloadPayroll = async () => {
  let cut_off_date = formDownload.value.cut_off_date
  let start_date = moment(cut_off_date[0]).format('YYYY-MM-DD')
  let end_date = moment(cut_off_date[cut_off_date.length - 1]).format('YYYY-MM-DD')
  let specific = formDownload.value.specific ? '/' + formDownload.value.timesheet_id : ''
  let url = 'api/v1/payment/cut-off/export' + specific + '/' + start_date + '/' + end_date

  const { valid } = await formData.value.validate()
  if (valid) {
    downloadDialog.value = false
    showLoading()
    try {
      const res = await ApiService.get(url, {
        responseType: 'blob',
      })

      if (res) {
        const url = window.URL.createObjectURL(
          new Blob([res], { type: '"application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"' }),
        )

        // Create a temporary <a> element to trigger the download
        const link = document.createElement('a')
        link.href = url
        link.setAttribute('download', `payroll_${start_date}_${end_date}.xlsx`)

        // Append the <a> element to the body and click it to trigger the download
        document.body.appendChild(link)
        link.click()

        // Clean up: remove the <a> element and revoke the blob URL
        document.body.removeChild(link)
        window.URL.revokeObjectURL(url)

        Swal.close()

        formDownload.value.specific = false
        formDownload.value.timesheet_id = null
      }
    } catch (error) {
      showNotif('error', error.response?.statusText, 'bottom-end')
      console.log(error)
    }
  }
}

onMounted(() => {
  getData()
  getPackage()
  getTutor()
  getTimesheet()
})
</script>

<template>
  <!-- FILTER  -->
  <FilterSidebar
    :active="filterActive"
    :width="450"
    @close="filterActive = false"
  >
    <template v-slot:header> Filter </template>
    <template v-slot:content>
      <VRow class="my-1">
        <VCol cols="12">
          <VTextField
            v-model="keyword"
            placeholder="Search"
            prepend-inner-icon="ri-search-line"
            variant="solo"
            @change="getData"
          />
        </VCol>
        <VCol cols="12">
          <VAutocomplete
            clearable="true"
            :loading="loading"
            :disabled="loading"
            label="Package Name"
            :items="package_list"
            :item-title="item => (item.package ? item.type_of + ' - ' + item.package : item.type_of)"
            item-value="id"
            v-model="package_id"
            placeholder="Select Timesheet Package"
            variant="solo"
            @update:modelValue="getData"
          />
        </VCol>
        <VCol cols="12">
          <VAutocomplete
            :loading="loading"
            :disabled="loading"
            clearable="true"
            label="Tutor/Mentor Name"
            :items="tutor_list"
            :item-props="
              item => ({
                title: item.full_name,
                subtitle: item.roles.map(role => role.name).join(', '),
              })
            "
            item-value="uuid"
            v-model="tutor_id"
            placeholder="Select Tutor/Mentor Name"
            variant="solo"
          />
        </VCol>
        <VCol cols="12">
          <VDateInput
            v-model="cutOffDate"
            label="Cut-Off Date"
            prepend-icon=""
            multiple="range"
            color="primary"
            variant="solo"
            @update:modelValue="getData"
          ></VDateInput>
        </VCol>
      </VRow>
    </template>
  </FilterSidebar>

  <!-- DOWNLOAD  -->
  <VDialog
    v-model="downloadDialog"
    width="auto"
  >
    <VCard
      width="450"
      prepend-icon="ri-download-line"
      title="Download Timesheet"
    >
      <VCardText>
        <VForm
          @submit.prevent="downloadPayroll"
          ref="formData"
        >
          <VRow>
            <VCol cols="12">
              <VDateInput
                label="Start - End Date"
                variant="solo"
                prepend-icon=""
                multiple="range"
                v-model="formDownload.cut_off_date"
                :rules="rules.required"
                class="mb-3"
              />
              <VCheckbox
                label="Specific Timesheet"
                v-model="formDownload.specific"
              ></VCheckbox>

              <v-autocomplete
                :loading="loading"
                label="Timesheet - Package"
                variant="solo"
                :items="timesheet"
                :item-props="
                  item => ({
                    title: item.package_type + ' - ' + item.package_name,
                    subtitle: item.clients,
                  })
                "
                item-value="id"
                class="mt-3"
                v-model="formDownload.timesheet_id"
                :disabled="formDownload.specific ? false : true"
              />
            </VCol>
          </VRow>
          <VCardActions class="mt-5">
            <VBtn
              color="error"
              @click="downloadDialog = false"
            >
              <VIcon
                icon="ri-close-line"
                class="me-3"
              />
              Close
            </VBtn>
            <VSpacer />
            <VBtn
              color="success"
              type="submit"
            >
              Download
              <VIcon
                icon="ri-download-line"
                class="ms-3"
              />
            </VBtn>
          </VCardActions>
        </VForm>
      </VCardText>
    </VCard>
  </VDialog>

  <!-- BUTTON & LIST  -->
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
        <VCol cols="6">
          <VBtn
            color="info"
            @click="filterActive = !filterActive"
            v-tooltip:end="'Filter'"
          >
            <VIcon icon="ri-search-line"
          /></VBtn>
        </VCol>
        <VCol
          cols="6"
          class="text-end"
        >
          <VBtn
            color="error"
            class="me-1"
            @click="cancelCutOff"
            v-if="selected.length > 0"
            v-tooltip:start="'Cancel'"
          >
            <VIcon icon="ri-close-line" />
          </VBtn>
          <VBtn
            color="secondary"
            v-tooltip:start="'Download Timesheet'"
            @click="downloadDialog = true"
          >
            <VIcon icon="ri-download-line" />
          </VBtn>
        </VCol>
      </VRow>

      <!-- Loader  -->
      <vSkeletonLoader
        class="mx-auto border"
        type="table-thead, table-row@10"
        v-if="loading"
      ></vSkeletonLoader>
      <VTable
        class="text-no-wrap"
        v-else
      >
        <thead>
          <tr>
            <th class="text-uppercase">#</th>
            <th class="text-uppercase text-center">Timesheet</th>
            <th class="text-uppercase text-center">Activity</th>
            <th class="text-uppercase text-center">Students Name</th>
            <th class="text-uppercase text-center">Activity Date</th>
            <th class="text-uppercase text-center">Mentor/Tutor</th>
            <th class="text-uppercase text-center">Time Spent</th>
            <th class="text-uppercase text-center">Fee/Hours</th>
            <th class="text-uppercase text-center">Total</th>
            <th class="text-uppercase text-center">Cut-Off Date</th>
            <th class="text-uppercase text-center">Cut-Off Status</th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="item in data.data"
            :key="item"
          >
            <td>
              <VCheckbox
                v-model="selected"
                :value="item.id"
              ></VCheckbox>
            </td>
            <td>{{ item.package.type + ' - ' + item.package.name }}</td>
            <td>{{ item.students }}</td>
            <td>{{ item.activity }}</td>
            <td>{{ item.date }}</td>
            <td>{{ item.mentor_tutor }}</td>
            <td>{{ item.time_spent > 0 ? item.time_spent / 60 + ' Hours' : '-' }}</td>
            <td>Rp. {{ new Intl.NumberFormat('id-ID').format(item.fee_hours) }}</td>
            <td>Rp. {{ new Intl.NumberFormat('id-ID').format((item.time_spent / 60) * item.fee_hours) }}</td>
            <td class="text-center">
              {{ item.cutoff_date }}
            </td>
            <td class="text-center">
              <VChip color="success"> {{ item.cutoff_status }} </VChip>
            </td>
          </tr>
        </tbody>
        <thead>
          <tr>
            <th colspan="9">Total Fee</th>
            <th
              colspan="2"
              class="text-end"
            >
              Rp. {{ new Intl.NumberFormat('id-ID').format(data.total_fee) }}
            </th>
          </tr>
        </thead>
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

<style lang="scss"></style>
