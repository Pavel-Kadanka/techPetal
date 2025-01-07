<template>
  <v-container>
    <v-row v-if="!showProfile" justify="center">
      <v-col cols="12" sm="8" md="6">
        <v-card>
          <v-tabs v-model="tab">
            <v-tab value="login">Login</v-tab>
            <v-tab value="register">Register</v-tab>
          </v-tabs>

          <v-card-text>
            <v-window v-model="tab">
              <!-- Login Form -->
              <v-window-item value="login">
                <v-form @submit.prevent="handleLogin">
                  <v-text-field v-model="loginForm.email" label="Email" type="email" required></v-text-field>
                  <v-text-field v-model="loginForm.password" label="Password" type="password" required></v-text-field>
                  <v-btn color="primary" type="submit" block class="mt-4">
                    Login
                  </v-btn>
                </v-form>
              </v-window-item>

              <!-- Register Form -->
              <v-window-item value="register">
                <v-form @submit.prevent="handleRegister">
                  <v-text-field v-model="registerForm.name" label="Full Name" required></v-text-field>
                  <v-text-field v-model="registerForm.email" label="Email" type="email" :rules="emailRules" required></v-text-field>
                  <v-text-field v-model="registerForm.password" label="Password" type="password"
                    required :rules="passwordRules"></v-text-field>
                  <v-btn color="primary" type="submit" block class="mt-4">
                    Register
                  </v-btn>
                </v-form>
              </v-window-item>
            </v-window>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>

    <!-- User Profile View -->
    <v-row v-else-if="userData">
      <!-- Admin View -->
      <template v-if="userData.role === 'admin'">
        <v-col cols="12">
          <h2 class="text-h4 mb-6">Admin Dashboard</h2>
          
          <!-- User Management Card -->
          <v-card class="mb-6" elevation="2">
            <v-card-title class="d-flex justify-space-between align-center bg-primary pa-4">
              <span class="text-white">User Management</span>
              <v-btn variant="outlined" color="white" @click="showCreateDialog = true">Add user</v-btn>
            </v-card-title>
            
            <v-card-text class="pa-4">
              <!-- Search and Filter -->
              <v-row class="mb-4">
                <v-col cols="12" sm="4">
                  <v-text-field
                    v-model="searchQuery"
                    label="Search users"
                    prepend-inner-icon="mdi-magnify"
                    density="comfortable"
                    hide-details
                    clearable
                  ></v-text-field>
                </v-col>
                <v-col cols="12" sm="4">
                  <v-select
                    v-model="roleFilter"
                    :items="['All', ...roles]"
                    label="Filter by role"
                    density="comfortable"
                    hide-details
                  ></v-select>
                </v-col>
              </v-row>

              <!-- Users Table -->
              <v-data-table
                :headers="headers"
                :items="filteredUsers"
                :search="searchQuery"
                class="elevation-1"
              >
                <template v-slot:item.actions="{ item }">
                  <v-btn
                    icon="mdi-pencil"
                    size="small"
                    color="primary"
                    class="mr-2"
                    @click="editUser(item)"
                  ></v-btn>
                  <v-btn
                    icon="mdi-delete"
                    size="small"
                    color="error"
                    @click="confirmDelete(item)"
                  ></v-btn>
                </template>
              </v-data-table>
            </v-card-text>
          </v-card>

          <!-- Create/Edit User Dialog -->
          <v-dialog v-model="showEditDialog" max-width="500px">
            <v-card>
              <v-card-title>{{ editedUser.id ? 'Edit User' : 'Create User' }}</v-card-title>
              <v-card-text>
                <v-form ref="userForm">
                  <v-text-field v-model="editedUser.name" label="Name" required></v-text-field>
                  <v-text-field v-model="editedUser.email" label="Email" type="email" required></v-text-field>
                  <v-text-field 
                    v-if="!editedUser.id"
                    v-model="editedUser.password" 
                    label="Password" 
                    type="password"
                    required
                  ></v-text-field>
                  <v-select
                    v-model="editedUser.role"
                    :items="roles"
                    label="Role"
                    required
                  ></v-select>
                </v-form>
              </v-card-text>
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="error" @click="showEditDialog = false">Cancel</v-btn>
                <v-btn color="primary" @click="saveUser">Save</v-btn>
              </v-card-actions>
            </v-card>
          </v-dialog>

          <v-dialog v-model="showCreateDialog" max-width="500px">
            <v-card>
              <v-card-title>{{ creatededUser.id ? 'Edit User' : 'Create User' }}</v-card-title>
              <v-card-text>
                <v-form ref="userForm">
                  <v-text-field v-model="creatededUser.name" label="Name" required></v-text-field>
                  <v-text-field v-model="creatededUser.email" label="Email" type="email" required></v-text-field>
                  <v-text-field 
                    v-if="!creatededUser.id"
                    v-model="creatededUser.password" 
                    label="Password" 
                    type="password"
                    required
                  ></v-text-field>
                  <v-select
                    v-model="creatededUser.role"
                    :items="roles"
                    label="Role"
                    required
                  ></v-select>
                </v-form>
              </v-card-text>
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="error" @click="showCreateDialog = false">Cancel</v-btn>
                  <v-btn color="primary" @click="saveUser">Save</v-btn>
              </v-card-actions>
            </v-card>
          </v-dialog>

          <!-- Delete Confirmation Dialog -->
          <v-dialog v-model="showDeleteDialog" max-width="400px">
            <v-card>
              <v-card-title>Confirm Delete</v-card-title>
              <v-card-text>
                Are you sure you want to delete this user?
              </v-card-text>
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="error" @click="deleteUser(userToDelete)">Delete</v-btn>
                <v-btn @click="showDeleteDialog = false">Cancel</v-btn>
              </v-card-actions>
            </v-card>
          </v-dialog>
        </v-col>
      </template>

      <!-- Regular User View -->
      <template v-else>
        <v-col cols="12">
          <h2 class="text-h4 mb-6">My Profile</h2>
          <v-row>
            <v-col cols="12" md="8">
              <v-card elevation="2">
                <v-card-title class="bg-primary text-white pa-4">
                  Profile Information
                </v-card-title>
                <v-card-text class="pa-4">
                  <v-form ref="profileForm">
                    <v-row>
                      <v-col cols="12" md="6">
                        <v-text-field v-if="!editedProfile.name"
                          v-model="userData.name"
                          label="Name"
                          :readonly="!isEditing"
                          :rules="[v => !!v || 'Name is required']"
                          variant="outlined"
                          prepend-inner-icon="mdi-account"
                        ></v-text-field>
                        <v-text-field v-else
                          v-model="userData.name"
                          label="Name"
                          :readonly="!isEditing"
                          :rules="[v => !!v || 'Name is required']"
                          variant="outlined"
                          prepend-inner-icon="mdi-account"
                        ></v-text-field>
                      </v-col>
                      <v-col cols="12" md="6">
                        <v-text-field v-if="!editedProfile.email"
                          v-model="userData.email"
                          label="Email"
                          type="email"
                          readonly
                          variant="outlined"
                          prepend-inner-icon="mdi-email"
                        ></v-text-field>
                        <v-text-field v-else
                          v-model="editedProfile.email"
                          label="Email"
                          type="email"
                          readonly
                          variant="outlined"
                          prepend-inner-icon="mdi-email"
                        ></v-text-field>
                      </v-col>
                    </v-row>
                  </v-form>
                </v-card-text>
                <v-card-actions class="pa-4">
                  
                </v-card-actions>
              </v-card>
            </v-col>
            
            <!-- Activity Card -->
            <v-col cols="12" md="4">
              <v-card elevation="2">
                <v-card-title class="bg-primary text-white pa-4">
                  Account Information
                </v-card-title>
                <v-card-text class="pa-4">
                  <v-list>
                    <v-list-item>
                      <template v-slot:prepend>
                        <v-icon color="primary">mdi-shield-account</v-icon>
                      </template>
                      <v-list-item-title>Role</v-list-item-title>
                      <v-list-item-subtitle>{{ userData.role }}</v-list-item-subtitle>
                    </v-list-item>
                    <v-list-item>
                      <template v-slot:prepend>
                        <v-icon color="primary">mdi-calendar</v-icon>
                      </template>
                      <v-list-item-title>Member Since</v-list-item-title>
                      <v-list-item-subtitle>{{ userData.created }}</v-list-item-subtitle>
                    </v-list-item>
                  </v-list>
                </v-card-text>
              </v-card>
            </v-col>
          </v-row>
        </v-col>
      </template>
    </v-row>
  </v-container>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue'
