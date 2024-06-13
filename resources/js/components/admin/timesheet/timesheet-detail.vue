<script setup>
import AddActivity from '@/components/admin/timesheet/activity-add.vue'
import EditActivity from '@/components/admin/timesheet/activity-edit.vue'
import DeleteDialog from '@/components/DeleteHandler.vue'
import avatar1 from '@images/avatars/avatar-1.png'
import avatar2 from '@images/avatars/avatar-2.png'
import avatar3 from '@images/avatars/avatar-3.png'
import avatar4 from '@images/avatars/avatar-4.png'
import avatar5 from '@images/avatars/avatar-5.png'

const avatars = [avatar1, avatar2, avatar3, avatar4, avatar5]
const currentPage = ref(1)
const isDialogVisible = ref([
  {
    add: false,
    edit: false,
    delete: false,
  },
])

const selectedItem = ref([])

const toggleDialog = type => {
  if (!isDialogVisible.value[type]) {
    isDialogVisible.value[type] = true
  } else {
    isDialogVisible.value[type] = false
  }
}

const editActivity = item => {
  toggleDialog('edit')
  selectedItem.value = item
}

const deleteActivity = item => {
  toggleDialog('delete')
  selectedItem.value = item
}

const desserts = [
  {
    dessert: 'Frozen Yogurt',
    calories: 159,
    fat: 6,
    carbs: 24,
    protein: 4,
  },
  {
    dessert: 'Ice cream sandwich',
    calories: 237,
    fat: 6,
    carbs: 24,
    protein: 4,
  },
  {
    dessert: 'Eclair',
    calories: 262,
    fat: 6,
    carbs: 24,
    protein: 4,
  },
  {
    dessert: 'Cupcake',
    calories: 305,
    fat: 6,
    carbs: 24,
    protein: 4,
  },
  {
    dessert: 'Gingerbread',
    calories: 356,
    fat: 6,
    carbs: 24,
    protein: 4,
  },
]
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
          <AddActivity @close="toggleDialog('add')" />
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
            v-for="(item, index) in desserts"
            :key="index"
          >
            <td>
              {{ index + 1 }}
            </td>
            <td>
              {{ item.dessert }}
            </td>
            <td class="text-center">Package {{ index + 1 }}</td>
            <td>24 Feb 2024</td>
            <td class="text-center">14:00</td>
            <td class="text-center">15:00</td>
            <td class="text-center">
              <VIcon
                icon="ri-timer-2-line"
                class="cursor-pointer me-3"
                v-bind="activatorProps"
              />
              {{ 25 - (index % 5) }} Minutes
            </td>
            <td>
              <VChip
                :color="'#e05e5e'"
                class="font-weight-medium"
                size="small"
              >
                Not Yet
              </VChip>
            </td>
            <td class="text-end">
              <VBtn
                color="warning"
                density="compact"
                class="me-1"
                @click="editActivity(item)"
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
                @click="deleteActivity(item)"
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
        :data="selectedItem"
        title="activity"
        @close="toggleDialog('delete')"
      />
    </VDialog>
  </VCard>
</template>
