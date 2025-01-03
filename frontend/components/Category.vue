<template>
    <v-row>
        <template v-for="(category, index) in items" :key="index">
            <v-col class="text-h5 mt-2" cols="12">
                <strong class="">{{ category.name }}</strong>
            </v-col>
            <v-col v-for="(subItem, subIndex) in category.items" :key="subIndex" cols="6" md="2">
                <v-card height="150" class="d-flex align-center justify-center card" rounded="xl" color="primary" variant="outlined" image="/cat.jpg">
                    <v-card-text class="card">
                        <a class="text-white link"  :href="'/category' + subItem.link">
                            {{ subItem.name }}
                        </a>
                    </v-card-text>
                </v-card>
            </v-col>
        </template>
    </v-row>
</template>

<script setup>
defineProps({
    items: {
        type: Array,
        required: true,
    },
});
</script>
<style lang="scss">
.link {
    text-decoration: none;
    font-size: 1.8rem;
    font-weight: 600;
}
.card {
    display: flex;
    align-items: center;
    justify-content: center;
    backdrop-filter: blur(3px);
    height: 100%;
}
</style>