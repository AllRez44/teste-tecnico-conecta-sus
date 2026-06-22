import api from './api';
import store from '@/store';

export const apiGetAddresses = async({searchParams, axiosOptions}) => {
    const response = await api.get('/addresses' + (searchParams || ''), axiosOptions);
    if (response.data && response.data.total !== undefined) {
        store.commit('setTotalRows', { module: 'addresses', totalRows: response.data.total });
    }
    return response;
}

export const apiGetAddress = async({ id }) => {
    return api.get('/addresses/' + id);
}

export const apiPostAddress = async({ address }) => {
    return await api.post('/addresses', address);
}

export const apiPutAddress = async({ id, address }) => {
    return await api.put('/addresses/' + id, address);
}

export const apiDeleteAddress = async({ id }) => {
    return await api.delete('/addresses/' + id);
}
