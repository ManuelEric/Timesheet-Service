<script setup>
import NewRequest from '@/components/user/request/new-request.vue'
import ApiService from '@/services/ApiService'
import { onMounted } from 'vue'

const loading = ref(false)
const dialog = ref(false)
const currentPage = ref(1)
const totalPage = ref()
const keyword = ref()
const data = ref([])

const getData = async () => {
  loading.value = true
  try {
    const url = 'api/v1/request'
    const page = '?page=' + currentPage.value
    const search = keyword.value ? '&keyword=' + keyword.value : ''

    const res = await ApiService.get(url + page + search)

    if (res) {
      data.value = res
      totalPage.value = res.total
    }
  } catch (error) {
    console.log(error)
  } finally {
    loading.value = false
  }
}

const searchData = async () => {
  currentPage.value = 1
  await getData()
}

onMounted(() => {
  getData()
})
</script>

<template>
  <VCard>
    <VCardTitle>
      <div class="d-flex justify-between align-center">
        <div class="w-100">
          <h4>Program List</h4>
        </div>
      </div>
    </VCardTitle>
    <VCardText>
      <VRow class="my-1 justify-space-between">
        <VCol
          md="3"
          cols="12"
        >
          <VTextField
            label="Search"
            density="compact"
            v-model="keyword"
            variant="solo"
            single-line
            :loading="loading"
            :disabled="loading"
            @change="searchData"
          />
        </VCol>
        <VCol
          md="2"
          cols="12"
        >
          <VBtn
            density="compact"
            color="info"
            block
            border
            @click="dialog = true"
          >
            New Request
            <VIcon
              icon="ri-add-line"
              class="ms-3"
            />
          </VBtn>
        </VCol>
      </VRow>

      <VDialog
        v-model="dialog"
        width="auto"
        persistent
      >
        <NewRequest
          @close="dialog = false"
          @reload="getData"
        />
      </VDialog>

      <!-- Table  -->
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
            <th class="text-uppercase text-center">Student</th>
            <th class="text-uppercase text-center">School Name</th>
            <th class="text-uppercase text-center">Program Name</th>
            <th class="text-uppercase text-center">Notes</th>
          </tr>
        </thead>
        <tbody v-if="data?.data?.length > 0">
          <tr
            v-for="(item, i) in data.data"
            :key="i"
          >
            <th>{{ parseInt(i) + 1 }}</th>
            <th>{{ item.student_name }}</th>
            <th>{{ item.student_school }}</th>
            <th>{{ item.engagement_type }}</th>
            <th>{{ item.notes }}</th>
          </tr>
        </tbody>
        <!-- If Nothing Data  -->
        <tfoot v-else>
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
        />
      </div>
    </VCardText>
  </VCard>
</template>
