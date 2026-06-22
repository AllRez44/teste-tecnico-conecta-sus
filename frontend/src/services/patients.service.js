import api from './api';
import store from '@/store';

export const apiGetPatients = async({searchParams}) => {
    const response = await api.get('/patients' + (searchParams || ''));

    if (response.data && response.data.total !== undefined) {
        store.commit('setTotalRows', { module: 'patients', totalRows: response.data.total });
    }
    return response;
}

export const apiGetPatient = async({ id }) => {
    return api.get('/patients/' + id);
}

export const apiPostPatient = async({ patient }) => {
    return await api.post('/patients', patient);
}

export const apiPutPatient = async({ id, patient }) => {
    return await api.put('/patients/' + id, patient);
}

export const apiDeletePatient = async({ id }) => {
    return await api.delete('/patients/' + id);
}
