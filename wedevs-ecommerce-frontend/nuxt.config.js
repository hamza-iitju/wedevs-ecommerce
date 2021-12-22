export default {
  mode: 'universal',
  /*
   ** Headers of the page
   */
  head: {
    htmlAttrs: {
      lang: 'en',
    },
    title: 'Wedevs - eCommerce Laravel and Vue',
    meta: [{
        charset: 'utf-8'
      },
      {
        name: 'viewport',
        content: 'width=device-width, initial-scale=1'
      },
      {
        hid: 'description',
        name: 'description',
        content: process.env.npm_package_description || ''
      },
      {
        name: "csrf-token",
        content: "{{ csrf_token() }}"
      }
    ],
    link: [{
      rel: 'icon',
      type: 'image/x-icon',
      href: '/favicon.ico'
    }]
  },
  /*
   ** Customize the progress-bar color
   */
  loading: {
    color: '#fff'
  },
  /*
   ** Plugins to load before mounting the App
   */
  plugins: [{
      src: '~/plugins/vue-carousel',
      ssr: false
    },
    {
      src: '~/plugins/vue-backtotop',
      ssr: false
    },
    {
      src: '~/plugins/vue-toastification',
      ssr: false
    },
    {
      src: '~/plugins/vueperslides',
      ssr: false
    },
  ],
  /*
   ** Nuxt.js dev-modules
   */
  buildModules: [],
  /*
   ** Nuxt.js modules
   */
  modules: [
    'bootstrap-vue/nuxt',
    '@nuxtjs/axios',
    '@nuxtjs/auth-next'
  ],

  auth: {
    strategies: {
      local: {
        endpoints: {
          // login api
          login: {
            url: 'http://127.0.0.1:8000/api/customer/login',
            method: 'post',
            propertyName: 'token'
          },
          user: {
            url: 'http://127.0.0.1:8000/api/customer/user',
            method: 'get',
            propertyName: 'user'
          },
          // logout api
          logout: {
            url: 'http://127.0.0.1:8000/api/customer/logout',
            method: 'post'
          },
        },
        redirect: {
          login: '/login',
          logout: '/login',
          callback: '/login',
          home: '/'
        },
      }
    }
  },
  /*
  /*
  ** Global CSS
  */
  css: [
    './assets/scss/styles/animate.min.css',
    './assets/scss/styles/fontawesome.min.css',
    './assets/scss/styles/style.scss',
    './assets/scss/styles/admin.scss',
    './assets/scss/styles/responsive.scss',
  ],
  /** Axios module configuration
   ** See https://axios.nuxtjs.org/options
   */
  axios: {
    proxy: true,
    baseURL: 'http://localhost:8000/api',
    credentials: true
  },
  /*
   ** Globally configure <nuxt-link> default active class.
   */
  router: {
    linkActiveClass: 'active',
  },
  /*
   ** Build configuration
   */
  build: {
    /*
     ** You can extend webpack config here
     */
    extend(config, ctx) {}
  }
}