<script setup>
import { confirmBeforeSubmit, showLoading, showNotif } from '@/helper/notification'
import ApiService from '@/services/ApiService'
import debounce from 'lodash/debounce'
import moment from 'moment'
import Swal from 'sweetalert2'

const loading = ref(false)
const data = ref([])

const formDownload = ref({
  cut_off_date: [],
  specific: false,
  timesheet_id: null,
})
const currentPage = ref(1)
const totalPage = ref()
const selected = ref([])
const keyword = ref(null)
const package_id = ref(null)
const package_list = ref([])
const tutor_id = ref(null)
const tutor_list = ref([])
const timesheet = ref([])
const cutOffDate = ref(null)

const getData = async () => {
  if (cutOffDate.value) {
    loading.value = true
    const page = '?page=' + currentPage.value
    const search = keyword.value ? '&keyword=' + keyword.value : ''
    const package_select = package_id.value ? '&package_id=' + package_id.value : ''
    const start_date = cutOffDate.value ? '&cutoff_start=' + moment(cutOffDate.value[0]).format('YYYY-MM-DD') : ''
    const end_date = cutOffDate.value
      ? '&cutoff_end=' + moment(cutOffDate.value[cutOffDate.value.length - 1]).format('YYYY-MM-DD')
      : ''
    const tutor = tutor_id.value ? '&mentor_id=' + tutor_id.value : ''

    const url = 'api/v1/payment/paid' + page + search + package_select + start_date + end_date + tutor

    try {
      const res = await ApiService.get(url)
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
  } else {
    showNotif('info', 'Please fill in cutoff date first!', 'bottom-end')
    package_id.value = null
    tutor_id.value = null
  }
}

const searchData = debounce(async () => {
  await getData()
}, 1000)

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

const getTimesheet = async () => {
  let cut_off_date = cutOffDate.value
  let start_date = moment(cut_off_date[0]).format('YYYY-MM-DD')
  let end_date = moment(cut_off_date[cut_off_date.length - 1]).format('YYYY-MM-DD')

  const url = 'api/v1/timesheet/component/list?cutoff_start=' + start_date + '&cutoff_end=' + end_date

  loading.value = true
  try {
    const res = await ApiService.get(url)
    if (res) {
      timesheet.value = res
      loading.value = false
    }
  } catch (error) {
    loading.value = false
    console.error(error)
  }
}

const downloadPayroll = async data => {
  let cut_off_date = cutOffDate.value
  let start_date = moment(cut_off_date[0]).format('YYYY-MM-DD')
  let end_date = moment(cut_off_date[cut_off_date.length - 1]).format('YYYY-MM-DD')
  let specific = formDownload.value.specific ? '/' + formDownload.value.timesheet_id : ''

  let url =
    data == 'timesheet'
      ? 'api/v1/payment/cut-off/export' + specific + '/' + start_date + '/' + end_date
      : 'api/v1/payment/cut-off/summarize/' + start_date + '/' + end_date

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
      link.setAttribute(
        'download',
        data == 'timesheet' ? `Timesheet_${start_date}_${end_date}.xlsx` : `Payroll_${start_date}_${end_date}.xlsx`,
      )

      // Append the <a> element to the body and click it to trigger the download
      document.body.appendChild(link)
      link.click()

      // Clean up: remove the <a> element and revoke the blob URL
      document.body.removeChild(link)
      window.URL.revokeObjectURL(url)

      Swal.close()
      showNotif('success', 'Successfully downloaded', 'bottom-end')
    }
  } catch (error) {
    showNotif('error', 'Cut-Off date is not found!', 'bottom-end')
    console.log(error)
  }
}

watch(() => {
  // getData()
})

onMounted(() => {
  getData()
  getPackage()
  getTutor()
})
</script>

<template>
  <!-- FILTER  -->
  <VRow>
    <VCol
      md="4"
      cols="12"
    >
      <VDateInput
        v-model="cutOffDate"
        label="Cut-Off Date"
        prepend-icon=""
        multiple="range"
        color="primary"
        :clearable="true"
        variant="outlined"
        density="compact"
        @update:modelValue="getData"
      ></VDateInput>
    </VCol>
    <VCol
      md="4"
      cols="12"
    >
      <VAutocomplete
        :clearable="true"
        :loading="loading"
        :disabled="loading"
        label="Package Name"
        :items="package_list"
        :item-title="item => (item.package ? item.type_of + ' - ' + item.package : item.type_of)"
        item-value="id"
        v-model="package_id"
        placeholder="Select Timesheet Package"
        density="compact"
        @update:modelValue="getData"
      />
    </VCol>
    <VCol
      md="4"
      cols="12"
    >
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
        item-value="id"
        v-model="tutor_id"
        placeholder="Select Tutor/Mentor Name"
        density="compact"
        @update:modelValue="getData"
      />
    </VCol>
  </VRow>

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
        <VCol cols="12">
          <VBtn
            color="error"
            class="me-3"
            @click="cancelCutOff"
            v-if="selected.length > 0"
            v-tooltip:start="'Cancel'"
          >
            <VIcon icon="ri-close-line" />
          </VBtn>
          <VBtn
            size="small"
            variant="tonal"
            type="button"
            color="info"
            class="me-2"
            :loading="loading"
            :disabled="loading"
            @click.prevent="downloadPayroll('recap')"
            v-if="data?.data?.length > 0"
          >
            Recap
            <VIcon
              icon="ri-download-line"
              class="ms-3"
            />
          </VBtn>
          <VBtn
            size="small"
            variant="tonal"
            color="success"
            type="submit"
            :loading="loading"
            :disabled="loading"
            v-if="data?.data?.length > 0"
            @click.prevent="downloadPayroll('timesheet')"
          >
            Timesheet
            <VIcon
              icon="ri-download-line"
              class="ms-3"
            />
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
            <td>{{ item.activity }}</td>
            <td>{{ item.students }}</td>
            <td>{{ item.date }}</td>
            <td>{{ item.mentor_tutor }}</td>
            <td>{{ item.time_spent > 0 ? (item.time_spent / 60).toFixed(2) + ' Hours' : '-' }}</td>
            <td>Rp. {{ new Intl.NumberFormat('id-ID').format(item.fee_hours) }}</td>
            <td>
              Rp.
              {{
                ['Bonus Fee"', 'Additional Fee'].includes(item.activity)
                  ? new Intl.NumberFormat('id-ID').format((item.time_spent / 60) * item.fee_hours)
                  : new Intl.NumberFormat('id-ID').format(item.fee_hours)
              }}
            </td>
            <td class="text-center">
              {{ item.cutoff_date }}
            </td>
            <td class="text-center text-capitalize">
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
        <!-- If Nothing Data  -->
        <tfoot v-if="data?.data?.length == 0">
          <tr>
            <td
              colspan="10"
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

<style lang="scss"></style>
