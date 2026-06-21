import api from './api';

export const apiGetAddresses = async({searchParams}) => {
    return api.get('/addresses' + (searchParams || ''));
}

export const apiGetAddress = async({ id }) => {
    return api.get('/addresses/' + id);
}

export const apiPostAddress = async({ addresses }) => {
    return await api.post('/addresses', addresses);
}
