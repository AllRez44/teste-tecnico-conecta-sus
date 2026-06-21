import api from './api';

export const apiGetDashboard = async() => {
    return api.get('/dashboard');
}