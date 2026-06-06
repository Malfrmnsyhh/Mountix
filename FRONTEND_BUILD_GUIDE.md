# 🚀 PANDUAN BUILD FRONTEND DENGAN GEMINI CLI

> **Status:** Project sudah di-restructure ✅
> 
> Sekarang siap untuk STEP-BY-STEP frontend development

---

## 📋 LANGKAH-LANGKAH MEMBANGUN FRONTEND

### ✅ PREREQUISITE: APA SUDAH DILAKUKAN

Gemini CLI sudah berhasil:
- ✅ Membaca semua file project
- ✅ Merestruktur folder architecture
- ✅ Align dengan Laravel 12 conventions
- ✅ Prepare project untuk frontend

**Next:** Sekarang waktunya membangun frontend pages & components

---

## 🎯 CARA MEMBACA INSTRUKSI DAN BUILD

### **METODE 1: COPY-PASTE DARI gemini.md (RECOMMENDED)**

#### Step 1: Buka gemini.md di VS Code
```
File: C:\laragon\www\Mountix\gemini.md
```

#### Step 2: Lihat section "IMPLEMENTATION ROADMAP"
- Scroll ke bagian yang bertuliskan `## 🚀 IMPLEMENTATION ROADMAP`
- Di sana ada **6 STEP** yang clear

#### Step 3: Ambil instruksi dari STEP 1
```markdown
### **STEP 1: Layout Components (Foundation)**
Build reusable layouts and components first:
- [ ] `layouts/app.blade.php` - Main layout with navbar, footer
- [ ] `components/navbar.blade.php` - Navigation bar
... dst
```

#### Step 4: Copy instruksi STEP 1 ke Gemini CLI
Gunakan prompt pattern ini:

```
Saya akan membangun frontend Mountix menggunakan Blade + Tailwind CSS.

Backend sudah complete dengan API yang working.

**INSTRUKSI DARI gemini.md STEP 1:**
[PASTE INSTRUKSI DARI gemini.md STEP 1 SECTION]

PENTING:
- Follow instruksi gemini.md DENGAN PRESISI
- Buat file di struktur folder yang sudah di-restructure
- Gunakan Tailwind CSS untuk styling (no custom CSS)
- Buat components reusable
- Ikuti design system di gemini.md

Mulai dengan membuat layout components terlebih dahulu.
```

---

### **METODE 2: GUNAKAN PROMPT TEMPLATE SIAP PAKAI**

Copy prompt ini langsung ke Gemini CLI:

```
INSTRUKSI FRONTEND STEP 1: BUILD LAYOUT COMPONENTS

Project: Mountix (Laravel 12 dengan backend API sudah complete)
Frontend: Blade Templates + Tailwind CSS 4.0

File location: C:\laragon\www\Mountix

BUILD COMPONENTS BERIKUT (STEP 1):

1. layouts/app.blade.php
   - Main layout dengan navbar & footer
   - Brand/logo di navbar
   - Navigation links (Home, Browse Mountains, My Bookings, Profile)
   - Login/Logout button
   - Responsive hamburger menu untuk mobile
   - Footer dengan copyright & links

2. layouts/auth.blade.php
   - Layout untuk login/register pages
   - Centered form container
   - Background image atau gradient
   - Simple navbar dengan brand only

3. components/navbar.blade.php
   - Responsive navbar dengan AlpineJS
   - Logo/brand name di kiri
   - Navigation menu di tengah
   - User dropdown/profile di kanan
   - Hamburger menu untuk mobile
   - Sticky di top

4. components/footer.blade.php
   - Company info
   - Quick links
   - Contact info
   - Social media links
   - Copyright text

5. components/card.blade.php
   - Reusable card component dengan props
   - Background: white (#F8F8F6)
   - Shadow: shadow-md
   - Hover effect: scale-105 & shadow-lg
   - Border radius: rounded-lg
   - Padding: p-4
   - Props: title, footer, custom classes

6. components/button.blade.php
   - Reusable button component
   - Variants: primary (Forest Green), secondary (Earthy Brown), danger (Red)
   - Sizes: sm, md, lg
   - Disabled state
   - Loading state dengan spinner
   - Props: type, variant, size, loading, disabled

7. components/input.blade.php
   - Reusable input component
   - Types: text, email, password, number, date
   - Label & error message support
   - Focus ring (ring-2 ring-offset-2)
   - Placeholder styling
   - Required asterisk

8. components/alert.blade.php
   - Alert notification component
   - Types: success, error, warning, info
   - Dismissible (dengan X button)
   - AlpineJS untuk close functionality
   - Colors sesuai design system

9. components/loading.blade.php
   - Loading spinner component
   - Animated spinner icon
   - Optional loading text
   - Center positioning

10. components/pagination.blade.php
    - Pagination component
    - Previous/Next buttons
    - Page numbers
    - Active page styling
    - Disabled state untuk first/last page

11. components/modal.blade.php
    - Modal/dialog component
    - Backdrop dengan opacity
    - Close button (X)
    - Props: title, confirmText, cancelText
    - AlpineJS untuk show/hide

PENTING:
- Gunakan HANYA Tailwind utility classes
- Buat components sebagai Blade components (resources/views/components/)
- Setiap component harus reusable dengan proper props
- Add clear comments menjelaskan fungsi
- Use design color system dari gemini.md:
  * Primary: #2D5016 (Forest Green)
  * Secondary: #8B6F47 (Earthy Brown)
  * Neutral: #475569 (Slate Gray)
  * Light BG: #F8F8F6 (Off-white)
- Mobile-first responsive design
- Add AlpineJS untuk interactivity jika diperlukan

Output: File-file components yang rapi dan modular.
```

