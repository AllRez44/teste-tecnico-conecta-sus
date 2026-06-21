<template>
  <div class="global-loader-overlay">
    <div class="loader-content">
      <b-spinner label="Carregando..." variant="primary" style="width: 3rem; height: 3rem;"></b-spinner>
      <span class="mt-3 fs-5">Carregando...</span>
    </div>
  </div>
</template>

<script setup>
// Loader simples usando o b-spinner do BootstrapVue
</script>

<style scoped>
.global-loader-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100vw;
  height: 100vh;
  background-color: rgba(255, 255, 255, 0.8); /* Fundo branco levemente transparente */
  z-index: 9999; /* Para ficar por cima de tudo */
  display: flex;
  justify-content: center;
  align-items: center;
}

.loader-content {
  display: flex;
  flex-direction: column;
  align-items: center;
  font-weight: bold;
  color: #007bff; /* Cor primária do bootstrap */
}
</style>
