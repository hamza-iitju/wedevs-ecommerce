<template>
  <!-- Start Main Banner Area -->
  <div class="main-banner item-bg1">
    <div class="d-table">
      <div class="d-table-cell">
        <div class="container">
          <div class="main-banner-content">
            <span>New Inspiration 2021</span>
            <h1>Clothing made for you!</h1>
            <p>Trending from men and women style collection</p>

            <nuxt-link to="/products" class="btn btn-primary"
              >Shop New</nuxt-link
            >
            <nuxt-link to="/products" class="btn btn-light"
              >Popular Collection</nuxt-link
            >
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- End Main Banner Area -->
</template>

<script>
export default {
  name: "Banner",
};
</script>