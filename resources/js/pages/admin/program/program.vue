<script setup>
import avatar1 from '@images/avatars/avatar-1.png'
import avatar2 from '@images/avatars/avatar-2.png'
import avatar3 from '@images/avatars/avatar-3.png'
import avatar4 from '@images/avatars/avatar-4.png'
import avatar5 from '@images/avatars/avatar-5.png'

const avatars = [avatar1, avatar2, avatar3, avatar4, avatar5]
const currentPage = ref(1)
const selected = ref([])
const dialog = ref(false)
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
          <h4>Program Name</h4>
        </div>
      </div>
    </VCardTitle>
    <VCardText>
      <VRow class="my-1">
        <VCol
          cols="12"
          md="3"
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
          md="9"
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
            <VRow>
              <VCol md="12">
                <VAutocomplete
                  density="compact"
                  clearable
                  label="Mentor/Tutor"
                  :items="['California', 'Colorado', 'Florida', 'Georgia', 'Texas', 'Wyoming']"
                ></VAutocomplete>
              </VCol>
              <VCol md="8">
                <VAutocomplete
                  density="compact"
                  clearable
                  label="Package"
                  :items="['California', 'Colorado', 'Florida', 'Georgia', 'Texas', 'Wyoming']"
                ></VAutocomplete>
              </VCol>
              <VCol md="4">
                <VTextField
                  type="number"
                  density="compact"
                  clearable
                  label="Hours"
                />
              </VCol>
              <VCol md="12">
                <VAutocomplete
                  density="compact"
                  multiple
                  clearable
                  chips
                  label="PIC"
                  :items="['California', 'Colorado', 'Florida', 'Georgia', 'Texas', 'Wyoming']"
                ></VAutocomplete>
              </VCol>
              <VCol md="12">
                <VTextarea label="Notes"></VTextarea>
              </VCol>
              <VCol md="12">
                <VTextField
                  density="compact"
                  type="url"
                  label="Meeting Link"
                />
              </VCol>
            </VRow>

            <VDivider class="my-3" />
            <VCardActions>
              <VBtn
                color="error"
                @click="dialog = false"
              >
                <VIcon
                  icon="ri-close-line"
                  class="me-3"
                />
                Close
              </VBtn>
              <VSpacer />
              <VBtn color="success">
                Save
                <VIcon
                  icon="ri-save-line"
                  class="ms-3"
                />
              </VBtn>
            </VCardActions>
          </VCardText>
        </VCard>
      </VDialog>

      <VTable>
        <thead>
          <tr>
            <th
              class="text-uppercase"
              width="1%"
            >
              #
            </th>
            <th
              class="text-uppercase"
              width="1%"
            >
              No
            </th>
            <th class="text-uppercase text-center">Invoice ID</th>
            <th class="text-uppercase text-center">Student/School Name</th>
            <th class="text-uppercase text-center">Program Name</th>
            <th class="text-uppercase text-center">Timesheet</th>
          </tr>
        </thead>

        <tbody>
          <tr
            v-for="(item, index) in desserts"
            :key="index"
          >
            <td>
              <VCheckbox
                v-model="selected"
                :value="item"
              ></VCheckbox>
            </td>
            <td>
              {{ index + 1 }}
            </td>
            <td>
              <VIcon
                icon="ri-receipt-line"
                class="me-3"
              ></VIcon>
              {{ item.dessert }}
            </td>
            <td class="text-left">
              <VIcon
                icon="ri-user-line"
                class="me-3"
              ></VIcon>
              {{ item.dessert }}
            </td>
            <td class="text-left">
              <VIcon
                icon="ri-bookmark-line"
                class="me-3"
              ></VIcon>
              {{ item.calories }}
            </td>
            <td class="text-center">
              <VIcon
                icon="ri-file-check-line"
                class="mx-1"
                color="success"
              ></VIcon>
              <VIcon
                icon="ri-file-close-line"
                class="mx-1"
                color="error"
              >
              </VIcon>
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
