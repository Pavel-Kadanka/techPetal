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

export const useApi = () => {
  const config = useRuntimeConfig()
  
  const fetchPosts = async (category?: string) => {
    try {
      const url = category 
        ? `/api/posts.php?category=${category}`
        : '/api/posts.php'
      
      return await $fetch(url, {
        baseURL: config.public.apiBase
      })
    } catch (error) {
      console.error('Error fetching posts:', error)
      throw error
    }
  }

  const fetchPost = async (id: number) => {
    try {
      return await $fetch(`/api/posts.php?id=${id}`, {
        baseURL: config.public.apiBase
      })
    } catch (error) {
      console.error('Error fetching post:', error)
      throw error
    }
  }

  const fetchUsers = async () => {
    try {
      return await $fetch('/api/users.php', {
        baseURL: config.public.apiBase
      })
    } catch (error) {
      console.error('Error fetching users:', error)
      throw error
    }
  }

  const login = async (credentials: { email: string; password: string }) => {
    try {
      return await $fetch('/api/auth/login.php', {
        baseURL: config.public.apiBase,
        method: 'POST',
        body: credentials
      })
    } catch (error) {
      console.error('Login error:', error)
      throw error
    }
  }

  const register = async (userData: { 
    name: string; 
    email: string; 
    password: string; 
    role: string 
  }) => {
    try {
      return await $fetch('/api/auth/register.php', {
        baseURL: config.public.apiBase,
        method: 'POST',
        body: userData
      })
    } catch (error) {
      console.error('Registration error:', error)
      throw error
    }
  }

  const fetchUser = async (id: number) => {
    try {
      return await $fetch(`/api/users.php?id=${id}`, {
        baseURL: config.public.apiBase
      })
    } catch (error) {
      console.error('Error fetching user:', error)
      throw error
    }
  }

  const getCurrentUser = async () => {
    try {
      if (!process.client) {
        console.log('Not running on client, skipping getCurrentUser')
        return null
      }
      
      const token = localStorage.getItem('token')
      if (!token) {
        console.log('No token found in localStorage')
        return null
      }

      console.log('Fetching current user with token:', token.substring(0, 10) + '...')

      const response = await $fetch('/api/auth/me.php', {
        baseURL: config.public.apiBase,
        headers: {
          'Authorization': `Bearer ${token}`
        },
        credentials: 'include'
      })

      console.log('getCurrentUser response:', response)
      
      if (!response || !response.id) {
        console.log('Invalid response from server')
        localStorage.removeItem('token')
        return null
      }

      return response
    } catch (error) {
      console.error('Error fetching current user:', error)
      localStorage.removeItem('token')
      return null
    }
  }

  const getAllUsers = async () => {
    try {
      const token = localStorage.getItem('token')
      return await $fetch('/api/users.php', {
        baseURL: config.public.apiBase,
        headers: {
          'Authorization': `Bearer ${token}`
        }
      })
    } catch (error) {
      console.error('Error fetching all users:', error)
      throw error
    }
  }

  const createUser = async (userData: UserData) => {
    try {
      const token = localStorage.getItem('token')
      return await $fetch('/api/users.php', {
        baseURL: config.public.apiBase,
        method: 'POST',
        body: userData,
        headers: {
          'Authorization': `Bearer ${token}`
        }
      })
    } catch (error) {
      console.error('Error creating user:', error)
      throw error
    }
  }

  const updateUser = async (userId: number, userData: UpdateUserData) => {
    try {
      const token = localStorage.getItem('token')
      return await $fetch(`/api/users.php?id=${userId}`, {
        baseURL: config.public.apiBase,
        method: 'PUT',
        body: JSON.stringify(userData),
        headers: {
          'Authorization': `Bearer ${token}`,
          'Content-Type': 'application/json'
        }
      })
    } catch (error) {
      console.error('Error updating user:', error)
      throw error
    }
  }

  const deleteUser = async (userId: number) => {
    try {
      const token = localStorage.getItem('token');
      return await $fetch(`/api/users.php?id=${userId}`, {
        baseURL: config.public.apiBase,
        method: 'DELETE',
        headers: {
          'Authorization': `Bearer ${token}`,
          'Content-Type': 'application/json'
        }
      });
    } catch (error) {
      console.error('Error deleting user:', error);
      throw error;
    }
  }

  return {
    fetchPosts,
    fetchPost,
    fetchUsers,
    login,
    register,
    fetchUser,
    getCurrentUser,
    getAllUsers,
    createUser,
    updateUser,
    deleteUser,
  }
} 