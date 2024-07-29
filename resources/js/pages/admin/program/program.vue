<script setup>
import { showNotif } from '@/helper/notification'
import { rules } from '@/helper/rules'
import ApiService from '@/services/ApiService'

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
const tutor_selected = ref([])
const tutor_list = ref([])
const subjects = ref([])
const package_list = ref([])
const pic_list = ref([])
const inhouse_mentor = ref([])
const duration_readonly = ref(false)

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
  const page = '?page=' + currentPage.value
  const search = keyword.value ? '&keyword=' + keyword.value : ''
  const program = program_name.value ? '&program_name=' + program_name.value : ''
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

const getTutor = async (inhouse = false) => {
  const url = inhouse ? 'api/v1/user/mentor-tutors?inhouse=true' : 'api/v1/user/mentor-tutors'
  try {
    const res = await ApiService.get(url)
    if (res) {
      if (inhouse) {
        inhouse_mentor.value = Object.values(res)
      } else {
        tutor_list.value = res
      }
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

const checkPackage = () => {
  const package_id = form.value.package_id
  const index = package_list.value.findIndex(item => item.id === package_id)
  let item = package_list.value[index]

  if (item.detail) {
    duration_readonly.value = true
    form.value.duration = item.detail
  } else {
    duration_readonly.value = false
    form.value.duration = null
  }
}

const getPIC = async () => {
  try {
    const res = await ApiService.get('api/v1/user/component/list')
    if (res) {
      pic_list.value = res
    }
  } catch (error) {
    console.error(error)
  }
}

const getSubject = async uuid => {
  form.value.subject_id = null
  try {
    const res = await ApiService.get('api/v1/user/mentor-tutors/' + uuid + '/subjects')
    if (res) {
      subjects.value = res
    }
  } catch (error) {
    console.error(error)
  }
}

const searchData = async () => {
  currentPage.value = 1
  await getData()
}

const submit = async () => {
  form.value.mentortutor_email = tutor_selected.value.email
  // console.log(form.value)
  const { valid } = await formData.value.validate()
  if (valid) {
    // set ref id first
    form.value.ref_id = selected.value

    try {
      const res = await ApiService.post('api/v1/timesheet/create', form.value)
      if (res) {
        showNotif('success', res.message, 'bottom-end')
        selected.value = []
        dialog.value = false
        form.value = {
          ref_id: [],
          mentortutor_email: null,
          subject_id: null,
          inhouse_id: null,
          package_id: null,
          duration: '',
          notes: '',
          pic_id: [],
        }
        tutor_selected.value = []
        getData()
      }
    } catch (error) {
      if (error?.response?.data?.errors) {
        const validationErrors = error.response.data.errors
        let errorMessage = 'Validation errors:'

        // Merge validation errors
        for (const key in validationErrors) {
          if (validationErrors.hasOwnProperty(key)) {
            errorMessage += `\n${key}: ${validationErrors[key].join(', ')}`
          }
        }
        showNotif('error', errorMessage, 'bottom-end')
      }
    }
  }
}
// End Function

onMounted(() => {
  getData()
  getProgram()
  getTutor()
  getTutor(true)
  getPackage()
  getPIC()
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
          md="5"
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
            @change="searchData"
          />
        </VCol>

        <VCol
          cols="12"
          md="4"
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
            <VForm
              @submit.prevent="submit"
              ref="formData"
              validate-on="input"
              fast-fail
            >
              <VRow>
                <VCol md="12">
                  <VAutocomplete
                    density="compact"
                    clearable
                    v-model="tutor_selected"
                    label="Mentor/Tutor"
                    :items="tutor_list"
                    :item-props="
                      item => ({
                        title: item.first_name + ' ' + item.last_name,
                      })
                    "
                    :rules="rules.required"
                    @update:modelValue="getSubject(tutor_selected.uuid)"
                  ></VAutocomplete>
                </VCol>
                <VCol
                  md="12"
                  v-if="subjects.length > 0"
                >
                  <VAutocomplete
                    density="compact"
                    clearable
                    v-model="form.subject_id"
                    label="Subject Tutoring"
                    :items="subjects"
                    item-title="subject"
                    item-value="id"
                    :rules="rules.required"
                  ></VAutocomplete>
                </VCol>
                <VCol md="8">
                  <VAutocomplete
                    density="compact"
                    clearable
                    label="Package"
                    v-model="form.package_id"
                    :items="package_list"
                    :item-props="
                      item => ({ title: item.package != null ? item.type_of + ' - ' + item.package : item.type_of })
                    "
                    item-value="id"
                    :rules="rules.required"
                    @update:modelValue="checkPackage"
                  ></VAutocomplete>
                </VCol>
                <VCol md="4">
                  <VTextField
                    type="number"
                    density="compact"
                    clearable
                    :label="+form.duration / 60 ? 'Minutes (' + form.duration / 60 + ' Hours)' : 'Minutes'"
                    :readonly="duration_readonly"
                    v-model="form.duration"
                    :rules="rules.required"
                  />
                </VCol>
                <VCol md="12">
                  <VAutocomplete
                    density="compact"
                    clearable
                    v-model="form.inhouse_id"
                    label="Inhouse Mentor/Tutor"
                    :items="inhouse_mentor"
                    :item-props="
                      item => ({
                        title: item.first_name + ' ' + item.last_name,
                      })
                    "
                    item-value="uuid"
                    :rules="rules.required"
                  ></VAutocomplete>
                </VCol>
                <VCol md="12">
                  <VAutocomplete
                    density="compact"
                    multiple
                    clearable
                    chips
                    label="PIC"
                    v-model="form.pic_id"
                    :items="pic_list"
                    item-title="full_name"
                    item-value="id"
                    :rules="rules.required"
                  ></VAutocomplete>
                </VCol>
                <VCol md="12">
                  <VTextarea
                    label="Notes"
                    v-model="form.notes"
                  ></VTextarea>
                </VCol>
              </VRow>

              <VDivider class="my-3" />
              <VCardActions>
                <VBtn
                  color="error"
                  type="button"
                  @click="dialog = false"
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
                  Save
                  <VIcon
                    icon="ri-save-line"
                    class="ms-3"
                  />
                </VBtn>
              </VCardActions>
            </VForm>
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
            :class="{ 'bg-secondary': selected.includes(item.id) }"
          >
            <td>
              <VCheckbox
                v-model="selected"
                :value="item.id"
                v-if="!item.timesheet_id"
              ></VCheckbox>
              <VIcon
                icon="ri-check-line"
                color="success"
                v-else
              ></VIcon>
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
