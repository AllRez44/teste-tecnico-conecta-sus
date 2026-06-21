<template>
  <div class="position-fixed" style="bottom: 20px; right: 20px; z-index: 1050;">
    <b-toast 
      v-model="hasError" 
      variant="danger" 
      solid
      title="Erro"
    >
      {{ errorMessage }}
    </b-toast>
  </div>
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
