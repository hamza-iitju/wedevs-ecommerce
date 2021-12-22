<template>
  <div>
    <!-- Start Navbar Area -->
    <div :class="['navbar-area', { 'is-sticky': isSticky }]">
      <div class="comero-nav">
        <div class="container">
          <nav class="navbar navbar-expand-md navbar-light">
            <nuxt-link class="navbar-brand" to="/">
              <img src="../assets/img/logo.png" alt="logo" />
            </nuxt-link>

            <b-navbar-toggle target="navbarSupportedContent"></b-navbar-toggle>

            <b-collapse
              class="collapse navbar-collapse"
              id="navbarSupportedContent"
              is-nav
            >
              <ul class="navbar-nav">
                <li class="nav-item">
                  <nuxt-link to="/" class="nav-link">Home</nuxt-link>
                </li>

                <li class="nav-item">
                  <nuxt-link to="/products" class="nav-link">Shop</nuxt-link>
                </li>

                <li class="nav-item">
                  <nuxt-link to="/products" class="nav-link"
                    >All Products</nuxt-link
                  >
                </li>

                <li class="nav-item">
                  <nuxt-link to="/contact" class="nav-link">Contact</nuxt-link>
                </li>

                <li class="nav-item">
                  <nuxt-link to="/contact" class="nav-link">About Us</nuxt-link>
                </li>
              </ul>

              <div class="others-option">
                <div class="option-item" v-if="$auth.loggedIn">
                  <nuxt-link to="#">{{ $auth.user.name }}</nuxt-link>
                </div>
                <div class="option-item" v-if="$auth.loggedIn">
                  <nuxt-link to="/order">My Orders</nuxt-link>
                </div>
                <div class="option-item" v-if="$auth.loggedIn">
                  <a @click.prevent="logout" href="#">Logout</a>
                </div>

                <div class="option-item" v-else>
                  <nuxt-link to="/login">Login</nuxt-link>
                </div>
                <div class="option-item">
                  <a @click.prevent="toggle" href="#">
                    Cart({{ cart.length }}) <i class="fas fa-shopping-bag"></i>
                  </a>
                </div>
              </div>
            </b-collapse>
          </nav>
        </div>
      </div>
    </div>
    <!-- End Navbar Area -->

    <SidebarPanel></SidebarPanel>
  </div>
</template>

<script>
import SidebarPanel from "../layouts/SidebarPanel";
import { mutations } from "../utils/sidebar-util";
import axios from "axios";

export default {
  components: {
    SidebarPanel,
  },
  data() {
    return {
      isSticky: false,
    };
  },
  mounted() {
    const that = this;
    window.addEventListener("scroll", () => {
      let scrollPos = window.scrollY;
      if (scrollPos >= 100) {
        that.isSticky = true;
      } else {
        that.isSticky = false;
      }
    });
  },
  computed: {
    cart() {
      return this.$store.getters.cart;
    },
  },
  methods: {
    toggle() {
      mutations.toggleNav();
    },
    async logout() {
      await this.$auth
        .logout()
        .then(() => this.$toast.success("Logout Out Successfully!"))
        .then(() => this.$router.push("/"));
    },
  },
};
</script>