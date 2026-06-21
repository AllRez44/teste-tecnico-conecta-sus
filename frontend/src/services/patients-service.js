import axios from 'axios';
import {API_URL} from "@/utils";

const api = axios.create({
    baseURL: API_URL + '/patients'
})

export const apiGetPatients = async({searchParams}) => {
    return api.get(searchParams);
}

export const apiGetPatient = async({ id }) => {
    return api.get('/' + id);
}

export const apiPostPatient = async({ patient }) => {
    return await api.post('/', patient);
}
