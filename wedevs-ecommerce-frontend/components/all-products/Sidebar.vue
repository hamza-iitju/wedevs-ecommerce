<template>
  <div class="col-lg-4 col-md-12">
    <div class="woocommerce-sidebar-area">
      <div class="collapse-widget collections-list-widget">
        <h3 v-b-toggle.collapse-2 class="collapse-widget-title">
          Categories
          <i class="fas fa-angle-up"></i>
        </h3>
        <b-collapse visible id="collapse-2">
          <ul class="collections-list-row">
            <li class="active"><a href="#">Electronics</a></li>
            <li><a href="#">Home & Appliance</a></li>
            <li><a href="#">Clothing</a></li>
            <li><a href="#">Health & Beauty</a></li>
            <li><a href="#">Accessories</a></li>
            <li><a href="#">Sports & Outdoor</a></li>
          </ul>
        </b-collapse>
      </div>

      <div class="collapse-widget aside-products-widget">
        <h3 class="aside-widget-title">Popular Products</h3>

        <div
          class="aside-single-products"
          v-for="(product, index) in product"
          :product="product"
          :key="index"
          @clicked="toggle"
        >
          <div class="products-image">
            <nuxt-link :to="`/products-details/${product.id}`">
              <img :src="product.images" :alt="product.name" />
            </nuxt-link>
          </div>

          <div class="product-content">
            <h6>
              <nuxt-link :to="`/products-details/${product.id}`">{{
                product.name
              }}</nuxt-link>
            </h6>

            <div class="product-price">
              <span class="old-price" v-if="product.offer">
                ৳{{ product.price - product.offerPrice }}
              </span>
              <span class="new-price">৳{{ product.price }}</span>
            </div>

            <a
              v-if="getExistPId === product.id"
              href="javascript:void(0)"
              class="btn btn-light added-btn"
              @click="addToCart(product)"
            >
              Added Already
            </a>

            <a
              v-else-if="product.qty > 0"
              href="javascript:void(0)"
              class="btn btn-light"
              @click="addToCart(product)"
            >
              Add to Cart
            </a>

            <a v-else class="btn btn-light added-btn"> Out of Stock </a>
          </div>
        </div>
      </div>

      <div class="collapse-widget aside-trending-widget">
        <div class="aside-trending-products">
          <img src="../../assets/img/bestseller-hover-img1.jpg" alt="image" />

          <div class="category">
            <h4>Top Trending</h4>
            <span>Spring/Summer 2021 Collection</span>
          </div>

          <a href="#"></a>
        </div>
      </div>
    </div>
  </div>
</template>


<script>
import QuckView from "../modals/QuckView";
import { mutations } from "../../utils/sidebar-util";
import ProductItem from "../landing-one/ProductItem";
import axios from "axios";
export default {
  data() {
    return {
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
  components: {
    QuckView,
    ProductItem,
  },
  methods: {
    toggle() {
      mutations.toggleQuickView();
    },
  },
  async mounted() {
    const response = await axios.get("http://127.0.0.1:8000/api/products/view");
    const lim_pro = response.data.slice(0, 3);
    this.product = lim_pro.map((pro) => ({
      id: pro.id,
      name: pro.name,
      slug: pro.slug,
      images: "http://127.0.0.1:8000/storage/product/" + pro.images[0],
      description: pro.description,
      price: pro.price,
      qty: pro.qty,
      status: pro.status,
      created_at: pro.created_at,
      updated_at: pro.updated_at,
    }));
  },
};
</script>