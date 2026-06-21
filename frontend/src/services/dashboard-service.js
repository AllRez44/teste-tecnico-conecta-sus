import axios from 'axios';
import {API_URL} from "@/utils";

const api = axios.create({
    baseURL: API_URL + '/patients'
})

export const apiGetDashboard = async() => {
    return api.get('/dashboard');
}