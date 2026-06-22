<template>
  <b-toast 
    v-model="hasSuccess" 
    variant="success" 
    solid
    toaster="b-toaster-bottom-right"
    title="Sucesso"
  >
    {{ successMessage }}
  </b-toast>
</template>

<script>
export default {
  name: 'SuccessToast',
  computed: {
    hasSuccess: {
      get() {
        return !!this.$store.state.successMessage;
      },
      set(val) {
        if (!val) {
          this.$store.commit('setSuccessMessage', null);
        }
      }
    },
    successMessage() {
      return this.$store.state.successMessage;
    }
  }
}
</script>
