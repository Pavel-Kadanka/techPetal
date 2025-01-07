import { useRuntimeConfig } from '#app'

export const usePostApi = () => {
  const config = useRuntimeConfig()
  const baseURL = config.public.apiBase

  return {
    async getPosts(category?: string) {
      const url = category 
        ? `/api/posts.php?category=${category}`
        : '/api/posts.php'
      
      return await $fetch(url, {
        baseURL
      })
    },

    async getPost(id: number) {
      return await $fetch(`/api/posts.php?id=${id}`, {
        baseURL
      })
    }
  }
} 