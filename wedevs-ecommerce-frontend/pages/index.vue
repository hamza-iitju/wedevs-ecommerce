<template>
  <div>
    <Banner></Banner>
    <Offer></Offer>
    <LatestProducts></LatestProducts>
    <ProductCategory></ProductCategory>
    <TrendingProducts></TrendingProducts>
    <BestSellers></BestSellers>
    <Facility></Facility>
  </div>
</template>

<script>
import Banner from "../components/landing-one/Banner";
import Offer from "../components/landing-one/Offer";
import LatestProducts from "../components/landing-one/LatestProducts";
import ProductCategory from "../components/landing-one/ProductCategory";
import TrendingProducts from "../components/landing-one/TrendingProducts";
import BestSellers from "../components/landing-one/BestSellers";
import Facility from "../components/landing-one/Facility";

export default {
  components: {
    Banner,
    Offer,
    LatestProducts,
    ProductCategory,
    TrendingProducts,
    BestSellers,
    Facility,
  },
};
</script>