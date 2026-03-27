<template>
  <div class="discipline-form">

    <h1>{{ isEdit ? 'Edit Discipline Record' : 'Add Discipline Record' }}</h1>

    <form @submit.prevent="handleSubmit">

      <div>
        <label>Student</label>
        <select v-model="form.student_id" required>
          <option value="">Select Student</option>
          <option v-for="s in students" :key="s.id" :value="s.id">
            {{ s.sname }} ({{ s.class }})
          </option>
        </select>
      </div>

      <div>
        <label>Class</label>
        <input v-model="form.class" type="text" required />
      </div>

      <div>
        <label>Incident Type</label>
        <select v-model="form.incident_type_id" required>
          <option value="">Select Type</option>
          <option v-for="t in types" :key="t.id" :value="t.id">
            {{ t.name }}
          </option>
        </select>
      </div>

      <div>
        <label>Date</label>
        <input v-model="form.date" type="date" required />
      </div>

      <div>
        <label>Detail</label>
        <textarea v-model="form.detail" rows="4" placeholder="Details..."></textarea>
      </div>

      <button type="submit" :disabled="loading">
        {{ loading ? 'Saving...' : 'Save' }}
      </button>

      <button type="button" @click="goBack">Cancel</button>

    </form>

    <p v-if="error" class="error">{{ error }}</p>

  </div>
</template>

<script>
import { ref, onMounted, computed } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import axios from '../axios'

export default {
  name: 'DisciplineForm',

  setup() {
    const route = useRoute()
    const router = useRouter()

    const loading = ref(false)
    const error = ref(null)

    const form = ref({
      student_id: '',
      class: '',
      incident_type_id: '',
      date: '',
      detail: '',
    })

    const students = ref([])
    const types = ref([])

    const isEdit = computed(() => !!route.params.id)

    // Fetch meta data (students + incident types)
    const fetchMeta = async () => {
      try {
        const [studentsRes, typesRes] = await Promise.all([
          axios.get('/students?per_page=1000'),
          axios.get('/incident-types'),
        ])
        students.value = studentsRes.data.data
        types.value = typesRes.data
      } catch (err) {
        error.value = 'Failed to load students or incident types'
      }
    }

    // Fetch record for edit
    const fetchRecord = async () => {
      try {
        const res = await axios.get(`/discipline-records/${route.params.id}`)
        form.value = res.data
      } catch (err) {
        error.value = 'Failed to load record'
      }
    }

    const handleSubmit = async () => {
      loading.value = true
      error.value = null

      try {
        if (isEdit.value) {
          await axios.put(`/discipline-records/${route.params.id}`, form.value)
        } else {
          await axios.post('/discipline-records', form.value)
        }

        router.push('/discipline')

      } catch (err) {
        error.value = err.response?.data?.message || 'Save failed'
      } finally {
        loading.value = false
      }
    }

    const goBack = () => {
      router.push('/discipline')
    }

    onMounted(() => {
      fetchMeta()
      if (isEdit.value) fetchRecord()
    })

    return {
      form,
      students,
      types,
      loading,
      error,
      isEdit,
      handleSubmit,
      goBack,
    }
  },
}
</script>

<style scoped>
.discipline-form {
  max-width: 600px;
  margin: auto;
}

input, select, textarea {
  width: 100%;
  margin-bottom: 10px;
  padding: 8px;
}

button {
  padding: 8px 12px;
  margin-right: 5px;
}

.error {
  color: red;
}
</style>