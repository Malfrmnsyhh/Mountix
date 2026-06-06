import apiClient from './api-client';

export const createBooking = async (bookingData) => {
  try {
    const response = await apiClient.post('/booking', bookingData);
    return response.data;
  } catch (error) {
    throw error.response?.data || error.message;
  }
};

export const getMyBookings = async (params = {}) => {
  try {
    const response = await apiClient.get('/booking', { params });
    return response.data;
  } catch (error) {
    throw error.response?.data || error.message;
  }
};

export const getBookingDetail = async (id) => {
  try {
    const response = await apiClient.get(`/booking/${id}`);
    return response.data;
  } catch (error) {
    throw error.response?.data || error.message;
  }
};

window.bookingService = { createBooking, getMyBookings, getBookingDetail };
