<script setup>
const route = useRoute()
const { fetchPosts } = useApi()

const { data: post, pending, error } = await useAsyncData(
    'post',
    () => fetchPosts()
)


const numberOfPosts = post.value?.length - 1

</script>
<template>
    <v-row align="end" justify="center">
        <v-col cols="6">
            <div class="title-text">
                <span class="text-h5">
                    Nevíte si rady při výběru
                    <span class="pink-1 font-weight-bold">elektroniky</span>
                    nebo
                    <span class="pink-1 font-weight-bold">spotřebičů</span> podívejte se na jeden z našich článků
                </span>
            </div>

            <v-card class="mx-auto bg-primary" height="65vh" rounded="xl" :href="'/category/'+post[numberOfPosts].theme.toLowerCase()+'/'+post[numberOfPosts].id">
                <v-img class="align-end text-white" height="40vh" :src="'/'+post[numberOfPosts].image"
                    cover>
                </v-img>
                <v-card-title class="font-weight-bold">{{ post[numberOfPosts].title }}</v-card-title>
                <v-card-subtitle>
                    <v-list-item>
                        <template v-slot:title><span>{{ post[numberOfPosts].theme }}</span></template>
                        <template v-slot:append>
                            <span>{{ post[numberOfPosts].date }}</span>
                        </template>
                    </v-list-item>
                </v-card-subtitle>

                <v-card-text>
                    {{ post[numberOfPosts].text }}
                </v-card-text>
            </v-card>
        </v-col>
        <v-col cols="6">
            <v-card class="mx-auto bg-primary" height="40vh" rounded="xl" :href="'/category/'+post[numberOfPosts-1].theme.toLowerCase()+'/'+post[numberOfPosts-1].id">
                <v-img class="align-end text-white" height="25vh" :src="'/'+post[numberOfPosts-1].image"
                    cover>
                </v-img>
                <v-card-title class="font-weight-bold">{{ post[numberOfPosts-1].title }}</v-card-title>
                <v-card-subtitle>
                    <v-list-item>
                        <template v-slot:title><span>{{ post[numberOfPosts-1].theme }}</span></template>
                        <template v-slot:append>
                            <span>{{ post[numberOfPosts-1].date }}</span>
                        </template>
                    </v-list-item>
                </v-card-subtitle>
            </v-card>
            <v-card class="mt-5 bg-primary" height="40vh" rounded="xl" :href="'/category/'+post[numberOfPosts-2].theme.toLowerCase()+'/'+post[numberOfPosts-2].id">
                <v-img class="align-end text-white" height="25vh" :src="'/'+post[numberOfPosts-2].image"
                    cover>
                </v-img>
                <v-card-title class="font-weight-bold">{{ post[numberOfPosts-2].title }}</v-card-title>
                <v-card-subtitle>
                    <v-list-item>
                        <template v-slot:title><span>{{ post[numberOfPosts-2].theme }}</span></template>
                        <template v-slot:append>
                            <span>{{ post[numberOfPosts-2].date }}</span>
                        </template>
                    </v-list-item>
                </v-card-subtitle>
            </v-card>
        </v-col>
    </v-row>
</template>

<style lang="scss" scoped>
.title-text {
    margin: 2rem 1rem;
}
</style>