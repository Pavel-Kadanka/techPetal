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
            <v-card class="d-flex flex-column" height="65vh" image="/cat.jpg" rounded="xl" v-ripple="{ class: 'text-primary' }">
                <v-spacer></v-spacer>
                <v-spacer></v-spacer>
                <v-card-text class="text-content">
                    <h3 class="text-h4 font-weight-bold">This is a title</h3>
                    <v-list-item>
                        <template v-slot:title><span class="text-subtitle-1">Thema</span></template>
                        <template v-slot:append>
                            <span class="text-subtitle-1">22.11. 2025</span>
                        </template>
                    </v-list-item>
                    <p class="text-subtitle-2 pl-4">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Commodi,
                        ratione debitis quis est labore voluptatibus!
                    </p>
                </v-card-text>
            </v-card>
        </v-col>
        <v-col cols="6">
            <v-card class="d-flex flex-column my-6" height="40vh" image="/cat.jpg" rounded="xl" v-ripple="{ class: 'text-primary' }">
                <v-spacer></v-spacer>
                <v-spacer></v-spacer>
                <v-card-text class="text-content">
                    <h3 class="text-h4 font-weight-bold">This is a title</h3>
                    <v-list-item>
                        <template v-slot:title><span class="text-subtitle-1">Thema</span></template>
                        <template v-slot:append>
                            <span class="text-subtitle-1">22.11. 2025</span>
                        </template>
                    </v-list-item>
                </v-card-text>
            </v-card>
            <v-card class="d-flex flex-column" height="35vh" image="/cat.jpg" rounded="xl" v-ripple="{ class: 'text-primary' }">
                <v-spacer></v-spacer>
                <v-spacer></v-spacer>
                <v-card-text class="text-content">
                    <h3 class="text-h4 font-weight-bold">This is a title</h3>
                    <v-list-item>
                        <template v-slot:title><span class="text-subtitle-1">Thema</span></template>
                        <template v-slot:append>
                            <span class="text-subtitle-1">22.11. 2025</span>
                        </template>
                    </v-list-item>
                </v-card-text>
            </v-card>
        </v-col>
    </v-row>
</template>

<style lang="scss" scoped>
.title-text {
    margin: 2rem 1rem;
}
</style>