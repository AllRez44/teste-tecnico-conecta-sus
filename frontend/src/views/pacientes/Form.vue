<template>
  <PageLayout>
    <PageHeader
      :title="isEdit ? 'Editar Paciente' : 'Novo Paciente'"
      :subtitle="isEdit ? 'Edite os dados do paciente.' : 'Cadastre um novo paciente no sistema.'"
    />
    <FormPatient :api-errors="apiErrors" @submit="handleSubmit" @cancel="handleCancel" />
  </PageLayout>
</template>

<script>
import PageHeader from "@/components/PageHeader.vue";
import PageLayout from "@/components/layouts/PageLayout.vue";
import FormPatient from "@/components/FormPatient.vue";

export default {
  name: "PatientFormView",
  components: {
    PageHeader,
    PageLayout,
    FormPatient
  },
  data() {
    return {
      apiErrors: {}
    }
  },
  computed: {
    isEdit() {
      return !!this.$route.params.id;
    }
  },
  async mounted() {
    if (this.isEdit) {
      try {
        await this.$store.dispatch('getPatient', { id: this.$route.params.id });
      } catch (error) {
        this.$router.push({ name: 'pacientes' });
        this.$store.dispatch('showError', 'Paciente não encontrado.');
      }
    } else {
      this.$store.commit('setPatient', {});
    }
  },
  methods: {
    async handleSubmit(patientData) {
      this.apiErrors = {};
      try {
        if (this.isEdit) {
          await this.$store.dispatch('putPatient', { id: this.$route.params.id, patient: patientData });
        } else {
          await this.$store.dispatch('postPatient', { patient: patientData });
        }
        this.$router.push({ name: 'pacientes' });
      } catch (error) {
        if (error.response && error.response.status === 422) {
          this.apiErrors = error.response.data.errors || {};
        } else {
        // TODO: Implement Error handling
        }
      }
    },
    handleCancel() {
      this.$router.push({ name: 'pacientes' });
    }
  }
}
</script>
