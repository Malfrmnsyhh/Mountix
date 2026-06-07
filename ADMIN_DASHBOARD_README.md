# 🔐 ADMIN DASHBOARD BUILD GUIDE
**Status: Production-Ready | Framework: Laravel 12 + Blade + Tailwind CSS**

---

## 📌 **CRITICAL RULES (JANGAN DILANGGAR!)**

### Rule 1: Auth & Middleware
- ✅ Admin dashboard gunakan EXISTING `RoleMiddleware` dari `app/Http/Middleware/RoleMiddleware.php`
- ✅ Route prefix: `/admin/*` - SUDAH DEFINED di `routes/web.php` (tambahkan)
- ✅ Hanya user dengan `role = 'admin'` yang bisa akses
- ✅ JANGAN ubah `routes/api.php` - API admin endpoints sudah ada di line 49-56
- ❌ JANGAN bikin middleware baru
- ❌ JANGAN ubah User model (role field SUDAH ADA)

### Rule 2: Models & Database
- ✅ Gunakan EXISTING models ONLY: `Gunung.php`, `Jalur.php`, `User.php`, `Booking.php`, `Payment.php`, `ETicket.php`
- ✅ Jangan tambah kolom baru di table (SUDAH OPTIMAL)
- ✅ TIDAK PERLU migration baru - semua sudah ada
- ❌ JANGAN modify existing model relationships
- ❌ JANGAN create model baru tanpa approval

### Rule 3: File Structure
- ✅ Controllers: `app/Http/Controllers/Admin/*` (NEW folder, untuk admin controllers)
- ✅ Views: `resources/views/admin/*` (NEW folder, untuk admin pages)
- ✅ Routes: tambah ke `routes/web.php` di section admin (BARU)
- ✅ No CSS - gunakan EXISTING Tailwind config
- ❌ JANGAN buat folder di tempat lain
- ❌ JANGAN duplicate komponen yang sudah ada

### Rule 4: Naming Convention
- Controllers: `AdminGunungController` (prefix Admin)
- Views: `admin/gunung/index.blade.php` (folder lowercase)
- Routes: `admin.gunung.index` (dot notation)
- Routes match EXACTLY: `routes/web.php` prefix

