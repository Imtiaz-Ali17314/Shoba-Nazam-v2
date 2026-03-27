<template>
  <div class="login-container">
    <h1>Login</h1>

    <form @submit.prevent="handleLogin">
      <div>
        <label>Email</label>
        <input v-model="email" type="email" required />
      </div>

      <div>
        <label>Password</label>
        <input v-model="password" type="password" required />
      </div>

      <button type="submit" :disabled="loading">
        {{ loading ? 'Logging in...' : 'Login' }}
      </button>
    </form>

    <p v-if="error" class="error">{{ error }}</p>
  </div>
</template>

<script>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import axios from '../axios'

export default {
  name: 'Login',

  setup() {
    const router = useRouter()

    const email = ref('')
    const password = ref('')
    const loading = ref(false)
    const error = ref(null)

    const handleLogin = async () => {
      loading.value = true
      error.value = null

      try {
        // 1. CSRF cookie (Sanctum)
        await axios.get('/sanctum/csrf-cookie')

        // 2. Login request
        await axios.post('/login', {
          email: email.value,
          password: password.value,
        })

        // 3. Get user (optional but recommended)
        await axios.get('/user')

        // 4. Redirect to dashboard
        router.push('/dashboard')

      } catch (err) {
        error.value =
          err.response?.data?.message || 'Invalid credentials'
      } finally {
        loading.value = false
      }
    }

    return {
      email,
      password,
      loading,
      error,
      handleLogin,
    }
  },
}
</script>

<style scoped>
.login-container {
  max-width: 400px;
  margin: auto;
}

input {
  width: 100%;
  margin-bottom: 10px;
  padding: 8px;
}

button {
  padding: 10px;
  width: 100%;
}

.error {
  color: red;
}
</style>