---

## 🔄 WORKFLOW BUILD FRONTEND (STEP-BY-STEP)

### **TIMELINE YANG RECOMMENDED:**

```
STEP 1: Layout Components (2-3 hari)
├─ layouts/app.blade.php
├─ layouts/auth.blade.php
├─ components/navbar.blade.php
├─ components/footer.blade.php
├─ components/card.blade.php
├─ components/button.blade.php
├─ components/input.blade.php
├─ components/modal.blade.php
├─ components/alert.blade.php
├─ components/loading.blade.php
├─ components/pagination.blade.php
└─ TEST: Browser check ✓

STEP 2: Authentication Pages (1-2 hari)
├─ pages/auth/login.blade.php
├─ pages/auth/register.blade.php
├─ pages/auth/forgot-password.blade.php
├─ resources/js/auth.js (API functions)
├─ AuthController.php (web version)
└─ TEST: Login flow ✓

STEP 3: Main Pages (2-3 hari)
├─ pages/home.blade.php
├─ pages/gunung/index.blade.php
├─ pages/gunung/show.blade.php
├─ pages/profile/show.blade.php
├─ HomeController.php
├─ GunungController.php (web version)
└─ TEST: Browse & search ✓

STEP 4: Booking Flow (2-3 hari)
├─ pages/booking/create.blade.php
├─ pages/booking/index.blade.php
├─ pages/booking/show.blade.php
├─ BookingController.php (web version)
└─ TEST: Complete booking ✓

STEP 5: Payment & E-Ticket (2 hari)
├─ pages/payment/create.blade.php
├─ pages/payment/success.blade.php
├─ pages/eticket/show.blade.php
├─ PaymentController.php (web version)
├─ ETicketController.php
└─ TEST: Payment & e-ticket ✓

STEP 6: Polish & Advanced (1-2 hari)
├─ Setup routes/web.php (all routes)
├─ JavaScript setup (resources/js/app.js)
├─ API client setup (resources/js/api-client.js)
├─ Database seeding (dummy data)
└─ FINAL TEST: End-to-end flow ✓

TOTAL TIME: 1-2 minggu
```

---

## 📝 PROMPT UNTUK SETIAP STEP

### **STEP 1: Layout Components**
```
[GUNAKAN PROMPT TEMPLATE SIAP PAKAI DI ATAS]
```

### **STEP 2: Authentication Pages**
```
INSTRUKSI FRONTEND STEP 2: BUILD AUTHENTICATION PAGES

Project: Mountix (Layout components sudah jadi)

BUILD PAGES BERIKUT:

1. pages/auth/login.blade.php
   - Form dengan email & password
   - "Remember me" checkbox
   - Login button
   - Links: Register, Forgot password
   - Error messages display
   - Show/hide password toggle
   - Extend dari layouts/auth.blade.php

2. pages/auth/register.blade.php
   - Form: name, email, phone, password, confirm password
   - Password strength meter
   - Terms checkbox
   - Register button
   - Link: Already have account? Login
   - Real-time email availability check
   - Extend dari layouts/auth.blade.php

3. pages/auth/forgot-password.blade.php
   - Email input untuk reset
   - Submit button
   - Success message setelah submit
   - Extend dari layouts/auth.blade.php

4. resources/js/auth.js
   - Function: registerUser(formData)
   - Function: loginUser(email, password)
   - Function: logoutUser()
   - Function: resetPassword(email)
   - Store JWT token ke localStorage
   - Error handling dengan alert

5. AuthController.php (web version)
   - loginForm() → return login view
   - registerForm() → return register view
   - forgotForm() → return forgot password view
   - logout() → clear session redirect

6. routes/web.php updates
   - GET /login → AuthController@loginForm
   - GET /register → AuthController@registerForm
   - GET /forgot-password → AuthController@forgotForm
   - POST /logout → AuthController@logout

PENTING:
- Form validation client-side
- Use components dari STEP 1
- Integrate dengan API /api/v1/auth/*
- Store JWT token & user ke localStorage
- Redirect after login/register
- Responsive design

Test: Bisa login & register ✓
```

