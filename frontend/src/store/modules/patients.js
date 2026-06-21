import { apiGetPatient, apiGetPatients, apiPostPatient } from "@/services/patients.service";

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
                    throw error;
                }
                console.error(`Error fetching patients: \n Error:`, error);
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
        }
    },
}