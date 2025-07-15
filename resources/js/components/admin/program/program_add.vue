<script setup>
import { showNotif } from '@/helper/notification'
import { rules } from '@/helper/rules'
import ApiService from '@/services/ApiService'

const props = defineProps({ selected: Object })
const emit = defineEmits(['close', 'reload'])

const loading = ref(false)
const tutor_selected = ref(null)
const tutor_list = ref([])
const curriculum_list = ref([])
const subjects = ref([])
const package_list = ref([])
const pic_list = ref([])
const inhouse_mentor = ref([])
const duration_readonly = ref(false)
const require = props.selected[0]?.require?.toLowerCase()
const has_npwp = ref(null)
const fee_nett = ref(null)
const students_name = ref(props.selected.map(item => item.mentee))

const formData = ref()
const form = ref({
  ref_id: props.selected.map(item => item.id),
  mentortutor_email: null,
  subject_id: null,
  inhouse_id: null,
  package_id: props.selected[0]?.package ?? null,
  tax: null,
  individual_fee: null,
  duration: '',
  notes: '',
  pic_id: [],
  curriculum_id: props.selected[0]?.curriculum ?? null,
})

const getTutor = async (inhouse = false) => {
  const url = inhouse
    ? 'api/v1/user/mentor-tutors?inhouse=true&role=' + require
    : 'api/v1/user/mentor-tutors?role=' + require
  try {
    const res = await ApiService.get(url)
    if (res) {
      if (inhouse) {
        inhouse_mentor.value = Object.values(res)
      } else {
        tutor_list.value = res
      }
    }
  } catch (error) {
    console.error(error)
  }
}

const getPackage = async () => {
  try {
    const res = await ApiService.get('api/v1/package/component/list?category=' + require)
    if (res) {
      package_list.value = res
    }
  } catch (error) {
    console.error(error)
  }
}

const checkPackage = () => {
  const package_id = form.value.package_id
  const index = package_list.value.findIndex(item => item.id === package_id)
  let item = package_list.value[index]

  if (item.detail) {
    duration_readonly.value = true
    form.value.duration = item.detail
  } else {
    duration_readonly.value = false
    form.value.duration = null
  }
}

const getPIC = async () => {
  try {
    const res = await ApiService.get('api/v1/user/component/list')
    if (res) {
      pic_list.value = res
    }
  } catch (error) {
    console.error(error)
  }
}

const getSubject = async (item, uuid = null, npwp = 0) => {
  // check NPWP
  has_npwp.value = npwp
  form.value.tax = npwp == 1 ? 2.5 : 2.5

  form.value.subject_id = null
  form.value.subject_name = null
  form.value.individual_fee = null
  fee_nett.value = null

  const curriculum = form.value.curriculum_id ? '/' + form.value.curriculum_id : ''
  try {
    const res = await ApiService.get('api/v1/user/mentor-tutors/' + uuid + '/subjects' + curriculum)
    if (res) {
      subjects.value = res
    }
  } catch (error) {
    console.error(error)
  }
}

const getIndividualFee = async (tutor_id, subject_name, curriculum_id) => {
  const grade = props.selected[0]?.grade

  if (subject_name) {
    try {
      const res = await ApiService.get(
        'api/v1/component/fee/tutor/' + tutor_id + '/' + subject_name + '/' + curriculum_id + '/' + grade,
      )

      if (res) {
        // if student more than one, use fee group
        form.value.individual_fee = props.selected?.length > 1 ? res.fee_group : res.fee_individual
        if (form.value.individual_fee) {
          checkNettFee()
        } else {
          fee_nett.value = null
        }
      }
    } catch (error) {
      showNotif(
        'error',
        "We're sorry, but we couldn't find a tutor fee for the selected curriculum and subject. This may be outside the scope of our current agreement. Please reach out to our HR team for assistance or to explore available options",
        'bottom-end',
      )
      console.error(error)
    }
  } else {
    form.value.individual_fee = null
    fee_nett.value = null
  }
}

const getCurriculum = async () => {
  try {
    const res = await ApiService.get('api/v1/curriculum/component/list')
    if (res) curriculum_list.value = res
  } catch (error) {
    console.error(error)
  }
}

