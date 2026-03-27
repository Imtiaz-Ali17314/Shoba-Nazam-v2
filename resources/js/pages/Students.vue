<template>
  <div class="students">

    <h1>Students</h1>

    <!-- Search + Add -->
    <div class="top-bar">
      <input
        v-model="search"
        @input="debouncedSearch"
        type="text"
        placeholder="Search by name or code..."
      />

      <button @click="goToCreate">+ Add Student</button>
    </div>

    <!-- Table -->
    <table>
      <thead>
        <tr>
          <th>Name</th>
          <th>Father Name</th>
          <th>Code</th>
          <th>Class</th>
          <th>Actions</th>
        </tr>
      </thead>

      <tbody>
        <tr v-for="student in students.data" :key="student.id">
          <td>{{ student.sname }}</td>
          <td>{{ student.fathername }}</td>
          <td>{{ student.code }}</td>
          <td>{{ student.class }}</td>
          <td>
            <button @click="editStudent(student.id)">Edit</button>
            <button @click="deleteStudent(student.id)">Delete</button>
          </td>
        </tr>

        <tr v-if="students.data.length === 0">
          <td colspan="5">No students found</td>
        </tr>
      </tbody>
    </table>

    <!-- Pagination -->
    <div class="pagination">
      <button :disabled="!students.prev_page_url" @click="changePage(students.current_page - 1)">
        Prev
      </button>

      <span>Page {{ students.current_page }} of {{ students.last_page }}</span>

      <button :disabled="!students.next_page_url" @click="changePage(students.current_page + 1)">
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
.students {
  padding: 20px;
}

.top-bar {
  display: flex;
  justify-content: space-between;
  margin-bottom: 15px;
}

input {
  padding: 8px;
  width: 250px;
}

button {
  padding: 6px 10px;
  margin-left: 5px;
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