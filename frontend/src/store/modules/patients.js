import { apiGetPatient, apiGetPatients, apiPostPatient, apiDeletePatient, apiPutPatient } from "@/services/patients.service";

export const patientsStore = {
    state: () => ({
        /**
         * @type {{ id: number, name: string, cpf: string, cns: string, birth_date: string, gender: string, phone?: string, address_id: number }[]}
         */
        patients: [],
        /**
         * @type {{ id: number, name: string, cpf: string, cns: string, birth_date: string, gender: string, phone: string, address_id: number }}
         */
        patient: {},
    }),
    getters: {
    },
    mutations: {
        setPatients(state, patients) {
            state.patients = patients;
        },
        setPatient(state, patient) {
            state.patient = patient;
        },
        removePatient(state, id) {
            state.patients = state.patients.filter(p => p.id !== id);
        }
    },
    actions: {
        async getPatients({ commit }, { searchParams } = {}) {
            try {
                const response = await apiGetPatients({ searchParams });
                commit('setPatients', response.data.data);
            } catch (error) {
                if (searchParams) {
                    console.error(`Error fetching patients with search params: ${searchParams}\n Error:`, error);
                } else {
                    console.error(`Error fetching patients: \n Error:`, error);
                }
                throw error;
            }
        },
        async getPatient({ commit }, { id }) {
            try {
                const response = await apiGetPatient({ id });
                commit('setPatient', response.data);
            } catch (error) {
                console.error(`Error fetching patient ID ${id}: `, error);
                throw error;
            }
        },
        async postPatient({ commit }, { patient }) {
            try {
                const response = await apiPostPatient({ patient });
                commit('setPatient', response.data);
            } catch (error) {
                console.error(`Error posting patient: ${JSON.stringify(patient.toString())} \n Error:`, error);
                throw error;
            }
        },
        async putPatient({ commit }, { id, patient }) {
            try {
                const response = await apiPutPatient({ id, patient });
                commit('setPatient', response.data);
            } catch (error) {
                console.error(`Error putting patient ID ${id}: `, error);
                throw error;
            }
        },
        async deletePatient({ commit, dispatch }, { id }) {
            try {
                await apiDeletePatient({ id });
                commit('removePatient', id);
            } catch (error) {
                const defaultErrorMessage = 'Erro ao excluir paciente';   
                if (error.response?.data?.errors?.patient?.length) {
                    const patientErrors = error.response?.data?.errors?.patient;
                    dispatch('showError', patientErrors[0] || defaultErrorMessage);
                } else {
                    dispatch('showError', defaultErrorMessage);
                }
                throw error;
            }
        }
    },
}