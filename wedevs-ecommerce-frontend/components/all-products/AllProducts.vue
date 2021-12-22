<template>
  <div class="col-lg-8 col-md-12">
    <div class="products-filter-options">
      <div class="row align-items-center">
        <div class="col d-flex">
          <span>Sort:</span>

          <div class="products-ordering-list">
            <select @change="sortPrice">
              <option>Sort by Price</option>
              <option value="1">Price Ascending</option>
              <option value="2">Price Descending</option>
            </select>
          </div>
        </div>
      </div>
    </div>

    <div id="products-filter" class="products-collections-listing row">
      <ProductItem
        v-for="(product, index) in product"
        :product="product"
        :key="index"
        @clicked="toggle"
        :className="`col-lg-6 col-md-6 products-col-item`"
      ></ProductItem>
    </div>

    <QuckView />
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
    sortPrice(e) {
      if (e.target.value == 1) {
        this.product.sort((a, b) => a.price - b.price);
      } else if (e.target.value == 2) {
        this.product.sort((a, b) => b.price - a.price);
      } else {
        this.product;
      }
    },
  },
  async mounted() {
    const response = await axios.get("http://127.0.0.1:8000/api/products/view");
    this.product = response.data.map((pro) => ({
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