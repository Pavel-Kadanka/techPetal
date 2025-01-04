<template>
    <v-container>
        <v-row justify="center">
            <v-col cols="12" md="10">
                <h1 class="text-h3 text-center mb-6">O nás</h1>
                
                <v-card class="mb-6" elevation="2">
                    <v-card-text>
                        <p class="text-body-1">
                            Jsme mladá a dynamická společnost, která se zaměřuje na poskytování kvalitních služeb našim zákazníkům. 
                            Naším cílem je přinášet inovativní řešení a překonávat očekávání.
                        </p>
                    </v-card-text>
                </v-card>

                <v-row class="mb-6">
                    <v-col cols="12" md="4">
                        <v-card height="100%">
                            <v-card-title class="text-center">
                                <v-icon size="large" color="primary" class="mb-2">mdi-target</v-icon>
                                <div>Naše mise</div>
                            </v-card-title>
                            <v-card-text class="text-center">
                                Poskytovat prvotřídní služby a řešení, která pomáhají našim klientům růst.
                            </v-card-text>
                        </v-card>
                    </v-col>

                    <v-col cols="12" md="4">
                        <v-card height="100%">
                            <v-card-title class="text-center">
                                <v-icon size="large" color="primary" class="mb-2">mdi-eye</v-icon>
                                <div>Naše vize</div>
                            </v-card-title>
                            <v-card-text class="text-center">
                                Stát se lídrem v našem oboru a inspirovat ostatní k inovacím.
                            </v-card-text>
                        </v-card>
                    </v-col>

                    <v-col cols="12" md="4">
                        <v-card height="100%">
                            <v-card-title class="text-center">
                                <v-icon size="large" color="primary" class="mb-2">mdi-heart</v-icon>
                                <div>Naše hodnoty</div>
                            </v-card-title>
                            <v-card-text class="text-center">
                                Kvalita, spolehlivost, inovace a orientace na zákazníka.
                            </v-card-text>
                        </v-card>
                    </v-col>
                </v-row>

                <v-row class="mb-6">
                    <v-col cols="12">
                        <h2 class="text-h4 text-center mb-4">Náš tým</h2>
                        <v-row>
                            <v-col v-for="member in teamMembers" :key="member.id" cols="12" sm="6" md="4">
                                <v-card class="text-center">
                                    <v-img
                                        :src="member.image"
                                        height="200"
                                        cover
                                        class="bg-grey-lighten-2"
                                    ></v-img>
                                    <v-card-title class="justify-center">{{ member.name }}</v-card-title>
                                    <v-card-subtitle>{{ member.position }}</v-card-subtitle>
                                    <v-card-text>{{ member.description }}</v-card-text>
                                </v-card>
                            </v-col>
                        </v-row>
                    </v-col>
                </v-row>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
export default {
    name: 'AboutPage',
    head() {
        return {
            title: 'O nás',
            meta: [
                {
                    hid: 'description',
                    name: 'description',
                    content: 'O naší společnosti - kdo jsme a co děláme'
                }
            ]
        }
    },
    data() {
        return {
            teamMembers: [
                {
                    id: 1,
                    name: 'Pavel Kadaňka',
                    position: 'CEO',
                    description: 'Tvůrce projektu',
                    image: '/images/team/pavel.jpg'
                },
                // Add more team members...
            ]
        }
    }
}
</script>

<style scoped>
.v-card-title {
    word-break: normal;
}
</style>