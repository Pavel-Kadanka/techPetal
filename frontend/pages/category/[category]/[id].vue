<script setup>
const route = useRoute()
const { fetchPost } = useApi()
const { getCategoryName } = useCategories()

const { data: post, pending, error } = await useAsyncData(
  'post',
  () => fetchPost(route.params.id)
)

// Add breadcrumbs computed property
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
    title: getCategoryName(route.params.category),
    disabled: false,
    href: `/category/${route.params.category}`,
  },
  {
    title: post.value?.title || 'Loading...',
    disabled: true,
  },
])
</script>

<template>
  <v-container>
    <!-- Add breadcrumbs -->
    <v-breadcrumbs :items="breadcrumbs"></v-breadcrumbs>

    <!-- Loading state -->
    <v-row v-if="pending" justify="center">
      <v-col cols="12" class="text-center">
        <v-progress-circular indeterminate color="primary" size="64"></v-progress-circular>
      </v-col>
    </v-row>

    <!-- Error state -->
    <v-row v-else-if="error" justify="center">
      <v-col cols="12" md="8">
        <v-alert type="error" title="Error" :text="error.message"></v-alert>
      </v-col>
    </v-row>

    <!-- Post content -->
    <v-row v-else-if="post" justify="center">
      <v-col cols="12" md="8">
        <v-card>
          <!-- Post image -->
          <v-img v-if="post.image" :src="post.image" :alt="post.title" height="400" cover></v-img>

          <v-card-title class="text-h4 pt-4">
            {{ post.title }}
          </v-card-title>

          <!-- Post metadata -->
          <v-card-subtitle>
            <v-row align="center" no-gutters>
              <v-col>
                <v-list-item>
                  <template v-slot:title><v-chip color="primary" label class="mr-2">
                    {{ post.theme }}
                  </v-chip></template>
                  <template v-slot:prepend>
                    <v-rating v-model="post.rating" readonly density="compact" half-increments class="mr-2"></v-rating>
                  </template>
                  <template v-slot:append>
                    <span class="text-caption">
                      {{ new Date(post.date).toLocaleDateString() }}
                    </span>
                  </template>
                </v-list-item>
                
                
                
              </v-col>
            </v-row>
          </v-card-subtitle>

          <!-- Post content -->
          <v-card-text class="text-body-1">
            <div v-html="post.text"></div>
          </v-card-text>

          <!-- Parameters section if available -->
          
        </v-card>

        <!-- Navigation buttons -->
        <v-row class="mt-4">
          <v-col cols="6">
            <v-btn variant="tonal" :disabled="!post?.id || post.id <= 1"
              @click="navigateTo(`/category/${(route.params.category)}/${parseInt(post.id) - 1}`)" block
              prepend-icon="mdi-chevron-left">
              Previous Post
            </v-btn>
          </v-col>
          <v-col cols="6">
            <v-btn variant="tonal" @click="navigateTo(`/category/${(route.params.category)}/${parseInt(post.id) + 1}`)"
              block append-icon="mdi-chevron-right">
              Next Post
            </v-btn>
          </v-col>
        </v-row>
      </v-col>

      <!-- Related info sidebar -->
      <v-col cols="12" md="4">
        <v-card>
          <v-card-title>Share</v-card-title>
          <v-card-text>
            <v-btn v-for="(icon, index) in ['mdi-facebook', 'mdi-twitter', 'mdi-linkedin']" :key="index" :icon="icon"
              variant="text" class="mx-2"></v-btn>
          </v-card-text>
          <v-expand-transition>
            <div v-if="post.parameters">
              <v-divider></v-divider>
              <v-card-text>
                <v-list>
                  <v-list-subheader>Parameters</v-list-subheader>
                  <v-list-item v-for="(value, key) in JSON.parse(post.parameters)" :key="key">
                    <v-list-item-title>{{ key }}</v-list-item-title>
                    <v-list-item-subtitle>{{ value }}</v-list-item-subtitle>
                  </v-list-item>
                </v-list>
              </v-card-text>
            </div>
          </v-expand-transition>
        </v-card>

        <!-- You might want to add more sidebar content here -->
      </v-col>
    </v-row>

    <!-- No post found -->
    <v-row v-else justify="center">
      <v-col cols="12" md="8">
        <v-alert type="warning" title="Not Found" text="Post not found"></v-alert>
      </v-col>
    </v-row>
  </v-container>
</template>

<style scoped>
/* Add any custom styles here if needed */
.v-card-text :deep(img) {
  max-width: 100%;
  height: auto;
}

.v-card-text :deep(a) {
  color: rgb(var(--v-theme-primary));
  text-decoration: none;
}

.v-card-text :deep(p) {
  margin-bottom: 1rem;
}
</style>