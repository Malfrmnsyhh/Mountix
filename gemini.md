#  MOUNTIX - Frontend Development Instructions (Blade + Tailwind CSS)

> **IMPORTANT:** Jangan mengubah instruksi ini tanpa persetujuan. Instruksi ini dirancang untuk konsistensi maksimal.

---

##  PROJECT STATUS

###  COMPLETED
- **Phase 1:** Authentication System (JWT, Register, Login, Refresh Token)
- **Phase 2:** API Endpoints (RESTful - Gunung, Jalur, Booking, Payment, ETicket)
- **Phase 3:** Payment & Booking Logic (Quota validation, payment processing, e-ticket generation)

###  CURRENT PHASE (Phase 4)
- **Phase 4:** Frontend Development with Blade + Tailwind CSS

---

##  TECH STACK REQUIREMENTS

\\\
Framework:          Laravel 12
Template Engine:    Blade (NOT React - Native Laravel)
Styling:           Tailwind CSS 4.0
Icons:             Lucide React (via CDN) or Tabler Icons
State Management:  Blade + JavaScript (AlpineJS for interactivity)
API Integration:   Axios via JavaScript
Database:          SQLite
PHP Version:       8.2+
\\\

---

##  DESIGN SYSTEM & BRANDING

### Color Palette (Wajib Gunakan)
\\\
Primary:           #2D5016 (Forest Green) - CTA, headers
Secondary:         #8B6F47 (Earthy Brown) - Accents, highlights
Neutral Dark:      #475569 (Slate Gray) - Text, borders
Neutral Light:     #F8F8F6 (Off-white) - Backgrounds
Success:           #22C55E (Green) - Status success
Warning:           #EAB308 (Yellow) - Status warning
Danger:            #EF4444 (Red) - Status danger
\\\

### Typography
- **Heading:** Font-size: 24px-48px, Font-weight: 600-700, Family: System fonts
- **Body:** Font-size: 14px-16px, Font-weight: 400, Family: System fonts
- **Caption:** Font-size: 12px-14px, Font-weight: 400, Color: Neutral Gray

### Components Style
- **Cards:** Rounded corners (8px-12px), shadow-md, hover effect scale-105
- **Buttons:** Rounded (6px-8px), padding consistent, smooth transitions (250ms)
- **Inputs:** Border-radius 6px, focus:ring-2, placeholder text gray-400
- **Modals/Dialogs:** Backdrop with opacity, smooth animation

---

##  FOLDER STRUCTURE (Mandatory)

\\\
resources/
 views/
    layouts/
       app.blade.php              # Main layout with navbar & footer
       auth.blade.php             # Auth layout (login/register)
   │    admin.blade.php            # Admin layout (future)
    pages/
       home.blade.php             # Landing page / Home
       auth/
          login.blade.php
          register.blade.php
          forgot-password.blade.php
       gunung/
          index.blade.php        # List all mountains
          show.blade.php         # Mountain detail
       booking/
          create.blade.php       # Booking form
          show.blade.php         # Booking detail
          index.blade.php        # My bookings
       payment/
          create.blade.php       # Payment form
          success.blade.php      # Payment success
       eticket/
          show.blade.php         # E-ticket / QR code display
       profile/
           show.blade.php         # User profile
           edit.blade.php         # Edit profile
    components/
        navbar.blade.php
        footer.blade.php
        card.blade.php
        button.blade.php
        input.blade.php
        modal.blade.php
        alert.blade.php
        loading.blade.php
        pagination.blade.php
 css/
    app.css                        # Tailwind directives
 js/
     app.js                         # Main app JS (Vite entry)
     api-client.js                  # Axios config with JWT
     auth.js                        # Auth functions
     utils.js                       # Helper functions
\\\

---

##  CRITICAL IMPLEMENTATION RULES

### 1. **JWT Authentication in JavaScript**
\\\javascript
// File: resources/js/api-client.js

import axios from 'axios';

const apiClient = axios.create({
  baseURL: '/api/v1',
  timeout: 10000,
});

// Interceptor: Attach JWT token to every request
apiClient.interceptors.request.use((config) => {
  const token = localStorage.getItem('auth_token');
  if (token) {
    config.headers.Authorization = \Bearer \\;
  }
  return config;
});

