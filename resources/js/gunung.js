import apiClient from './api-client';

export const getGunungs = async (params = {}) => {
  try {
    const response = await apiClient.get('/gunung', { params });
    return response.data;
  } catch (error) {
    throw error.response?.data || error.message;
  }
};

export const getGunungDetail = async (id) => {
  try {
    const response = await apiClient.get(`/gunung/${id}`);
    return response.data;
  } catch (error) {
    throw error.response?.data || error.message;
  }
};

window.gunungService = { getGunungs, getGunungDetail };
