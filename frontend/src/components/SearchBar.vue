<template>
  <div class="search-bar">
    <b-form-input
      type="search"
      placeholder="Pesquisar..."
      v-model="internalValue"
      @input="onInput"
    ></b-form-input>
  </div>
</template>

<script>
export default {
  name: 'SearchBar',
  data() {
    return {
      internalValue: this.$route.query.search || '',
      timeout: null
    }
  },
  methods: {
    onInput(value) {
      if (this.timeout) {
        clearTimeout(this.timeout);
      }
      this.timeout = setTimeout(() => {
        this.$emit('search', value);
      }, 400);
    }
  }
}
</script>

<style scoped>
.search-bar {
  max-width: 300px;
  width: 100%;
}
</style>
