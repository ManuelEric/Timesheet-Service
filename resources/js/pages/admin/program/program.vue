<script setup>
import ProgramTutor from '@/components/admin/program/program_add.vue'
import ProgramMentor from '@/components/admin/program/program_add_specialist.vue'
import { showNotif } from '@/helper/notification'
import ApiService from '@/services/ApiService'
import debounce from 'lodash/debounce'

// Start Variable
const selected = ref([])
const dialog = ref(false)
const dialogNotes = ref(false)

const props = defineProps({ name: String })

const currentPage = ref(1)
const totalPage = ref()
const keyword = ref()
const data = ref([])
const loading = ref(false)
const program_list = ref([])
const program_name = ref()
const notes = ref()
// End Variable

// Start Function
const getData = async () => {
  // reset selected
  // selected.value = []

  // Check Category of Ref Program
  const category = props.name

  const page = '?page=' + currentPage.value
  const search = keyword.value ? '&keyword=' + keyword.value : ''
  const program = program_name.value ? '&program_name=' + encodeURIComponent(program_name.value) : ''
  const paginate = '&paginate=true'

  const url =
    category == 'tutoring'
      ? 'api/v1/program/list' + page + search + program + paginate
      : 'api/v1/request' + page + keyword + '&is_cancelled=true'
  try {
    loading.value = true
    const res = await ApiService.get(url)

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

const searchData = debounce(async item => {
  currentPage.value = 1
  keyword.value = item.target.value

  await getData()
}, 1000)

const goToTimesheet = id => {
  window.open('/admin/timesheet/' + props.name + '/' + id)
}
// End Function

watch(() => {
  getData()
})

onMounted(() => {
  getData()
  getProgram()
})
</script>

<template>
  <v-dialog
    v-model="dialogNotes"
    width="400"
  >
    <v-card
      title="Notes"
      prepend-icon="ri-chat-3-line"
    >
      <v-card-text>
        <div v-html="notes"></div>
      </v-card-text>
    </v-card>
  </v-dialog>
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
          v-if="props.name == 'tutoring'"
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
            hide-details
            single-line
            @input="searchData"
          />
        </VCol>

        <VCol
          cols="12"
          :md="props.name == 'tutoring' ? 6 : 9"
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
            <VIcon
              icon="ri-add-line"
              class="me-3"
            ></VIcon>
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
        <ProgramTutor
          v-if="props.name == 'tutoring'"
          :selected="selected"
          @close=";(dialog = false), (selected = [])"
          @reload=";(selected = []), getData()"
        />

        <ProgramMentor
          v-if="props.name == 'specialist'"
          :selected="selected"
          @close="dialog = false"
          @reload=";(selected = []), getData()"
        />
      </VDialog>
      <!-- End Assign Modal  -->

      <!-- Loader  -->
      <div
        class="d-flex bg-secondary py-1 px-2 rounded-lg"
        style="align-items: center"
        v-if="selected.length > 0"
      >
        Selected:
        <small
          class="bg-info px-3 rounded-xl ms-1 d-flex"
          style="font-size: 10px; align-items: center"
          v-for="item in selected"
          :key="item"
        >
          {{ item.mentee }}
          <v-icon
            icon="ri-close-line"
            color="error"
            class="ms-2 cursor-pointer"
            @click="selected = selected.filter(data => data !== item)"
          />
        </small>
      </div>
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
            <th class="text-uppercase text-center">Timesheet</th>
            <th class="text-uppercase text-center">Student</th>
            <th class="text-uppercase text-center">School Name</th>
            <th class="text-uppercase text-center">
              {{ props.name == 'tutoring' ? 'Program Name' : 'Engagement Type' }}
            </th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="(item, index) in data.data"
            :key="index"
            :class="{ 'bg-secondary': selected.includes(item.id) }"
          >
            <td>
              <VText v-if="item.cancellation_reason">
                <VTooltip
                  activator="parent"
                  location="top"
                >
                  Cancel: {{ item.cancellation_reason }}
                </VTooltip>
                <VIcon
                  icon="ri-subtract-line"
                  color="error"
                />
              </VText>

              <VCheckbox
                v-model="selected"
                :value="{
                  id: item.id,
                  require: item.require,
                  mentee: item.student_name,
                }"
                v-else-if="(!item.timesheet_id || !item.scnd_timesheet_id) && !item.cancellation_reason"
              ></VCheckbox>

              <VIcon
                icon="ri-check-line"
                color="success"
                v-else-if="item.timesheet_id && item.scnd_timesheet_id && !item.cancellation_reason"
              ></VIcon>
            </td>
            <td class="text-center">
              <!-- First Timesheet  -->
              <VText
                v-if="item.timesheet_id"
                class="cursor-pointer"
                @click="goToTimesheet(item.timesheet_id)"
              >
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

              <!-- Second Timesheet  -->
              <VText
                v-if="item.scnd_timesheet_id"
                class="cursor-pointer"
                @click="goToTimesheet(item.scnd_timesheet_id)"
              >
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
            </td>
            <td
              class="text-left"
              nowrap
            >
              <VIcon
                icon="ri-user-line"
                class="me-3"
              ></VIcon>
              {{ item.student_name }}

              <div
                class="d-inline ms-2 cursor-pointer"
                v-if="props.name == 'specialist' && item.notes"
                @click=";(dialogNotes = true), (notes = item.notes)"
              >
                <v-tooltip
                  activator="parent"
                  location="start"
                >
                  Notes
                </v-tooltip>
                <v-icon
                  icon="ri-chat-3-line"
                  color="info"
                ></v-icon>
              </div>
            </td>
            <td
              class="text-left"
              nowrap
            >
              {{ item.student_school }}
            </td>
            <td
              v-if="props.name == 'tutoring'"
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
              v-else
              class="text-left"
              nowrap
            >
              <VIcon
                icon="ri-bookmark-line"
                class="me-3"
              ></VIcon>
              {{ item.engagement_type }}
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
