# ⚡ QUICK REFERENCE - CLI AGENT EXECUTION GUIDE

**Purpose**: File ini untuk quick lookup saat implementasi. Baca instruksi.md dulu!

---

## 🎯 TL;DR - WHAT TO DO

### PHASE 1: Navbar (Priority: HIGH)
```
1. Create resources/views/components/navbar.blade.php
2. Add navbar CSS to resources/css/app.css
3. Create resources/js/navbar.js
4. Include navbar in layout template
5. Test on mobile & desktop
```

**Key Changes**:
- Separate guest vs authenticated states
- Mobile hamburger menu untuk < 768px
- Sticky header dengan z-index 100
- Dropdown menu untuk profile

---

### PHASE 2: Hero Section (Priority: HIGH)
```
1. Create resources/views/components/hero.blade.php
2. Add hero CSS to resources/css/app.css
3. Create resources/js/hero.js
4. Include hero in homepage
5. Optimize background image
```

**Key Changes**:
- Update copy: "Booking Pendakian Gunung Impian Anda"
- Add trust badges (2,500+ users, 100% money back, 24/7 support)
- Improve CTA buttons styling
- Add scroll indicator animation

---

### PHASE 3: Gunung Populer (Priority: HIGH)
```
1. Create resources/views/components/mountain-card.blade.php
2. Create resources/views/components/gunung-populer.blade.php
3. Add mountain card CSS to resources/css/app.css
4. Update HomeController for data
5. Include gunung-populer in homepage
```

**Key Changes**:
- Show 6 mountains in grid (not just 1)
- Add status badges (tersedia/terbatas/penuh)
- Add rating stars
- Responsive grid: 3 col desktop, 2 col tablet, 1 col mobile

---

## 🎨 CSS VARIABLES TO ADD

Add ini di root dari `resources/css/app.css`:

```css
:root {
  /* Colors */
  --primary-dark: #1B5E20;
  --primary-main: #2E7D32;
  --primary-light: #66BB6A;
  --secondary-main: #FF8C42;
  --secondary-light: #FFB74D;
  --accent-main: #00A86B;
  --accent-hover: #00916D;
  --gray-900: #1F2937;
  --gray-800: #374151;
  --gray-700: #4B5563;
  --gray-100: #F9FAFB;
  --gray-50: #FFFFFF;
  --success: #10B981;
  --warning: #F59E0B;
  --error: #EF4444;
  
  /* Backgrounds & Borders */
  --bg-primary: #FFFFFF;
  --bg-secondary: #F9FAFB;
  --border-color: #E5E7EB;
  
  /* Shadows */
  --shadow-sm: 0 1px 2px 0 rgba(0,0,0,0.05);
  --shadow-md: 0 4px 6px -1px rgba(0,0,0,0.1);
  --shadow-lg: 0 10px 15px -3px rgba(0,0,0,0.1);
  
  /* Typography */
  --text-xs: 12px;
  --text-sm: 14px;
  --text-base: 16px;
  --text-lg: 18px;
  --text-xl: 20px;
  --text-2xl: 24px;
  --text-3xl: 30px;
  --text-4xl: 36px;
  --line-height-tight: 1.2;
  --line-height-normal: 1.5;
  --line-height-relaxed: 1.75;
  
  /* Spacing */
  --spacing-2: 8px;
  --spacing-3: 12px;
  --spacing-4: 16px;
  --spacing-6: 24px;
  --spacing-8: 32px;
  --spacing-10: 40px;
  --spacing-12: 48px;
  --spacing-16: 64px;
  --spacing-20: 80px;
  
  /* Border Radius */
  --radius-sm: 4px;
  --radius-md: 8px;
  --radius-lg: 12px;
  --radius-xl: 16px;
  --radius-full: 9999px;
}
```

---

## 📁 FILES TO CREATE/MODIFY

### CREATE (New Files):
```
resources/views/components/navbar.blade.php
resources/views/components/hero.blade.php
resources/views/components/mountain-card.blade.php
resources/views/components/gunung-populer.blade.php
resources/js/navbar.js
resources/js/hero.js
```