const submit = async () => {
  form.value.mentortutor_email = tutor_selected.value.email

  const { valid } = await formData.value.validate()
  if (valid) {
    loading.value = true
    try {
      const res = await ApiService.post('api/v1/timesheet/create', form.value)
      if (res) {
        showNotif('success', res.message, 'bottom-end')
        emit('reload')

        form.value = {
          ref_id: [],
          mentortutor_email: null,
          subject_id: null, // used when subject fetched from the server
          subject_name: null, // used when subject fetched from own db
          inhouse_id: null,
          package_id: null,
          duration: '',
          notes: '',
          pic_id: [],
          tax: null,
          individual_fee: '',
        }
        tutor_selected.value = null

        window.open('/admin/timesheet/tutoring/' + res.data?.timesheet_id, '_blank')
      }
    } catch (error) {
      console.log(error)
      if (error?.response?.data?.errors) {
        const validationErrors = error.response.data.errors
        showNotif('error', validationErrors, 'bottom-end')
      }
    } finally {
      emit('close')
      loading.value = false
    }
  }
}

// Check Nett
const checkNettFee = () => {
  const nett = form.value.individual_fee * (1 - form.value.tax / 100)
  fee_nett.value = Math.trunc(nett)
}

// Check Gross
const checkGrossFee = () => {
  const gross = fee_nett.value / (1 - form.value.tax / 100)
  form.value.individual_fee = Math.trunc(gross)
}
// End Functions

onMounted(() => {
  getTutor()
  getTutor(true)
  getPackage()
  getPIC()
  getCurriculum()
})
</script>

