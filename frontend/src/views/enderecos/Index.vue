<script>
import PageHeader from "@/components/PageHeader.vue";
import PageLayout from "@/components/PageLayout.vue";

export default {
  name: "AddressesView",
  methods: {
    handleNewAddress() {
      console.log('Novo Endereço');
    },
  },
  components: {
    PageHeader,
    PageLayout,
  }
}
</script>

<template>
  <PageLayout>
    <PageHeader
      title="Gestão de Endereços"
      subtitle="Gerencie os endereços cadastrados no sistema."
    >
      <template #actions>
        <b-button variant="primary" @click="handleNewAddress">
          <b-icon icon="plus" /> Novo Endereço
        </b-button>
      </template>
    </PageHeader>
    <div /> 
  </PageLayout>
</template>

<style scoped>
</style>