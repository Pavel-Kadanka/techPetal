<template>
  <v-container>
    <v-breadcrumbs :items="breadcrumbs"></v-breadcrumbs>
    <Category :items="categories" />
  </v-container>
</template>

<script>
export default {
  data() {
    return {
      categories: [
        {
          name: "Elektronika",
          items: [
            { name: "Počítače", link: "/pocitace", image: "/computer.webp" },
            { name: "Mobily", link: "/mobily", image: "/phone.jpg" },
          ],
        },
        {
          name: "Spotřebiče",
          items: [
            { name: "Ledničky", link: "/lednicky", image: "/fridge.webp" },
            { name: "Pračky", link: "/pracky", image: "/washer.webp" },
          ],
        },
      ],
      breadcrumbs: [
        {
          title: 'Domu',
          disabled: false,
          href: '/',
        },
        {
          title: 'Kategorie',
          disabled: true,
        },
      ],
    };
  },
};
</script>

<style scoped>
a {
  text-decoration: none;
}
</style>
