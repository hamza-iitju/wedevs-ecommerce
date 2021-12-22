<template>
  <div>
    <!-- Start Page Title Area -->
    <div class="page-title-area">
      <div class="container">
        <ul>
          <li><nuxt-link to="/">Home</nuxt-link></li>
          <li>Cart</li>
        </ul>
      </div>
    </div>
    <!-- End Page Title Area -->

    <!-- Start Checkout Area -->
    <section class="checkout-area ptb-60">
      <div class="container">
        <div class="row">
          <div class="col-lg-12 col-md-12">
            <div class="user-actions">
              <i class="fas fa-sign-in-alt"></i>
              <span
                >Returning customer?
                <nuxt-link to="/products"
                  >Click here to more carts</nuxt-link
                ></span
              >
            </div>
          </div>
        </div>

        <form>
          <div class="row">
            <div class="col-lg-6 col-md-12">
              <div class="billing-details">
                <h3 class="title">Billing Details</h3>
                <div class="row">
                  <div class="col-lg-12 col-md-6">
                    <div class="form-group">
                      <label>Full Name <span class="required">*</span></label>
                      <input
                        type="text"
                        id="fullName"
                        v-model="shippingDetails.person_name"
                        class="form-control"
                        required
                      />
                    </div>
                  </div>

                  <div class="col-lg-12 col-md-6">
                    <div class="form-group">
                      <label>Address <span class="required">*</span></label>
                      <input
                        type="text"
                        id="address"
                        v-model="shippingDetails.address"
                        class="form-control"
                        required
                      />
                    </div>
                  </div>

                  <div class="col-lg-12 col-md-6">
                    <div class="form-group">
                      <label>City <span class="required">*</span></label>
                      <input
                        type="text"
                        id="city"
                        v-model="shippingDetails.city"
                        class="form-control"
                        required
                      />
                    </div>
                  </div>

                  <div class="col-lg-6 col-md-6">
                    <div class="form-group">
                      <label
                        >Email Address <span class="required">*</span></label
                      >
                      <input
                        type="email"
                        id="email"
                        v-model="shippingDetails.email"
                        class="form-control"
                        required
                      />
                    </div>
                  </div>

                  <div class="col-lg-6 col-md-6">
                    <div class="form-group">
                      <label>Phone <span class="required">*</span></label>
                      <input
                        type="text"
                        id="phone"
                        v-model="shippingDetails.phone"
                        class="form-control"
                        required
                      />
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-lg-6 col-md-12">
              <div class="order-details">
                <h3 class="title">Your Order</h3>

                <div class="order-table table-responsive">
                  <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th scope="col">Product Name</th>
                        <th scope="col">Total</th>
                      </tr>
                    </thead>

                    <tbody>
                      <tr v-for="(cart, i) in cart" :key="i">
                        <td class="product-name">
                          <a href="#">{{ cart.name }}</a>
                        </td>

                        <td class="product-total">
                          <span class="subtotal-amount"
                            >৳{{ cart.price * cart.quantity }}</span
                          >
                        </td>
                      </tr>

                      <tr>
                        <td class="order-subtotal">
                          <span>Cart Subtotal</span>
                        </td>

                        <td class="order-subtotal-price">
                          <span class="order-subtotal-amount"
                            >৳{{ cartTotal }}</span
                          >
                        </td>
                      </tr>
                      <tr>
                        <td class="order-shippingDetails">
                          <span>Shipping Cost</span>
                        </td>

                        <td class="shippingDetails-price">
                          <span>৳100.00</span>
                        </td>
                      </tr>
                      <tr>
                        <td class="total-price">
                          <span>Order Total</span>
                        </td>

                        <td class="product-subtotal">
                          <span class="subtotal-amount"
                            >৳{{ parseFloat(cartTotal + 100).toFixed(2) }}</span
                          >
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>

                <div class="payment-method">
                  <p>
                    <input
                      type="radio"
                      id="direct-bank-transfer"
                      name="radio-group"
                      checked
                    />
                    <label for="direct-bank-transfer">Bank Transfer</label>
                  </p>
                  <p>
                    <input type="radio" id="paypal" name="radio-group" />
                    <label for="paypal"
                      >SSL Commerce (Bkash, Rocket, Nagad)</label
                    >
                  </p>
                  <p>
                    <input
                      type="radio"
                      id="cash-on-delivery"
                      name="radio-group"
                    />
                    <label for="cash-on-delivery">Cash on Delivery</label>
                  </p>
                </div>

                <button
                  type="button"
                  href="javascript:void(0)"
                  @click="add"
                  class="btn btn-primary order-btn"
                >
                  Place Order
                </button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </section>
    <!-- End Checkout Area -->
  </div>
</template>

<script>
import firebase from "../../plugins/firebase";
import axios from "axios";

export default {
  data() {
    return {
      shippingDetails: {
        person_name: this.$auth.user.name,
        address: "Jahangirnagar University",
        city: "Dhaka",
        email: this.$auth.user.name,
        phone: this.$auth.user.phone,
        created_at: new Date(),
        updated_at: new Date(),
      },
    };
  },
  computed: {
    cart() {
      return this.$store.getters.cart;
    },
    cartTotal() {
      return this.$store.getters.totalAmount;
    },
  },
  methods: {
    add() {
      const cartData = {
        total: this.cartTotal,
        customer_id: 1,
        shipping: this.shippingDetails,
        products: this.cart,
      };

      const response = axios.post(
        "http://127.0.0.1:8000/api/checkout",
        cartData
      );

      console.log(response);
      if (response.errors) {
        this.$toast.error(response.errors.message, {
          icon: "fas fa-cart-plus",
        });
      }
      this.$toast.success(`Thanks for the order`, {
        icon: "fas fa-cart-plus",
      });
      this.$store.dispatch("cartEmpty");
      this.$router.push("/");
    },
    async saveOrder() {
      const response = await axios.post(
        "http://127.0.0.1:8000/api/checkout",
        this.cartData,
        {
          headers: {
            Accept: "application/json",
          },
        }
      );
      console.log(response);
    },
  },
};
</script>