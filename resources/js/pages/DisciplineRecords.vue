<template>
  <div class="space-y-6">
   <div class="flex flex-col md:flex-row items-start md:items-center justify-between mb-5 gap-4">
      <div>
       <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight mb-4">ڈسپلن ریکارڈز</h1>
        <p class="text-sm text-gray-500 mt-1 font-medium">طلباء کے ڈسپلن، کارروائیوں اور حاضری کے معاملات</p>
      </div>

      <button @click="goToCreate" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl shadow-lg shadow-indigo-500/30 transition-all active:scale-95 flex items-center shrink-0">
        <svg class="w-5 h-5 me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
        نیا ریکارڈ
      </button>
    </div>

    <!-- Filters Area -->
    <div class="bg-white p-5 rounded-2xl shadow-lg shadow-gray-200/30 border border-gray-100 flex flex-wrap gap-4 items-end">
      
      <div class="flex-1 min-w-[200px]">
        <label class="block text-xs font-semibold text-gray-500 mb-1">تاریخ سے</label>
        <input type="date" v-model="filters.date_from" @change="fetchRecords" class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500/50 outline-none text-sm transition-colors" />
      </div>
      
      <div class="flex-1 min-w-[200px]">
        <label class="block text-xs font-semibold text-gray-500 mb-1">تاریخ تک</label>
        <input type="date" v-model="filters.date_to" @change="fetchRecords" class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500/50 outline-none text-sm transition-colors" />
      </div>

      <div class="flex-1 min-w-[200px]">
        <label class="block text-xs font-semibold text-gray-500 mb-1">طالب علم</label>
        <select v-model="filters.student_id" @change="fetchRecords" class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500/50 outline-none text-sm transition-colors">
          <option value="">تمام طلباء</option>
          <option v-for="s in students" :key="s.id" :value="s.id">{{ s.sname }} ({{ s.code }})</option>
        </select>
      </div>

      <div class="flex-1 min-w-[200px]">
        <label class="block text-xs font-semibold text-gray-500 mb-1">نوعیت (Type)</label>
        <select v-model="filters.incident_type_id" @change="fetchRecords" class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500/50 outline-none text-sm transition-colors">
          <option value="">تمام</option>
          <option v-for="t in types" :key="t.id" :value="t.id">{{ t.name }}</option>
        </select>
      </div>

      <div class="flex-1 min-w-[200px]">
        <label class="block text-xs font-semibold text-gray-500 mb-1">درجہ/کلاس</label>
        <input type="text" v-model="filters.class" @input="debouncedFetch" placeholder="کلاس..." class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-500/50 outline-none text-sm transition-colors" />
      </div>

      <button @click="resetFilters" class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-600 font-semibold rounded-lg transition-colors text-sm">
        ری سیٹ
      </button>

    </div>

    <!-- Data Table -->
    <div class="bg-white rounded-2xl shadow-xl shadow-gray-200/40 border border-gray-100 overflow-hidden">
      <div class="overflow-x-auto">
        <table class="w-full text-right align-middle">
          <thead>
            <tr class="bg-gray-50/50 text-gray-500 border-b border-gray-100">
              <th class="py-4 px-6 font-semibold text-sm">تاریخ</th>
              <th class="py-4 px-6 font-semibold text-sm">طالب علم / کلاس</th>
              <th class="py-4 px-6 font-semibold text-sm">نوعیت</th>
              <th class="py-4 px-6 font-semibold text-sm w-1/3">تفصیلات</th>
              <th class="py-4 px-6 font-semibold text-sm text-center">ایکشنز</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-100">
            <tr v-for="record in records.data" :key="record.id" class="hover:bg-gray-50/50 transition-colors group">
              <td class="py-4 px-6">
                <span class="px-3 py-1 bg-indigo-50 text-indigo-700 rounded-md text-sm font-semibold inline-block" dir="ltr">{{ record.date }}</span>
              </td>
              <td class="py-4 px-6">
                <div class="font-bold text-gray-900">{{ record.student?.sname || 'نامعلوم' }}</div>
                <div class="text-xs text-gray-500 mt-1">{{ record.student?.class || '...' }}</div>
              </td>
              <td class="py-4 px-6">
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-rose-100 text-rose-800">
                  {{ record.incident_type?.name }}
                </span>
              </td>
              <td class="py-4 px-6 text-gray-600 text-sm leading-relaxed max-w-sm truncate whitespace-normal line-clamp-2">
                {{ record.detail }}
              </td>
              <td class="py-4 px-6 text-center">
                <div class="flex items-center justify-center space-x-2 space-x-reverse opacity-0 group-hover:opacity-100 transition-opacity">
                  <button @click="editRecord(record.id)" class="p-2 text-indigo-500 hover:text-indigo-700 hover:bg-indigo-50 rounded-lg transition-colors" title="ترمیم">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                  </button>
                  <button @click="deleteRecord(record.id)" class="p-2 text-red-500 hover:text-red-700 hover:bg-red-50 rounded-lg transition-colors" title="حذف">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                  </button>
                </div>
              </td>
            </tr>
            <tr v-if="!records.data || records.data.length === 0">
              <td colspan="5" class="py-12 text-center text-gray-500">
                <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                <div class="text-lg">کوئی ریکارڈ نہیں ملا</div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Pagination -->
      <div v-if="records.total > records.per_page" class="bg-gray-50/50 p-4 border-t border-gray-100 flex items-center justify-between">
        <span class="text-sm text-gray-600">
          صفحہ {{ records.current_page }} از {{ records.last_page }}
        </span>
        <div class="flex space-x-2 space-x-reverse">
          <button :disabled="!records.prev_page_url" @click="changePage(records.current_page - 1)" class="px-4 py-2 border border-gray-200 rounded-lg text-sm font-medium hover:bg-white disabled:opacity-50 disabled:bg-transparent transition-colors">
            پچھلا
          </button>
          <button :disabled="!records.next_page_url" @click="changePage(records.current_page + 1)" class="px-4 py-2 border border-gray-200 rounded-lg text-sm font-medium hover:bg-white disabled:opacity-50 disabled:bg-transparent transition-colors">
            اگلا
          </button>
        </div>
      </div>
    </div>

    <!-- Error state -->
    <div v-if="error" class="mt-4 p-4 bg-red-50 border border-red-200 text-red-600 text-sm rounded-xl font-medium flex items-center">
      <svg class="w-5 h-5 me-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
      {{ error }}
    </div>

  </div>