### MODIFY (Existing Files):
```
resources/css/app.css              (ADD: navbar + hero + card CSS)
resources/js/app.js                (IMPORT: navbar.js, hero.js)
resources/views/layouts/app.blade.php (INCLUDE: navbar)
resources/views/index.blade.php    (INCLUDE: hero, gunung-populer)
app/Http/Controllers/HomeController.php (UPDATE: query gunung populer)
```

---

## 🔄 COMPONENT TREE

```
Layout (app.blade.php)
├── navbar.blade.php
├── index.blade.php (homepage)
│   ├── hero.blade.php
│   └── gunung-populer.blade.php
│       └── mountain-card.blade.php (×6)
└── footer (to be designed later)
```

---

## 📱 RESPONSIVE BREAKPOINTS

```
Mobile:        0px - 639px
Tablet:        640px - 1023px
Desktop:       1024px - 1279px
Large Desktop: 1280px+

Usage:
@media (max-width: 639px) { /* mobile */ }
@media (min-width: 640px) and (max-width: 1023px) { /* tablet */ }
@media (min-width: 1024px) { /* desktop */ }
```

---

## 🎯 KEY CSS CLASSES

### Buttons
```css
.btn              - base button
.btn-primary      - green action button
.btn-secondary    - outlined button
.btn-link         - text link button
.btn-sm           - small size
.btn-lg           - large size
```

### Text Styles
```css
.section-title    - h2 heading
.section-subtitle - subtitle text
.card-title       - h3 heading
.hero-title       - h1 heading
```

### Components
```css
.navbar           - header
.hero             - hero section
.mountain-card    - individual card
.mountains-grid   - card grid container
.section-footer   - footer of section
```

---

## ✅ STEP-BY-STEP EXECUTION

### Hour 1-2: Navbar
1. [ ] Create navbar component file
2. [ ] Write HTML structure
3. [ ] Write CSS (desktop view)
4. [ ] Write CSS (mobile view)
5. [ ] Write JavaScript
6. [ ] Test on all devices

### Hour 3-4: Hero Section
1. [ ] Create hero component file
2. [ ] Write HTML structure
3. [ ] Write CSS (desktop view)
4. [ ] Optimize background image
5. [ ] Write CSS (mobile view)
6. [ ] Write JavaScript (scroll, parallax)
7. [ ] Test on all devices

### Hour 5-7: Gunung Populer
1. [ ] Create mountain-card component
2. [ ] Create gunung-populer section
3. [ ] Write CSS for cards
4. [ ] Write CSS for grid layout
5. [ ] Update HomeController
6. [ ] Update homepage to include
7. [ ] Test cards display correctly
8. [ ] Test responsive grid

### Hour 8: Testing & Fixes
1. [ ] Test all devices
2. [ ] Fix responsive issues
3. [ ] Optimize images
4. [ ] Check performance
5. [ ] Final review

---

## 🚨 COMMON MISTAKES TO AVOID

❌ **Don't**:
- Modify backend logic (routing, controllers beyond data fetch)
- Use hardcoded hex colors (use CSS variables)
- Forget mobile responsive design
- Add unnecessary animations
- Forget alt text on images
- Use px for font sizes (use variables)
- Forget border-radius on cards
- Make buttons too small (< 44px on mobile)

✅ **Do**:
- Keep HTML semantic
- Use CSS variables for all colors/spacing
- Mobile-first approach
- Test on real devices, not just DevTools
- Use grid for layout (not float/flex everything)
- Lazy load images below fold
- Use transitions for interactions
- Test all interactive elements

---

## 🎬 ANIMATION EXAMPLES

### Fade In Up (Hero)
```css
@keyframes fadeInUp {
  from { opacity: 0; transform: translateY(30px); }
  to { opacity: 1; transform: translateY(0); }
}
.hero-inner { animation: fadeInUp 0.8s ease-out; }
```

### Bounce (Scroll Indicator)
```css
@keyframes bounce {
  0%, 100% { transform: translateY(0); }
  50% { transform: translateY(8px); }
}
.scroll-arrow { animation: bounce 2s infinite; }
```

### Card Hover
```css
.mountain-card:hover {
  transform: translateY(-8px);
  box-shadow: var(--shadow-lg);
}
```

---

## 🔗 BLADE TEMPLATE QUICK SYNTAX

