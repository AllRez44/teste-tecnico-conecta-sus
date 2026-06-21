<script>
import PageHeader from "@/components/PageHeader.vue";
import PageLayout from "@/components/layouts/PageLayout.vue";

export default {
  name: "PatientsView",
  methods: {
    handleNewPatient() {
      console.log('Novo Paciente');
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
      title="Gestão de Pacientes"
      subtitle="Gerencie os dados dos pacientes cadastrados no sistema."
    >
      <template #actions>
        <b-button variant="primary" @click="handleNewPatient">
          <b-icon icon="plus" /> Novo Paciente
        </b-button>
      </template>
    </PageHeader>
    <div /> 
  </PageLayout>
</template>

<style scoped>
</style>