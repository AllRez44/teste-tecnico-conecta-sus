import { apiGetAddress, apiGetAddresses, apiPostAddress } from "@/services/addresses.service";

export const addressesStore = {
    state: () => ({
        /**
         * @type {{ id: number, street: string, zip_code: string, neighborhood: string, city: string, city: string, state: string }[]}
         */
        addresses: [],
        /**
         * @type {{ id: number, street: string, zip_code: string, neighborhood: string, city: string, city: string, state: string }}
         */
        address: {},
    }),
    getters: {
    },
    mutations: {
        setAddresses(state, addresses) {
            state.addresses = addresses;
        },
        setAddress(state, address) {
            state.address = address;
        }
    },
    actions: {
        async getAddresses({ commit }, { searchParams } = {}) {
            try {
                const response = await apiGetAddresses({ searchParams });
                commit('setAddresses', response.data.data);
            } catch (error) {
                if (searchParams) {
                    console.error(`Error fetching addresses with search params: ${searchParams}\n Error:`, error);
                    throw error;
                }
                console.error(`Error fetching addresses: \n Error:`, error);
                throw error;
            }
        },
        async getAddress({ commit }, { id }) {
            try {
                const response = await apiGetAddress({ id });
                commit('setAddress', response.data);
            } catch (error) {
                console.error(`Error fetching address ID ${id}: `, error);
                throw error;
            }
        },
        async postAddress({ commit }, { patient }) {
            try {
                const response = await apiPostAddress({ patient });
                commit('setAddress', response.data);
            } catch (error) {
                console.error(`Error posting address: ${JSON.stringify(patient.toString())} \n Error:`, error);
                throw error;
            }
        }
    },
}