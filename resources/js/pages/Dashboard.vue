<template>
  <div class="dashboard">

    <h1>Dashboard</h1>

    <!-- Stats Cards -->
    <div class="cards">
      <div class="card">
        <h3>Total Students</h3>
        <p>{{ stats.total_students }}</p>
      </div>

      <div class="card">
        <h3>Total Records</h3>
        <p>{{ stats.total_records }}</p>
      </div>

      <div class="card">
        <h3>This Month</h3>
        <p>{{ stats.this_month_records }}</p>
      </div>
    </div>

    <!-- Charts -->
    <div class="charts">
      <canvas id="recordsChart"></canvas>
    </div>

    <p v-if="error" class="error">{{ error }}</p>

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
.dashboard {
  padding: 20px;
}

.cards {
  display: flex;
  gap: 15px;
  margin-bottom: 20px;
}

.card {
  flex: 1;
  padding: 15px;
  background: #f5f5f5;
  border-radius: 8px;
  text-align: center;
}

.charts {
  max-width: 600px;
}

.error {
  color: red;
}
</style>