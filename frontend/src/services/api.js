import { API_URL } from '@/utils';
import axios from 'axios';

const api = axios.create({
  baseURL: API_URL,
  timeout: 10000,
});

api.interceptors.response.use(
  (response) => {
    return response;
  },
  (error) => {
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
