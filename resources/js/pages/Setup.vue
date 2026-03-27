<template>
  <div class="setup-container">
    <h1>Setup Madrasa</h1>

    <form @submit.prevent="handleSubmit">
      <!-- Madrasa Info -->
      <div>
        <label>Madrasa Name</label>
        <input v-model="form.name" type="text" required />
      </div>

      <div>
        <label>Logo</label>
        <input type="file" @change="handleFile" />
      </div>

      <div>
        <label>Email</label>
        <input v-model="form.email" type="email" />
      </div>

      <div>
        <label>Phone</label>
        <input v-model="form.phone" type="text" />
      </div>

      <!-- Admin Info -->
      <h2>Admin User</h2>

      <div>
        <label>Name</label>
        <input v-model="form.admin_name" type="text" required />
      </div>

      <div>
        <label>Email</label>
        <input v-model="form.admin_email" type="email" required />
      </div>

      <div>
        <label>Password</label>
        <input v-model="form.password" type="password" required />
      </div>

      <button type="submit" :disabled="loading">
        {{ loading ? 'Setting up...' : 'Setup' }}
      </button>
    </form>

    <p v-if="error" class="error">{{ error }}</p>
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
.setup-container {
  max-width: 500px;
  margin: auto;
}

input {
  width: 100%;
  margin-bottom: 10px;
  padding: 8px;
}

button {
  padding: 10px;
}

.error {
  color: red;
}
</style>