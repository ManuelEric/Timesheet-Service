<script setup>
import { showNotif } from '@/helper/notification'
import ApiService from '@/services/ApiService'
import avatar1 from '@images/avatars/avatar-1.png'
import avatar2 from '@images/avatars/avatar-2.png'
import avatar3 from '@images/avatars/avatar-3.png'
import avatar4 from '@images/avatars/avatar-4.png'
import avatar5 from '@images/avatars/avatar-5.png'
import debounce from 'lodash/debounce'

// Start Variable
const avatars = [avatar1, avatar2, avatar3, avatar4, avatar5]

const selected = ref([])
const currentPage = ref(1)
const totalPage = ref()
const keyword = ref()
const data = ref([])
const loading = ref(false)
const program_list = ref([])
const program_name = ref()
const package_list = ref([])
const package_name = ref()

// End Variable

// Start Function
const getData = async () => {
  const page = '?page=' + currentPage.value
  const search = keyword.value ? '&keyword=' + keyword.value : ''
  const program = program_name.value ? '&program_name=' + encodeURIComponent(program_name.value) : ''
  const package_search = package_name.value ? '&package_id=' + package_name.value : ''
  const paginate = '&paginate=true'
  try {
    loading.value = true
    const res = await ApiService.get('api/v1/timesheet/list' + page + search + program + package_search + paginate)
    // console.log(res)
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

const getPackage = async () => {
  try {
    const res = await ApiService.get('api/v1/package/component/list')
    if (res) {
      package_list.value = res
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
  getPackage()
})
</script>

<template>
  <VCard>
    <VCardTitle>
      <div class="d-flex justify-between align-center">
        <div class="w-100">
          <h4>Timesheet List</h4>
        </div>
      </div>
    </VCardTitle>
    <VCardText>
      <VRow class="my-1 justify-space-between">
        <VCol
          cols="12"
          md="6"
        >
          <VRow>
            <VCol
              cols="12"
              md="6"
            >
              <VAutocomplete
                clearable
                v-model="program_name"
                label="Program Name"
                :items="program_list"
                item-title="program_name"
                placeholder="Select Program Name"
                variant="solo"
                :loading="loading"
                :disabled="loading"
                @update:modelValue="getData"
              />
            </VCol>
            <VCol
              cols="12"
              md="6"
            >
              <VAutocomplete
                clearable="true"
                v-model="package_name"
                label="Package"
                :items="package_list"
                :item-props="
                  item => ({
                    title: item.package != null ? item.type_of + ' - ' + item.package : item.type_of,
                  })
                "
                item-value="id"
                placeholder="Select Package"
                variant="solo"
                :loading="loading"
                :disabled="loading"
                @update:modelValue="getData"
              />
            </VCol>
          </VRow>
        </VCol>
        <VCol
          cols="12"
          md="3"
        >
          <VTextField
            :loading="loading"
            :disabled="loading"
            append-inner-icon="ri-search-line"
            label="Search"
            variant="solo"
            hide-details
            single-line
            v-model="keyword"
            @input="searchData"
          />
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
            <th
              class="text-uppercase"
              width="1%"
            >
              No
            </th>
            <th class="text-uppercase text-center">School/Student Name</th>
            <th class="text-uppercase text-center">Program Name</th>
            <th class="text-uppercase text-center">Package</th>
            <th class="text-uppercase text-center">Tutor/Mentor</th>
            <th class="text-uppercase text-center">PIC</th>
            <th class="text-uppercase text-center">Total Hours</th>
            <th class="text-uppercase text-center">Used</th>
            <th class="text-uppercase text-center">#</th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="(item, index) in data.data"
            :key="index"
            :class="item.void == 'true' ? 'bg-secondary' : ''"
          >
            <td>
              {{ parseInt(index) + 1 }}
            </td>
            <td :class="item.group ? 'cursor-pointer text-left' : 'text-left'">
              <VText v-if="item.group">
                <VIcon
                  icon="ri-group-line"
                  class="me-3"
                />
                {{ item.clients[0] }}
                <VBadge
                  color="error"
                  :content="item.clients.length - 1 + '+'"
                  inline
                >
                </VBadge>

                <VTooltip
                  activator="parent"
                  location="top"
                  transition="scroll-y-transition"
                  class="bg-white"
                >
                  <div v-for="client in item.clients">
                    {{ client }}
                  </div>
                </VTooltip>
              </VText>
              <VText v-else>
                <VIcon
                  icon="ri-user-line"
                  class="me-3"
                />
                {{ item.clients }}
              </VText>
            </td>
            <td>
              <VIcon
                icon="ri-bookmark-3-line"
                class="me-3"
              ></VIcon>
              {{ item.free_trial ? '[TRIAL]' : '' }}
              {{ item.program_name }}
            </td>
            <td class="text-start">
              <VIcon
                icon="ri-bookmark-line"
                class="me-3"
              ></VIcon>
              {{ item.detail_package ? item.package_type + ' - ' + item.detail_package : item.package_type }}
            </td>
            <td class="text-left">
              <VAvatar
                size="25"
                class="avatar-center me-3"
                :image="avatars[index % 5]"
              />
              {{ item.tutor_mentor }}
            </td>
            <td class="text-left">
              <VIcon
                icon="ri-user-line"
                class="cursor-pointer me-3"
              />
              {{ item.admin }}
            </td>
            <td class="text-left">
              <VIcon
                icon="ri-calendar-schedule-line"
                class="cursor-pointer me-3"
              />
              {{ item.duration / 60 }} Hours
            </td>
            <td class="text-left">
              <VIcon
                icon="ri-timer-2-line"
                class="cursor-pointer me-3"
              />
              {{ item.spent / 60 }} Hours
            </td>
            <td>
              <router-link :to="'/admin/timesheet/' + item.id">
                <VBtn :color="item.void == 'true' ? 'light' : 'secondary'">
                  <VIcon
                    icon="ri-timeline-view"
                    class="cursor-pointer"
                  />

                  <VTooltip
                    activator="parent"
                    location="top"
                    transition="scroll-y-transition"
                  >
                    View Detail
                  </VTooltip>
                </VBtn>
              </router-link>
            </td>
          </tr>
        </tbody>
        <!-- If Nothing Data  -->
        <tfoot v-if="data?.data?.length == 0">
          <tr>
            <td
              colspan="9"
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
          :show-first-last-page="false"
          @update:modelValue="getData"
        />
      </div>
    </VCardText>
  </VCard>
</template>
