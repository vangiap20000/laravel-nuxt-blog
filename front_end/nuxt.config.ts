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
});