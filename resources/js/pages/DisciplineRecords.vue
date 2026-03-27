<template>
  <div class="records">

    <h1>Discipline Records</h1>

    <!-- Filters -->
    <div class="filters">
      <input type="date" v-model="filters.date_from" @change="fetchRecords" />
      <input type="date" v-model="filters.date_to" @change="fetchRecords" />

      <select v-model="filters.student_id" @change="fetchRecords">
        <option value="">All Students</option>
        <option v-for="s in students" :key="s.id" :value="s.id">
          {{ s.sname }}
        </option>
      </select>

      <select v-model="filters.incident_type_id" @change="fetchRecords">
        <option value="">All Types</option>
        <option v-for="t in types" :key="t.id" :value="t.id">
          {{ t.name }}
        </option>
      </select>

      <input
        type="text"
        placeholder="Class"
        v-model="filters.class"
        @input="debouncedFetch"
      />

      <button @click="resetFilters">Reset</button>
      <button @click="goToCreate">+ Add Record</button>
    </div>

    <!-- Table -->
    <table>
      <thead>
        <tr>
          <th>Date</th>
          <th>Student</th>
          <th>Class</th>
          <th>Type</th>
          <th>Detail</th>
          <th>Actions</th>
        </tr>
      </thead>

      <tbody>
        <tr v-for="record in records.data" :key="record.id">
          <td>{{ record.date }}</td>
          <td>{{ record.student?.sname }}</td>
          <td>{{ record.student?.class }}</td>
          <td>{{ record.incident_type?.name }}</td>
          <td>{{ record.detail }}</td>
          <td>
            <button @click="editRecord(record.id)">Edit</button>
            <button @click="deleteRecord(record.id)">Delete</button>
          </td>
        </tr>

        <tr v-if="records.data.length === 0">
          <td colspan="6">No records found</td>
        </tr>
      </tbody>
    </table>

    <!-- Pagination -->
    <div class="pagination">
      <button :disabled="!records.prev_page_url" @click="changePage(records.current_page - 1)">
        Prev
      </button>

      <span>Page {{ records.current_page }} / {{ records.last_page }}</span>

      <button :disabled="!records.next_page_url" @click="changePage(records.current_page + 1)">
        Next
      </button>
    </div>

    <p v-if="error" class="error">{{ error }}</p>

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
          axios.get('/students?per_page=1000'),
          axios.get('/incident-types'),
        ])

        students.value = studentsRes.data.data
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
.records {
  padding: 20px;
}

.filters {
  display: flex;
  flex-wrap: wrap;
  gap: 10px;
  margin-bottom: 15px;
}

input, select {
  padding: 6px;
}

table {
  width: 100%;
  border-collapse: collapse;
}

th, td {
  padding: 10px;
  border: 1px solid #ddd;
}

.pagination {
  margin-top: 15px;
}

.error {
  color: red;
}
</style>