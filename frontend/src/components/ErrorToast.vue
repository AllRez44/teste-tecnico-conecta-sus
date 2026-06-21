<template>
  <b-toast 
    v-model="hasError" 
    variant="danger" 
    solid
    toaster="b-toaster-bottom-right"
    title="Erro"
  >
    {{ errorMessage }}
  </b-toast>
</template>

<script>
export default {
  name: 'ErrorToast',
  computed: {
    hasError: {
      get() {
        return !!this.$store.state.errorMessage;
      },
      set(val) {
        if (!val) {
          this.$store.commit('setErrorMessage', null);
        }
      }
    },
    errorMessage() {
      return this.$store.state.errorMessage;
    }
  }
}
</script>
