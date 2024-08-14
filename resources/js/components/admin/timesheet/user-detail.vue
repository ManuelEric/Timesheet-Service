<script setup>
import UserEdit from '@/components/admin/timesheet/user-edit.vue'
import DeleteDialog from '@/components/DeleteHandler.vue'
import { showLoading, showNotif } from '@/helper/notification'
import { router } from '@/plugins/router'
import ApiService from '@/services/ApiService'
import moment from 'moment'
import Swal from 'sweetalert2'

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
  showLoading()
  try {
    const res = await ApiService.get('api/v1/timesheet/' + id + '/detail')
    // console.log(res)
    if (res) {
      data.value = res
    }
    Swal.close()
  } catch (error) {
    if (error.response?.status == 400) {
      showNotif('error', error.response?.data?.errors, 'bottom-end')
      router.push('/admin/timesheet')
    }
    console.log(error)
  }
}

const deleteTimesheet = async () => {
  try {
    const res = await ApiService.delete('api/v1/timesheet/' + props.id + '/delete')
    console.log(res)
    if (res) {
      data.value = res
      showNotif('success', res.message, 'bottom-end')
      isDialogVisible.value.delete = false
      router.push('/admin/timesheet')
    }
  } catch (error) {
    if (error.response?.status == 400) {
      showNotif('error', error.response?.data?.errors, 'bottom-end')
    }
  }
}

const toggleDialog = type => {
  if (!isDialogVisible.value[type]) {
    isDialogVisible.value[type] = true
  } else {
    isDialogVisible.value[type] = false
  }
}

const downloadTimesheet = async (id, name) => {
  showLoading()
  try {
    const res = await ApiService.get('api/v1/timesheet/' + id + '/export', {
      responseType: 'blob',
    })

    if (res) {
      const url = window.URL.createObjectURL(
        new Blob([res], { type: '"application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"' }),
      )

      // Create a temporary <a> element to trigger the download
      const link = document.createElement('a')
      link.href = url
      link.setAttribute('download', `timesheet_${name}.xlsx`)

      // Append the <a> element to the body and click it to trigger the download
      document.body.appendChild(link)
      link.click()

      // Clean up: remove the <a> element and revoke the blob URL
      document.body.removeChild(link)
      window.URL.revokeObjectURL(url)

      Swal.close()
    }
  } catch (error) {
    showNotif('error', error.response?.statusText, 'bottom-end')
    console.log(error)
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
        Timesheet - {{ data.packageDetails?.package_type }}
      </div>
      <div>
        <VMenu
          :close-on-content-click="false"
          location="bottom"
          open-on-hover
        >
          <template v-slot:activator="{ props }">
            <VBtn
              color="secondary"
              v-bind="props"
              v-tooltip:start="'Settings'"
            >
              <VIcon icon="ri-settings-3-line"></VIcon>
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
                <div
                  class="cursor-pointer"
                  @click="
                    downloadTimesheet(
                      props.id,
                      data?.packageDetails?.package_type +
                        '-' +
                        data?.packageDetails?.package_name +
                        '_' +
                        data?.packageDetails?.tutormentor_name,
                    )
                  "
                >
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
            <tbody v-if="data.clientProfile?.length > 1">
              <tr class="bg-secondary">
                <td>Name</td>
                <td>School</td>
                <td>Grade</td>
              </tr>
              <tr v-for="client in data.clientProfile">
                <td>{{ client.client_name }}</td>
                <td>{{ client.client_school }}</td>
                <td>{{ client.client_grade }}</td>
              </tr>
            </tbody>
            <tbody v-else-if="data.clientProfile?.length == 1">
              <tr>
                <td width="20%">Name</td>
                <td width="1%">:</td>
                <td>{{ data.clientProfile[0].client_name }}</td>
              </tr>
              <tr>
                <td>School Name</td>
                <td width="1%">:</td>
                <td>{{ data.clientProfile[0].client_school }}</td>
              </tr>
              <tr>
                <td>Grade</td>
                <td width="1%">:</td>
                <td>{{ data.clientProfile[0].client_grade }}</td>
              </tr>
              <tr>
                <td>Email</td>
                <td width="1%">:</td>
                <td>{{ data.clientProfile[0].client_mail }}</td>
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
                <td>
                  {{ data.packageDetails?.package_type + ' - ' + data.packageDetails?.package_name }}
                </td>
              </tr>
              <tr>
                <td>Person in Charge</td>
                <td width="1%">:</td>
                <td>
                  <ol
                    class="ms-4"
                    type="1"
                  >
                    <li>{{ data.packageDetails?.pic_name }}</li>
                  </ol>
                </td>
              </tr>
              <tr>
                <td>Tutor/Mentor</td>
                <td width="1%">:</td>
                <td>{{ data.packageDetails?.tutormentor_name }}</td>
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
                  <h1 class="m-0 mb-1 text-white">
                    {{ data.packageDetails?.duration_in_minutes }}
                  </h1>
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
                  <h1 class="m-0 mb-1 text-white">
                    {{ data.packageDetails?.time_spent_in_minutes }}
                  </h1>
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
                    {{ data.packageDetails?.duration_in_minutes - data.packageDetails?.time_spent_in_minutes }}
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
        :item="data.editableColumns"
        :package_id="data.packageDetails?.package_id"
        :id="props.id"
        @close="toggleDialog('edit')"
        @reload="getData(props.id)"
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
        @delete="deleteTimesheet"
        @close="toggleDialog('delete')"
      />
    </VDialog>
  </VCard>
</template>