### **STEP 3: Main Pages**
```
INSTRUKSI FRONTEND STEP 3: BUILD MAIN PAGES

Project: Mountix (Auth pages sudah jadi)

BUILD PAGES BERIKUT:

1. pages/home.blade.php
   - Hero banner dengan background image
   - Search bar (input mountain name)
   - Popular mountains grid (3 columns)
   - Mountain cards dengan: image, name, difficulty, rating, price
   - "Browse All" CTA button
   - Extend dari layouts/app.blade.php

2. pages/gunung/index.blade.php
   - Sidebar filters (desktop), collapsible (mobile)
   - Filters: difficulty, price range, location, rating
   - Mountain cards grid (3 columns, responsive)
   - Pagination at bottom
   - Extend dari layouts/app.blade.php

3. pages/gunung/show.blade.php
   - Hero image (full width)
   - Mountain info: name, location, description
   - Details: difficulty, altitude, duration
   - Routes list (table)
   - Reviews/ratings section
   - "Book Now" CTA button
   - Extend dari layouts/app.blade.php

4. pages/profile/show.blade.php
   - Profile picture
   - User info: name, email, phone
   - My bookings button/link
   - Edit profile button/link
   - Change password link
   - Logout button
   - Extend dari layouts/app.blade.php

5. GunungController.php (web version)
   - index() → fetch dari API & return gunung index view
   - show($id) → fetch detail & return show view

6. HomeController.php
   - index() → fetch popular mountains & return home view

7. ProfileController.php
   - show() → fetch user data & return profile view
   - edit() → return edit form
   - update() → update & redirect

Test: Bisa browse gunung & lihat detail ✓
```

### **STEP 4 & SETERUSNYA**
[Copy dari gemini.md section masing-masing STEP]

---

## ⚡ QUICK START SEKARANG

### **Cara Third: LANGSUNG COPY-PASTE GEMINI.MD**

1. **Buka gemini.md di VS Code**
   ```
   File → Open: C:\laragon\www\Mountix\gemini.md
   ```

2. **Scroll ke section "IMPLEMENTATION ROADMAP"**

3. **Copy seluruh "STEP 1: Layout Components"**

4. **Paste ke Gemini CLI dengan menambahkan header:**
   ```
   Build frontend Mountix STEP 1 sesuai instruksi berikut:
   
   [PASTE DARI gemini.md]
   
   Penting:
   - Project sudah restructured, folder ready
   - Use design system dari gemini.md
   - Mobile-first responsive
   - Tailwind utility classes only
   ```

5. **Tunggu Gemini CLI generate files**

6. **Check hasil di VS Code**
   - Lihat file-file yang dibuat
   - Verify struktur folder benar

7. **Test di browser**
   ```bash
   php artisan serve
   ```
   Buka: http://localhost:8000

8. **Lanjut ke STEP 2**

---

## 🔍 CARA MEMVERIFIKASI SETIAP STEP

### **Checklist untuk setiap STEP:**

```
✓ Semua files sudah di folder yang benar
✓ Blade syntax benar (no syntax errors)
✓ Components dapat di-reference dengan benar
✓ Responsive pada berbagai ukuran screen
✓ No console errors di DevTools
✓ API calls include JWT token (check Network tab)
✓ Styling sesuai design system
✓ Reusable components digunakan
```

---

## 📞 TROUBLESHOOTING

### **Jika ada error saat render di browser:**

**1. Blade syntax error?**
```bash
php artisan view:cache
php artisan cache:clear
php artisan view:clear
```

**2. Component tidak ditemukan?**
```
Check: resources/views/components/nama-component.blade.php
Pastikan folder path benar
```

**3. CSS/Tailwind tidak apply?**
```bash
npm run build
# atau watch:
npm run dev
```

**4. API 401 Unauthorized?**
```
Check: JWT token ada di localStorage
Verify: api-client.js include token di header
```

### **Gemini CLI Generate File di Tempat Salah?**

Beri instruksi yang lebih spesifik:
```
"Tolong buat file di path EXACT ini:
resources/views/pages/home.blade.php

Jangan buat di folder lain."
```

---

## ✨ SUMMARY

**Untuk memulai build frontend:**

1. ✅ Baca section "IMPLEMENTATION ROADMAP" di gemini.md
2. ✅ Copy STEP 1 instruction
3. ✅ Paste ke Gemini CLI dengan konteks project
4. ✅ Tunggu generate & verify
5. ✅ Test di browser
6. ✅ Lanjut ke STEP 2, dst
7. ✅ Setiap STEP, test & verify sebelum lanjut

**Status:** READY TO BUILD 🚀

---

**Last Updated:** June 6, 2026
**Version:** 1.0
