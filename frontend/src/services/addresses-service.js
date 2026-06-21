import axios from 'axios';
import {API_URL} from "@/utils";

const api = axios.create({
    baseURL: API_URL + '/addresses'
})

export const apiGetAddresses = async({searchParams}) => {
    return api.get(searchParams);
}

export const apiGetAddress = async({ id }) => {
    return api.get('/' + id);
}

export const apiPostAddress = async({ addresses }) => {
    return await api.post('/', addresses);
}
