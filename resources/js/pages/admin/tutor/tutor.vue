<script setup>
import { showNotif } from '@/helper/notification'
import ApiService from '@/services/ApiService'
import debounce from 'lodash/debounce'
import moment from 'moment'

// Start Variable
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
  const paginate = '&paginate=true'
  try {
    loading.value = true
    const res = await ApiService.get('api/v1/user/mentor-tutors' + page + search + paginate)

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

const searchData = debounce(async () => {
  currentPage.value = 1
  await getData()
}, 1000)

const checkEmail = async email => {
  try {
    const res = await ApiService.post('api/v1/auth/email/checking', {
      email: email,
    })
  } catch (error) {
    console.error(error)
  }
}

const updateInhouse = async (uuid, value, email) => {
  await checkEmail(email)

  try {
    const res = await ApiService.put('api/v1/user/mentor-tutors/' + uuid, {
      inhouse: value ? 1 : 0,
    })

    if (res) {
      showNotif('success', res.message, 'bottom-end')
    }
  } catch (error) {
    console.error(error)
    showNotif('error', error.response?.data?.errors, 'bottom-end')
  }
}

const updateFee = debounce(async (uuid, subject) => {
  try {
    const res = await ApiService.patch('api/v1/user/mentor-tutors/' + uuid + '/subjects/' + subject.id, {
      fee_individual: subject.fee_individual ?? 0,
    })

    if (res) {
      showNotif('success', res.message, 'bottom-end')
    }
  } catch (error) {
    console.error(error)
    showNotif('error', 'Please fill in the field individual fee', 'bottom-end')
  }
}, 1000)
// End Function

onMounted(() => {
  getData()
})
</script>

<template>
  <VCard>
    <VCardTitle>
      <div class="d-flex justify-between align-center">
        <div class="w-100">
          <h4>Tutor/Mentor</h4>
        </div>

        <div class="w-25">
          <VTextField
            v-model="keyword"
            :loading="loading"
            :disabled="loading"
            append-inner-icon="ri-search-line"
            density="compact"
            label="Search"
            hide-details
            single-line
            @input="searchData"
          ></VTextField>
        </div>
      </div>
    </VCardTitle>
    <VCardText>
      <!-- Loader  -->
      <vSkeletonLoader
        class="mx-auto border"
        type="table-thead, table-row@10"
        v-if="loading"
      ></vSkeletonLoader>

      <VTable v-else>
        <thead>
          <tr>
            <th
              class="text-uppercase"
              width="1%"
            >
              No
            </th>
            <th class="text-uppercase text-center">Mentor/Tutor Name</th>
            <th class="text-uppercase text-center">Email</th>
            <th class="text-uppercase text-center">Role</th>
            <th nowrap>Inhouse Mentor</th>
            <th class="text-uppercase text-center">Phone Number</th>
            <th class="text-uppercase text-center">Detail</th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="(item, index) in data.data"
            :key="index"
          >
            <td>
              {{ parseInt(index) + 1 }}
            </td>
            <td nowrap>
              <VIcon
                icon="ri-user-line"
                class="me-3"
              ></VIcon>
              {{ item.full_name }}
            </td>
            <td
              class="text-start"
              nowrap
            >
              <VIcon
                icon="ri-mail-line"
                class="me-3"
              ></VIcon>
              {{ item.email }}
            </td>
            <td
              class="text-start"
              nowrap
            >
              <VIcon
                icon="ri-user-line"
                class="me-3"
              ></VIcon>
              <span
                v-for="(role, index) in item.roles"
                :key="index"
              >
                {{ role.name }}
                <!-- Menambahkan koma jika bukan item terakhir -->
                <span v-if="index < item.roles.length - 1">, </span>
              </span>
            </td>
            <td class="d-flex justify-center">
              <VSwitch
                v-model="item.inhouse"
                @update:modelValue="updateInhouse(item.uuid, item.inhouse, item.email)"
                value="1"
              ></VSwitch>
            </td>
            <td
              class="text-start"
              nowrap
            >
              <VIcon
                icon="ri-smartphone-line"
                class="me-3"
              ></VIcon>
              {{ item.phone }}
            </td>
            <td
              class="text-center"
              nowrap
            >
              <VDialog max-width="700">
                <template v-slot:activator="{ props: activatorProps }">
                  <VIcon
                    icon="ri-folder-info-line"
                    class="cursor-pointer"
                    v-bind="activatorProps"
                  />
                </template>

                <template v-slot:default="{ isActive }">
                  <VCard>
                    <VCardText class="py-5">
                      <div class="d-flex justify-between align-center mb-3">
                        <h4 class="w-100">Detail</h4>

                        <VBtn
                          size="x-small"
                          color="secondary"
                          icon="ri-close-line"
                          @click="isActive.value = false"
                        ></VBtn>
                      </div>
                      <!-- Start Tutor  -->
                      <VTable
                        density="compact"
                        v-if="
                          item.roles.findIndex(role => role.name === 'Tutor') >= 0 ||
                          item.roles.findIndex(role => role.name === 'External Mentor') >= 0
                        "
                      >
                        <thead>
                          <tr>
                            <th
                              class="text-left"
                              nowrap
                            >
                              {{
                                item.roles.findIndex(role => role.name === 'Tutor') >= 0
                                  ? 'Subject Tutoring'
                                  : 'Engagement Type'
                              }}
                            </th>
                            <th nowrap>
                              {{
                                item.roles.findIndex(role => role.name === 'Tutor') >= 0 ? 'Curriculum' : 'Package Name'
                              }}
                            </th>
                            <th nowrap>
                              {{ item.roles.findIndex(role => role.name === 'Tutor') >= 0 ? 'Grade' : 'Stream' }}
                            </th>
                            <th nowrap>Year</th>
                            <th nowrap>Fee Individual - Gross</th>
                          </tr>
                        </thead>
                        <tbody>
                          <template
                            v-for="(sub_item, index) in item.roles"
                            :key="index"
                          >
                            <tr
                              v-if="sub_item.name == 'Tutor' || sub_item.name == 'External Mentor'"
                              v-for="subject in sub_item.subjects"
                              :key="subject"
                            >
                              <td nowrap>
                                {{ sub_item.name == 'Tutor' ? subject.tutor_subject : subject.engagement_type_name }}

                                <a
                                  :href="sub_item.agreement"
                                  target="_blank"
                                  class="ms-2 d-inline cursor-pointer"
                                  v-if="sub_item.agreement"
                                >
                                  <VTooltip
                                    activator="parent"
                                    location="end"
                                  >
                                    Check Agreement
                                  </VTooltip>
                                  <VIcon icon="ri-file-pdf-2-line" />
                                </a>
                              </td>
                              <td nowrap>
                                {{ sub_item.name == 'Tutor' ? subject.curriculum_name : subject.package_name }}
                              </td>
                              <td nowrap>
                                {{ sub_item.name == 'Tutor' ? subject.grade : subject.stream }}
                              </td>
                              <td nowrap>
                                {{
                                  moment(subject.start_date).format('LL') +
                                  ' - ' +
                                  moment(subject.end_date).format('LL')
                                }}
                              </td>
                              <td nowrap>
                                <VTextField
                                  prefix="Rp. "
                                  v-model="subject.fee_individual"
                                  density="compact"
                                  type="number"
                                  label="Fee Gross"
                                  class="my-3"
                                  @update:model-value="updateFee(item.uuid, subject)"
                                />
                              </td>
                            </tr>
                          </template>
                        </tbody>
                      </VTable>
                      <VCardText
                        v-else
                        class="text-center"
                      >
                        There is no tutoring subject
                      </VCardText>
                      <!-- End Tutor  -->
                    </VCardText>
                  </VCard>
                </template>
              </VDialog>
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
          :total-visible="5"
          color="primary"
          density="compact"
          :show-first-last-page="false"
          @update:modelValue="getData"
        />
      </div>
    </VCardText>
  </VCard>
</template>
