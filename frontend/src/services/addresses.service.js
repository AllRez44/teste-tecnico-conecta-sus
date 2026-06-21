import api from './api';
import store from '@/store';

export const apiGetAddresses = async({searchParams}) => {
    const response = await api.get('/addresses' + (searchParams || ''));
    if (response.data && response.data.total !== undefined) {
        store.commit('setTotalRows', { module: 'addresses', totalRows: response.data.total });
    }
    return response;
}

export const apiGetAddress = async({ id }) => {
    return api.get('/addresses/' + id);
}

export const apiPostAddress = async({ addresses }) => {
    return await api.post('/addresses', addresses);
}
