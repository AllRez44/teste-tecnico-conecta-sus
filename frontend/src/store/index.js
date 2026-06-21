import Vue from 'vue'
import Vuex from 'vuex'
import { addressesStore } from "@/store/modules/addresses";
import { patientsStore } from "@/store/modules/patients";
import { apiGetDashboard } from "@/services/dashboard.service";


Vue.use(Vuex)

export default new Vuex.Store({
  state: {
    isLoading: false,
    /** @type {{ total_patients: number, total_addresses: number }} **/
    summary: {}
  },
  getters: {
    getSummary() {
      return this.summary;
    }
  },
  mutations: {
    setLoading(state, status) {
      state.isLoading = status;
    },
    setSummary(state, summary) {
      state.summary = summary;
    }
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
  },
  modules: {
    addresses: addressesStore,
    patient: patientsStore,
  }
})