import { useRouter } from 'vue-router'
import { useApi } from '~/composables/useApi'

const router = useRouter()
const api = useApi()
const tab = ref('login')

const loginForm = ref({
  email: '',
  password: ''
})

const registerForm = ref({
  name: '',
  email: '',
  password: '',
  role: ''
})

const roles = ['user', 'admin', 'moderator']

// Add new refs for user data display
const showProfile = ref(false)
const userData = ref(null)
const { fetchUser } = useApi()

const showEditDialog = ref(false)
const showCreateDialog = ref(false)
const showDeleteDialog = ref(false)
const allUsers = ref([])
const creatededUser = ref({
  id: null,
  name: '',
  email: '',
  password: '',
  role: 'user'
})
const editedUser = ref({
  id: null,
  name: '',
  email: '',
  password: '',
  role: 'user'
})
let userToDelete = null
const isEditing = ref(false)
const editedProfile = ref({
  name: '',
  email: '',
  newPassword: ''
})

const searchQuery = ref('')
const roleFilter = ref('All')
const headers = [
  { title: 'Name', key: 'name' },
  { title: 'Email', key: 'email' },
  { title: 'Role', key: 'role' },
  { title: 'Status', key: 'status' },
  { title: 'Actions', key: 'actions', sortable: false }
]

