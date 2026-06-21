<template>
  <PageLayout>
    <PageHeader
      :title="isEdit ? 'Editar Endereço' : 'Novo Endereço'"
      :subtitle="isEdit ? 'Edite os dados do endereço.' : 'Cadastre um novo endereço no sistema.'"
    />
    <div />
  </PageLayout>
</template>

<script>
import PageHeader from "@/components/PageHeader.vue";
import PageLayout from "@/components/layouts/PageLayout.vue";

export default {
  name: "AddressFormView",
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
