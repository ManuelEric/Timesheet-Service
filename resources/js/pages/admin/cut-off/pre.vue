<script setup>
import additionalFee from '@/components/admin/cut-off/additional_add.vue'
import newCutOff from '@/components/admin/cut-off/cutoff_add.vue'
import cutOffExisting from '@/components/admin/cut-off/cutoff_existing_add.vue'
import ApiService from '@/services/ApiService'

const loading = ref(false)
const data = ref([])
const isDialogVisible = ref({
  cut_off: false,
  additional_fee: false,
  add_bonus: false,
  add_existing: false,
})

const currentPage = ref(1)
const totalPage = ref()
const selected = ref([])
const keyword = ref(null)
const package_id = ref(null)
const package_list = ref([])

const getData = async () => {
  loading.value = true
  const page = '?page=' + currentPage.value
  const search = keyword.value ? '&keyword=' + keyword.value : ''
  const package_select = package_id.value ? '&package_id=' + package_id.value : ''

  try {
    const res = await ApiService.get('api/v1/payment/unpaid' + page + search + package_select)
    if (res) {
      currentPage.value = res.current_page
      totalPage.value = res.last_page
      data.value = res
    }
  } catch (error) {
    console.error(error)
  } finally {
    loading.value = false
  }
}

const getPackage = async () => {
  loading.value = true
  try {
    const res = await ApiService.get('api/v1/package/component/list')
    if (res) {
      package_list.value = res
      loading.value = false
    }
  } catch (error) {
    loading.value = false
    console.error(error)
  }
}

onMounted(() => {
  getData()
  getPackage()
})
</script>

<template>
  <VCard>
    <VCardTitle>
      <div class="d-flex justify-between align-center">
        <div class="w-100">
          <h4>Pre Cut-Off</h4>
        </div>
      </div>
    </VCardTitle>
    <VCardText>
      <VRow class="my-1">
        <VCol
          cols="3"
          md="4"
        >
          <VAutocomplete
            :loading="loading"
            :disabled="loading"
            clearable="true"
            label="Package Name"
            :items="package_list"
            :item-title="item => item.type_of + ' - ' + item.package"
            item-value="id"
            v-model="package_id"
            placeholder="Select Timesheet Package"
            density="compact"
            @update:modelValue="getData"
          />
        </VCol>
        <VCol
          cols="3"
          md="3"
        >
          <VTextField
            :loading="loading"
            :disabled="loading"
            append-inner-icon="ri-search-line"
            density="compact"
            label="Search"
            variant="solo"
            hide-details
            single-line
            v-model="keyword"
            @change="getData"
          />
        </VCol>
        <VCol
          cols="6"
          md="5"
          class="text-end"
        >
          <VBtn
            color="warning"
            density="compact"
            class="me-1"
            @click="isDialogVisible.add_existing = true"
            v-if="selected.length > 0"
          >
            <VIcon
              icon="ri-add-box-line"
              class="me-2"
            />
            Add to Existing Cut-Off
          </VBtn>

          <VMenu
            :close-on-content-click="false"
            location="bottom"
          >
            <template v-slot:activator="{ props }">
              <VBtn
                density="compact"
                color="light-primary"
                v-bind="props"
                class="me-1"
              >
                Additional Fee
                <VIcon
                  icon="ri-arrow-down-s-line"
                  class="ms-2"
                />
              </VBtn>
            </template>
            <VList>
              <VListItem>
                <div
                  class="cursor-pointer"
                  @click="isDialogVisible.additional_fee = true"
                >
                  <VIcon
                    icon="ri-wallet-2-line"
                    class="me-2"
                  />
                  Additional Fee
                </div>
              </VListItem>
              <VListItem>
                <div
                  class="cursor-pointer"
                  @click="isDialogVisible.add_bonus = true"
                >
                  <VIcon
                    icon="ri-wallet-3-line"
                    class="me-2"
                  />
                  Add Bonus
                </div>
              </VListItem>
            </VList>
          </VMenu>
          <VBtn
            color="secondary"
            density="compact"
            @click="isDialogVisible.cut_off = true"
            v-if="selected.length == 0"
          >
            <VIcon
              icon="ri-scissors-cut-line"
              class="me-2"
            />
            Cut-Off
          </VBtn>
        </VCol>
      </VRow>

      <!-- Loader  -->
      <vSkeletonLoader
        class="mx-auto border"
        type="table-thead, table-row@10"
        v-if="loading"
      ></vSkeletonLoader>
      <VTable
        class="text-no-wrap"
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
            <th
              class="text-uppercase"
              width="1%"
            >
              No
            </th>
            <th class="text-uppercase text-center">Timesheet</th>
            <th class="text-uppercase text-center">Activity</th>
            <th class="text-uppercase text-center">Mentor/Tutor</th>
            <th class="text-uppercase text-center">Date & Time</th>
            <th class="text-uppercase text-center">Time Spent</th>
            <th class="text-uppercase text-center">Fee/Hours</th>
            <th class="text-uppercase text-center">Total</th>
            <th class="text-uppercase text-center">Cut-Offf Status</th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="(item, index) in data.data"
            :key="index"
          >
            <td>
              <VCheckbox
                v-model="selected"
                :value="item.id"
              ></VCheckbox>
            </td>
            <td>{{ parseInt(index) + 1 }}</td>
            <td>{{ item.package.type + ' - ' + item.package.name }}</td>
            <td>{{ item.activity }}</td>
            <td>{{ item.mentor_tutor }}</td>
            <td>{{ item.date }}</td>
            <td>{{ item.time_spent / 60 + ' Hours' }}</td>
            <td>Rp. {{ item.fee_hours }}</td>
            <td>
              Rp.
              {{ (item.time_spent / 60) * item.fee_hours }}
            </td>
            <td class="text-center">
              <VChip :color="item.cutoff_status == 'not yet' ? '#ff0217' : '#91c45e'">
                {{ item.cutoff_status.charAt(0).toUpperCase() + item.cutoff_status.slice(1).toLowerCase() }}
              </VChip>
            </td>
          </tr>
        </tbody>
      </VTable>

      <div class="d-flex justify-center mt-5">
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

    <!-- Cut-Off Dialog -->
    <VDialog
      v-model="isDialogVisible.cut_off"
      max-width="450"
      persistent
    >
      <newCutOff
        @close="isDialogVisible.cut_off = false"
        @reload="getData"
      />
    </VDialog>

    <!-- Add Existing Dialog -->
    <VDialog
      v-model="isDialogVisible.add_existing"
      max-width="450"
      persistent
      scrollable
    >
      <cutOffExisting
        :id="selected"
        @close="isDialogVisible.add_existing = false"
        @reload="getData"
        @reset="selected = []"
      />
    </VDialog>
  </VCard>

  <!-- Add Bonus Dialog -->
  <VDialog
    v-model="isDialogVisible.add_bonus"
    max-width="450"
    persistent
  >
    <additionalFee
      :title="'bonus'"
      @close="isDialogVisible.add_bonus = false"
    />
  </VDialog>

  <!-- Additional Fee Dialog -->
  <VDialog
    v-model="isDialogVisible.additional_fee"
    max-width="450"
    persistent
  >
    <additionalFee
      :title="'fee'"
      @close="isDialogVisible.additional_fee = false"
    />
  </VDialog>
</template>

<style lang="scss"></style>
