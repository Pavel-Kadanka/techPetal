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
          name: "Technologie",
          items: [
            { name: "AI", link: "/ai", image: "https://images.unsplash.com/photo-1518770660439-4636190af475" },
            { name: "Blockchain", link: "/blockchain", image: "https://images.unsplash.com/photo-1542831371-29b0f74f9713" },
            { name: "IoT", link: "/iot", image: "https://images.unsplash.com/photo-1527181152855-fc03fc7949c8" },
            { name: "Bezpečnost", link: "/cyb-safe", image: "https://images.unsplash.com/photo-1550751827-4bd374c3f58b" },
          ],
        },
        {
          name: "Startupy",
          items: [
            { name: "Startupy", link: "/startup", image: "https://images.unsplash.com/photo-1519389950473-47ba0277781c" },
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