// Interceptor: Handle 401 errors (token expired)
apiClient.interceptors.response.use(
  (response) => response,
  async (error) => {
    if (error.response?.status === 401) {
      // Clear token and redirect to login
      localStorage.removeItem('auth_token');
      localStorage.removeItem('user');
      window.location.href = '/login';
    }
    return Promise.reject(error);
  }
);

export default apiClient;
\\\

### 2. **Store JWT Token After Login**
\\\javascript
// After successful login API call:
localStorage.setItem('auth_token', response.data.token);
localStorage.setItem('user', JSON.stringify(response.data.user));
\\\

### 3. **Check Authentication State in Blade**
\\\lade
@if(\ = auth()->check())
    {{-- User logged in --}}
    <span>Welcome, {{ auth()->user()->name }}</span>
@else
    {{-- User not logged in --}}
    <a href="/login">Login</a>
@endif
\\\

### 4. **Redirect Unauthenticated Users**
\\\lade
@guest
    <script>
        window.location.href = '/login';
    </script>
@endguest
\\\

### 5. **API Error Handling Pattern**
\\\javascript
try {
  const response = await apiClient.get('/gunung');
  // Handle success
} catch (error) {
  if (error.response?.status === 404) {
    showAlert('Data not found', 'error');
  } else if (error.response?.status === 403) {
    showAlert('Unauthorized', 'error');
  } else {
    showAlert('Something went wrong', 'error');
  }
}
\\\

### 6. **Responsive Design - Mobile First**
\\\lade
<!-- Example: Grid responsive -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
    <!-- Items here -->
</div>

<!-- Example: Hidden on mobile -->
<div class="hidden md:block">
    <!-- Desktop only -->
</div>
\\\

---

##  IMPLEMENTATION ROADMAP

### **STEP 1: Layout Components (Foundation)**
Build reusable layouts and components first:
- [ ] \layouts/app.blade.php\ - Main layout with navbar, footer
- [ ] \components/navbar.blade.php\ - Navigation bar
- [ ] \components/footer.blade.php\ - Footer
- [ ] \components/card.blade.php\ - Reusable card component
- [ ] \components/button.blade.php\ - Button component
- [ ] \components/input.blade.php\ - Input field component
- [ ] \components/alert.blade.php\ - Alert notifications
- [ ] \components/loading.blade.php\ - Loading spinner

### **STEP 2: Authentication Pages**
- [ ] \pages/auth/login.blade.php\ - Login form with validation
- [ ] \pages/auth/register.blade.php\ - Register form
- [ ] \pages/auth/forgot-password.blade.php\ - Forgot password form
- [ ] \esources/js/auth.js\ - Auth API functions

### **STEP 3: Main Pages**
- [ ] \pages/home.blade.php\ - Landing page with hero & gunung list
- [ ] \pages/gunung/index.blade.php\ - Browse all mountains
- [ ] \pages/gunung/show.blade.php\ - Mountain detail page
- [ ] \pages/profile/show.blade.php\ - User profile

### **STEP 4: Booking Flow**
- [ ] \pages/booking/create.blade.php\ - Booking form
- [ ] \pages/booking/index.blade.php\ - My bookings list
- [ ] \pages/booking/show.blade.php\ - Booking detail

### **STEP 5: Payment & E-Ticket**
- [ ] \pages/payment/create.blade.php\ - Payment form
- [ ] \pages/payment/success.blade.php\ - Payment success page
- [ ] \pages/eticket/show.blade.php\ - E-ticket with QR code display

### **STEP 6: Advanced Features**
- [ ] Pagination component
- [ ] Search & filter functionality
- [ ] Image upload handling
- [ ] Print/Download e-ticket

---

##  PAGE SPECIFICATIONS

### **1. Home Page (\pages/home.blade.php\)**
**Purpose:** Landing page, search, browse popular mountains

**Sections:**
- Hero Banner (background image, search bar)
- Search Bar (input: mountain name, location, difficulty)
- Popular Mountains (grid of 3-6 mountains)
- Testimonials (optional)
- Call-to-Action (browse all mountains)

**Features:**
- Responsive grid (1 col mobile, 2 cols tablet, 3 cols desktop)
- Search form with AJAX filtering
- Mountain cards showing: name, image, rating, price
- Mobile hamburger menu

