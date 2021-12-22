<template>
  <!-- Start Top Header Area -->
  <div class="top-header">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-7 col-md-6">
          <ul class="top-header-nav">
            <li v-if="!$auth.loggedIn">
              <nuxt-link to="/login">Login</nuxt-link>
            </li>
            <li v-if="!$auth.loggedIn">
              <nuxt-link to="/signup">Signup</nuxt-link>
            </li>
            <li><nuxt-link to="/products">Products</nuxt-link></li>
            <li><nuxt-link to="/contact">Contact</nuxt-link></li>
          </ul>
        </div>

        <div class="col-lg-5 col-md-6">
          <ul class="top-header-right-nav">
            <li><nuxt-link to="/cart">Cart</nuxt-link></li>
            <li>
              <div class="languages-list">
                <select>
                  <option value="1">Eng</option>
                  <option value="2">BN</option>
                </select>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
  <!-- End Top Header Area -->
</template>