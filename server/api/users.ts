import { useRuntimeConfig } from '#app'

interface UserData {
  id?: number
  name: string
  email: string
  password?: string
  role: string
}

interface UpdateUserData {
  name?: string
  email?: string
  password?: string
  role?: string
}

export const useUserApi = () => {
  const config = useRuntimeConfig()
  const baseURL = config.public.apiBase

  const getAuthHeaders = () => {
    if (process.client) {
      const token = localStorage.getItem('token')
      return token ? { 'Authorization': `Bearer ${token}` } : {}
    }
    return {}
  }

  return {
    async login(credentials: { email: string; password: string }) {
      return await $fetch('/api/auth/login.php', {
        baseURL,
        method: 'POST',
        body: credentials
      })
    },

    async register(userData: UserData) {
      return await $fetch('/api/auth/register.php', {
        baseURL,
        method: 'POST',
        body: userData
      })
    },

    async getCurrentUser() {
      if (!process.client) return null
      
      const headers = getAuthHeaders()
      if (!headers.Authorization) return null

      try {
        const response = await $fetch('/api/auth/me.php', {
          baseURL,
          headers,
          credentials: 'include'
        })
        
        return response?.id ? response : null
      } catch (error) {
        console.error('Error fetching current user:', error)
        if (process.client) localStorage.removeItem('token')
        return null
      }
    },

    async getAllUsers() {
      return await $fetch('/api/users.php', {
        baseURL,
        headers: getAuthHeaders()
      })
    },

    async getUser(id: number) {
      return await $fetch(`/api/users.php?id=${id}`, {
        baseURL,
        headers: getAuthHeaders()
      })
    },

    async createUser(userData: UserData) {
      return await $fetch('/api/users.php', {
        baseURL,
        method: 'POST',
        body: userData,
        headers: getAuthHeaders()
      })
    },

    async updateUser(userId: number, userData: UpdateUserData) {
      return await $fetch(`/api/users.php?id=${userId}`, {
        baseURL,
        method: 'PUT',
        body: userData,
        headers: getAuthHeaders()
      })
    },

    async deleteUser(userId: number) {
      return await $fetch(`/api/users.php?id=${userId}`, {
        baseURL,
        method: 'DELETE',
        headers: getAuthHeaders()
      })
    },

    async updateProfile(userData: UpdateUserData) {
      return await $fetch('/api/users/profile.php', {
        baseURL,
        method: 'PUT',
        body: userData,
        headers: getAuthHeaders()
      })
    }
  }
} 