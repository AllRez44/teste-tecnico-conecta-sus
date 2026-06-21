import api from './api';

export const apiGetPatients = async({searchParams}) => {
    return api.get('/patients' + (searchParams || ''));
}

export const apiGetPatient = async({ id }) => {
    return api.get('/patients/' + id);
}

export const apiPostPatient = async({ patient }) => {
    return await api.post('/patients', patient);
}
