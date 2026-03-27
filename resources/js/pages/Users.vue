<template>
  <div class="space-y-6">
   <div class="flex flex-col sm:flex-row items-center justify-between mb-5 gap-4">
      <div>
       <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight mb-4">یوزر مینجمنٹ</h1>
        <p class="text-sm text-gray-500 mt-1 font-medium">سسٹم کے صارفین، ان کے رولز اور رسائی کا کنٹرول</p>
      </div>
      
      <button @click="showCreate = true" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl shadow-lg shadow-indigo-500/30 transition-all active:scale-95 whitespace-nowrap flex items-center">
        <svg class="w-5 h-5 me-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
        نیا صارف
      </button>
    </div>

    <!-- Data Table -->
    <div class="bg-white rounded-2xl shadow-xl shadow-gray-200/40 border border-gray-100 overflow-hidden">
      <div class="overflow-x-auto">
        <table class="w-full text-right align-middle">
          <thead>
            <tr class="bg-gray-50/50 text-gray-500 border-b border-gray-100">
              <th class="py-4 px-6 font-semibold text-sm">نام</th>
              <th class="py-4 px-6 font-semibold text-sm">ای میل</th>
              <th class="py-4 px-6 font-semibold text-sm">رولز</th>
              <th class="py-4 px-6 font-semibold text-sm text-center">سٹیٹس</th>
              <th class="py-4 px-6 font-semibold text-sm text-center">ایکشنز</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-100">
            <tr v-for="user in users.data" :key="user.id" class="hover:bg-gray-50/50 transition-colors group">
              <td class="py-3 px-6">
                <div class="flex items-center">
                  <div class="h-10 w-10 flex-shrink-0 bg-indigo-50 text-indigo-600 rounded-full flex items-center justify-center font-bold text-lg me-3">
                    {{ user.name.charAt(0) }}
                  </div>
                  <div class="font-medium text-gray-900">{{ user.name }}</div>
                </div>
              </td>
              <td class="py-3 px-6 text-gray-600 font-sans" dir="ltr">{{ user.email }}</td>
              <td class="py-3 px-6">
                <div class="flex flex-wrap gap-1">
                  <span v-for="role in user.roles" :key="role.id" class="px-2 py-1 bg-purple-50 text-purple-700 rounded-md text-xs font-semibold">
                    {{ role.name }}
                  </span>
                </div>
              </td>
              <td class="py-3 px-6 text-center">
                <span :class="[user.is_active ? 'bg-green-50 text-green-600' : 'bg-red-50 text-red-600']" class="px-3 py-1 rounded-full text-xs font-bold inline-flex items-center">
                  <span :class="[user.is_active ? 'bg-green-500' : 'bg-red-500']" class="w-1.5 h-1.5 rounded-full me-1.5"></span>
                  {{ user.is_active ? 'فعال' : 'غیر فعال' }}
                </span>
              </td>
              <td class="py-3 px-6 text-center">
                <div class="flex items-center justify-center space-x-2 space-x-reverse opacity-0 group-hover:opacity-100 transition-opacity">
                  <button @click="editUser(user)" class="p-2 text-indigo-500 hover:text-indigo-700 hover:bg-indigo-50 rounded-lg transition-colors" title="ترمیم کریں">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                  </button>
                  <button @click="toggleStatus(user)" class="p-2 hover:bg-gray-100 rounded-lg transition-colors" :class="user.is_active ? 'text-orange-500 hover:text-orange-700' : 'text-green-500 hover:text-green-700'" :title="user.is_active ? 'غیر فعال کریں' : 'فعال کریں'">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path v-if="user.is_active" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>
                      <path v-else stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                  </button>
                </div>
              </td>
            </tr>
            <tr v-if="!users.data || users.data.length === 0">
              <td colspan="5" class="py-12 text-center text-gray-500">
                <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                <div class="text-lg">کوئی صارف نہیں ملا</div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Pagination -->
      <div v-if="users.total > users.per_page" class="bg-gray-50/50 p-4 border-t border-gray-100 flex items-center justify-between">
        <span class="text-sm text-gray-600">
          صفحہ {{ users.current_page }} از {{ users.last_page }}
        </span>
        <div class="flex space-x-2 space-x-reverse">
          <button :disabled="!users.prev_page_url" @click="changePage(users.current_page - 1)" class="px-4 py-2 border border-gray-200 rounded-lg text-sm font-medium hover:bg-white disabled:opacity-50 disabled:bg-transparent transition-colors">
            پچھلا
          </button>
          <button :disabled="!users.next_page_url" @click="changePage(users.current_page + 1)" class="px-4 py-2 border border-gray-200 rounded-lg text-sm font-medium hover:bg-white disabled:opacity-50 disabled:bg-transparent transition-colors">
            اگلا
          </button>
        </div>
      </div>
    </div>

    <!-- Error state -->
    <div v-if="error" class="mt-4 p-4 bg-red-50 border border-red-200 text-red-600 text-sm rounded-xl font-medium flex items-center">
      {{ error }}
    </div>

    <!-- Create/Edit User Modal -->
    <transition name="fade">
      <div v-if="showCreate" class="fixed inset-0 z-50 flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-gray-900/40 backdrop-blur-sm" @click="closeModal"></div>
        <div class="bg-white rounded-3xl shadow-2xl w-full max-w-lg overflow-hidden relative z-10 transform transition-all p-8">
          <h2 class="text-2xl font-bold text-gray-900 mb-6">{{ editMode ? 'صارف میں ترمیم کریں' : 'نیا صارف بنائیں' }}</h2>
         <!-- 🔹 Modal error -->
          <div v-if="modalError"
            class="mb-4 p-4 bg-red-50 border border-red-200 text-red-600 text-sm rounded-xl font-medium flex items-center">
            {{ modalError }}
          </div>

          <form @submit.prevent="handleSubmit" class="space-y-4">
            <div class="space-y-1">
              <label class="block text-sm font-semibold text-gray-700">نام</label>
              <input v-model="form.name" type="text" required class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 outline-none transition-colors" />
            </div>

            <div class="space-y-1">
              <label class="block text-sm font-semibold text-gray-700">ای میل</label>
              <input v-model="form.email" type="email" required dir="ltr" class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 outline-none transition-colors" />
            </div>

            <div v-if="!editMode" class="space-y-1">
              <label class="block text-sm font-semibold text-gray-700">پاس ورڈ</label>
              <input v-model="form.password" type="password" required dir="ltr" class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 outline-none transition-colors" />
            </div>

            <div class="space-y-1">
              <label class="block text-sm font-semibold text-gray-700">استحقاق (Roles)</label>
              <select v-model="form.role" class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 outline-none transition-colors">
                <option value="admin">ایڈمن</option>
                <option value="nazim">ناظم</option>
                <option value="viewer">ویور</option>
              </select>
            </div>

            <div class="pt-4 flex justify-end space-x-3 space-x-reverse">
              <button type="button" @click="closeModal" class="px-5 py-2.5 text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-xl font-semibold transition-colors">منسوخ کریں</button>
              <button type="submit" :disabled="loading" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-semibold transition-colors disabled:opacity-50">
                {{ loading ? 'محفوظ ہو رہا ہے...' : 'محفوظ کریں' }}
              </button>
            </div>
          </form>
        </div>
      </div>
    </transition>
  </div>
