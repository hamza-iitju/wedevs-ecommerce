<template>
  <div>
    <!-- Start Page Title Area -->
    <div class="page-title-area">
      <div class="container">
        <ul>
          <li><nuxt-link to="/">Home</nuxt-link></li>
          <li>{{ product.name }}</li>
        </ul>
      </div>
    </div>
    <!-- End Page Title Area -->

    <!-- Start Products Details Area -->
    <section class="products-details-area ptb-60">
      <div class="container">
        <div class="row">
          <ProductImages :images="product.images" />
          <Details
            :id="product.id"
            :name="product.name"
            :price="product.price"
            :qty="product.qty"
          />
          <DetailsInfo :description="product.description" />
          <RelatedProducts />
        </div>
      </div>
    </section>
  </div>
</template>



<script>
import ProductImages from "../../components/products/ProductImages";
import Details from "../../components/products/Details";
import DetailsInfo from "../../components/products/DetailsInfo";
import RelatedProducts from "../../components/products/RelatedProducts";
import axios from "axios";

export default {
  components: {
    ProductImages,
    Details,
    DetailsInfo,
    RelatedProducts,
  },
  data() {
    return {
      id: this.$route.params.id,
      product: [
        {
          id: 1,
          name: "",
          slug: "",
          images: "",
          description: "",
          price: 0,
          qty: 0,
          status: 1,
          created_at: null,
          updated_at: null,
        },
      ],
    };
  },
  computed: {
    // product(){
    //     return this.$store.state.products.all.find(product => product.id === parseInt(this.id));
    // }
  },
  async mounted() {
    const response = await axios.get(
      `http://127.0.0.1:8000/api/products/${this.id}`
    );
    this.product = response.data;
  },
};
</script>