<template>
  <CheckoutItem />
</template>

<script>
import CheckoutItem from "../components/cart/CheckoutItem";
export default {
  middleware: "auth",
  components: {
    CheckoutItem,
  },
};
</script>