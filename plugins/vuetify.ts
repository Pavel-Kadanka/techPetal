import { defineNuxtPlugin } from '#app';
import '@mdi/font/css/materialdesignicons.css';
import 'vuetify/styles';
import { createVuetify } from 'vuetify';
import * as components from 'vuetify/components';
import * as directives from 'vuetify/directives';
import colors from 'vuetify/lib/util/colors';

export default defineNuxtPlugin((nuxtApp) => {
  const vuetify = createVuetify({
    components,
    directives,
    theme: {
      defaultTheme: 'light',
      themes: {
        light: {
          colors: {
            primary: colors.pink.lighten1,       // #FCE4EC
            secondary: colors.pink.lighten2,     // #F8BBD0
            accent: colors.pink.lighten3,        // #F48FB1
            'text-primary': colors.pink.lighten4,  // #F06292
            'text-secondary': colors.pink.lighten5,  // #EC407A
          },
        },
      },
    },
    icons: {
      defaultSet: 'mdi',
    },
  });

  nuxtApp.vueApp.use(vuetify);
});
