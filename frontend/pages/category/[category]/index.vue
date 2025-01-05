<script setup>
const route = useRoute()
const category = route.params.category
const { fetchPosts } = useApi()
const { getCategoryName } = useCategories()

// Add breadcrumbs with proper category name
const breadcrumbs = computed(() => [
  {
    title: 'Domu',
    disabled: false,
    href: '/',
  },
  {
    title: 'Kategorie',
    disabled: false,
    href: '/category',
  },
  {
    title: getCategoryName(category),
    disabled: true,
  },
])

// You might want to modify fetchPosts to accept category as a parameter
const { data: posts, pending, error } = await useAsyncData(
  `posts-${category}`,
  () => fetchPosts(category)
)
</script>

<template>
  <v-container fluid>
    <!-- Add breadcrumbs -->
    <v-breadcrumbs :items="breadcrumbs"></v-breadcrumbs>
    
    <!-- Category title with proper name -->
    <v-row class="mb-4">
      <v-col cols="12">
        <h1 class="text-h4">{{ getCategoryName(category) }}</h1>
      </v-col>
    </v-row>

    <!-- Rest of your template remains the same -->
    <v-row v-if="pending" justify="center">
      <v-col cols="12" class="text-center">
        <v-progress-circular
          indeterminate
          color="primary"
          size="64"
        ></v-progress-circular>
      </v-col>
    </v-row>

    <!-- Error state -->
    <v-row v-else-if="error" justify="center">
      <v-col cols="12" md="8">
        <v-alert
          type="error"
          title="Error"
          :text="error.message"
        ></v-alert>
      </v-col>
    </v-row>

    <!-- Posts grid -->
    <v-row v-else>
      <v-col
        v-for="post in posts"
        :key="post.id"
        cols="12"
        sm="6"
        md="6"
        lg="6"
        xl="3"
      >
        <v-card
          :to="`/category/${category}/${post.id}`"
          height="300"
          class="post-card"
        >
          <v-img
            :src="post.image || '/cat.jpg'"
            class="fill-height"
            cover
            gradient="to bottom, rgba(0,0,0,.1), rgba(0,0,0,.8)"
          >
            <template v-slot:default>
              <v-card-item class="fill-height d-flex flex-column justify-end">
                <!-- Theme chip -->
                <v-chip
                  color="primary"
                  label
                  size="small"
                  class="mb-2"
                >
                  {{ post.theme }}
                </v-chip>
                <!-- Title -->
                <v-card-title class="text-white pa-0 text-h6">
                  {{ post.title }}
                </v-card-title>
                
                <!-- Rating and date -->
                <div class="d-flex align-center mt-2">
                  <v-rating
                    v-model="post.rating"
                    color="warning"
                    density="compact"
                    half-increments
                    readonly
                    size="small"
                  ></v-rating>
                  <v-spacer></v-spacer>
                  <span class="text-caption text-white">
                    {{ new Date(post.date).toLocaleDateString() }}
                  </span>
                </div>
              </v-card-item>
            </template>
          </v-img>
        </v-card>
      </v-col>
    </v-row>

    <!-- No posts -->
    <v-row v-if="!pending && !error && (!posts || posts.length === 0)" justify="center">
      <v-col cols="12" md="8" class="text-center">
        <v-alert
          type="info"
          title="No Posts"
          text="No posts found in this category."
        ></v-alert>
      </v-col>
    </v-row>
  </v-container>
</template>

<style scoped>
.post-card {
  transition: transform 0.2s;
}

.post-card:hover {
  transform: translateY(-4px);
}

/* Ensure text doesn't overflow */
.v-card-title {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.text-truncate {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
</style> 