<template>
  <div class="users-page">

    <h1>User Management</h1>

    <!-- Create User Button -->
    <button @click="showCreate = true">+ Add User</button>

    <!-- Users Table -->
    <table>
      <thead>
        <tr>
          <th>Name</th>
          <th>Email</th>
          <th>Roles</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>

      <tbody>
        <tr v-for="user in users.data" :key="user.id">
          <td>{{ user.name }}</td>
          <td>{{ user.email }}</td>
          <td>{{ user.roles.map(r => r.name).join(', ') }}</td>
          <td>{{ user.is_active ? 'Active' : 'Inactive' }}</td>
          <td>
            <button @click="editUser(user)">Edit</button>
            <button @click="toggleStatus(user)">
              {{ user.is_active ? 'Deactivate' : 'Activate' }}
            </button>
          </td>
        </tr>

        <tr v-if="users.data.length === 0">
          <td colspan="5">No users found</td>
        </tr>
      </tbody>
    </table>

    <!-- Pagination -->
    <div class="pagination">
      <button :disabled="!users.prev_page_url" @click="changePage(users.current_page - 1)">
        Prev
      </button>
      <span>Page {{ users.current_page }} / {{ users.last_page }}</span>
      <button :disabled="!users.next_page_url" @click="changePage(users.current_page + 1)">
        Next
      </button>
    </div>

    <!-- Create/Edit User Modal -->
    <div v-if="showCreate" class="modal">
      <div class="modal-content">
        <h2>{{ editMode ? 'Edit User' : 'Add User' }}</h2>

        <form @submit.prevent="handleSubmit">
          <div>
            <label>Name</label>
            <input v-model="form.name" type="text" required />
          </div>

          <div>
            <label>Email</label>
            <input v-model="form.email" type="email" required />
          </div>

          <div v-if="!editMode">
            <label>Password</label>
            <input v-model="form.password" type="password" required />
          </div>

          <div>
            <label>Roles</label>
            <select v-model="form.roles" multiple>
              <option v-for="r in roles" :key="r.id" :value="r.name">{{ r.name }}</option>
            </select>
          </div>

          <button type="submit" :disabled="loading">
            {{ loading ? 'Saving...' : 'Save' }}
          </button>

          <button type="button" @click="closeModal">Cancel</button>

        </form>

        <p v-if="error" class="error">{{ error }}</p>
      </div>
    </div>

  </div>
</template>

<script>
import { ref, onMounted } from 'vue'
import axios from '../axios'

export default {
  name: 'Users',

  setup() {
    const users = ref({ data: [], current_page: 1, last_page: 1 })
    const roles = ref([])

    const showCreate = ref(false)
    const editMode = ref(false)

    const form = ref({
      id: null,
      name: '',
      email: '',
      password: '',
      roles: [],
    })

    const loading = ref(false)
    const error = ref(null)

    const fetchUsers = async (page = 1) => {
      try {
        const res = await axios.get('/users', { params: { page } })
        users.value = res.data
      } catch (err) {
        error.value = 'Failed to load users'
      }
    }

    const fetchRoles = async () => {
      try {
        const res = await axios.get('/roles')
        roles.value = res.data
      } catch (err) {
        error.value = 'Failed to load roles'
      }
    }

    const changePage = (page) => {
      fetchUsers(page)
    }

    const editUser = (user) => {
      editMode.value = true
      form.value = {
        id: user.id,
        name: user.name,
        email: user.email,
        password: '',
        roles: user.roles.map(r => r.name),
      }
      showCreate.value = true
    }

    const toggleStatus = async (user) => {
      try {
        await axios.patch(`/users/${user.id}/toggle-status`)
        fetchUsers(users.value.current_page)
      } catch (err) {
        error.value = 'Status update failed'
      }
    }

    const handleSubmit = async () => {
      loading.value = true
      error.value = null

      try {
        if (editMode.value) {
          await axios.put(`/users/${form.value.id}`, form.value)
        } else {
          await axios.post('/users', form.value)
        }
        closeModal()
        fetchUsers(users.value.current_page)
      } catch (err) {
        error.value = err.response?.data?.message || 'Save failed'
      } finally {
        loading.value = false
      }
    }

    const closeModal = () => {
      showCreate.value = false
      editMode.value = false
      form.value = { id: null, name: '', email: '', password: '', roles: [] }
      error.value = null
    }

    onMounted(() => {
      fetchRoles()
      fetchUsers()
    })

    return {
      users,
      roles,
      showCreate,
      editMode,
      form,
      loading,
      error,
      fetchUsers,
      changePage,
      editUser,
      toggleStatus,
      handleSubmit,
      closeModal,
    }
  },
}
</script>

<style scoped>
.users-page {
  padding: 20px;
}

table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 15px;
}

th, td {
  border: 1px solid #ddd;
  padding: 8px;
}

button {
  padding: 6px 10px;
  margin-right: 5px;
}

.pagination {
  margin-top: 10px;
}

/* Modal */
.modal {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0,0,0,0.5);
  display: flex;
  align-items: center;
  justify-content: center;
}

.modal-content {
  background: white;
  padding: 20px;
  width: 400px;
  border-radius: 6px;
}

input, select {
  width: 100%;
  margin-bottom: 10px;
  padding: 6px;
}

.error {
  color: red;
}
</style>