### Rule 5: Compatibility
- ✅ Gunakan components dari `resources/views/components/` (sudah ada)
- ✅ Reuse navbar/footer dari layout
- ✅ API calls via Axios - use JWT token (EXISTING pattern)
- ✅ Tailwind colors: gunakan design system dari `gemini.md` (primary: #2D5016, secondary: #8B6F47)
- ❌ JANGAN bikin design baru
- ❌ JANGAN import CSS/framework baru

---

## 🗂️ **MANDATORY FOLDER STRUCTURE**

```
resources/views/
├── admin/                          ← NEW FOLDER
│   ├── layouts/
│   │   └── app.blade.php           ← Admin layout dengan sidebar
│   ├── dashboard/
│   │   └── index.blade.php         ← Overview statistik
│   ├── gunung/
│   │   ├── index.blade.php         ← List semua gunung
│   │   ├── create.blade.php        ← Form tambah gunung
│   │   ├── edit.blade.php          ← Form edit gunung
│   │   └── show.blade.php          ← Detail gunung
│   ├── jalur/
│   │   ├── index.blade.php
│   │   ├── create.blade.php
│   │   └── edit.blade.php
│   ├── fasilitas/
│   │   ├── index.blade.php
│   │   ├── create.blade.php
│   │   └── edit.blade.php
│   ├── booking/
│   │   ├── index.blade.php         ← List booking management
│   │   └── show.blade.php          ← Detail + update status
│   ├── payment/
│   │   ├── index.blade.php         ← Monitoring transaksi
│   │   └── show.blade.php
│   ├── eticket/
│   │   ├── index.blade.php
│   │   └── show.blade.php
│   ├── users/
│   │   ├── index.blade.php
│   │   └── show.blade.php
│   └── components/
│       ├── sidebar.blade.php       ← Navigation menu
│       ├── topbar.blade.php        ← Header dengan user menu
│       └── stats-card.blade.php    ← Card untuk dashboard
│
app/Http/Controllers/Admin/         ← NEW FOLDER
├── DashboardController.php         ← Dashboard overview
├── AdminGunungController.php       ← Gunung CRUD
├── AdminJalurController.php        ← Jalur CRUD
├── AdminFasilitasController.php    ← Fasilitas CRUD
├── AdminBookingController.php      ← Booking management
├── AdminPaymentController.php      ← Payment monitoring
├── AdminETicketController.php      ← E-Ticket validation
└── AdminUserController.php         ← User management
```

**NO OTHER FILES NEEDED - struktur KETAT!**

---

## 🔌 **ROUTES (Tambah ke routes/web.php)**

```php
// TAMBAH INI DI routes/web.php SEBELUM penutup file
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::resource('gunung', AdminGunungController::class);
    Route::resource('jalur', AdminJalurController::class);
    Route::resource('fasilitas', AdminFasilitasController::class);
    
    Route::resource('booking', AdminBookingController::class)->only(['index', 'show', 'update']);
    Route::resource('payment', AdminPaymentController::class)->only(['index', 'show']);
    Route::resource('eticket', AdminETicketController::class)->only(['index', 'show']);
    Route::resource('users', AdminUserController::class)->only(['index', 'show']);
});

// NOTA: 
// - Gunakan existing 'auth' middleware (JANGAN 'auth:api')
// - Tambah 'admin' middleware check (lihat Rule 1)
// - Routes SUDAH EXIST di API (line 49-56) - ini untuk Blade/Web view
```

---

## 📋 **IMPLEMENTATION ROADMAP (6 STEP)**

### **STEP 1: Middleware & Auth Layer (2 jam)**
**Goal**: Pastikan hanya admin yang bisa akses admin panel

File:
- `app/Http/Middleware/AdminMiddleware.php` (BARU)
- `routes/web.php` (EDIT - tambah admin routes)

Checklist:
- [ ] Buat AdminMiddleware yang check `auth()->user()->role === 'admin'`
- [ ] Redirect non-admin ke home dengan flash message
- [ ] Tambah routes admin ke `routes/web.php`
- [ ] Test: akses `/admin` sebagai user biasa → harus redirect ke home
- [ ] Test: akses `/admin` sebagai admin → harus tampil dashboard

---

### **STEP 2: Layout & Components (3 jam)**
**Goal**: Buat UI base untuk admin panel

Files:
- `resources/views/admin/layouts/app.blade.php` (BARU)
- `resources/views/admin/components/sidebar.blade.php` (BARU)
- `resources/views/admin/components/topbar.blade.php` (BARU)
- `resources/views/admin/components/stats-card.blade.php` (BARU)

Specs:
```
Layout:
├─ Topbar (fixed top) - Logo + User dropdown + Logout
├─ Sidebar (fixed left) - Menu navigation + Active state
└─ Content area - Main content slot

Sidebar Menu Items:
├─ Dashboard (icon: home)
├─ Data Management (folder icon)
│  ├─ Gunung
│  ├─ Jalur
│  └─ Fasilitas
├─ Booking Management
├─ Payment Monitor
├─ E-Ticket
└─ Users

Colors: Primary #2D5016, Secondary #8B6F47, Gray #475569
Responsive: Sidebar collapsible di mobile
```

Checklist:
- [ ] Layout extends dengan @yield untuk content
- [ ] Sidebar dengan link active state
- [ ] Topbar dengan dropdown user profile
- [ ] Stats card component reusable
- [ ] Mobile responsive (sidebar toggle)
- [ ] Test semua links navigasi

---

### **STEP 3: Dashboard Controller & Page (4 jam)**
**Goal**: Dashboard dengan statistik overview

Files:
- `app/Http/Controllers/Admin/DashboardController.php` (BARU)
- `resources/views/admin/dashboard/index.blade.php` (BARU)

Logic:
```php
// Controller harus query:
$totalGunung = Gunung::count();
$totalBooking = Booking::count();
$totalRevenue = Payment::where('status', 'success')->sum('amount');
$bookingHariIni = Booking::whereDate('created_at', today())->count();

// Chart data (OPTIONAL):
$bookingChart = Booking::selectRaw('DATE(created_at) as date, COUNT(*) as total')
    ->groupBy('date')->last30days();
$paymentChart = Payment::selectRaw('status, COUNT(*) as total')
    ->groupBy('status');
```

View:
```
Dashboard Layout:
├─ Welcome greeting (nama admin)
├─ Stats Row (4 cards):
│  ├─ Total Gunung
│  ├─ Booking Hari Ini
│  ├─ Total Revenue
│  └─ Pending Payments
├─ Recent Bookings Table (last 10)
├─ Payment Status Breakdown (pie chart)
└─ Quick Actions buttons
```

Checklist:
- [ ] Query data dari existing models
- [ ] Render stats cards dengan icon
- [ ] Display recent bookings table
- [ ] Format currency untuk revenue (Rp)
- [ ] Format date dengan Indonesian locale
- [ ] Test load time (should <1s)

---

### **STEP 4: Gunung CRUD (6 jam)**
**Goal**: Full CRUD untuk management gunung (key feature)

Files:
- `app/Http/Controllers/Admin/AdminGunungController.php` (BARU)
- `resources/views/admin/gunung/index.blade.php` (BARU)
- `resources/views/admin/gunung/create.blade.php` (BARU)
- `resources/views/admin/gunung/edit.blade.php` (BARU)
- `resources/views/admin/gunung/show.blade.php` (BARU)

Controller Methods:
```php
- index() - List semua gunung dengan pagination + search
- create() - Form tambah gunung
- store() - Save ke DB, handle file upload foto
- show() - Detail gunung + jalur
- edit() - Form edit
- update() - Update data
- destroy() - Soft delete atau flag inactive
```

Forms must include:
```
├─ Nama gunung (text, required)
├─ Deskripsi (textarea, markdown)
├─ Ketinggian (number, meter)
├─ Lokasi (text)
├─ Foto (file upload, store ke storage/public/gunung/)
├─ Harga tiket (currency, Rp)
├─ Kuota max pendaki (number)
├─ Status (open/close dropdown)
├─ Difficulty level (easy/medium/hard)
└─ Jalur yang tersedia (multi-select)
```

File Upload:
- ✅ Store foto ke `storage/app/public/gunung/{gunung_id}/`
- ✅ Thumbnail di dashboard list
- ✅ Full image di detail page
- ❌ JANGAN hardcode path - gunakan Storage facade

Checklist:
- [ ] List page dengan pagination (10 per page)
- [ ] Search by nama gunung
- [ ] Create form dengan validation
- [ ] File upload working dan accessible
- [ ] Edit page pre-populate data
- [ ] Delete dengan soft delete (if available) atau flag
- [ ] Test upload file valid & invalid
- [ ] Test validation messages tampil
- [ ] Test mobile form responsiveness

---

### **STEP 5: Jalur, Fasilitas, Booking, Payment CRUD (6 jam)**
**Goal**: Complete CRUD untuk semua entitas

Files:
- `app/Http/Controllers/Admin/AdminJalurController.php`
- `app/Http/Controllers/Admin/AdminFasilitasController.php`
- `app/Http/Controllers/Admin/AdminBookingController.php`
- `app/Http/Controllers/Admin/AdminPaymentController.php`
- `resources/views/admin/jalur/{index,create,edit}.blade.php`
- `resources/views/admin/fasilitas/{index,create,edit}.blade.php`
- `resources/views/admin/booking/{index,show}.blade.php`
- `resources/views/admin/payment/{index,show}.blade.php`

Key Points:

**Jalur CRUD:**
- Belong to Gunung (dropdown select)
- Difficulty, duration, elevation_gain
- List dengan gunung name
- Cannot delete if has active bookings

**Fasilitas CRUD:**
- Nama fasilitas, deskripsi
- Assign ke gunung (many-to-many if needed)
- Simple CRUD

**Booking Management (READ-ONLY mostly):**
- List dengan filter: status (pending/confirmed/cancelled)
- Show detail + user info + jalur + tanggal
- Update status (only admin can confirm/cancel)
- JANGAN ubah user/jalur - readonly

**Payment Monitoring (READ-ONLY mostly):**
- List dengan filter: status (pending/success/failed)
- Show detail + booking info + amount
- Verify button (for manual payment verification)
- Display proof upload (if applicable)

Checklist:
- [ ] Jalur CRUD working + relationship to Gunung
- [ ] Fasilitas CRUD working
- [ ] Booking list dengan filter status
- [ ] Booking detail readonly fields, updateable status
- [ ] Payment list dengan filter
- [ ] Payment verify action working
- [ ] All forms validated
- [ ] Delete actions protected (cascade check)

---

### **STEP 6: Polish & Testing (4 jam)**
**Goal**: Refinement, error handling, final testing

Tasks:
- [ ] Error handling untuk semua forms
- [ ] Flash messages (success/error/warning)
- [ ] Pagination tested
- [ ] Search/filter tested
- [ ] File upload edge cases (size limit, format)
- [ ] Date formatting consistent (Indonesian)
- [ ] Currency formatting (Rp)
- [ ] Mobile responsiveness check (375px, 768px, 1024px)
- [ ] Accessibility (label, alt text, contrast)
- [ ] Performance (query optimization, no N+1)
- [ ] Security (CSRF token, validation, auth check)
- [ ] Browser compatibility (Chrome, Firefox, Safari)

Verification Checklist:
```
FUNCTIONAL:
├─ [ ] Admin login, redirect to /admin/dashboard
├─ [ ] Non-admin redirect to home
├─ [ ] All CRUD operations working
├─ [ ] File upload working
├─ [ ] Validation errors showing
├─ [ ] Success messages showing
├─ [ ] Pagination working

DATA INTEGRITY:
├─ [ ] Edit form pre-populate correctly
├─ [ ] Delete removes data from DB
├─ [ ] Relationships maintained (Gunung → Jalur)
├─ [ ] No orphan records

SECURITY:
├─ [ ] Non-admin cannot access /admin/*
├─ [ ] CSRF tokens in forms
├─ [ ] Input validation (no SQL injection)
├─ [ ] File upload safe (whitelist extensions)

UI/UX:
├─ [ ] Responsive di mobile/tablet/desktop
├─ [ ] Buttons clickable (not disabled by mistake)
├─ [ ] Forms clear and usable
├─ [ ] Consistent design with main site
├─ [ ] Loading states shown
```

---

## 🎨 **DESIGN SYSTEM (FIXED - DON'T CHANGE)**

```
Primary Color: #2D5016 (Forest Green)
- Buttons, headers, active states

Secondary Color: #8B6F47 (Earthy Brown)
- Accents, highlights, hover states

Neutral Dark: #475569 (Slate Gray)
- Text, borders, dark elements

Neutral Light: #F8F8F6 (Off-white)
- Backgrounds, cards

Success: #10B981 (Green)
- Success messages, confirmed status

Warning: #F59E0B (Amber)
- Warnings, pending status

Danger: #EF4444 (Red)
- Errors, failed status, delete

Font:
- Sans-serif (default Tailwind)
- H1: 32px bold
- H2: 24px bold
- Body: 16px normal
```

---

## 🚀 **EXECUTION CHECKLIST**

```
PRE-EXECUTION:
[ ] Review existing routes/api.php (line 49-56) - sudah ada admin endpoints
[ ] Review User model - role field sudah ada
[ ] Review RoleMiddleware - already in place
[ ] NO new migrations needed
[ ] NO new models needed

DURING EXECUTION (per STEP):
[ ] Create files di EXACT path (no variations)
[ ] Follow naming convention STRICTLY
[ ] Use EXISTING models only
[ ] Test each step before proceeding
[ ] Commit after each STEP completed

POST-EXECUTION:
[ ] Run: php artisan migrate (should be no-op, check)
[ ] Run: php artisan db:seed MountixSeeder (seed initial data)
[ ] Test admin login: http://localhost:8000/admin
[ ] Test all CRUD operations
[ ] Test file uploads
[ ] Verify JWT token in API calls (DevTools → Network)
[ ] Test mobile responsiveness

DEPLOYMENT:
[ ] No file conflicts ✓ (new folder, no overwrites)
[ ] No route conflicts ✓ (admin.* prefix unique)
[ ] No model changes ✓ (existing only)
[ ] No migration changes ✓ (none needed)
[ ] Can rollback if needed ✓ (just delete admin folder)
```

---

## ⚠️ **THINGS TO AVOID (CRITICAL)**

```
❌ JANGAN:
1. Modify routes/api.php (admin API endpoints SUDAH ADA)
2. Modify User model (role field SUDAH ADA)
3. Modify RoleMiddleware (SUDAH OPTIMAL)
4. Create new migrations (SEMUA SUDAH ADA)
5. Create new models (REUSE existing)
6. Change existing controller locations
7. Create CSS/SCSS files (gunakan Tailwind)
8. Add new npm packages (unless absolutely needed)
9. Modify existing views (only create NEW admin views)
10. Hardcode file paths (use Storage facade)

✅ DO:
1. Create NEW controllers dalam app/Http/Controllers/Admin/
2. Create NEW views dalam resources/views/admin/
3. Extend existing layout (if needed, use admin layout specifically)
4. Use existing models & relationships
5. Follow naming convention (AdminGunungController, admin.gunung.index)
6. Use design system colors
7. Add validation in controllers
8. Handle file uploads safely
9. Test before proceeding to next step
10. Ask for clarification if unsure
```

---

## 📞 **IF THINGS GO WRONG**

```
Issue: Route conflict
→ Check routes/web.php prefix - should be 'admin.*' (unique)

Issue: Auth not working
→ Verify middleware stack in routes (auth, admin)
→ Check User model has 'role' field

Issue: Model not found
→ Check controller use statements match file paths
→ Verify model exists in app/Models/

Issue: File upload not working
→ Check storage:link - run: php artisan storage:link
→ Verify directory permissions
→ Check file size limit in .env

Issue: Design looks wrong
→ Check Tailwind is compiled (npm run dev or build)
→ Verify color codes match exactly (#2D5016, not #2d5016)
→ Check no custom CSS overriding

Issue: Data not showing
→ Check queries in controller (use Tinker if needed)
→ Verify relationships in models
→ Check pagination offset
```

---

## ✨ **FINAL VALIDATION**

Before marking complete, verify:

1. **No File Conflicts**: Run `git status` - ONLY admin/* files should be new
2. **No Crashes**: Test admin panel - should load without errors
3. **No Breaking Changes**: Test existing user flow (booking, payment) - should still work
4. **Data Integrity**: Verify seeder populates data correctly
5. **Security**: Try accessing `/admin/*` as non-admin - should deny
6. **Performance**: Dashboard load should be <2 seconds

---

**STATUS: READY TO EXECUTE** ✅

When ready, follow STEP 1-6 in order. Each step should be validated before moving to next.

Generated: 2026-06-07 | Framework: Laravel 12 | Frontend: Blade + Tailwind CSS 4.0
