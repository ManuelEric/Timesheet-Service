<script setup>
import ApiService from '@/services/ApiService'
import avatar1 from '@images/avatars/avatar-1.png'
import avatar2 from '@images/avatars/avatar-2.png'
import avatar3 from '@images/avatars/avatar-3.png'
import avatar4 from '@images/avatars/avatar-4.png'
import avatar5 from '@images/avatars/avatar-5.png'

// Start Variable
const avatars = [avatar1, avatar2, avatar3, avatar4, avatar5]
const currentPage = ref(1)
const totalPage = ref()
const keyword = ref()
const data = ref([])
const loading = ref(false)
// End Variable

// Start Function
const getData = async () => {
  const page = '?page=' + currentPage
  const search = keyword.value ? '&keyword=' + keyword.value : ''
  try {
    loading.value = true
    const res = await ApiService.get('api/v1/user/mentor-tutors' + page + search)

    if (res) {
      currentPage.value = res.current_page
      totalPage.value = res.to
      data.value = res
    }
    loading.value = false
  } catch (error) {
    console.error(error)
    loading.value = false
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
          <h4>Tutor/Mentor</h4>
        </div>

        <div class="w-25">
          <VTextField
            v-model="keyword"
            :loading="loading"
            :disabled="loading"
            append-inner-icon="mdi-magnify"
            density="compact"
            label="Search"
            variant="solo"
            hide-details
            single-line
            @change="getData"
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
            <th class="text-uppercase text-center">Role</th>
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
              {{ index + 1 }}
            </td>
            <td>
              <VAvatar
                size="25"
                class="avatar-center me-3"
                :image="avatars[index % 5]"
              />
              {{ item.first_name + ' ' + item.last_name }}
            </td>
            <td class="text-start">
              <VIcon
                icon="ri-mail-line"
                class="me-3"
              ></VIcon>
              {{ item.email }}
            </td>
            <td class="text-start">
              <VIcon
                icon="ri-user-line"
                class="me-3"
              ></VIcon>
              {{ item.role }}
            </td>
            <td class="text-start">
              <VIcon
                icon="ri-smartphone-line"
                class="me-3"
              ></VIcon>
              {{ item.phone }}
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
                      <VTable
                        density="compact"
                        v-if="item.tutor_subject"
                      >
                        <thead>
                          <tr>
                            <th class="text-left">Subject</th>
                            <th class="text-end">Fee/Hours</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>{{ item.tutor_subject }}</td>
                            <td class="text-end">Rp. {{ item.feehours }}</td>
                          </tr>
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
      </VTable>
      <div
        class="d-flex justify-center mt-5"
        v-if="data.data?.length > 0"
      >
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
