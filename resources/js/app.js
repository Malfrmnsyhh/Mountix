import './bootstrap';
import './auth';
import './navbar';
import './hero';
import './animations';
import './gunung';
import './booking';
import './payment';
import apiClient from './api-client';

window.apiClient = apiClient;

// Global Alert Handler
window.showAlert = (message, type = 'success') => {
    const bgClass = type === 'success' ? 'bg-success' : 'bg-danger';
    const alert = document.createElement('div');
    alert.className = `${bgClass} text-white px-6 py-3 rounded-lg shadow-2xl fixed bottom-8 right-8 z-[100] transition-all duration-300 transform translate-y-20`;
    alert.innerHTML = `
        <div class="flex items-center space-x-3">
            <span class="font-medium">${message}</span>
        </div>
    `;
    document.body.appendChild(alert);
    
    // Animate in
    setTimeout(() => {
        alert.classList.remove('translate-y-20');
        alert.classList.add('translate-y-0');
    }, 100);

    // Auto remove
    setTimeout(() => {
        alert.classList.add('translate-y-20', 'opacity-0');
        setTimeout(() => alert.remove(), 300);
    }, 4000);
};
