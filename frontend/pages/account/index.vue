<template>
  <v-container>
    <v-row justify="center">
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
                  <v-text-field
                    v-model="loginForm.email"
                    label="Email"
                    type="email"
                    required
                  ></v-text-field>
                  <v-text-field
                    v-model="loginForm.password"
                    label="Password"
                    type="password"
                    required
                  ></v-text-field>
                  <v-btn color="primary" type="submit" block class="mt-4">
                    Login
                  </v-btn>
                  <v-btn
                    color="error"
                    block
                    class="mt-4"
                    @click="handleGoogleLogin"
                  >
                    <v-icon start>mdi-google</v-icon>
                    Login with Google
                  </v-btn>
                </v-form>
              </v-window-item>

              <!-- Register Form -->
              <v-window-item value="register">
                <v-form @submit.prevent="handleRegister">
                  <v-text-field
                    v-model="registerForm.name"
                    label="Full Name"
                    required
                  ></v-text-field>
                  <v-text-field
                    v-model="registerForm.email"
                    label="Email"
                    type="email"
                    required
                  ></v-text-field>
                  <v-text-field
                    v-model="registerForm.password"
                    label="Password"
                    type="password"
                    required
                  ></v-text-field>
                  <v-select
                    v-model="registerForm.role"
                    :items="roles"
                    label="Role"
                    required
                  ></v-select>
                  <v-btn color="primary" type="submit" block class="mt-4">
                    Register
                  </v-btn>
                  <v-btn
                    color="error"
                    block
                    class="mt-4"
                    @click="handleGoogleLogin"
                  >
                    <v-icon start>mdi-google</v-icon>
                    Sign up with Google
                  </v-btn>
                </v-form>
              </v-window-item>
            </v-window>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script setup>
import { ref } from 'vue'
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

const handleLogin = async () => {
  try {
    const data = await api.login(loginForm.value)
    if (data.user) {
      // Store user data in state management if needed
      router.push(`/account/${data.user.id}`)
    }
  } catch (error) {
    console.error('Login error:', error)
  }
}

const handleRegister = async () => {
  try {
    const data = await api.register(registerForm.value)
    if (data.user) {
      // Store user data in state management if needed
      router.push(`/account/${data.user.id}`)
    }
  } catch (error) {
    console.error('Registration error:', error)
  }
}

const handleGoogleLogin = async () => {
  // Implement Google OAuth login
  window.location.href = `${config.public.apiBase}/api/auth/google`
}
</script>

<style>

</style>