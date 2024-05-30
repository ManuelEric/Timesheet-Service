<script setup>
import avatar1 from '@images/avatars/avatar-1.png'
import avatar2 from '@images/avatars/avatar-2.png'
import avatar3 from '@images/avatars/avatar-3.png'
import avatar4 from '@images/avatars/avatar-4.png'
import avatar5 from '@images/avatars/avatar-5.png'

const avatars = [avatar1, avatar2, avatar3, avatar4, avatar5]
const currentPage = ref(1)
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
          <h4>Tutor/Mentor</h4>
        </div>

        <div class="w-25">
          <VTextField
            :loading="loading"
            append-inner-icon="mdi-magnify"
            density="compact"
            label="Search"
            variant="solo"
            hide-details
            single-line
            @click:append-inner="onClick"
          ></VTextField>
        </div>
      </div>
    </VCardTitle>
    <VCardText>
      <VTable>
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
            <th class="text-uppercase text-center">Phone Number</th>
            <th class="text-uppercase text-center">Detail</th>
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
              <VAvatar
                size="25"
                class="avatar-center me-3"
                :image="avatars[index % 5]"
              />
              {{ item.dessert }}
            </td>
            <td class="text-center">
              <VIcon
                icon="ri-mail-line"
                class="me-3"
              ></VIcon>
              {{ item.calories }}
            </td>
            <td class="text-center">
              <VIcon
                icon="ri-smartphone-line"
                class="me-3"
              ></VIcon>
              {{ item.fat }}
            </td>
            <td class="text-center">
              <VDialog max-width="500">
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
                      <VTable density="compact">
                        <thead>
                          <tr>
                            <th class="text-left">Subject</th>
                            <th class="text-end">Fee/Hours</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>Biology</td>
                            <td class="text-end">Rp. 130.000</td>
                          </tr>
                        </tbody>
                      </VTable>
                      <!-- End Tutor  -->
                    </VCardText>
                  </VCard>
                </template>
              </VDialog>
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
