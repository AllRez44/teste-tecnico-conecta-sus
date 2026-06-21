<script>
import PageHeader from "@/components/PageHeader.vue";
import PageLayout from "@/components/layouts/PageLayout.vue";
import TablePaginated from "@/components/TablePaginated.vue";
import { formatApiSearchParams, formatCEP } from "@/utils";

export default {
  name: "AddressesView",
  components: {
    PageHeader,
    PageLayout,
    TablePaginated
  },
  computed: {
    items() {
      return this.$store.state.addresses.addresses;
    },
    totalRows() {
      return this.$store.state.pagination.addresses?.totalRows || 0;
    }
  },
  data() {
    return {
      fields: [
        { key: 'zip_code', label: 'CEP', thClass: 'font-weight-bold text-dark' },
        { key: 'street', label: 'Logradouro', thClass: 'font-weight-bold text-dark' },
        { key: 'neighborhood', label: 'Bairro', thClass: 'font-weight-bold text-dark' },
        { key: 'city', label: 'Cidade', thClass: 'font-weight-bold text-dark' },
        { key: 'state', label: 'UF', thClass: 'font-weight-bold text-dark' },
        { key: 'acoes', label: 'Ações', thClass: 'font-weight-bold text-dark text-right', tdClass: 'text-right' }
      ]
    }
  },
  methods: {
    handleNewAddress() {
      console.log('Novo Endereço');
    },
    handleEdit(item) {
      console.log('Editar', item);
    },
    handleDelete(item) {
      console.log('Excluir', item);
    },
    async fetchAddresses() {
      const searchParams = formatApiSearchParams(this.$route.query);
      await this.$store.dispatch('getAddresses', { searchParams });
    },
    formatCEP
  },
  watch: {
    '$route.query.page': 'fetchAddresses',
    '$route.query.search': 'fetchAddresses',
  },
  async beforeMount() {
    await this.fetchAddresses();
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
    
    <TablePaginated
      :items="items"
      :fields="fields"
      :total-rows="totalRows"
    >
      <template #cell(zip_code)="data">
        {{ formatCEP(data.item.zip_code) }}
      </template>
      <template #cell(acoes)="data">
        <b-button variant="link" class="p-0 mr-3 text-primary" @click="handleEdit(data.item)">
          <b-icon icon="pencil" font-scale="1.2" />
        </b-button>
        <b-button variant="link" class="p-0 text-danger" @click="handleDelete(data.item)">
          <b-icon icon="trash" font-scale="1.2" />
        </b-button>
      </template>
    </TablePaginated>
  </PageLayout>
</template>