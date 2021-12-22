<template>
  <div>
    <div class="page-title-area">
      <div class="container">
        <ul>
          <li><nuxt-link to="/">Home</nuxt-link></li>
          <li>Signup</li>
        </ul>
      </div>
    </div>

    <section class="signup-area ptb-60">
      <div class="container">
        <div class="signup-content">
          <div class="section-title">
            <h2><span class="dot"></span> Create an Account</h2>
          </div>

          <form class="signup-form">
            <div class="form-group">
              <label>Name</label>
              <input
                type="text"
                v-model="form.name"
                class="form-control"
                placeholder="Enter your name"
                id="name"
                name="name"
                required
              />
            </div>

            <div class="form-group">
              <label>Phone</label>
              <input
                type="text"
                v-model="form.phone"
                class="form-control"
                placeholder="Enter your phone"
                id="phone"
                name="phone"
                required
              />
            </div>

            <div class="form-group">
              <label>Email</label>
              <input
                type="email"
                v-model="form.email"
                class="form-control"
                placeholder="Enter your name"
                id="email"
                name="email"
              />
            </div>

            <div class="form-group">
              <label>Password</label>
              <input
                type="password"
                v-model="form.password"
                class="form-control"
                placeholder="Enter your password"
                id="password"
                name="password"
                required
              />
            </div>

            <div class="form-group">
              <label>Confirm Password</label>
              <input
                type="password"
                v-model="form.password_confirmation"
                class="form-control"
                placeholder="Enter your password again"
                id="password"
                name="password_confirmation"
                required
              />
            </div>

            <button
              type="button"
              class="btn btn-primary"
              @click.prevent="register()"
            >
              Signup
            </button>

            <nuxt-link to="/" class="return-store"
              >or Return to Store</nuxt-link
            >
          </form>
        </div>
      </div>
    </section>
  </div>
</template>

<script>
export default {
  data() {
    return {
      form: {
        name: "",
        email: "",
        password: "",
        password_confirmation: "",
        phone: "",
        error: null,
      },
    };
  },

  methods: {
    async register() {
      try {
        await this.$axios.post(
          "http://127.0.0.1:8000/api/customer/register",
          this.form
        );

        await this.$auth
          .loginWith("local", {
            data: {
              email: this.form.email,
              password: this.form.password,
            },
          })
          .then((res) => {
            this.$router.push("/");
          })
          .then(() => this.$toast.success("Registration Successful!"))
          .catch((err) => {
            this.$toast.error("Something Wrong!");
          });
      } catch (e) {
        this.error = e.response.data.message;
        console.log(this.error);
      }
    },
  },
};
</script>