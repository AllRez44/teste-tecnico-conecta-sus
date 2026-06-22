export const API_URL = process.env.VUE_APP_API_URL;

export const VIA_CEP_API_URL = "https://viacep.com.br/ws/:CEP/json/";

export const BRAZILIAN_STATES = ['AC', 'AL', 'AP', 'AM', 'BA', 'CE', 'DF', 'ES', 'GO', 'MA', 'MT', 'MS', 'MG', 'PA', 'PB', 'PR', 'PE', 'PI', 'RJ', 'RN', 'RS', 'RO', 'RR', 'SC', 'SP', 'SE', 'TO'];

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

export const getOnlyNumbers = (str) => {
  if (!str) return '';
  return String(str).replace(/\D/g, '');
};

export const formatCEP = (cep) => {
  if (!cep) return '-';
  const clean = getOnlyNumbers(cep);
  if (clean.length !== 8) return cep;
  
  return `${clean.slice(0, 5)}-${clean.slice(5)}`;
};

export const formatCPF = (cpf) => {
  if (!cpf) return '-';
  const clean = getOnlyNumbers(cpf);
  if (clean.length !== 11) return cpf;
  
  return `${clean.slice(0, 3)}.${clean.slice(3, 6)}.${clean.slice(6, 9)}-${clean.slice(9)}`;
};

export const formatCNS = (cns) => {
  if (!cns) return '-';
  const clean = getOnlyNumbers(cns);
  if (clean.length !== 15) return cns;
  
  return `${clean.slice(0, 3)} ${clean.slice(3, 7)} ${clean.slice(7, 11)} ${clean.slice(11)}`;
};