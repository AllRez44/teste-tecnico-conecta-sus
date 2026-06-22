<template>
  <PageLayout>
    <PageHeader
      :title="isEdit ? 'Editar Endereço' : 'Novo Endereço'"
      :subtitle="isEdit ? 'Edite os dados do endereço.' : 'Cadastre um novo endereço no sistema.'"
    />
    <FormAddress @submit="handleSubmit" @cancel="handleCancel" />
  </PageLayout>
</template>

<script>
import PageHeader from "@/components/PageHeader.vue";
import PageLayout from "@/components/layouts/PageLayout.vue";
import FormAddress from "@/components/FormAddress.vue";

export default {
  name: "AddressFormView",
  components: {
    PageHeader,
    PageLayout,
    FormAddress
  },
  computed: {
    isEdit() {
      return !!this.$route.params.id;
    }
  },
  async mounted() {
    if (this.isEdit) {
      try {
        await this.$store.dispatch('getAddress', { id: this.$route.params.id });
      } catch (error) {
        this.$router.push({ name: 'enderecos' });
        this.$store.dispatch('showError', 'Endereço não encontrado.');
      }
    } else {
      this.$store.commit('setAddress', {});
    }
  },
  methods: {
    async handleSubmit(addressData) {
      try {
        if (this.isEdit) {
          await this.$store.dispatch('putAddress', { id: this.$route.params.id, address: addressData });
          this.$store.dispatch('showSuccess', 'Endereço atualizado com sucesso.');
        } else {
          await this.$store.dispatch('postAddress', { address: addressData });
          this.$store.dispatch('showSuccess', 'Endereço criado com sucesso.');
        }
        this.$router.push({ name: 'enderecos' });
      } catch (error) {
        console.error('Erro ao salvar endereço: ', error);
      }
    },
    handleCancel() {
      this.$router.push({ name: 'enderecos' });
    }
  }
}
</script>
