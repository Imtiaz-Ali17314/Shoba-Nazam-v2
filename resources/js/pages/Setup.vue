<template>
  <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-indigo-50 via-white to-purple-50 p-6 relative overflow-hidden">
    <!-- Decorative -->
    <div class="absolute top-0 right-0 w-full h-96 bg-gradient-to-b from-indigo-100/50 object-cover mix-blend-multiply opacity-60"></div>
    <div class="absolute -top-40 -right-40 w-96 h-96 bg-indigo-200 rounded-full mix-blend-multiply filter blur-3xl opacity-50"></div>
    <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-purple-200 rounded-full mix-blend-multiply filter blur-3xl opacity-50"></div>

    <div class="relative w-full max-w-4xl bg-white/70 backdrop-blur-xl border border-white/50 rounded-[2rem] shadow-2xl overflow-hidden shadow-indigo-500/10">
      <div class="flex flex-col md:flex-row">
        <!-- Sidebar context -->
        <div class="md:w-1/3 bg-gradient-to-br from-indigo-600 to-purple-700 p-10 text-white flex flex-col justify-between relative overflow-hidden">
          <div class="absolute inset-0 bg-white/10 backdrop-blur-sm -skew-y-12 transform origin-top left-0 scale-150 opacity-20"></div>
          <div class="relative z-10">
            <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center mb-6 backdrop-blur-md">
              <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
            </div>
            <h2 class="text-3xl font-extrabold mb-4">نیا مدرسہ سیٹ اپ</h2>
            <p class="text-indigo-100 text-sm leading-relaxed mb-6 font-medium">سسٹم کو فعال کرنے کیلئے مدرسے کی تفصیلات اور ایڈمن اکاؤنٹ ترتیب دیں۔ ایک بار سیٹ اپ ہونے پر آپ تمام فیچرز استعمال کر سکیں گے۔</p>
          </div>
          <div class="relative z-10 text-sm text-indigo-200">
            © 2026 شوبا نظام
          </div>
        </div>

        <!-- Form  -->
        <div class="md:w-2/3 p-10">
          <form @submit.prevent="handleSubmit" class="space-y-6">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <!-- Madrasa Name -->
              <div class="space-y-1 group md:col-span-2">
                <label class="block text-sm font-semibold text-gray-700 group-focus-within:text-indigo-600 transition-colors">مدرسے کا نام <span class="text-red-500">*</span></label>
                <input v-model="form.name" type="text" required class="w-full px-4 py-3 bg-gray-50/50 border border-gray-200 text-gray-900 rounded-xl focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 focus:bg-white transition-all outline-none" placeholder="جامعہ ..." />
              </div>

              <!-- Phone -->
              <div class="space-y-1 group relative">
                <label class="block text-sm font-semibold text-gray-700 group-focus-within:text-indigo-600 transition-colors">فون نمبر</label>
                <input v-model="form.phone" type="text" dir="ltr" class="w-full px-4 py-3 bg-gray-50/50 border border-gray-200 text-gray-900 rounded-xl focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 focus:bg-white transition-all outline-none" placeholder="0300-1234567" />
              </div>

              <!-- General Email -->
              <div class="space-y-1 group relative">
                <label class="block text-sm font-semibold text-gray-700 group-focus-within:text-indigo-600 transition-colors">رسید/ای میل</label>
                <input v-model="form.email" type="email" dir="ltr" class="w-full px-4 py-3 bg-gray-50/50 border border-gray-200 text-gray-900 rounded-xl focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 focus:bg-white transition-all outline-none" placeholder="info@madrasa.com" />
              </div>
            </div>

            <hr class="border-gray-100 my-6" />

            <h3 class="text-xl font-bold text-gray-800 mb-4">ایڈمن اکاؤنٹ</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <!-- Admin Name -->
              <div class="space-y-1 group">
                <label class="block text-sm font-semibold text-gray-700 group-focus-within:text-indigo-600 transition-colors">ایڈمن کا نام <span class="text-red-500">*</span></label>
                <input v-model="form.admin_name" type="text" required class="w-full px-4 py-3 bg-gray-50/50 border border-gray-200 text-gray-900 rounded-xl focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 focus:bg-white transition-all outline-none" placeholder="احمد" />
              </div>

              <!-- Admin Email -->
              <div class="space-y-1 group">
                <label class="block text-sm font-semibold text-gray-700 group-focus-within:text-indigo-600 transition-colors">ایڈمن ای میل (لاگ ان کیلئے) <span class="text-red-500">*</span></label>
                <input v-model="form.admin_email" type="email" required dir="ltr" class="w-full px-4 py-3 bg-gray-50/50 border border-gray-200 text-gray-900 rounded-xl focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 focus:bg-white transition-all outline-none" placeholder="admin@domain.com" />
              </div>

              <!-- Password -->
              <div class="space-y-1 group md:col-span-2">
                <label class="block text-sm font-semibold text-gray-700 group-focus-within:text-indigo-600 transition-colors">پاس ورڈ <span class="text-red-500">*</span></label>
                <input v-model="form.password" type="password" required dir="ltr" class="w-full px-4 py-3 bg-gray-50/50 border border-gray-200 text-gray-900 rounded-xl focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 focus:bg-white transition-all outline-none" placeholder="••••••••" />
              </div>
            </div>

            <!-- Error Toast -->
            <div v-if="error" class="mt-4 p-4 bg-red-50 border border-red-200 text-red-600 text-sm rounded-xl font-medium flex items-center animate-pulse">
              <svg class="w-5 h-5 me-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
              {{ error }}
            </div>

            <div class="pt-4 flex justify-end">
              <button type="submit" :disabled="loading" class="px-8 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl shadow-lg shadow-indigo-500/30 hover:shadow-indigo-500/50 transform transition-all active:scale-[0.98] disabled:opacity-70 disabled:cursor-not-allowed flex justify-center items-center">
                <span v-if="loading" class="me-2">
                  <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                </span>
                {{ loading ? 'سیٹ اپ ہو رہا ہے...' : 'سیٹ اپ مکمل کریں' }}
              </button>
            </div>
            
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from '../axios'

export default {
  name: 'Setup',

  data() {
    return {
      loading: false,
      error: null,
      form: {
        name: '',
        logo: null,
        email: '',
        phone: '',
        admin_name: '',
        admin_email: '',
        password: '',
      },
    }
  },

  methods: {
    handleFile(e) {
      this.form.logo = e.target.files[0]
    },

    async handleSubmit() {
      this.loading = true
      this.error = null

      try {
        const formData = new FormData()

        Object.keys(this.form).forEach(key => {
          if (this.form[key]) {
            formData.append(key, this.form[key])
          }
        })

        await axios.post('/setup', formData)

        // redirect to login
        this.$router.push('/login')

      } catch (err) {
        this.error = err.response?.data?.message || 'Something went wrong'
      } finally {
        this.loading = false
      }
    }
  }
}
</script>

<style scoped>
/* Scoped css removed in favor of tailwind utility classes */
</style>