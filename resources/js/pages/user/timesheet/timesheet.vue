<script setup>
import { showNotif } from '@/helper/notification'
import ApiService from '@/services/ApiService'
import UserService from '@/services/UserService'
import { onUpdated } from 'vue'
import { useRouter } from 'vue-router'

const props = defineProps({ cat: String })
const router = useRouter()
const currentPage = ref(1)
const role = ref(UserService.getUser().role_detail[0].role.toLowerCase())
const totalPage = ref()
const keyword = ref()
const data = ref([])
const loading = ref(false)
const package_list = ref([])
const package_name = ref()

// End Variable

// Start Function
const getData = async () => {
  const page = '?page=' + currentPage.value
  const search = keyword.value ? '&keyword=' + keyword.value : ''
  const package_search = package_name.value ? '&package_id=' + package_name.value : ''
  const paginate = '&paginate=true'
  const is_subject = role.value == 'tutor' || props?.cat == 'tutoring' ? '' : '&is_subject_specialist=true'

  try {
    loading.value = true
    const res = await ApiService.get('api/v1/timesheet/list' + page + search + package_search + is_subject + paginate)
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

const getPackage = async () => {
  // Check Role
  const temp_role =
    UserService.getUser().role_detail[0].role.toLowerCase() == 'external mentor'
      ? 'mentor'
      : UserService.getUser().role_detail[0].role.toLowerCase()

  const role = UserService.getUser().role_detail.length == 1 ? '?category=' + temp_role : ''

  try {
    const res = await ApiService.get('api/v1/package/component/list' + role)
    if (res) {
      package_list.value = res
    }
  } catch (error) {
    console.error(error)
  }
}

const searchData = async () => {
  currentPage.value = 1
  await getData()
}

const goToTimesheet = (id, require) => {
  router.push('/user/timesheet/' + id + '/' + require.toLowerCase())
}
// End Function

onUpdated(() => {
  getData()
})

onMounted(() => {
  console.log(UserService.getUser())
  getData()
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
                clearable="true"
                v-model="package_name"
                label="Package"
                :items="package_list"
                :item-props="
                  item => ({ title: item.package != null ? item.type_of + ' - ' + item.package : item.type_of })
                "
                item-value="id"
                placeholder="Select Package"
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
            hide-details
            single-line
            v-model="keyword"
            @change="searchData"
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
        hover
      >
        <thead>
          <tr>
            <th
              class="text-uppercase"
              width="1%"
            >
              No
            </th>
            <th class="text-uppercase text-center">Student Name</th>
            <th class="text-uppercase text-center">Program Name</th>
            <th class="text-uppercase text-center">Package</th>
            <th class="text-uppercase text-center">{{ role == 'tutor' ? 'Tutor' : 'Mentor' }}</th>
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
            class="cursor-pointer"
            @click="goToTimesheet(item.id, item.require)"
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

              <VBadge
                color="success"
                :content="'Done'"
                inline
                v-if="item.spent == item.duration"
                class="ms-2"
              >
              </VBadge>
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
              <VIcon
                icon="ri-user-line"
                class="mr-2"
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
              {{ (item.spent / 60).toFixed(2) }} Hours
            </td>
            <td>
              <router-link :to="'/user/timesheet/' + item.id + '/' + item.require.toLowerCase()">
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
