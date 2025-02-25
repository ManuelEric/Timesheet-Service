<script setup>
import NewRequest from '@/components/user/request/new-request.vue'

const loading = ref(false)
const dialog = ref(false)
const currentPage = ref(1)
const totalPage = ref()
const keyword = ref()
const data = ref([])
</script>

<template>
  <VCard>
    <VCardTitle>
      <div class="d-flex justify-between align-center">
        <div class="w-100">
          <h4>Request List</h4>
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
            variant="solo"
            single-line
            :loading="loading"
            :disabled="loading"
          />
        </VCol>
        <VCol
          md="1"
          cols="12"
        >
          <VBtn
            density="compact"
            color="info"
            block
            border
            @click="dialog = true"
          >
            New
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
        <NewRequest @close="dialog = false" />
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
            <th class="text-uppercase text-center">Student/School Name</th>
            <th class="text-uppercase text-center">Program Name</th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="i in 10"
            :key="i"
          >
            <th>i</th>
            <th>Student Name / School</th>
            <th>Program Name</th>
          </tr>
        </tbody>
        <!-- If Nothing Data  -->
        <tfoot>
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