### Loop through items
```blade
@foreach($items as $item)
  <div>{{ $item->property }}</div>
@endforeach

@forelse($items as $item)
  <div>{{ $item->property }}</div>
@empty
  <p>No items</p>
@endforelse
```

### Conditional
```blade
@if(condition)
  <p>True</p>
@elseif(other)
  <p>Other</p>
@else
  <p>False</p>
@endif

@guest
  <!-- Not logged in -->
@endguest

@auth
  <!-- Logged in -->
@endauth
```

### Asset paths
```blade
{{ asset('images/mountain.jpg') }}     <!-- from public -->
{{ asset('storage/gunung/image.jpg') }} <!-- from storage -->
```

### Links
```blade
<a href="{{ route('route.name') }}">Link</a>
<a href="/gunung/{{ $item->id }}">Link</a>
```

---

## 🔧 JAVASCRIPT QUICK SNIPPETS

### DOM Selection
```javascript
document.getElementById('id')
document.querySelector('.class')
document.querySelectorAll('.class')
document.getElementsByClassName('class')
```

### Event Listener
```javascript
element.addEventListener('click', function() {
  console.log('Clicked');
});

element.addEventListener('scroll', () => {
  // scroll handler
});
```

### Toggle Class
```javascript
element.classList.add('class-name');
element.classList.remove('class-name');
element.classList.toggle('class-name');
element.classList.contains('class-name');
```

### Smooth Scroll
```javascript
element.scrollIntoView({ behavior: 'smooth' });
```

### Prevent Default
```javascript
event.preventDefault();
event.stopPropagation();
```

---

## 📊 FILE SIZE TARGETS

```
Total CSS:      < 100KB (minified)
Total JS:       < 50KB (minified)
Hero Image:     < 150KB (optimized)
Card Images:    < 50KB each (lazy loaded)
Total Page:     < 2MB (with all assets)
```

---

## 🧪 TESTING COMMANDS (If using Laravel)

```bash
# Clear cache
php artisan view:clear
php artisan cache:clear

# Generate storage link (for images)
php artisan storage:link

# Run dev server
npm run dev
php artisan serve

# Build for production
npm run build
```

---

## 📈 PERFORMANCE CHECKLIST

- [ ] Images optimized (WebP format preferred)
- [ ] Lazy loading on images below fold
- [ ] CSS minified
- [ ] JavaScript minified
- [ ] No console errors
- [ ] Lighthouse score > 80
- [ ] First Contentful Paint < 2s
- [ ] Largest Contentful Paint < 4s
- [ ] Cumulative Layout Shift < 0.1

---

## 🎯 PRIORITY ORDER WHEN TIME CONSTRAINED

**Essential (Must Do)**:
1. Navbar responsive + auth states
2. Hero section copy + layout
3. 6 mountains display in grid

**Important (Should Do)**:
4. Proper styling & colors
5. Mobile responsive
6. Hover effects

**Nice-to-Have (If Time Permits)**:
7. Animations
8. Parallax effect
9. Video demo button functionality
10. Loading states

---

## 📞 WHERE TO FIND DETAILS

```
instruksi.md
├── PHASE 1: Navbar specifications
├── PHASE 2: Hero specifications
└── PHASE 3: Mountain cards specifications

design-specifications.md
├── Color system
├── Typography
├── Component showcase
└── Animation specs

implementation-guide.md
├── Step-by-step code examples
├── Blade template syntax
├── CSS classes
└── Testing checklist
```

---

## ⚠️ IF STUCK

1. Check HTML structure matches examples
2. Verify CSS variables are defined
3. Check class names in HTML match CSS
4. Look for typos in file names
5. Clear browser cache (Ctrl+Shift+Delete)
6. Check browser DevTools for errors
7. Verify image paths are correct
8. Test in incognito mode

---

## 🚀 DEPLOYMENT CHECKLIST

Before pushing to production:

- [ ] All CSS applied correctly
- [ ] All images loading
- [ ] No broken links
- [ ] Mobile responsive verified
- [ ] Cross-browser tested
- [ ] Performance acceptable
- [ ] No console errors
- [ ] Git committed with clear messages

---

**Created**: June 2026  
**Status**: Ready for CLI Agent to use  
**Contact**: Refer to instruksi.md for detailed specifications

