<template>
  <div class="space-y-6">
    <div class="flex flex-col sm:flex-row items-center justify-between mb-8 gap-4">
      <div>
        <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">طلباء کی فہرست</h1>
        <p class="text-sm text-gray-500 mt-1 font-medium">مدرسے کے تمام طلباء کی تفصیلات اور تلاش</p>
      </div>

      <div class="flex items-center space-x-4 space-x-reverse w-full sm:w-auto">
        <!-- Search Input -->
        <div class="relative flex-1 sm:w-64">
          <span class="absolute inset-y-0 right-0 flex items-center pr-3">
            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
          </span>
          <input
            v-model="search"
            @input="debouncedSearch"
            type="text"
            dir="rtl"
            class="w-full pr-10 pl-4 py-2 bg-white border border-gray-200 text-gray-900 rounded-xl focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all outline-none"
            placeholder="نام یا کوڈ سے تلاش کریں..."
          />
        </div>

        <button @click="goToCreate" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl shadow-lg shadow-indigo-500/30 transition-all active:scale-95 whitespace-nowrap flex items-center">
          <svg class="w-5 h-5 me-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
          نیا طالب علم
        </button>
      </div>
    </div>

    <!-- Data Table -->
    <div class="bg-white rounded-2xl shadow-xl shadow-gray-200/40 border border-gray-100 overflow-hidden">
      <div class="overflow-x-auto">
        <table class="w-full text-right align-middle">
          <thead>
            <tr class="bg-gray-50/50 text-gray-500 border-b border-gray-100">
              <th class="py-4 px-6 font-semibold text-sm">نام</th>
              <th class="py-4 px-6 font-semibold text-sm">ولدیت</th>
              <th class="py-4 px-6 font-semibold text-sm">کوڈ</th>
              <th class="py-4 px-6 font-semibold text-sm">درجہ / کلاس</th>
              <th class="py-4 px-6 font-semibold text-sm text-center">ایکشنز</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-100">
            <tr v-for="student in students.data" :key="student.id" class="hover:bg-gray-50/50 transition-colors group">
              <td class="py-3 px-6">
                <div class="flex items-center">
                  <div class="h-10 w-10 flex-shrink-0 bg-indigo-50 text-indigo-600 rounded-full flex items-center justify-center font-bold text-lg me-3">
                    {{ student.sname.charAt(0) }}
                  </div>
                  <div class="font-medium text-gray-900">{{ student.sname }}</div>
                </div>
              </td>
              <td class="py-3 px-6 text-gray-600">{{ student.fathername }}</td>
              <td class="py-3 px-6">
                <span class="px-3 py-1 bg-gray-100 text-gray-700 rounded-lg text-xs font-semibold tracking-wide">{{ student.code }}</span>
              </td>
              <td class="py-3 px-6 text-gray-600">{{ student.class }}</td>
              <td class="py-3 px-6 text-center">
                <div class="flex items-center justify-center space-x-2 space-x-reverse opacity-0 group-hover:opacity-100 transition-opacity">
                  <button @click="editStudent(student.id)" class="p-2 text-indigo-500 hover:text-indigo-700 hover:bg-indigo-50 rounded-lg transition-colors" title="ترمیم کریں">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                  </button>
                  <button @click="deleteStudent(student.id)" class="p-2 text-red-500 hover:text-red-700 hover:bg-red-50 rounded-lg transition-colors" title="حذف کریں">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                  </button>
                </div>
              </td>
            </tr>
            <tr v-if="students.data.length === 0">
              <td colspan="5" class="py-12 text-center text-gray-500">
                <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <div class="text-lg">کوئی طالب علم نہیں ملا</div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      
      <!-- Pagination -->
      <div v-if="students.total > students.per_page" class="bg-gray-50/50 p-4 border-t border-gray-100 flex items-center justify-between">
        <span class="text-sm text-gray-600">
          صفحہ {{ students.current_page }} از {{ students.last_page }}
        </span>
        <div class="flex space-x-2 space-x-reverse">
          <button :disabled="!students.prev_page_url" @click="changePage(students.current_page - 1)" class="px-4 py-2 border border-gray-200 rounded-lg text-sm font-medium hover:bg-white disabled:opacity-50 disabled:bg-transparent transition-colors">
            پچھلا
          </button>
          <button :disabled="!students.next_page_url" @click="changePage(students.current_page + 1)" class="px-4 py-2 border border-gray-200 rounded-lg text-sm font-medium hover:bg-white disabled:opacity-50 disabled:bg-transparent transition-colors">
            اگلا
          </button>
        </div>
      </div>
    </div>

    <!-- Error state -->
    <div v-if="error" class="mt-4 p-4 bg-red-50 border border-red-200 text-red-600 text-sm rounded-xl font-medium flex items-center">
      {{ error }}
    </div>

  </div>
</template>

<script>
import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import axios from '../axios'

export default {
  name: 'Students',

  setup() {
    const router = useRouter()

    const students = ref({
      data: [],
      current_page: 1,
      last_page: 1,
      prev_page_url: null,
      next_page_url: null,
    })

    const search = ref('')
    const error = ref(null)
    let timeout = null

    const fetchStudents = async (page = 1) => {
      try {
        const res = await axios.get('/students', {
          params: {
            page,
            search: search.value,
          },
        })

        students.value = res.data

      } catch (err) {
        error.value = 'Failed to load students'
      }
    }

    const changePage = (page) => {
      fetchStudents(page)
    }

    const debouncedSearch = () => {
      clearTimeout(timeout)
      timeout = setTimeout(() => {
        fetchStudents(1)
      }, 500)
    }

    const goToCreate = () => {
      router.push('/students/create')
    }

    const editStudent = (id) => {
      router.push(`/students/${id}/edit`)
    }

    const deleteStudent = async (id) => {
      if (!confirm('Are you sure?')) return

      try {
        await axios.delete(`/students/${id}`)
        fetchStudents()
      } catch (err) {
        error.value = 'Delete failed'
      }
    }

    onMounted(() => {
      fetchStudents()
    })

    return {
      students,
      search,
      error,
      changePage,
      debouncedSearch,
      goToCreate,
      editStudent,
      deleteStudent,
    }
  },
}
</script>

<style scoped>
/* Switched to Tailwind CSS classes */
</style>