// https://nuxt.com/docs/api/configuration/nuxt-config
import tailwindcss from "@tailwindcss/vite";

export default defineNuxtConfig({
  compatibilityDate: '2025-05-15',
  devtools: { enabled: true },
  css: ['~/assets/css/main.css'],
  vite: {
    plugins: [
      tailwindcss(),
    ],
  },

  modules: [
    '@nuxt/content',
    '@nuxt/eslint',
    '@nuxt/fonts',
    '@nuxt/icon',
    '@nuxt/image',
    '@nuxt/scripts',
    '@nuxt/test-utils',
    '@nuxt/ui',
    'nuxt-auth-sanctum'
  ],
  sanctum:{
    baseUrl : 'http://localhost:8000',
    endpoints:{
      login: '/api/login',
      logout: '/api/logout'
    },

    redirect: {
      onLogin: '/',
      onLogout: '/login'
    }
  },
  runtimeConfig:{
    public:{
      baseUrl : 'http://localhost:8000'
    }
  }
})