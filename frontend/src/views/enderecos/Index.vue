<script>
import PageHeader from "@/components/PageHeader.vue";
import PageLayout from "@/components/layouts/PageLayout.vue";
import TablePaginated from "@/components/TablePaginated.vue";
import ConfirmModal from "@/components/ConfirmModal.vue";
import { formatApiSearchParams, formatCEP } from "@/utils";

export default {
  name: "AddressesView",
  components: {
    PageHeader,
    PageLayout,
    TablePaginated,
    ConfirmModal
  },
  computed: {
    items() {
      return this.$store.state.addresses.addresses;
    },
    totalRows() {
      return this.$store.state.pagination.addresses?.totalRows || 0;
    },
    deleteMessage() {
      if (!this.itemToDelete) return '';
      return `Tem certeza que deseja excluir o endereço ${this.itemToDelete.street} de CEP ${this.formatCEP(this.itemToDelete.zip_code)}?`;
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
      ],
      itemToDelete: null
    }
  },
  methods: {
    handleNewAddress() {
      this.$router.push({ name: 'enderecos-form' });
    },
    handleEdit(item) {
      this.$router.push({ name: 'enderecos-form', params: { id: item.id } });
    },
    handleDelete(item) {
      this.itemToDelete = item;
      this.$bvModal.show('delete-modal');
    },
    async confirmDelete() {
      if (!this.itemToDelete) return;
      try {
        await this.$store.dispatch('deleteAddress', { id: this.itemToDelete.id });
        this.itemToDelete = null;
        this.$bvModal.hide('delete-modal');
      } catch (error) {
        console.error('Failed to delete address', error);
      }
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

    <ConfirmModal 
      id="delete-modal"
      title="Excluir Endereço"
      :message="deleteMessage"
      @confirm="confirmDelete"
      @cancel="$bvModal.hide('delete-modal')"
    />
  </PageLayout>
</template>