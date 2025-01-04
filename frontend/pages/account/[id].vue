<script setup>
const { fetchUser } = useApi()
const route = useRoute()
const { data: user, pending, error } = await useAsyncData(
  'user',
  () => fetchUser(route.params.id)
)
console.log(user)
</script>
<template>
  <v-container>
    <v-row v-if="user">
      <!-- Admin View -->
      <template v-if="user.role === 'admin'">
        <v-col cols="12">
          <h2>Admin Dashboard</h2>
          <v-card>
            <v-card-text>
              <h3>User Management</h3>
              <!-- Add admin-specific features -->
            </v-card-text>
          </v-card>
        </v-col>
      </template>

      <!-- Regular User View -->
      <template v-else>
        <v-col cols="12">
          <h2>User Profile</h2>
          <v-card>
            <v-card-text>
              <v-row>
                <v-col cols="12" md="6">
                  <v-text-field
                    v-model="user.name"
                    :label="user.name"
                    readonly
                  ></v-text-field>
                </v-col>
                <v-col cols="12" md="6">
                  <v-text-field
                    v-model="user.email"
                    label="Email"
                    readonly
                  ></v-text-field>
                </v-col>
              </v-row>
            </v-card-text>
          </v-card>
        </v-col>
      </template>
    </v-row>
  </v-container>
</template>
