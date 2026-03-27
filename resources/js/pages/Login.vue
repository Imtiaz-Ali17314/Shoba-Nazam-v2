<template>
  <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-indigo-50 via-white to-indigo-100 p-4 relative overflow-hidden">
    <!-- Decorative blobs -->
    <div class="absolute -top-32 -left-32 w-96 h-96 bg-indigo-300 rounded-full mix-blend-multiply filter blur-3xl opacity-50 animate-blob"></div>
    <div class="absolute -bottom-32 -right-32 w-96 h-96 bg-purple-300 rounded-full mix-blend-multiply filter blur-3xl opacity-50 animate-blob animation-delay-2000"></div>

    <div class="relative w-full max-w-md bg-white/70 backdrop-blur-xl border border-white/40 rounded-3xl shadow-2xl overflow-hidden p-8 transition-all hover:shadow-indigo-500/20">
      <div class="text-center mb-10">
        <div class="bg-indigo-600 w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg shadow-indigo-500/30">
          <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
        </div>
        <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">شوبا نظام</h1>
        <p class="text-gray-500 mt-2 text-sm font-medium">سسٹم میں لاگ ان کریں</p>
      </div>

      <form @submit.prevent="handleLogin" class="space-y-6">
        <div class="space-y-1 relative group">
          <label class="block text-sm font-semibold text-gray-700 transition-colors group-focus-within:text-indigo-600">ای میل</label>
          <div class="relative">
            <span class="absolute inset-y-0 right-0 flex items-center pr-3">
              <svg class="w-5 h-5 text-gray-400 group-focus-within:text-indigo-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
            </span>
            <input v-model="email" type="email" required dir="ltr" class="w-full pr-10 pl-4 py-3 bg-white/50 border border-gray-200 text-gray-900 rounded-xl focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 focus:bg-white transition-all outline-none" placeholder="admin@example.com" />
          </div>
        </div>

        <div class="space-y-1 relative group">
          <label class="block text-sm font-semibold text-gray-700 transition-colors group-focus-within:text-indigo-600">پاس ورڈ</label>
          <div class="relative">
            <span class="absolute inset-y-0 right-0 flex items-center pr-3">
              <svg class="w-5 h-5 text-gray-400 group-focus-within:text-indigo-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
            </span>
            <input v-model="password" type="password" required dir="ltr" class="w-full pr-10 pl-4 py-3 bg-white/50 border border-gray-200 text-gray-900 rounded-xl focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 focus:bg-white transition-all outline-none" placeholder="••••••••" />
          </div>
        </div>

        <button type="submit" :disabled="loading" class="w-full py-3 px-4 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-bold rounded-xl shadow-lg shadow-indigo-500/30 hover:shadow-indigo-500/50 transform transition-all active:scale-[0.98] disabled:opacity-70 disabled:cursor-not-allowed flex justify-center items-center">
          <span v-if="loading" class="me-2">
            <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
          </span>
          {{ loading ? 'لاگ ان ہو رہا ہے...' : 'لاگ ان کریں' }}
        </button>
      </form>

      <!-- Error Toast/Message -->
      <div v-if="error" class="mt-6 p-4 bg-red-50 border border-red-200 text-red-600 text-sm rounded-xl font-medium flex items-center animate-pulse">
        <svg class="w-5 h-5 me-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
        {{ error }}
      </div>
    </div>
  </div>
</template>

<script>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import axios from '../axios'

export default {
  name: 'Login',

  setup() {
    const router = useRouter()

    const email = ref('')
    const password = ref('')
    const loading = ref(false)
    const error = ref(null)

    const handleLogin = async () => {
      loading.value = true
      error.value = null

      try {
        // 1. CSRF cookie (Sanctum)
        await axios.get('/sanctum/csrf-cookie')

        // 2. Login request
        await axios.post('/login', {
          email: email.value,
          password: password.value,
        })

        // 3. Get user (optional but recommended)
        await axios.get('/user')

        // 4. Redirect to dashboard
        router.push('/dashboard')

      } catch (err) {
        error.value =
          err.response?.data?.message || 'Invalid credentials'
      } finally {
        loading.value = false
      }
    }

    return {
      email,
      password,
      loading,
      error,
      handleLogin,
    }
  },
}
</script>

<style scoped>
@keyframes blob {
  0% { transform: translate(0px, 0px) scale(1); }
  33% { transform: translate(30px, -50px) scale(1.1); }
  66% { transform: translate(-20px, 20px) scale(0.9); }
  100% { transform: translate(0px, 0px) scale(1); }
}
.animate-blob {
  animation: blob 7s infinite;
}
.animation-delay-2000 {
  animation-delay: 2s;
}
</style>