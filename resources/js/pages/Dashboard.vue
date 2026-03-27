<template>
  <div class="space-y-6">
    <div class="flex items-center justify-between mb-8">
      <div>
        <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">ڈیش بورڈ</h1>
        <p class="text-sm text-gray-500 mt-1 font-medium">مدرسے کے اعداد و شمار کا تفصیلی جائزہ</p>
      </div>
      <button @click="fetchDashboard" class="p-2 bg-white text-gray-500 hover:text-indigo-600 rounded-xl shadow-sm border border-gray-100 transition-colors">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
      </button>
    </div>

    <!-- Stats Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      
      <!-- Card 1 -->
      <div class="bg-white rounded-2xl p-6 shadow-xl shadow-gray-200/40 border border-gray-100 flex flex-col relative overflow-hidden group">
        <div class="absolute top-0 right-0 w-32 h-32 bg-indigo-50 rounded-bl-full -mr-8 -mt-8 transition-transform group-hover:scale-110"></div>
        <div class="relative z-10">
          <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-bold text-gray-700">کل طلباء</h3>
            <div class="w-12 h-12 bg-indigo-100 text-indigo-600 rounded-xl flex items-center justify-center">
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            </div>
          </div>
          <p class="text-4xl font-black text-gray-900">{{ stats.total_students || 0 }}</p>
        </div>
      </div>

      <!-- Card 2 -->
      <div class="bg-white rounded-2xl p-6 shadow-xl shadow-gray-200/40 border border-gray-100 flex flex-col relative overflow-hidden group">
        <div class="absolute top-0 right-0 w-32 h-32 bg-purple-50 rounded-bl-full -mr-8 -mt-8 transition-transform group-hover:scale-110"></div>
        <div class="relative z-10">
          <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-bold text-gray-700">کل ریکارڈز</h3>
            <div class="w-12 h-12 bg-purple-100 text-purple-600 rounded-xl flex items-center justify-center">
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            </div>
          </div>
          <p class="text-4xl font-black text-gray-900">{{ stats.total_records || 0 }}</p>
        </div>
      </div>

      <!-- Card 3 -->
      <div class="bg-white rounded-2xl p-6 shadow-xl shadow-gray-200/40 border border-gray-100 flex flex-col relative overflow-hidden group">
        <div class="absolute top-0 right-0 w-32 h-32 bg-rose-50 rounded-bl-full -mr-8 -mt-8 transition-transform group-hover:scale-110"></div>
        <div class="relative z-10">
          <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-bold text-gray-700">اس ماہ کی کارروائیاں</h3>
            <div class="w-12 h-12 bg-rose-100 text-rose-600 rounded-xl flex items-center justify-center">
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            </div>
          </div>
          <p class="text-4xl font-black text-gray-900">{{ stats.this_month_records || 0 }}</p>
        </div>
      </div>

    </div>

    <!-- Charts Area -->
    <div class="bg-white rounded-2xl p-6 shadow-xl shadow-gray-200/40 border border-gray-100 mt-6">
      <h3 class="text-xl font-bold text-gray-800 mb-6">ماہانہ ڈسپلن ریکارڈز</h3>
      <div class="relative w-full h-[400px]">
        <canvas id="recordsChart"></canvas>
      </div>
    </div>

    <div v-if="error" class="mt-4 p-4 bg-red-50 border border-red-200 text-red-600 text-sm rounded-xl font-medium flex items-center">
      <svg class="w-5 h-5 me-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
      {{ error }}
    </div>

  </div>
</template>

<script>
import { ref, onMounted } from 'vue'
import axios from '../axios'
import Chart from 'chart.js/auto'

export default {
  name: 'Dashboard',

  setup() {
    const stats = ref({
      total_students: 0,
      total_records: 0,
      this_month_records: 0,
      monthly_records: [],
    })

    const error = ref(null)
    let chartInstance = null

    const fetchDashboard = async () => {
      try {
        const res = await axios.get('/dashboard')

        stats.value = res.data

        renderChart()

      } catch (err) {
        error.value = 'Failed to load dashboard'
      }
    }

    const renderChart = () => {
      const ctx = document.getElementById('recordsChart')

      if (chartInstance) {
        chartInstance.destroy()
      }

      chartInstance = new Chart(ctx, {
        type: 'bar',
        data: {
          labels: stats.value.monthly_records.map(item => item.month),
          datasets: [
            {
              label: 'Records',
              data: stats.value.monthly_records.map(item => item.count),
            },
          ],
        },
      })
    }

    onMounted(() => {
      fetchDashboard()
    })

    return {
      stats,
      error,
    }
  },
}
</script>

<style scoped>
/* Scoped css removed in favor of tailwind classes */
</style>