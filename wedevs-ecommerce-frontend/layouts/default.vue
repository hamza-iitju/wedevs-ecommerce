<template>
  <div>
    <TopHeader></TopHeader>
    <Menubar></Menubar>
    <nuxt />
    <Footer></Footer>
    <SiteLoader v-if="loading" />
    <BackToTop></BackToTop>
  </div>
</template>

<script>
import TopHeader from "./TopHeader";
import Menubar from "./Menubar";
import Footer from "./Footer";
import BackToTop from "./BackToTop";
import SiteLoader from "./SiteLoder";
export default {
  components: {
    TopHeader,
    Menubar,
    Footer,
    BackToTop,
    SiteLoader,
  },
  data() {
    return {
      loading: true,
      isShowing: true,
    };
  },
  methods: {},
  watch: {
    $route(pathUrl) {
      this.loading = true;
      setTimeout(() => {
        this.loading = false;
      }, 600);
    },
  },
  mounted() {
    setTimeout(() => {
      this.loading = false;
    }, 600);
  },
};
</script>