const passwordRules = [
  v => !v || v.length >= 8 || 'Password must be at least 8 characters',
  v => !v || /\d/.test(v) || 'Password must contain at least one number',
  v => !v || /[A-Z]/.test(v) || 'Password must contain at least one uppercase letter'
]
const emailRules = [
  v => !!v || 'Email is required',
  v => /.+@.+\..+/.test(v) || 'Email must be valid'
]

const filteredUsers = computed(() => {
  let users = [...allUsers.value]
  if (roleFilter.value !== 'All') {
    users = users.filter(user => user.role === roleFilter.value)
  }
  return users
})

const handleLogin = async () => {
  try {
    const data = await api.login(loginForm.value)
    if (data.user) {
      localStorage.setItem('token', data.token)
      localStorage.setItem('userData', JSON.stringify(data.user))
      userData.value = await api.getCurrentUser()
      showProfile.value = true
      location.reload();
    }
  } catch (error) {
    console.error('Login error:', error)
  }
}

const handleRegister = async () => {
  try {
    const data = await api.register(registerForm.value)
    if (data.user) {
      localStorage.setItem('token', data.token)
      localStorage.setItem('userData', JSON.stringify(data.user))
      userData.value = data.user
      showProfile.value = true
      location.reload();
    }
  } catch (error) {
    console.error('Registration error:', error)
  }
}

// Add function to check auth state
const checkAuthState = async () => {
  const token = localStorage.getItem('token')
  const storedUserData = localStorage.getItem('userData')
  
  console.log('Checking auth state:', { token: !!token, storedUserData: !!storedUserData })
  
  if (token && storedUserData) {
    try {
      // First set the stored data to provide immediate feedback
      userData.value = JSON.parse(storedUserData)
      showProfile.value = true
      console.log('Set initial user data:', userData.value)
      
      // Then verify and update with fresh data from the server
      const user = await api.getCurrentUser()
      console.log('Server response for current user:', user)
      
      if (user) {
        userData.value = user
        localStorage.setItem('userData', JSON.stringify(user))
        console.log('Updated user data:', userData.value)
      } else {
        console.log('No user data from server, clearing state')
        localStorage.removeItem('token')
        localStorage.removeItem('userData')
        showProfile.value = false
        userData.value = null
      }
    } catch (error) {
      console.error('Error in checkAuthState:', error)
      localStorage.removeItem('token')
      localStorage.removeItem('userData')
      showProfile.value = false
      userData.value = null
    }
  } else {
    console.log('No stored credentials found')
    showProfile.value = false
    userData.value = null
  }
}

// Move checkAuthState call to the top level of the script
checkAuthState()

// Admin functions
const fetchAllUsers = async () => {
  try {
    allUsers.value = await api.fetchUsers()
  } catch (error) {
    console.error('Error fetching users:', error)
  }
}

const editUser = (user) => {
  editedUser.value = { ...user }; // Create a copy of the user object
  showEditDialog.value = true;
}

const confirmDelete = (user) => {
  userToDelete = user;
  showDeleteDialog.value = true;
}

const saveUser = async () => {
  try {
    if (editedUser.value.id) {
      // Update existing user
      const updateData = {
        id: editedUser.value.id,
        name: editedUser.value.name,
        email: editedUser.value.email,
        role: editedUser.value.role
      }
      await api.updateUser(editedUser.value.id, updateData)
    } else {
      // Create new user
      const createData = {
        name: creatededUser.value.name,
        email: creatededUser.value.email,
        password: creatededUser.value.password,
        role: creatededUser.value.role
      }
      await api.createUser(createData)
    }
    showEditDialog.value = false
    showCreateDialog.value = false
    await fetchAllUsers()
    // Reset the editedUser
    editedUser = {
      id: null,
      name: '',
      email: '',
      password: '',
      role: 'user'
    }
    creatededUser.value = {
      id: null,
      name: '',
      email: '',
      password: '',
      role: 'user'
    }
  } catch (error) {
    console.error('Error saving user:', error)
  }
}

const deleteUser = async (user) => {
  try {
    // Make sure we're using the correct ID property
    const userId = user._id || user.id; // Handle both possible ID formats
    await api.deleteUser(userId);
    showDeleteDialog.value = false;
    await fetchAllUsers(); // Refresh the list
    userToDelete = null; // Reset the userToDelete
  } catch (error) {
    console.error('Error deleting user:', error);
  }
}

// Call fetchAllUsers when admin view is mounted
if (userData.value?.role === 'admin') {
  fetchAllUsers()
}

onMounted(() => {
  console.log('Component mounted') // Debug log
})
</script>
<script>
export default {
  name: 'Account',
  data() {
    return {
      showProfile: false,
      userData: null,
    }
  }
}
</script>

<style></style>