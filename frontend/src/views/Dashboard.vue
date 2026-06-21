<template>
  <PageLayout>
    <PageHeader
      title="Visão Geral do Painel"
      subtitle="Métricas em tempo real e atividade recente da rede de saúde."
    />
    <b-row>
      <b-col md="6" class="mb-4 d-flex">
        <b-card class="custom-card shadow-sm w-100">
          <div class="d-flex justify-content-between align-items-start">
            <div>
              <div class="text-muted font-weight-bold text-uppercase mb-3" style="font-size: 0.85rem; letter-spacing: 0.5px;">
                Total de Pacientes
              </div>
              <h1 class="font-weight-bold text-dark mb-0" style="font-size: 2.5rem;">
                {{ formatNumber(patientsCount) }}
              </h1>
            </div>
            <div class="icon-box icon-blue">
              <b-icon icon="person" font-scale="1.4"></b-icon>
            </div>
          </div>
        </b-card>
      </b-col>

      <b-col md="6" class="mb-4 d-flex">
        <b-card class="custom-card shadow-sm w-100">
          <div class="d-flex justify-content-between align-items-start">
            <div>
              <div class="text-muted font-weight-bold text-uppercase mb-3" style="font-size: 0.85rem; letter-spacing: 0.5px;">
                Total de Endereços
              </div>
              <h1 class="font-weight-bold text-dark mb-0" style="font-size: 2.5rem;">
                {{ formatNumber(addressesCount) }}
              </h1>
            </div>
            <div class="icon-box icon-orange">
              <b-icon icon="geo-alt" font-scale="1.3"></b-icon>
            </div>
          </div>
        </b-card>
      </b-col>
    </b-row>
  </PageLayout>
</template>

<script>
import { numberFormatter } from "@/utils";
import PageHeader from "@/components/PageHeader.vue";
import PageLayout from "@/components/layouts/PageLayout.vue";

export default {
  name: "DashboardView",
  components: {
    PageHeader,
    PageLayout
  },
  computed: {
    patientsCount() {
      return this.$store.getters.totalPatientsCount;
    },
    addressesCount() {
      return this.$store.getters.totalAddressesCount;
    }
  },
  methods: {
    formatNumber(val) {
      return val !== undefined 
        ? numberFormatter.format(val)
        : '-';
    }
  },
  async beforeMount() {
    await this.$store.dispatch('getSummary');
  },
}
</script>

<style scoped>
.custom-card {
  border-radius: 8px;
  border: 1px solid #e2e8f0;
}

.icon-box {
  width: 48px;
  height: 48px;
  border-radius: 6px;
  display: flex;
  align-items: center;
  justify-content: center;
}

.icon-blue {
  background-color: #e2e8f0;
  color: #1e3a8a;
}

.icon-orange {
  background-color: #ffedd5;
  color: #9a3412;
}
</style>