</template>

<script>
import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import axios from '../axios'

export default {
  name: 'DisciplineRecords',

  setup() {
    const router = useRouter()

    const records = ref({
      data: [],
      current_page: 1,
      last_page: 1,
    })

    const students = ref([])
    const types = ref([])

    const filters = ref({
      date_from: '',
      date_to: '',
      student_id: '',
      incident_type_id: '',
      class: '',
    })

    const error = ref(null)
    let timeout = null

    const fetchRecords = async (page = 1) => {
      try {
        const res = await axios.get('/discipline-records', {
          params: {
            page,
            ...filters.value,
          },
        })

        records.value = res.data
      } catch (err) {
        error.value = 'Failed to load records'
      }
    }

    const fetchMeta = async () => {
      try {
        const [studentsRes, typesRes] = await Promise.all([
          axios.get('/students?all=1'),
          axios.get('/incident-types?all=1'),
        ])
        students.value = studentsRes.data
        types.value = typesRes.data
      } catch (err) {
        error.value = 'Failed to load filters'
      }
    }

    const changePage = (page) => {
      fetchRecords(page)
    }

    const debouncedFetch = () => {
      clearTimeout(timeout)
      timeout = setTimeout(() => {
        fetchRecords(1)
      }, 500)
    }

    const resetFilters = () => {
      filters.value = {
        date_from: '',
        date_to: '',
        student_id: '',
        incident_type_id: '',
        class: '',
      }
      fetchRecords()
    }

    const goToCreate = () => {
      router.push('/discipline/create')
    }

    const editRecord = (id) => {
      router.push(`/discipline/${id}/edit`)
    }

    const deleteRecord = async (id) => {
      if (!confirm('Are you sure?')) return

      try {
        await axios.delete(`/discipline-records/${id}`)
        fetchRecords()
      } catch (err) {
        error.value = 'Delete failed'
      }
    }

    onMounted(() => {
      fetchMeta()
      fetchRecords()
    })

    return {
      records,
      students,
      types,
      filters,
      error,
      changePage,
      debouncedFetch,
      resetFilters,
      goToCreate,
      editRecord,
      deleteRecord,
      fetchRecords,
    }
  },
}
</script>

<style scoped>
/* Switched to tailwind utility classes */
</style>