</template>

<script>
import { ref, onMounted } from 'vue'
import axios from '../axios'

export default {
  name: 'Users',

  setup() {
    const users = ref({ data: [], current_page: 1, last_page: 1 })
    const roles = ref([])

    const showCreate = ref(false)
    const editMode = ref(false)

    const form = ref({
      id: null,
      name: '',
      email: '',
      password: '',
      role: 'admin',
    })

    const loading = ref(false)
    const error = ref(null)
    const modalError = ref(null)

    const fetchUsers = async (page = 1) => {
      try {
        const res = await axios.get('/users', { params: { page } })
        users.value = res.data
      } catch (err) {
        error.value = 'Failed to load users'
      }
    }

    const changePage = (page) => {
      fetchUsers(page)
    }

    const editUser = (user) => {
      editMode.value = true
      form.value = {
        id: user.id,
        name: user.name,
        email: user.email,
        password: '',
        role: user.roles.length > 0 ? user.roles[0].name : 'admin',
      }
      showCreate.value = true
    }

    const toggleStatus = async (user) => {
      try {
        await axios.patch(`/users/${user.id}/toggle-status`)
        fetchUsers(users.value.current_page)
      } catch (err) {
        error.value = 'Status update failed'
      }
    }

    const handleSubmit = async () => {
      loading.value = true
      error.value = null
      modalError.value = null

      try {
        if (editMode.value) {
          await axios.put(`/users/${form.value.id}`, form.value)
        } else {
          console.log(form.value);
          await axios.post('/users', form.value)
        }
        closeModal()
        fetchUsers(users.value.current_page)
      } catch (err) {
        if (showCreate.value) {
          modalError.value = err.response?.data?.message || 'Save failed'
        } else {
          error.value = err.response?.data?.message || 'Save failed'
        }
      } finally {
        loading.value = false
      }
    }

    const closeModal = () => {
      showCreate.value = false
      modalError.value = null
      editMode.value = false
      form.value = { id: null, name: '', email: '', password: '', role: 'admin' }
      error.value = null
    }

    onMounted(() => {
      fetchUsers()
    })

    return {
      users,
      roles,
      showCreate,
      editMode,
      form,
      loading,
      error,
      modalError,
      fetchUsers,
      changePage,
      editUser,
      toggleStatus,
      handleSubmit,
      closeModal,
    }
  },
}
</script>

<style scoped>
/* Scoped styles replaced by Tailwind */
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.2s;
}
.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>