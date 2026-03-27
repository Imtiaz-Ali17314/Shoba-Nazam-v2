<template>
  <div class="settings-page">

    <h1>Madrasa Settings</h1>

    <form @submit.prevent="handleSubmit">

      <div>
        <label>Madrasa Name</label>
        <input v-model="form.name" type="text" required />
      </div>

      <div>
        <label>Logo</label>
        <input type="file" @change="handleFileChange" accept="image/*" />
        <div v-if="previewLogo">
          <img :src="previewLogo" alt="Logo Preview" class="logo-preview" />
        </div>
      </div>

      <div>
        <label>Primary Color</label>
        <input type="color" v-model="form.primary_color" />
      </div>

      <div>
        <label>Academic Year</label>
        <input type="text" v-model="form.academic_year" placeholder="2025-2026" required />
      </div>

      <div>
        <label>Phone</label>
        <input type="text" v-model="form.phone" />
      </div>

      <div>
        <label>Email</label>
        <input type="email" v-model="form.email" />
      </div>

      <div>
        <label>Address</label>
        <textarea v-model="form.address" rows="3"></textarea>
      </div>

      <button type="submit" :disabled="loading">
        {{ loading ? 'Saving...' : 'Save Settings' }}
      </button>

      <p v-if="error" class="error">{{ error }}</p>

    </form>

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
        const res = await axios.get('/madrasa')
        const data = res.data
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

        await axios.post('/madrasa', formData, {
          headers: { 'Content-Type': 'multipart/form-data' },
        })

        alert('Settings saved successfully!')

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
.settings-page {
  max-width: 600px;
  margin: auto;
  padding: 20px;
}

input, textarea {
  width: 100%;
  margin-bottom: 10px;
  padding: 6px;
}

.logo-preview {
  max-width: 150px;
  margin-top: 10px;
}

button {
  padding: 8px 12px;
}

.error {
  color: red;
  margin-top: 10px;
}
</style>