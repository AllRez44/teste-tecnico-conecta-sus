export const API_URL = process.env.VUE_APP_API_URL;

export const VIA_CEP_API_URL = "https://viacep.com.br/ws/:CEP/json/";

export const numberFormatter = new Intl.NumberFormat('pt-BR');

export const formatDate = (dateStr) => {
  if (!dateStr) return '-';
  const [year, month, day] = dateStr.split('-');
  return `${day}/${month}/${year}`;
};

export const formatApiSearchParams = (query) => {
  const q = { page: 1, ...query };
  const searchParams = new URLSearchParams(q).toString();
  return searchParams ? `?${searchParams}` : '';
};