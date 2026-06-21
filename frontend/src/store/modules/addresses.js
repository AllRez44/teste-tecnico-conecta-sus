import {apiGetAddress, apiGetAddresses, apiPostAddress} from "@/services/addresses.service";

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
        getAllAddresses() {
            return this.addresses;
        },
        getAddress() {
            return this.address;
        }
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
        async getAddresses({ searchParams }) {
            try {
                const response = await apiGetAddresses({searchParams});
                this.commit('setAddresses', response.data);
            } catch (error) {
                if (searchParams) {
                    console.error(`Error fetching addresses with search params: ${searchParams}\n Error:`, error);
                    throw error;
                }
                console.error(`Error fetching addresses: \n Error:`, error);
                throw error;
            }
        },
        async getAddress({ id }) {
            try {
                const response = await apiGetAddress({ id });
                this.commit('setAddress', response.data);
            } catch (error) {
                console.error(`Error fetching address ID ${id}: `, error);
                throw error;
            }
        },
        async postAddress({ patient }) {
            try {
                const response = await apiPostAddress({ patient });
                this.commit('setAddress', response.data);
            } catch (error) {
                console.error(`Error posting address: ${JSON.stringify(patient.toString())} \n Error:`, error);
                throw error;
            }
        }
    },
}