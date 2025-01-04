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
        <a href="/account">
          <v-icon size="40" color="primary" icon="mdi-magnify"></v-icon>
        </a>
        <a href="/account" class="pl-4">
          <v-icon size="40" color="primary" icon="mdi-account"></v-icon>
        </a>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
export default {
  name: 'SimpleMenu',
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
