<template>
  <div class="space-y-6 max-w-3xl mx-auto">
    <div class="mb-8 border-b border-gray-200 pb-5 flex items-center justify-between">
      <div>
        <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">{{ isEdit ? 'ریکارڈ میں ترمیم' : 'نیا ڈسپلن ریکارڈ' }}</h1>
        <p class="text-sm text-gray-500 mt-1 font-medium">طالب علم کی حاضری یا ڈسپلن کی کارروائی درج کریں</p>
      </div>
      <button type="button" @click="goBack" class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-xl transition-all">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
      </button>
    </div>

    <div class="bg-white rounded-2xl shadow-xl shadow-gray-200/40 border border-gray-100 overflow-hidden">
      <form @submit.prevent="handleSubmit" class="p-8 space-y-6">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div class="space-y-2 md:col-span-2">
            <label class="block text-sm font-semibold text-gray-700">طالب علم <span class="text-red-500">*</span></label>
            <select v-model="form.student_id" @change="onStudentChange" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 outline-none transition-colors">
              <option value="" disabled>منتخب کریں...</option>
              <option v-for="s in students" :key="s.id" :value="s.id">{{ s.sname }} ({{ s.class }})</option>
            </select>
          </div>

          <div class="space-y-2">
            <label class="block text-sm font-semibold text-gray-700">درجہ / کلاس <span class="text-red-500">*</span></label>
            <input v-model="form.class" type="text" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 outline-none transition-colors" placeholder="درجہ..." />
          </div>

          <div class="space-y-2">
            <label class="block text-sm font-semibold text-gray-700">نوعیت (Type) <span class="text-red-500">*</span></label>
            <select v-model="form.incident_type_id" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 outline-none transition-colors">
              <option value="" disabled>نوعیت منتخب کریں...</option>
              <option v-for="t in types" :key="t.id" :value="t.id">{{ t.name }}</option>
            </select>
          </div>

          <div class="space-y-2 md:col-span-2">
            <label class="block text-sm font-semibold text-gray-700">تاریخ <span class="text-red-500">*</span></label>
            <input v-model="form.date" type="date" required dir="ltr" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 outline-none transition-colors text-right" />
          </div>

          <div class="space-y-2 md:col-span-2">
            <label class="block text-sm font-semibold text-gray-700">تفصیلات</label>
            <textarea v-model="form.detail" rows="4" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 outline-none transition-colors resize-none" placeholder="مزید تفصیلات یہاں درج کریں..."></textarea>
          </div>
        </div>

        <div v-if="error" class="p-4 bg-red-50 border border-red-200 text-red-600 text-sm rounded-xl font-medium flex items-center">
          <svg class="w-5 h-5 me-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
          {{ error }}
        </div>

        <!-- Footer actions -->
        <div class="flex justify-end pt-6 border-t border-gray-100 space-x-3 space-x-reverse">
          <button type="button" @click="goBack" class="px-6 py-2.5 text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-xl font-semibold transition-colors">منسوخ کریں</button>
          <button type="submit" :disabled="loading" class="px-8 py-2.5 bg-gradient-to-r from-indigo-600 to-indigo-700 hover:from-indigo-700 hover:to-indigo-800 text-white font-bold rounded-xl shadow-lg shadow-indigo-500/30 transition-all disabled:opacity-50 flex items-center">
            <span v-if="loading" class="me-2">
              <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
            </span>
            {{ loading ? 'محفوظ ہو رہا ہے...' : 'ڈیٹا محفوظ کریں' }}
          </button>
        </div>

      </form>
    </div>
  </div>
</template>

<script>
import { ref, onMounted, computed } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import axios from '../axios'

export default {
  name: 'DisciplineForm',

  setup() {
    const route = useRoute()
    const router = useRouter()

    const loading = ref(false)
    const error = ref(null)

    const form = ref({
      student_id: '',
      class: '',
      incident_type_id: '',
      date: '',
      detail: '',
    })

    const students = ref([])
    const types = ref([])

    const isEdit = computed(() => !!route.params.id)

    // Fetch meta data (students + incident types)
    const fetchMeta = async () => {
      try {
        const [studentsRes, typesRes] = await Promise.all([
          axios.get('/students?all=1'),
          axios.get('/incident-types?all=1'),
        ])
        students.value = studentsRes.data
        types.value = typesRes.data
      } catch (err) {
        error.value = 'Failed to load students or incident types'
      }
    }

    // Fetch record for edit
    const fetchRecord = async () => {
      try {
        const res = await axios.get(`/discipline-records/${route.params.id}`)
        form.value = res.data
      } catch (err) {
        error.value = 'Failed to load record'
      }
    }

    const handleSubmit = async () => {
      loading.value = true
      error.value = null

      try {
        if (isEdit.value) {
          await axios.put(`/discipline-records/${route.params.id}`, form.value)
        } else {
          await axios.post('/discipline-records', form.value)
        }
        router.push('/discipline-records')
      } catch (err) {
        error.value = err.response?.data?.message || 'Save failed'
      } finally {
        loading.value = false
      }
    }

    const onStudentChange = () => {
      const student = students.value.find(s => s.id === form.value.student_id)
      if (student) {
        form.value.class = student.class
      }
    }

    const goBack = () => {
      router.push('/discipline-records')
    }

    onMounted(() => {
      fetchMeta()
      if (isEdit.value) fetchRecord()
    })

    return {
      form,
      students,
      types,
      loading,
      error,
      isEdit,
      handleSubmit,
      onStudentChange,
      goBack,
    }
  },
}
</script>

<style scoped>
/* Tailwind CSS utility classes used */
</style>