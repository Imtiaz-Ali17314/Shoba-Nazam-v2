<template>
  <div class="space-y-6 max-w-4xl mx-auto">
    <div class="mb-8 border-b border-gray-200 pb-5">
      <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">مدرسہ سیٹنگز</h1>
      <p class="text-sm text-gray-500 mt-1 font-medium">مدرسے کے بنیادی کوائف، لوگو اور تھیم کا انتظام کریں</p>
    </div>

    <div class="bg-white rounded-2xl shadow-xl shadow-gray-200/40 border border-gray-100 overflow-hidden">
      <form @submit.prevent="handleSubmit" class="p-8 space-y-8">
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
          <!-- Setup Info Section -->
          <div class="space-y-6">
            <h3 class="text-lg font-bold text-gray-800 border-b border-gray-100 pb-2">بنیادی معلومات</h3>
            
            <div class="space-y-2">
              <label class="block text-sm font-semibold text-gray-700">مدرسے کا نام</label>
              <input v-model="form.name" type="text" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 outline-none transition-colors" />
            </div>

            <div class="space-y-2">
              <label class="block text-sm font-semibold text-gray-700">تعلیمی سال</label>
              <input type="text" v-model="form.academic_year" placeholder="2025-2026" required dir="ltr" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 outline-none transition-colors" />
            </div>

            <div class="space-y-2">
              <label class="block text-sm font-semibold text-gray-700">پرائمری رنگ (تھیم)</label>
              <div class="flex items-center space-x-3 space-x-reverse">
                <input type="color" v-model="form.primary_color" class="h-10 w-10 p-0 border-0 rounded cursor-pointer" />
                <span class="text-sm text-gray-500 font-mono" dir="ltr">{{ form.primary_color }}</span>
              </div>
            </div>
            
            <div class="space-y-2">
              <label class="block text-sm font-semibold text-gray-700">لوگو</label>
              <div class="flex items-start space-x-4 space-x-reverse">
                <div class="flex-shrink-0 h-24 w-24 bg-gray-100 rounded-xl flex items-center justify-center border-2 border-dashed border-gray-300 overflow-hidden">
                  <img v-if="previewLogo" :src="previewLogo" alt="Logo Preview" class="h-full w-full object-cover" />
                  <svg v-else class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>
                <div class="flex-1">
                  <input type="file" id="logo-upload" @change="handleFileChange" accept="image/*" class="hidden" />
                  <label for="logo-upload" class="inline-block px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-lg cursor-pointer transition-colors">نیا لوگو منتخب کریں</label>
                  <p class="text-xs text-gray-400 mt-2">بہترین نتائج کیلئے مربع شکل کی تصویر (PNG/JPG) استعمال کریں</p>
                </div>
              </div>
            </div>
          </div>

          <!-- Contact Info Section -->
          <div class="space-y-6">
            <h3 class="text-lg font-bold text-gray-800 border-b border-gray-100 pb-2">رابطہ کی تفصیلات</h3>
            
            <div class="space-y-2">
              <label class="block text-sm font-semibold text-gray-700">فون نمبر</label>
              <input type="text" v-model="form.phone" dir="ltr" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 outline-none transition-colors" />
            </div>

            <div class="space-y-2">
              <label class="block text-sm font-semibold text-gray-700">ای میل</label>
              <input type="email" v-model="form.email" dir="ltr" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 outline-none transition-colors" />
            </div>

            <div class="space-y-2">
              <label class="block text-sm font-semibold text-gray-700">پتہ (Address)</label>
              <textarea v-model="form.address" rows="4" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 outline-none transition-colors resize-none"></textarea>
            </div>
          </div>
        </div>

        <div v-if="error" class="p-4 bg-red-50 border border-red-200 text-red-600 text-sm rounded-xl font-medium flex items-center">
          <svg class="w-5 h-5 me-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
          {{ error }}
        </div>

        <!-- Footer actions -->
        <div class="flex justify-end pt-6 border-t border-gray-100">
          <button type="submit" :disabled="loading" class="px-8 py-3 bg-gradient-to-r from-indigo-600 to-indigo-700 hover:from-indigo-700 hover:to-indigo-800 text-white font-bold rounded-xl shadow-lg shadow-indigo-500/30 transition-all disabled:opacity-50 flex items-center">
            <span v-if="loading" class="me-2">
              <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
            </span>
            {{ loading ? 'محفوظ ہو رہا ہے...' : 'ترمیم محفوظ کریں' }}
          </button>
        </div>

      </form>
    </div>
  </div>
</template>

<script>
import { ref, onMounted } from 'vue'
import axios from '../axios'

export default {
  name: 'Settings',

  setup() {
    const form = ref({
      name: '',
      logo: null,
      primary_color: '#000000',
      academic_year: '',
      phone: '',
      email: '',
      address: '',
    })

    const previewLogo = ref(null)
    const loading = ref(false)
    const error = ref(null)

    const fetchSettings = async () => {
      try {
        const res = await axios.get('/madrasa-info')
        const data = res.data
        console.log(data);
        form.value = {
          name: data.name || '',
          logo: null,
          primary_color: data.primary_color || '#000000',
          academic_year: data.academic_year || '',
          phone: data.phone || '',
          email: data.email || '',
          address: data.address || '',
        }
        previewLogo.value = data.logo_url || null
      } catch (err) {
        error.value = 'Failed to load settings'
      }
    }

    const handleFileChange = (e) => {
      const file = e.target.files[0]
      form.value.logo = file
      if (file) {
        previewLogo.value = URL.createObjectURL(file)
      }
    }

    const handleSubmit = async () => {
      loading.value = true
      error.value = null

      try {
        const formData = new FormData()
        for (const key in form.value) {
          if (form.value[key] !== null) {
            formData.append(key, form.value[key])
          }
        }

        await axios.post('/madrasa-info', formData, {
          headers: { 'Content-Type': 'multipart/form-data' },
        })

        alert('Settings saved successfully!')
        window.location.reload()

      } catch (err) {
        error.value = err.response?.data?.message || 'Save failed'
      } finally {
        loading.value = false
      }
    }

    onMounted(() => {
      fetchSettings()
    })

    return {
      form,
      previewLogo,
      loading,
      error,
      handleFileChange,
      handleSubmit,
    }
  },
}
</script>

<style scoped>
/* Switched to Tailwind CSS classes */
</style>