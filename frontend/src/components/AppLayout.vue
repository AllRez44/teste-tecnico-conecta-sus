<script setup>
</script>

<template>
  <div>
    <nav>
      <router-link to="/dashboard">Dashboard</router-link> |
      <router-link to="/enderecos">Endereços</router-link> |
      <router-link to="/pacientes">Pacientes</router-link>
    </nav>
    <slot />
  </div>
</template>

<style>
nav {
  padding: 30px;
}

nav a {
  font-weight: bold;
  color: #2c3e50;
}

nav a.router-link-exact-active {
  color: #42b983;
}
</style>