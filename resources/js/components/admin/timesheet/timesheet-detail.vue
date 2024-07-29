<script setup>
import ApiService from '@/services/ApiService'
import AddActivity from '@/components/admin/timesheet/activity-add.vue'
import EditActivity from '@/components/admin/timesheet/activity-edit.vue'
import DeleteDialog from '@/components/DeleteHandler.vue'
import { showNotif } from '@/helper/notification'
import { router } from '@/plugins/router'
import moment from 'moment'

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
      loading.value = true
    }
  } catch (error) {
    loading.value = false
    console.error(error)
  }
}

const submit = async () => {}

const toggleDialog = type => {
  if (!isDialogVisible.value[type]) {
    isDialogVisible.value[type] = true
  } else {
    isDialogVisible.value[type] = false
  }

  getData()
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
          density="compact"
          @click="toggleDialog('add')"
        >
          <VIcon icon="ri-add-line" />
          <VTooltip
            activator="parent"
            location="bottom"
            transition="scroll-x-transition"
          >
            New Activity
          </VTooltip>
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
              {{ moment(item.start_date).format('LL') }}
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
              <VChip
                :color="item.status == 'Not Yet' ? '#e05e5e' : '#91C45E'"
                class="font-weight-medium"
                size="small"
              >
                {{ item.status }}
              </VChip>
            </td>
            <td class="text-end">
              <VBtn
                color="warning"
                density="compact"
                class="me-1"
                @click="selectedActivity('edit', item)"
              >
                <VIcon
                  icon="ri-edit-line"
                  class="cursor-pointer"
                  v-bind="activatorProps"
                />

                <VTooltip
                  activator="parent"
                  location="left"
                  transition="scroll-x-transition"
                >
                  Edit Activity
                </VTooltip>
              </VBtn>

              <VBtn
                color="error"
                density="compact"
                @click="selectedActivity('delete', item)"
              >
                <VIcon
                  icon="ri-delete-bin-line"
                  class="cursor-pointer"
                  v-bind="activatorProps"
                />

                <VTooltip
                  activator="parent"
                  location="right"
                  transition="scroll-x-transition"
                >
                  Delete Activity
                </VTooltip>
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