<template>
  <VCard
    max-width="650"
    prepend-icon="ri-send-plane-line"
    :title="props.selected[0]?.program_name"
  >
    <VCardText>
      <div class="mb-4 d-flex gap-1">
        <p class="text-sm">{{ props.selected?.length > 1 ? 'Students' : 'Student' }}:</p>
        <p
          v-for="i in students_name"
          :key="i"
          class="text-sm bg-info px-2 rounded"
        >
          {{ i }}
        </p>
      </div>
      <VForm
        @submit.prevent="submit"
        ref="formData"
        validate-on="input"
      >
        <VRow>
          <VCol :cols="tutor_selected ? 11 : 12">
            <VAutocomplete
              clearable
              v-model="tutor_selected"
              label="Tutor Name"
              :items="tutor_list"
              :item-props="
                item => ({
                  title: item.full_name,
                  subtitle: item.roles.map(role => role.name).join(', '),
                })
              "
              :rules="rules.required"
              :loading="loading"
              :disabled="loading"
              density="compact"
              @update:modelValue="getSubject(tutor_selected.roles, tutor_selected.uuid, tutor_selected.has_npwp)"
            ></VAutocomplete>
          </VCol>
          <VCol
            cols="1"
            v-if="tutor_selected"
          >
            <VDialog max-width="600">
              <template v-slot:activator="{ props: activatorProps }">
                <VTooltip
                  activator="parent"
                  location="end"
                  >Fee Detail</VTooltip
                >
                <VIcon
                  icon="ri-folder-info-line"
                  class="cursor-pointer mt-3"
                  v-bind="activatorProps"
                />
              </template>

              <template v-slot:default="{ isActive }">
                <VCard>
                  <VCardText class="py-5">
                    <div class="d-flex justify-between align-center mb-3">
                      <h4 class="w-100">Detail of Active Agreement</h4>

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
                      v-if="tutor_selected?.roles.findIndex(role => role.name === 'Tutor') >= 0"
                    >
                      <thead>
                        <tr>
                          <th
                            class="text-left"
                            nowrap
                          >
                            Curriculum
                          </th>
                          <th nowrap>Subject Tutoring</th>
                          <th nowrap>Grade</th>
                          <th nowrap>Fee Individual - Gross</th>
                        </tr>
                      </thead>
                      <tbody>
                        <template
                          v-for="(sub_item, index) in tutor_selected.roles"
                          :key="index"
                        >
                          <tr
                            v-if="sub_item.name == 'Tutor'"
                            v-for="subject in sub_item.subjects"
                            :key="subject"
                          >
                            <td nowrap>
                              {{ subject.curriculum_name ?? '-' }}
                              <a
                                :href="subject.agreement"
                                target="_blank"
                                class="ms-2 d-inline cursor-pointer"
                                v-if="subject.agreement"
                              >
                                <VTooltip
                                  activator="parent"
                                  location="end"
                                >
                                  Check Agreement
                                </VTooltip>
                                <VIcon icon="ri-file-pdf-2-line" />
                              </a>
                            </td>
                            <td nowrap>{{ subject.tutor_subject ?? '-' }}</td>
                            <td nowrap>{{ subject.grade ?? '-' }}</td>
                            <td nowrap>
                              Rp.
                              {{ new Intl.NumberFormat('id-ID').format(subject.fee_individual) }}
                            </td>
                          </tr>
                        </template>
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
          </VCol>
          <VCol
            md="6"
            cols="6"
          >
            <VAutocomplete
              clearable
              v-model="form.curriculum_id"
              label="Curriculum"
              :items="curriculum_list"
              :item-props="
                item => ({
                  title: item.name,
                })
              "
              :loading="loading"
              readonly
              density="compact"
              item-value="id"
              @update:modelValue="getIndividualFee(tutor_selected.id, form.subject_name, form.curriculum_id)"
            ></VAutocomplete>
          </VCol>
          <VCol
            md="6"
            cols="6"
            v-if="props.selected[0]?.require?.toLowerCase() == 'tutor'"
          >
            <VAutocomplete
              clearable
              v-model="form.subject_name"
              label="Subject Tutoring"
              :items="subjects"
              item-value="tutor_subject"
              item-title="tutor_subject"
              :loading="loading"
              :disabled="loading"
              :rules="rules.required"
              density="compact"
              @update:modelValue="getIndividualFee(tutor_selected.id, form.subject_name, form.curriculum_id)"
            ></VAutocomplete>
          </VCol>
          <VCol
            md="8"
            cols="8"
          >
            <VAutocomplete
              clearable
              label="Package"
              v-model="form.package_id"
              :items="package_list"
              density="compact"
              :item-props="
                item => ({
                  title: item.package != null ? item.type_of + ' - ' + item.package : item.type_of,
                  subtitle: item.detail ? item.detail / 60 + ' Hours' : 'Customizable',
                })
              "
              item-value="id"
              :rules="rules.required"
              :loading="loading"
              :disabled="loading || props.selected[0]?.package"
              @update:modelValue="checkPackage"
            ></VAutocomplete>
          </VCol>
          <VCol
            md="4"
            cols="4"
          >
            <VTextField
              type="number"
              clearable
              :label="form.duration / 60 ? 'Minutes (' + (form.duration / 60).toFixed(1) + ' Hours)' : 'Minutes'"
              :readonly="duration_readonly"
              v-model="form.duration"
              density="compact"
              :rules="rules.required"
            />
          </VCol>
          <VCol
            md="4"
            cols="7"
          >
            <VTextField
              type="number"
              clearable
              label="Fee/hours (Nett)"
              v-model="fee_nett"
              density="compact"
              readonly
              :rules="rules.required"
              @update:model-value="checkGrossFee"
            />
          </VCol>
          <VCol
            md="4"
            cols="5"
          >
            <VTextField
              type="number"
              clearable
              label="Tax"
              v-model="form.tax"
              :rules="rules.required"
              density="compact"
              readonly
              @update:model-value="checkGrossFee"
            />
          </VCol>
          <VCol
            md="4"
            cols="12"
          >
            <v-tooltip
              activator="parent"
              location="top"
            >
              Fee Gross is automatically calculated based on the entered Net Fee and Tax Rate.
            </v-tooltip>
            <VTextField
              type="number"
              clearable
              label="Fee/hours (Gross)"
              v-model="form.individual_fee"
              density="compact"
              readonly
              :rules="rules.required"
              @update:model-value="checkNettFee"
            />
          </VCol>
          <VCol
            md="6"
            cols="6"
          >
            <VAutocomplete
              clearable
              v-model="form.inhouse_id"
              label="Inhouse Mentor/Tutor"
              :items="inhouse_mentor"
              density="compact"
              :item-props="
                item => ({
                  title: item.full_name,
                })
              "
              item-value="uuid"
              :loading="loading"
              :disabled="loading"
              :rules="rules.required"
            ></VAutocomplete>
          </VCol>
          <VCol
            md="6"
            cols="6"
          >
            <VAutocomplete
              multiple
              clearable
              chips
              label="PIC"
              v-model="form.pic_id"
              :items="pic_list"
              item-title="full_name"
              item-value="id"
              :loading="loading"
              density="compact"
              :disabled="loading"
              :rules="rules.required"
            ></VAutocomplete>
          </VCol>
          <VCol md="12">
            <VTextarea
              label="Notes"
              v-model="form.notes"
              density="compact"
            ></VTextarea>
          </VCol>
        </VRow>

        <VCardActions class="mt-5 px-0">
          <VBtn
            variant="tonal"
            color="error"
            type="button"
            @click="emit('close')"
          >
            <VIcon
              icon="ri-close-line"
              class="me-3"
            />
            Close
          </VBtn>
          <VSpacer />
          <VBtn
            variant="tonal"
            color="success"
            type="submit"
          >
            Save
            <VIcon
              icon="ri-save-line"
              class="ms-3"
            />
          </VBtn>
        </VCardActions>
      </VForm>
    </VCardText>
  </VCard>
</template>
