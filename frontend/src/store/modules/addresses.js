import { apiGetAddress, apiGetAddresses, apiPostAddress, apiDeleteAddress, apiPutAddress } from "@/services/addresses.service";

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
        },
        removeAddress(state, id) {
            state.addresses = state.addresses.filter(a => a.id !== id);
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
        async postAddress({ commit }, { address }) {
            try {
                const response = await apiPostAddress({ address });
                commit('setAddress', response.data);
            } catch (error) {
                console.error(`Error posting address: ${JSON.stringify(address.toString())} \n Error:`, error);
                throw error;
            }
        },
        async putAddress({ commit }, { id, address }) {
            try {
                const response = await apiPutAddress({ id, address });
                commit('setAddress', response.data);
            } catch (error) {
                console.error(`Error putting address ID ${id}: `, error);
                throw error;
            }
        },
        async deleteAddress({ commit, dispatch }, { id }) {
            try {
                await apiDeleteAddress({ id });
                commit('removeAddress', id);
            } catch (error) {
                console.error(`Error deleting address ID ${id}: `, error);
                const defaultErrorMessage = 'Erro ao excluir endereço';
                if (error.response?.data?.errors?.address?.length) {
                    const addressErrors = error.response?.data?.errors?.address;
                    dispatch('showError', addressErrors[0] || defaultErrorMessage);
                } else {
                    dispatch('showError', defaultErrorMessage);
                }
                throw error;
            }
        }
    },
}