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

  return {
    fetchPosts,
    fetchPost,
    fetchUsers,
    login,
    register,
    fetchUser
  }
} 