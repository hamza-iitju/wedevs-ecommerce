<template>
  <div>
    <div class="related-products-area">
      <div class="container">
        <div class="section-title">
          <h2><span class="dot"></span> Related Products</h2>
        </div>

        <div class="row">
          <ProductItem
            v-for="product in product"
            :product="product"
            :key="product.id"
            @clicked="toggle"
            :className="`col-lg-3 col-md-6 col-6`"
          ></ProductItem>
        </div>
      </div>
    </div>
    <QuckView />
  </div>
</template>

<script>
import ProductItem from "../landing-one/ProductItem";
import { mutations } from "../../utils/sidebar-util";
import QuckView from "../modals/QuckView";
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
    ProductItem,
    QuckView,
  },
  props: ["id"],
  methods: {
    toggle() {
      mutations.toggleQuickView();
    },
  },
  async mounted() {
    const response = await axios.get("http://127.0.0.1:8000/api/products/view");
    const lim_pro = response.data.slice(0, 4);
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