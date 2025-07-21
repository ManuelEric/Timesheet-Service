<script setup>
import DeleteDialog from '@/components/DeleteHandler.vue'
import { showNotif } from '@/helper/notification'
import ApiService from '@/services/ApiService'
import UserService from '@/services/UserService'
import debounce from 'lodash/debounce'
import AddActivity from './activity-add.vue'

// Start Variable
const props = defineProps({ id: String, require: String })
const updateReload = inject('updateReload')
const data = ref([])
const loading = ref(false)
const role = ref(UserService.getUser().role_detail[0].role.toLowerCase())

const isDialogVisible = ref([
  {
    add: false,
    delete: false,
  },
])

const selectedItem = ref([])
// End Variable

// Start Functions
const getData = async () => {
  loading.value = true
  try {
    const res = await ApiService.get('api/v1/timesheet/' + props.id + '/activities')

    if (res) {
      data.value = res
    }
  } catch (error) {
    console.error(error)
  } finally {
    loading.value = false
  }
}

const toggleDialog = type => {
  if (!isDialogVisible.value[type]) {
    isDialogVisible.value[type] = true
  } else {
    isDialogVisible.value[type] = false
  }
}

const selectedActivity = (type, item) => {
  selectedItem.value = item
  toggleDialog(type)
}

const deleteActivity = async () => {
  loading.value = true
  try {
    const res = await ApiService.delete('api/v1/timesheet/' + props.id + '/activity/' + selectedItem.value.id)
    if (res) {
      showNotif('success', res.message, 'bottom-end')
    }
  } catch (error) {
    showNotif('error', error.response?.data?.errors, 'bottom-end')
  } finally {
    loading.value = false
    getData()
    updateReload(true)
    toggleDialog('delete')
  }
}

const updateTime = debounce(async item => {
  item.end_date = item.date + ' ' + item.end_time + ':00'

  try {
    const res = await ApiService.put('api/v1/timesheet/' + props.id + '/activity/' + item.id, item)

    if (res) {
      showNotif('success', res.message, 'bottom-end')
    }
  } catch (error) {
    console.error(error)
  } finally {
    getData()
    updateReload(true)
  }
}, 500)

const updateStatus = async item => {
  try {
    const res = await ApiService.patch('api/v1/timesheet/' + props.id + '/activity/' + item.id, item)

    if (res) {
      showNotif('success', res.message, 'bottom-end')
    }
  } catch (error) {
    if (error?.response?.data?.message) showNotif('error', error.response.data.message, 'bottom-end')
    console.error(error)
  } finally {
    getData()
    updateReload(true)
  }
}

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
          <h4>Activity</h4>
        </div>
        <!-- for external mentor & tutor  -->
        <VBtn
          v-tooltip:start="'New Activity'"
          @click="toggleDialog('add')"
        >
          <VIcon icon="ri-add-line" />
        </VBtn>
        <!-- Add Dialog -->
        <VDialog
          v-model="isDialogVisible.add"
          max-width="600"
          persistent
        >
          <AddActivity
            :id="props.id"
            @close="toggleDialog('add')"
            @reload="getData"
          />
        </VDialog>
      </div>
    </VCardTitle>
    <VCardText>
      <VTable
        class="text-no-wrap"
        height="400"
        fixed-header
        v-if="!loading"
      >
        <thead>
          <tr>
            <th
              class="text-uppercase"
              width="1%"
            >
              No
            </th>
            <!-- <th class="text-uppercase text-center">Activity</th> -->
            <th class="text-uppercase text-center">Meeting Discussion</th>
            <th class="text-uppercase text-center">Date</th>
            <th class="text-uppercase text-center">Start Time</th>
            <th
              class="text-uppercase text-center"
              style="width: 200px !important"
            >
              End Time
            </th>
            <th class="text-uppercase text-center">Time Spent</th>
            <th class="text-uppercase text-center">Status</th>
            <th
              class="text-uppercase text-end"
              v-if="role != 'mentor'"
            >
              #
            </th>
          </tr>
        </thead>

        <tbody>
          <tr
            v-for="(item, index) in data"
            :key="index"
          >
            <td width="1%">
              {{ index + 1 }}
            </td>
            <!-- <td>
              {{ item.activity }}
            </td> -->
            <td class="text-start">
              {{ item.description }}
            </td>
            <td>
              {{ $moment(item.start_date).format('dddd') }},
              {{ $moment(item.start_date).format('MMM Do YYYY') }}
            </td>
            <td class="text-center">
              {{ item.start_time }}
            </td>
            <td class="text-start">
              <input
                type="time"
                class="form-control px-2 py-2 border rounded cursor-pointer"
                v-model="item.end_time"
                @change="updateTime(item)"
                :disabled="role == 'mentor' || item.start_time == '00:00' || item.cutoff_status == 'completed'"
                v-tooltip:start="item.cutoff_status == 'completed' ? 'Already Cut-Off' : 'End Time'"
              />
            </td>
            <td class="text-center">{{ item.estimate }} Minutes</td>
            <td>
              <VCheckbox
                color="success"
                v-model="item.status"
                :value="true"
                :disabled="role == 'mentor' || item.start_time == '00:00' || item.cutoff_status == 'completed'"
                v-tooltip:start="item.status ? 'Completed' : 'Not Yet'"
                @update:modelValue="updateStatus(item)"
              />
            </td>
            <td
              class="text-end"
              v-if="role != 'mentor'"
            >
              <VBtn
                color="primary"
                density="compact"
                class="me-1"
              >
                <a
                  :href="item.meeting_link"
                  target="_blank"
                  class="bg-primary"
                >
                  <VIcon icon="ri ri-link" />
                  Join
                </a>
              </VBtn>
              <VBtn
                color="error"
                density="compact"
                :disabled="item.start_time == '00:00' || item.cutoff_status == 'completed'"
                v-tooltip:start="item.status ? 'Already Cut-Off' : 'Delete Activity'"
                @click="selectedActivity('delete', item)"
              >
                <VIcon
                  icon="ri-delete-bin-line"
                  class="cursor-pointer"
                />
              </VBtn>
            </td>
          </tr>
        </tbody>
      </VTable>

      <VSkeletonLoader
        type="table"
        v-else
      />
    </VCardText>

    <!-- Delete Dialog -->
    <VDialog
      v-model="isDialogVisible.delete"
      max-width="400"
      persistent
    >
      <DeleteDialog
        :loading="loading"
        title="activity"
        @close="toggleDialog('delete')"
        @delete="deleteActivity"
      />
    </VDialog>
  </VCard>
</template>

<style lang="scss">
.v-field__field {
  grid-area: auto;
}
</style>
