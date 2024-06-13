<script setup>
import avatar1 from '@images/avatars/avatar-1.png'
import avatar2 from '@images/avatars/avatar-2.png'
import avatar3 from '@images/avatars/avatar-3.png'
import avatar4 from '@images/avatars/avatar-4.png'
import avatar5 from '@images/avatars/avatar-5.png'

const avatars = [avatar1, avatar2, avatar3, avatar4, avatar5]
const currentPage = ref(1)
const selected = ref([])
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
          <h4>TimeSheet</h4>
        </div>
      </div>
    </VCardTitle>
    <VCardText>
      <VRow class="my-1">
        <VCol
          cols="12"
          md="2"
        >
          <VAutocomplete
            clearable="true"
            label="Program Name"
            :items="['Program 1', 'Program 2', 'Program 3']"
            placeholder="Select Program Name"
            density="compact"
          />
        </VCol>
        <VCol
          cols="12"
          md="3"
        >
          <VAutocomplete
            clearable="true"
            label="Timesheet - Package"
            :items="['Timesheet 1', 'Timesheet 2', 'Timesheet 3']"
            placeholder="Select Timesheet"
            density="compact"
          />
        </VCol>
      </VRow>
      <VTable class="text-no-wrap">
        <thead>
          <tr>
            <th
              class="text-uppercase"
              width="1%"
            >
              No
            </th>
            <th class="text-uppercase text-center">Program Name</th>
            <th class="text-uppercase text-center">Package</th>
            <th class="text-uppercase text-center">Tutor/Mentor</th>
            <th class="text-uppercase text-center">PIC</th>
            <th class="text-uppercase text-center">School/Student Name</th>
            <th class="text-uppercase text-center">Total Hours</th>
            <th class="text-uppercase text-center">Used</th>
            <th class="text-uppercase text-center">#</th>
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
              <VIcon
                icon="ri-bookmark-3-line"
                class="me-3"
              ></VIcon>
              {{ item.dessert }}
            </td>
            <td class="text-center">
              <VIcon
                icon="ri-bookmark-line"
                class="me-3"
              ></VIcon>
              Package {{ index + 1 }}
            </td>
            <td class="text-left">
              <VAvatar
                size="25"
                class="avatar-center me-3"
                :image="avatars[index % 5]"
              />
              {{ item.dessert }}
            </td>
            <td class="text-left">
              <VIcon
                icon="ri-user-line"
                class="cursor-pointer me-3"
              />
              {{ item.dessert }}
            </td>
            <td class="text-left">
              <VIcon
                icon="ri-user-line"
                class="cursor-pointer me-3"
              />
              Student {{ index + 1 }}
            </td>
            <td class="text-left">
              <VIcon
                icon="ri-calendar-schedule-line"
                class="cursor-pointer me-3"
              />
              40 Hours
            </td>
            <td class="text-left">
              <VIcon
                icon="ri-timer-2-line"
                class="cursor-pointer me-3"
              />
              {{ 25 - (index % 5) }} Hours
            </td>
            <td>
              <router-link :to="'/admin/timesheet/' + index">
                <VBtn
                  color="secondary"
                  density="compact"
                  v-tooltip="'Tooltip'"
                >
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
      </VTable>
      <div class="d-flex justify-center mt-5">
        <VPagination
          v-model="currentPage"
          :length="5"
          color="primary"
        />
      </div>
    </VCardText>
  </VCard>
</template>
