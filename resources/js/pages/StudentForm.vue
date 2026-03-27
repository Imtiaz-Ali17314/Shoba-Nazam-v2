<template>
  <div class="student-form">

    <h1>{{ isEdit ? 'Edit Student' : 'Add Student' }}</h1>

    <form @submit.prevent="handleSubmit">

      <div>
        <label>Name</label>
        <input v-model="form.sname" type="text" required />
      </div>

      <div>
        <label>Father Name</label>
        <input v-model="form.fathername" type="text" required />
      </div>

      <div>
        <label>Code</label>
        <input v-model="form.code" type="text" required />
      </div>

      <div>
        <label>Class</label>
        <input v-model="form.class" type="text" required />
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
  name: 'StudentForm',

  setup() {
    const route = useRoute()
    const router = useRouter()

    const loading = ref(false)
    const error = ref(null)

    const form = ref({
      sname: '',
      fathername: '',
      code: '',
      class: '',
    })

    const isEdit = computed(() => !!route.params.id)

    // Fetch student for edit
    const fetchStudent = async () => {
      try {
        const res = await axios.get(`/students/${route.params.id}`)
        form.value = res.data
      } catch (err) {
        error.value = 'Failed to load student'
      }
    }

    const handleSubmit = async () => {
      loading.value = true
      error.value = null

      try {
        if (isEdit.value) {
          await axios.put(`/students/${route.params.id}`, form.value)
        } else {
          await axios.post('/students', form.value)
        }

        router.push('/students')

      } catch (err) {
        error.value =
          err.response?.data?.message || 'Save failed'
      } finally {
        loading.value = false
      }
    }

    const goBack = () => {
      router.push('/students')
    }

    onMounted(() => {
      if (isEdit.value) {
        fetchStudent()
      }
    })

    return {
      form,
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
.student-form {
  max-width: 500px;
  margin: auto;
}

input {
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