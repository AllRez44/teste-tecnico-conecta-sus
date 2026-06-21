<script>
import PageHeader from "@/components/PageHeader.vue";
import PageLayout from "@/components/layouts/PageLayout.vue";
import TablePaginated from "@/components/TablePaginated.vue";
import { formatDate, formatApiSearchParams, formatCPF, formatCNS } from "@/utils";

export default {
  name: "PatientsView",
  components: {
    PageHeader,
    PageLayout,
    TablePaginated
  },
  computed: {
    items() {
      return this.$store.state.patients.patients;
    },
    totalRows() {
      return this.$store.state.pagination.patients?.totalRows || 0;
    }
  },
  data() {
    return {
      fields: [
        { key: 'name', label: 'Nome', thClass: 'font-weight-bold text-dark' },
        { key: 'cpf', label: 'CPF', thClass: 'font-weight-bold text-dark' },
        { key: 'cns', label: 'CNS', thClass: 'font-weight-bold text-dark' },
        { key: 'birth_date', label: 'Data de Nascimento', thClass: 'font-weight-bold text-dark' },
        { key: 'acoes', label: 'Ações', thClass: 'font-weight-bold text-dark text-right', tdClass: 'text-right' }
      ]
    }
  },
  methods: {
    handleNewPatient() {
      console.log('Novo Paciente');
    },
    handleEdit(item) {
      console.log('Editar Paciente', item);
    },
    handleDelete(item) {
      console.log('Excluir Paciente', item);
    },
    async fetchPatients() {
      const searchParams = formatApiSearchParams(this.$route.query);
      await this.$store.dispatch('getPatients', { searchParams });
    },
    formatDate,
    formatCPF,
    formatCNS,
  },
  watch: {
    '$route.query.page': 'fetchPatients',
    '$route.query.search': 'fetchPatients',
  },
  async beforeMount() {
    await this.fetchPatients();
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
    <TablePaginated
      :items="items"
      :fields="fields"
      :total-rows="totalRows"
    >
      <template #cell(cpf)="data">
        {{ formatCPF(data.item.cpf) }}
      </template>
      <template #cell(cns)="data">
        {{ formatCNS(data.item.cns) }}
      </template>
      <template #cell(birth_date)="data">
        {{ formatDate(data.item.birth_date) }}
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

<style scoped>
</style>