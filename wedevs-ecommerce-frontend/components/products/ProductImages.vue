<template>
  <client-only>
    <div class="col-lg-6 col-md-6">
      <div class="products-page-gallery">
        <div class="product-page-gallery-main">
          <vueper-slides :bullets="false">
            <vueper-slide
              v-for="(img, i) in images"
              :key="i"
              :image="'http://127.0.0.1:8000/storage/product/' + img"
            />
          </vueper-slides>
        </div>
      </div>
    </div>
  </client-only>
</template>

<script>
export default {
  props: ["images"],
};
</script>