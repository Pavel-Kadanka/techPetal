<script setup>
import { mdiAccount } from '@mdi/js';
</script>

<template>
  <v-row class="pa-2">
    <v-col cols="3">
      <span class="color-primary text-h3">TechPetal</span>
    </v-col>
    <v-col align-self="center" cols="8" class="text-right box">
      <v-btn class="mx-4" color="primary" variant="outlined" href="/">domů</v-btn>
      <v-btn class="mx-4" color="primary" variant="outlined" href="/category">kategorie</v-btn>
      <v-btn class="mx-4" color="primary" variant="outlined" href="/about">o nás</v-btn>
    </v-col>
    <v-col cols="1" align-self="center" class="text-center">
      <v-icon size="50" color="primary">mdi-account</v-icon>
    </v-col>
  </v-row>
</template>

<script>
export default {
  name: 'SimpleMenu',
};
</script>

<style scoped>
.color-primary {
  color: #EC407A;
}
.input {
  border: #EC407A solid 1px;
  border-radius: 5px;
}

</style>
