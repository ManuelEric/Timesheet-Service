<script setup>
import UserEdit from '@/components/admin/timesheet/user-edit.vue'
import DeleteDialog from '@/components/DeleteHandler.vue'
import { showNotif } from '@/helper/notification'
import ApiService from '@/services/ApiService'
import moment from 'moment'

// Start Variable
const props = defineProps({ id: String })
const data = ref([])
const isDialogVisible = ref([
  {
    edit: false,
    delete: false,
  },
])
// End Variable

// Start Function
const getData = async id => {
  try {
    const res = await ApiService.get('api/v1/timesheet/' + id + '/detail')

    if (res) {
      data.value = res
    }
  } catch (error) {
    console.log(error)
  }
}

const deleteTimesheet = item => {
  isDialogVisible.value.delete = true
}

const toggleDialog = type => {
  if (!isDialogVisible.value[type]) {
    isDialogVisible.value[type] = true
  } else {
    isDialogVisible.value[type] = false
  }
}

// End Function

onMounted(() => {
  getData(props.id)
})
</script>

<template>
  <VCard class="mb-3">
    <VCardTitle class="d-flex justify-between align-center">
      <div class="w-100">
        <router-link to="/admin/timesheet">
          <VIcon
            icon="ri-arrow-left-line"
            color="secondary"
            class="me-2"
            size="25"
          ></VIcon>
        </router-link>
        Timesheet - {{ data.clientProfile?.client_name }}
      </div>
      <div>
        <VMenu
          :close-on-content-click="false"
          location="bottom"
        >
          <template v-slot:activator="{ props }">
            <VBtn
              density="compact"
              color="secondary"
              v-bind="props"
            >
              Action
              <VIcon icon="ri-arrow-down-s-line ms-2"></VIcon>
            </VBtn>
          </template>
          <VList>
            <VListItem>
              <div
                class="cursor-pointer"
                @click="toggleDialog('edit')"
              >
                <VIcon
                  icon="ri-pencil-line"
                  class="me-2"
                />
                Edit TimeSheet
              </div>
            </VListItem>
            <VListItem>
              <VListItemTitle>
                <div class="cursor-pointer">
                  <VIcon
                    icon="ri-download-line"
                    class="me-2"
                  />
                  Download TimeSheet
                </div>
              </VListItemTitle>
            </VListItem>
            <VListItem>
              <div
                class="cursor-pointer"
                @click="toggleDialog('delete')"
              >
                <VIcon
                  icon="ri-delete-bin-line"
                  class="me-2"
                />
                Delete TimeSheet
              </div>
            </VListItem>
          </VList>
        </VMenu>
      </div>
    </VCardTitle>
    <VCardText>
      <VRow align="center">
        <VCol md="7">
          <h4 class="mt-3 font-weight-light">
            <VIcon
              icon="ri-user-line"
              size="17"
              class="me-2"
            ></VIcon>
            Basic Profile
          </h4>
          <hr class="my-2" />
          <VTable density="compact">
            <tbody>
              <tr>
                <td width="20%">Name</td>
                <td width="1%">:</td>
                <td>{{ data.clientProfile?.client_name }}</td>
              </tr>
              <tr>
                <td>School Name</td>
                <td width="1%">:</td>
                <td>{{ data.clientProfile?.client_school }}</td>
              </tr>
              <tr>
                <td>Grade</td>
                <td width="1%">:</td>
                <td>11</td>
              </tr>
              <tr>
                <td>Email</td>
                <td width="1%">:</td>
                <td>email@email.com</td>
              </tr>
            </tbody>
          </VTable>

          <h4 class="mt-5 font-weight-light">
            <VIcon
              icon="ri-bookmark-line"
              class="me-2"
              size="17"
            ></VIcon>
            Package Details
          </h4>
          <hr class="my-2" />
          <VTable density="compact">
            <tbody>
              <tr>
                <td width="20%">Program</td>
                <td width="1%">:</td>
                <td>{{ data.packageDetails?.program_name }}</td>
              </tr>
              <tr>
                <td>Package</td>
                <td width="1%">:</td>
                <td>{{ data.packageDetails?.package_type }}</td>
              </tr>
              <tr>
                <td>Person in Charge</td>
                <td width="1%">:</td>
                <td>
                  <ol
                    class="ms-4"
                    type="1"
                  >
                    <li>{{ data.packageDetails?.pic }}</li>
                  </ol>
                </td>
              </tr>
              <tr>
                <td>Tutor/Mentor</td>
                <td width="1%">:</td>
                <td>{{ data.packageDetails?.tutor_mentor }}</td>
              </tr>
              <tr>
                <td>Update On</td>
                <td width="1%">:</td>
                <td>
                  {{ moment().format('LLL') }}
                </td>
              </tr>
            </tbody>
          </VTable>
        </VCol>
        <VCol md="5">
          <VCard
            color="#16B1FF"
            class="mb-2 d-flex align-center"
          >
            <div>
              <VCardItem>
                <VCardTitle class="text-white"> Total Minutes of Package </VCardTitle>
              </VCardItem>

              <VCardText class="d-flex justify-between">
                <div class="d-flex align-end w-100">
                  <h1 class="m-0 mb-1 text-white">{{ data.packageDetails?.duration_in_hours }}</h1>
                  <h4 class="m-0 ms-2 text-white">Minutes</h4>
                </div>
              </VCardText>
            </div>
            <VCardText
              ><div class="text-end w-100">
                <VIcon
                  icon="ri-calendar-schedule-line"
                  size="60"
                ></VIcon>
              </div>
            </VCardText>
          </VCard>
          <VCard
            color="#91c45e"
            class="mb-2 d-flex align-center"
          >
            <div>
              <VCardItem>
                <VCardTitle class="text-white"> Total Minutes Spent </VCardTitle>
              </VCardItem>
              <VCardText class="d-flex justify-between">
                <div class="d-flex align-end w-100">
                  <h1 class="m-0 mb-1 text-white">{{ data.packageDetails?.time_spent_in_hours }}</h1>
                  <h4 class="m-0 ms-2 text-white">Minutes</h4>
                </div>
              </VCardText>
            </div>
            <VCardText>
              <div class="text-end w-100">
                <VIcon
                  icon="ri-timer-flash-line"
                  size="60"
                  color="white"
                ></VIcon>
              </div>
            </VCardText>
          </VCard>

          <VCard
            color="#e05e5e"
            class="mb-2 d-flex align-center"
          >
            <div>
              <VCardItem>
                <VCardTitle class="text-white"> Total Minutes Left </VCardTitle>
              </VCardItem>
              <VCardText class="d-flex justify-between">
                <div class="d-flex align-end w-100">
                  <h1 class="m-0 mb-1 text-white">
                    {{ data.packageDetails?.duration_in_hours - data.packageDetails?.time_spent_in_hours }}
                  </h1>
                  <h4 class="m-0 ms-2 text-white">Minutes</h4>
                </div>
              </VCardText>
            </div>
            <VCardText>
              <div class="text-end w-100">
                <VIcon
                  icon="ri-timer-2-line"
                  size="60"
                ></VIcon>
              </div>
            </VCardText>
          </VCard>
        </VCol>
      </VRow>
    </VCardText>

    <!-- Edit Dialog -->
    <VDialog
      v-model="isDialogVisible.edit"
      max-width="600"
      persistent
    >
      <UserEdit
        item="data"
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
        title="timesheet"
        @close="toggleDialog('delete')"
      />
    </VDialog>
  </VCard>
</template>
