<script setup>
import AppLayout from "@/components/layouts/AppLayout.vue";
import GlobalLoader from "@/components/GlobalLoader.vue";
</script>

<template>
  <div id="app">
    <GlobalLoader v-if="$store.state.isLoading" />
    <AppLayout>
      <router-view/>
    </AppLayout>
  </div>
</template>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
}
</style>
