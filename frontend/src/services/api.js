import { API_URL } from '@/utils';
import axios from 'axios';
import store from '@/store';

const api = axios.create({
  baseURL: API_URL,
  timeout: 10000,
});

api.interceptors.request.use(
  (config) => {
    if (!config.silent) {
      store.commit('setLoading', true);
    }
    return config;
  },
  (error) => {
    store.commit('setLoading', false);
    return Promise.reject(error);
  }
);

api.interceptors.response.use(
  (response) => {
    if (!response.config.silent) {
      store.commit('setLoading', false);
    }
    return response;
  },
  (error) => {
    if (!error.config || !error.config.silent) {
      store.commit('setLoading', false);
    }
    if (error.response) {
      console.error(`[API Error] Status: ${error.response.status}`, error.response.data);
    } else if (error.request) {
      console.error('[API Error] Error without response:', error.request);
    } else {
      console.error('[API Error] Error on request:', error.message);
    }

    return Promise.reject(error);
  }
);

export default api;
