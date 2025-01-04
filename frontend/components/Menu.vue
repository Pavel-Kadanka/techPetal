<template>
  <v-container fluid>
    <v-row>
      <v-col cols="3">
        <span class="text-h3 font-weight-bold">TechPetal</span>
      </v-col>
      <v-col align-self="center" cols="7" class="text-right box">
        <v-btn class="mx-4 custom-border" color="primary" variant="outlined" border="md" href="/" >domů</v-btn>
        <v-btn class="mx-4 custom-border" color="primary" variant="outlined" border="md" href="/category">kategorie</v-btn>
        <v-btn class="mx-4 custom-border" color="primary" variant="outlined" border="md" href="/about">o nás</v-btn>
      </v-col>
      <v-col cols="2" align-self="center" class="text-center">
        <v-btn icon href="/account" class="" variant="flat">
          <v-icon size="40" color="primary" icon="mdi-magnify"></v-icon>
        </v-btn>
        <v-btn icon href="/account" variant="flat">
          <v-icon size="40" color="primary" icon="mdi-account"></v-icon>
        </v-btn>
        <template v-if="isLoggedIn">
          <v-btn icon @click="handleLogout" variant="flat">
            <v-icon size="40" color="primary" icon="mdi-logout"></v-icon>
          </v-btn>
        </template>
      </v-col>
    </v-row>
  </v-container>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useRouter } from 'vue-router';
import { useApi } from '~/composables/useApi';

const router = useRouter();
const api = useApi();
const isLoggedIn = ref(false);
const user = ref(null);

onMounted(() => {
  const token = localStorage.getItem('token');
  if (token) {
    isLoggedIn.value = true;
    const userData = JSON.parse(localStorage.getItem('user') || '{}');
    user.value = userData;
  }
});

const handleLogout = async () => {
  try {
    localStorage.removeItem('token');
    localStorage.removeItem('user');
    isLoggedIn.value = false;
    user.value = null;
    location.reload();
  } catch (error) {
    console.error('Logout error:', error);
  }
};
</script>

<style scoped>
.input {
  border: #EC407A solid 1px;
  border-radius: 5px;
}
.custom-border {
  border-color: var(--v-primary-base) !important; /* Use Vuetify's primary color */
}

</style>