---

### **2. Login Page (\pages/auth/login.blade.php\)**
**Purpose:** User authentication

**Form Fields:**
- Email input (required, email validation)
- Password input (required)
- "Remember me" checkbox
- Login button
- Links: Register, Forgot password

**Functionality:**
- Form validation (client & server)
- Show/hide password toggle
- Loading state on submit
- Error messages display
- Redirect to home on success
- Store JWT token

---

### **3. Register Page (\pages/auth/register.blade.php\)**
**Purpose:** New user registration

**Form Fields:**
- Name (required)
- Email (required, email validation)
- Phone (required, optional regex)
- Password (required, min 8 chars)
- Confirm Password (required, must match)
- Terms checkbox
- Register button

**Functionality:**
- Client-side validation
- Show password strength meter
- Check email availability (real-time)
- Error handling
- Redirect to login on success

---

### **4. Mountain List Page (\pages/gunung/index.blade.php\)**
**Purpose:** Browse all mountains with filters

**Layout:**
- Sidebar filters (on desktop, collapsible on mobile)
- Grid of mountain cards (3 columns)
- Pagination at bottom

**Filters:**
- Difficulty level (Pemula, Menengah, Expert)
- Price range (slider)
- Location/Region (dropdown)
- Rating (stars)

**Card Content:**
- Mountain image
- Mountain name
- Difficulty badge
- Rating ()
- Price (starting from)
- "View Detail" button

---

### **5. Mountain Detail Page (\pages/gunung/show.blade.php\)**
**Purpose:** Show complete mountain info & routes

**Sections:**
- Hero image (full width)
- Mountain name, location, description
- Difficulty, altitude, duration
- Routes available (table/cards)
- Reviews/Ratings section
- "Book Now" button (CTA)

**Routes Section:**
- List all routes for this mountain
- Show route name, difficulty, price, available quota
- "Select Route" button  goes to booking

---

### **6. Booking Form (\pages/booking/create.blade.php\)**
**Purpose:** Create new booking

**Form Sections:**
1. **Route Selection**
   - Display selected route info
   - Date picker (prevent past dates)
   - Difficulty and pricing

2. **Participants**
   - Number of participants (counter)
   - Participant details (name, age, emergency contact)
   - Dynamic form rows based on participant count

3. **Additional Services** (optional)
   - Tent rental, equipment rental, guide upgrade
   - Checkboxes with pricing

4. **Price Summary**
   - Itemized breakdown
   - Total price calculation
   - Proceed to payment button

**Validations:**
- Date must be in future
- At least 1 participant
- All required fields filled

---

### **7. Payment Page (\pages/payment/create.blade.php\)**
**Purpose:** Process payment

**Content:**
- Booking summary (mountain, date, participants, total)
- Payment method selection (Stripe/PayPal/Manual Transfer)
- Payment form (card details for Stripe)
- Terms & conditions checkbox
- "Complete Payment" button

**After Payment:**
- Show success message
- Display e-ticket with QR code
- Option to download PDF

---

### **8. E-Ticket Page (\pages/eticket/show.blade.php\)**
**Purpose:** Display e-ticket & QR code

**Content:**
- Ticket header (Mountix branding)
- Booking details (date, mountain, route, participants)
- Ticket code (unique identifier)
- QR code (scannable)
- Download/Print buttons

**Design:**
- Professional look (suitable for printing)
- Large QR code (easy to scan)
- Clear ticket code

---

### **9. User Profile Page (\pages/profile/show.blade.php\)**
**Purpose:** View user information

**Sections:**
- Profile picture
- User details (name, email, phone)
- Edit profile button
- My bookings link
- My e-tickets link
- Change password link
- Logout button

---

##  ROUTES REQUIRED (Add to routes/web.php)

\\\php
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/gunung', [GunungController::class, 'index'])->name('gunung.index');
Route::get('/gunung/{id}', [GunungController::class, 'show'])->name('gunung.show');

// Auth Routes (Must be in guest middleware)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
    Route::get('/register', [AuthController::class, 'registerForm'])->name('register');
    Route::get('/forgot-password', [AuthController::class, 'forgotForm'])->name('password.request');
});

