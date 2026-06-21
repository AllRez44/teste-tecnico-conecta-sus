<template>
  <PageLayout>
    <PageHeader
      :title="isEdit ? 'Editar Paciente' : 'Novo Paciente'"
      :subtitle="isEdit ? 'Edite os dados do paciente.' : 'Cadastre um novo paciente no sistema.'"
    />
    <div />
  </PageLayout>
</template>

<script>
import PageHeader from "@/components/PageHeader.vue";
import PageLayout from "@/components/layouts/PageLayout.vue";

export default {
  name: "PatientFormView",
  components: {
    PageHeader,
    PageLayout,
  },
  computed: {
    isEdit() {
      return !!this.$route.params.id;
    }
  },
}
</script>
