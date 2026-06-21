import Vue from 'vue'
import Vuex from 'vuex'
import { addressesStore } from "@/store/modules/addresses";
import { patientsStore } from "@/store/modules/patients";
import { apiGetDashboard } from "@/services/dashboard.service";


Vue.use(Vuex)

export default new Vuex.Store({
  state: {
    isLoading: false,
    errorMessage: null,
    /** @type {{ total_patients: number, total_addresses: number }} **/
    summary: {},
    /** @type {{ [key: string]: { totalRows: undefined } }} **/
    pagination: {},
  },
  getters: {
    totalPatientsCount: (state) => state.summary.total_patients,
    totalAddressesCount: (state) => state.summary.total_addresses,
  },
  mutations: {
    setLoading(state, status) {
      state.isLoading = status;
    },
    setErrorMessage(state, message) {
      state.errorMessage = message;
    },
    setSummary(state, summary) {
      state.summary = summary;
    },
    setTotalRows(state, { module, totalRows }) {
      if (!state.pagination[module]) {
        Vue.set(state.pagination, module, {});
      }
      Vue.set(state.pagination[module], 'totalRows', totalRows);
    },
  },
  actions: {
    async getSummary({ commit }) {
      try {
        const response = await apiGetDashboard();
        commit('setSummary', response.data);
      } catch (error) {
        console.error(`Error fetching dashboard summary: \n Error:`, error);
        throw error;
      }
    },
    showError({ commit }, message) {
      commit('setErrorMessage', message);
    }
  },
  modules: {
    addresses: addressesStore,
    patients: patientsStore,
  }
})
