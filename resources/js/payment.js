import apiClient from './api-client';

export const submitPayment = async (bookingId, paymentData) => {
  try {
    const response = await apiClient.post(`/booking/${bookingId}/payment`, paymentData, {
      headers: {
        'Content-Type': 'multipart/form-data'
      }
    });
    return response.data;
  } catch (error) {
    throw error.response?.data || error.message;
  }
};

export const verifyPayment = async (paymentId, status) => {
  try {
    const response = await apiClient.post(`/admin/payment/${paymentId}/verify`, { status });
    return response.data;
  } catch (error) {
    throw error.response?.data || error.message;
  }
};

window.paymentService = { submitPayment, verifyPayment };
