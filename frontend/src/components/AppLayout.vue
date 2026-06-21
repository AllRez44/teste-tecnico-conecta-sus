<template>
  <div>
    <!-- Sidebar -->
    <b-sidebar
      id="app-sidebar"
      class="sidebar"
      visible
      no-header
      no-close-on-route-change
      shadow
      width="260px"
    >
      <div class="p-3 text-center">
        <b-img class="sidebar-logo mb-4" src="@/assets/logo.png" alt="Logo" fluid></b-img>
        <h5 class="text-primary font-weight-bold mb-0" style="cursor: default;">ConectaSUS Admin</h5>
      </div>

      <b-nav vertical pills class="py-4 px-2">
        <b-nav-item 
          to="/dashboard"
          active-class="active bg-primary"
          :link-classes="$route.path.startsWith('/dashboard') ? 'text-light' : 'text-dark'"
        >
          Painel
        </b-nav-item>
        <b-nav-item
          to="/enderecos"
          active-class="active bg-primary"
          :link-classes="$route.path.startsWith('/enderecos') ? 'text-light' : 'text-dark'"
        >
          Endereços
        </b-nav-item>
        <b-nav-item 
          to="/pacientes" 
          active-class="active bg-primary"
          :link-classes="$route.path.startsWith('/pacientes') ? 'text-light' : 'text-dark'"
        >
          Pacientes
        </b-nav-item>
      </b-nav>
    </b-sidebar>
    
    <!-- Navbar -->
    <div class="d-flex flex-column bg-light vh-100" style="margin-left: 260px;">
      <b-navbar type="light" variant="white" class="border-bottom shadow-sm px-4 py-2">
        <b-navbar-nav class="mr-auto">
          <search-bar @search="handleSearch" style="min-width: 360px;"/>
        </b-navbar-nav>
        <b-navbar-nav class="ml-auto d-flex align-items-center">
          <span style="cursor: default;">Profissional de Saúde </span>
          <b-avatar class="ml-3" style="cursor: pointer;" />
        </b-navbar-nav>
      </b-navbar>

      <!-- Main Content -->
      <div class="flex-grow-1 p-4 overflow-auto">
        <slot />
      </div>
    </div>
  </div>
</template>

<script>
import SearchBar from './SearchBar.vue';

export default {
  name: 'AppLayout',
  components: {
    SearchBar
  },
  methods: {
    handleSearch(value) {
      const query = { ...this.$route.query };

      if (value) {
        query.search = value;
      } else {
        delete query.search;
      }

      this.$router.push({ query }).catch(err => {
        if (err.name !== 'NavigationDuplicated') {
          throw err;
        }
      });
    }
  }
}
</script>

<style scoped>
</style>