<template>
  <Category :items="categories" />
</template>

<script>
export default {
  data() {
    return {
      items: [
        { name: "Počítač", link: "/pocitace" },
        { name: "Mobily", link: "/mobily" },
        { name: "Spotřebiče", link: "/spotrebice" },
      ],
      categories: [
        {
          name: "Electronics",
          items: [
            { name: "Počítač", link: "/pocitace" },
            { name: "Mobily", link: "/mobily" },
          ],
        },
        {
          name: "Appliances",
          items: [{ name: "Spotřebiče", link: "/spotrebice" }],
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