// Protected Routes (Require authentication)
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    
    Route::get('/booking/create', [BookingController::class, 'create'])->name('booking.create');
    Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');
    Route::get('/booking', [BookingController::class, 'index'])->name('booking.index');
    Route::get('/booking/{booking}', [BookingController::class, 'show'])->name('booking.show');
    
    Route::get('/payment/{booking}', [PaymentController::class, 'create'])->name('payment.create');
    Route::post('/payment/{booking}', [PaymentController::class, 'store'])->name('payment.store');
    Route::get('/payment/{booking}/success', [PaymentController::class, 'success'])->name('payment.success');
    
    Route::get('/eticket/{booking}', [ETicketController::class, 'show'])->name('eticket.show');
    Route::get('/eticket/{booking}/download', [ETicketController::class, 'download'])->name('eticket.download');
});
\\\

---

##  JAVASCRIPT & API CLIENT SETUP

### **Setup Axios with JWT (\esources/js/api-client.js\)**
\\\javascript
import axios from 'axios';

const apiClient = axios.create({
  baseURL: import.meta.env.VITE_API_BASE_URL || '/api/v1',
});

// Request interceptor: Add JWT token
apiClient.interceptors.request.use(
  (config) => {
    const token = localStorage.getItem('auth_token');
    if (token) {
      config.headers.Authorization = \Bearer \\;
    }
    return config;
  },
  (error) => Promise.reject(error)
);

// Response interceptor: Handle errors
apiClient.interceptors.response.use(
  (response) => response,
  (error) => {
    if (error.response?.status === 401) {
      localStorage.removeItem('auth_token');
      localStorage.removeItem('user');
      window.location.href = '/login';
    }
    return Promise.reject(error);
  }
);

export default apiClient;
\\\

### **Main App JS (\esources/js/app.js\)**
\\\javascript
import './bootstrap';
import apiClient from './api-client.js';

// Make apiClient globally available
window.apiClient = apiClient;

// Global error handler
window.showAlert = (message, type = 'info') => {
  const alert = document.createElement('div');
  alert.className = \lert alert-\\;
  alert.textContent = message;
  document.body.appendChild(alert);
  
  setTimeout(() => alert.remove(), 3000);
};

// Expose for use in Blade
window.loadMountains = async () => {
  try {
    const response = await apiClient.get('/gunung');
    return response.data;
  } catch (error) {
    window.showAlert('Failed to load mountains', 'error');
  }
};
\\\

---

##  CRITICAL CHECKLIST

###  Before Implementation
- [ ] Verify all API endpoints in \/api.php\ are working
- [ ] Test JWT token generation and refresh
- [ ] Verify CORS headers if frontend is on different domain
- [ ] Check all model relationships (Booking  BookingMember, Payment, etc.)
- [ ] Verify SANCTUM or JWT configuration in Laravel

###  During Implementation
- [ ] Use Tailwind utility classes (NO custom CSS unless absolutely needed)
- [ ] Test responsive design on mobile (375px width minimum)
- [ ] Test all forms with validation
- [ ] Test error scenarios (404, 500, 401, 403)
- [ ] Ensure JWT token persists and refreshes correctly
- [ ] Check DevTools Network tab - JWT must be in Authorization header

###  Before Delivery
- [ ] All pages load without errors (no 404s)
- [ ] All API calls include JWT token (check DevTools Network)
- [ ] Forms validate and submit correctly
- [ ] Responsive design works (mobile 375px, tablet 768px, desktop 1024px+)
- [ ] No console errors or warnings
- [ ] Navigation works (navbar, links, redirects)
- [ ] Login/logout flow works end-to-end
- [ ] Booking flow works completely
- [ ] Payment simulation works
- [ ] E-ticket displays correctly

---

##  SUCCESS CRITERIA

After completing Phase 4, system should:
-  Users can register with email verification
-  Users can login/logout securely with JWT
-  Browse mountains with search and filters
-  View mountain details with routes
-  Make bookings with participant details
-  Process payments (mock or real gateway)
-  View e-tickets with QR codes
-  Manage user profiles
-  Mobile-friendly on all screens
-  Smooth animations and transitions
-  Professional, modern design
-  Proper error handling
-  Fast loading times

---

**Last Updated:** June 6, 2026
**Version:** 1.0
**Status:** Ready for implementation with Gemini CLI
