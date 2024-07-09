// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
  devtools: { enabled: true },
  ssr: true,
  srcDir: 'src/',
  modules: [
    '@nuxt/eslint',
    '@nuxt/ui',
  ],
  eslint: {
    config: {
      stylistic: {
        indent: 2,
        semi: true,
      },
    },
  },
  app: {
    head: {
      titleTemplate: '%s | Laravel nuxt blog',
      title: 'Laravel nuxt blog',
      charset: 'utf-8',
      viewport: 'width=device-width, initial-scale=1',
    },
  },
  nitro: {
    devProxy: {
      '/api': { target: 'http://127.0.0.1:8000/api', changeOrigin: true }
    }
  },
  runtimeConfig: {
    apiSecret: '', // can be overridden by NUXT_API_SECRET environment variable
    public: {
      apiBase: process.env.BASE_URL || 'http://127.0.0.1:8000/', // can be overridden by NUXT_PUBLIC_API_BASE environment variable
    },
  },
});
