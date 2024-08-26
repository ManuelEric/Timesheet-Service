<script setup>
import DeleteDialog from '@/components/DeleteHandler.vue'
import { showNotif } from '@/helper/notification'
import ApiService from '@/services/ApiService'
import AddActivity from './activity-add.vue'
import EditActivity from './activity-edit.vue'

// Start Variable
const props = defineProps({ id: String })
const data = ref([])
const loading = ref(false)

const isDialogVisible = ref([
  {
    add: false,
    edit: false,
    delete: false,
  },
])

const selectedItem = ref([])
// End Variable

// Start Function
const getData = async () => {
  loading.value = false
  try {
    const res = await ApiService.get('api/v1/timesheet/' + props.id + '/activities')
    if (res) {
      data.value = res
    }
  } catch (error) {
    console.error(error)
  } finally {
    loading.value = true
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
  try {
    const res = await ApiService.delete('api/v1/timesheet/' + props.id + '/activity/' + selectedItem.value.id)
    if (res) {
      showNotif('success', res.message, 'bottom-end')
      toggleDialog('delete')
    }
  } catch (error) {
    if (error.response?.status == 400) {
      showNotif('error', error.response?.data?.errors, 'bottom-end')
    }
  } finally {
    getData()
  }
}

const updateStatus = async item => {
  try {
    const res = await ApiService.put('api/v1/timesheet/' + props.id + '/activity/' + item.id, item)

    if (res) {
      showNotif('success', res.message, 'bottom-end')
    }
  } catch (error) {
    if (error?.response?.data?.errors) {
      const validationErrors = error.response.data.errors
      let errorMessage = 'Validation errors:'

      // Merge validation errors
      if (typeof validationErrors != 'string') {
        for (const key in validationErrors) {
          if (validationErrors.hasOwnProperty(key)) {
            errorMessage += `\n${key}: ${validationErrors[key].join(', ')}`
          }
        }
        showNotif('error', errorMessage, 'bottom-end')
      } else {
        showNotif('error', error.response.data.errors, 'bottom-end')
      }
    }
  } finally {
    getData()
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
      >
        <thead>
          <tr>
            <th
              class="text-uppercase"
              width="1%"
            >
              No
            </th>
            <th class="text-uppercase text-center">Activity</th>
            <th class="text-uppercase text-center">Description</th>
            <th class="text-uppercase text-center">Date</th>
            <th class="text-uppercase text-center">Start Time</th>
            <th class="text-uppercase text-center">End Time</th>
            <th class="text-uppercase text-center">Time Spent</th>
            <th class="text-uppercase text-center">Status</th>
            <th class="text-uppercase text-end">#</th>
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
            <td>
              {{ item.activity }}
            </td>
            <td class="text-center">
              {{ item.description }}
            </td>
            <td>
              {{ $moment(item.start_date).format('MMM Do YYYY') }}
            </td>
            <td class="text-center">
              {{ item.start_time }}
            </td>
            <td class="text-center">
              {{ item.end_time }}
            </td>
            <td class="text-center">
              <VIcon
                icon="ri-timer-2-line"
                class="cursor-pointer me-3"
              />
              {{ item.estimate }} Minutes
            </td>
            <td>
              <VCheckbox
                color="success"
                v-model="item.status"
                :value="1"
                :false-value="0"
                v-tooltip:start="item.status ? 'Completed' : 'Not Yet'"
                @update:modelValue="updateStatus(item)"
              />
            </td>
            <td class="text-end">
              <VBtn
                color="warning"
                density="compact"
                class="me-1"
                v-tooltip:start="'Edit Activity'"
                @click="selectedActivity('edit', item)"
              >
                <VIcon
                  icon="ri-edit-line"
                  class="cursor-pointer"
                />
              </VBtn>

              <VBtn
                color="error"
                density="compact"
                v-tooltip:start="'Delete Activity'"
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
    </VCardText>

    <!-- Edit Dialog -->
    <VDialog
      v-model="isDialogVisible.edit"
      max-width="600"
      persistent
    >
      <EditActivity
        :timesheet_id="props?.id"
        :activity="selectedItem"
        @close="toggleDialog('edit')"
        @reload="getData"
      />
    </VDialog>

    <!-- Delete Dialog -->
    <VDialog
      v-model="isDialogVisible.delete"
      max-width="400"
      persistent
    >
      <DeleteDialog
        title="activity"
        @close="toggleDialog('delete')"
        @delete="deleteActivity"
      />
    </VDialog>
  </VCard>
</template>
