# 🎨 DESIGN SPECIFICATIONS & COMPONENT GUIDELINES
## Mountix Homepage Refactor

---

## 📐 RESPONSIVE BREAKPOINTS REFERENCE

```
Mobile:        0px - 639px        (base, no prefix)
Small Tablet:  640px - 767px      (sm)
Tablet:        768px - 1023px     (md)
Desktop:       1024px - 1279px    (lg)
Large Desktop: 1280px+            (xl)

Usage in media queries:
@media (max-width: 767px) { /* mobile */ }
@media (min-width: 768px) { /* tablet up */ }
@media (min-width: 1024px) { /* desktop up */ }
@media (min-width: 1280px) { /* large desktop */ }
```

---

## 🎭 COMPONENT SHOWCASE & SPECIFICATIONS

### 1. BUTTON VARIANTS

#### Primary Button
```html
<button class="btn btn-primary">
  Temukan Gunung Pilihan
</button>
```
- **Background**: var(--accent-main) #00A86B
- **Text Color**: White (#FFFFFF)
- **Padding**: 12px 32px (sm), 16px 32px (lg)
- **Border Radius**: 8px
- **Font Weight**: 600
- **Font Size**: 16px (sm), 18px (lg)
- **Hover**: 
  - Background: var(--accent-hover) #00916D
  - Shadow: 0 6px 20px rgba(0, 168, 107, 0.4)
  - Transform: translateY(-2px)
- **Active**: Darker shade, no transform
- **Disabled**: Opacity 0.5, cursor not-allowed

#### Secondary Button
```html
<button class="btn btn-secondary">
  Lihat Ketersediaan
</button>
```
- **Background**: Transparent
- **Border**: 2px solid var(--primary-main) #2E7D32
- **Text Color**: var(--primary-main) #2E7D32
- **Padding**: 10px 24px
- **Border Radius**: 8px
- **Font Weight**: 600
- **Hover**:
  - Background: var(--primary-light) #66BB6A
  - Text Color: White
  - Border Color: var(--primary-light)

#### Link Button
```html
<a class="btn btn-link">
  Lihat Selengkapnya →
</a>
```
- **Background**: Transparent
- **Text Color**: var(--primary-main) #2E7D32
- **Font Weight**: 600
- **Text Decoration**: None
- **Hover**:
  - Background: var(--gray-100) #F9FAFB
  - Transform: translateX(4px)
  - Border Radius: 4px

#### Icon + Text Button
```html
<button class="btn btn-primary">
  <span class="icon">🏔️</span>
  <span>Temukan Gunung</span>
</button>
```
- **Display**: inline-flex
- **Gap**: 8px
- **Align Items**: center
- **Justify Content**: center

---

### 2. TEXT STYLES

#### Heading 1 (Page Title)
```html
<h1>Booking Pendakian Gunung Impian Anda</h1>
```
- **Font Size**: 36px (desktop), 24px (mobile)
- **Font Weight**: 800
- **Line Height**: 1.2 (tight)
- **Color**: var(--gray-900) #1F2937
- **Letter Spacing**: -0.5px
- **Margin Bottom**: 8px

#### Heading 2 (Section Title)
```html
<h2>Gunung Populer</h2>
```
- **Font Size**: 30px (desktop), 24px (mobile)
- **Font Weight**: 800
- **Line Height**: 1.2
- **Color**: var(--gray-900)
- **Letter Spacing**: -0.5px

#### Heading 3 (Card Title)
```html
<h3>Gunung Lawu</h3>
```
- **Font Size**: 20px
- **Font Weight**: 700
- **Line Height**: 1.4
- **Color**: var(--gray-900)

#### Body Text
```html
<p>Temukan jalur terbaik dari 50+ destinasi...</p>
```
- **Font Size**: 16px
- **Font Weight**: 400
- **Line Height**: 1.5 (normal)
- **Color**: var(--gray-800) #374151
- **Letter Spacing**: normal

#### Small Text (supporting)
```html
<p class="text-sm">Dari Rp 20.000</p>
```
- **Font Size**: 14px
- **Font Weight**: 400 or 500
- **Color**: var(--gray-700) #4B5563

#### Extra Small Text
```html
<span class="text-xs">✓ Tersedia</span>
```
- **Font Size**: 12px
- **Font Weight**: 600
- **Text Transform**: uppercase
- **Letter Spacing**: 0.5px

---

### 3. CARD COMPONENTS

#### Mountain Card Anatomy
```
┌─────────────────────────────────┐
│ [Status Badge - top right]      │
│ ┌─────────────────────────────┐ │
│ │   Image (200px height)      │ │
│ │   + Dark Overlay            │ │
│ └─────────────────────────────┘ │
│                                 │
│ Gunung Lawu          ⭐ 4.0     │  (Card Header)
│ 📍 Magetan, Jawa Tim...         │  (Location)
│ (125 ulasan)                    │  (Reviews)
│                                 │
│ ┌─────────────────────────────┐ │
│ │ Dari Rp 20.000             │ │  (Price Box)
│ └─────────────────────────────┘ │
│                                 │
│ [🗓️ Lihat Ketersediaan]         │
│ [Detail →]                      │
└─────────────────────────────────┘
```

**Card Specifications:**
- **Width**: 280px (min), responsive grid
- **Background**: White (#FFFFFF)
- **Border Radius**: 12px
- **Box Shadow**: 0 4px 6px -1px rgba(0,0,0,0.1)
- **Hover Shadow**: 0 10px 15px -3px rgba(0,0,0,0.1)
- **Hover Transform**: translateY(-8px)
- **Transition**: all 0.3s ease

**Card Image:**
- **Height**: 200px
- **Object Fit**: cover
- **Object Position**: center
- **Hover Effect**: scale(1.05)

**Status Badge:**
- **Position**: absolute top-right (12px from edges)
- **Padding**: 8px 12px
- **Border Radius**: 9999px (full rounded)
- **Font Size**: 12px
- **Font Weight**: 600
- **Text Transform**: uppercase

Badge Status:
```
✓ Tersedia:  Background #E0F2FE with green text
⚠️ Terbatas:  Background #FEF3C7 with orange text
✗ Penuh:     Background #FEE2E2 with red text
```

---

### 4. FORM INPUTS (Future reference)

#### Text Input
```html
<input type="text" placeholder="Cari nama gunung..." class="input">
```
- **Padding**: 12px 16px
- **Border**: 1px solid var(--border-color) #E5E7EB
- **Border Radius**: 8px
- **Font Size**: 16px
- **Focus**:
  - Border Color: var(--primary-main)
  - Box Shadow: 0 0 0 3px rgba(46, 125, 50, 0.1)
  - Outline: none

#### Dropdown Select
- **Same styling as text input**
- **Cursor**: pointer
- **Options text**: var(--gray-900)

---

### 5. BADGES & LABELS

#### Status Badge (in cards)
See "Status Badge" section above

#### Rating Stars
```html
<span class="stars">★★★★☆</span>
<span class="rating-value">4.0</span>
```
- **Stars Color**: var(--warning) #F59E0B
- **Font Size**: 14px
- **Rating Value**: var(--gray-900), bold

#### Location Label
```html
<p class="card-location">📍 Magetan, Jawa Timur</p>
```
- **Font Size**: 14px
- **Color**: var(--gray-700)
- **Emoji**: Yes, included in text

---

### 6. SPACING & LAYOUT

#### Container/Section Padding
```
Desktop:  48px horizontal, 48px vertical
Tablet:   32px horizontal, 40px vertical
Mobile:   16px horizontal, 32px vertical
```

#### Grid Gap
```
Mountains Grid:
- Desktop: 24px gap
- Tablet:  16px gap
- Mobile:  16px gap
```

#### Section Margins
```
Section to Section:    64px (--spacing-16)
Card to Card:          24px (--spacing-6)
Text Elements:         12-16px (--spacing-3 to --spacing-4)
Button to Button:      16px (--spacing-4)
```

---

### 7. HOVER & INTERACTION STATES

#### Card Hover
```
Transform: translateY(-8px)
Shadow: 0 10px 15px -3px rgba(0,0,0,0.1)
Image: scale(1.05)
Duration: 0.3s ease
```

#### Button Hover
```
Primary:
- Background darkens slightly
- Scale up with shadow
- Duration: 0.2s

Secondary:
- Background color change
- Border color change
- Duration: 0.2s
```

#### Link Hover
```
Color: change to primary-main
Background: light gray background
Transform: translateX(4px)
Duration: 0.2s
```

---

### 8. LOADING STATES (For future)

#### Skeleton Loaders (cards)
```html
<div class="skeleton">
  <div class="skeleton-image"></div>
  <div class="skeleton-text"></div>
  <div class="skeleton-text short"></div>
</div>
```

**Skeleton Styling:**
- **Background**: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%)
- **Background Size**: 200% 100%
- **Animation**: pulse 1.5s infinite
- **Border Radius**: match component

---

### 9. EMPTY STATES (For future)

```html
<div class="empty-state">
  <div class="empty-icon">📭</div>
  <h3>Tidak Ada Destinasi</h3>
  <p>Coba ubah filter pencarian Anda</p>
  <a href="/gunung" class="btn btn-primary">
    Kembali Ke Daftar Lengkap
  </a>
</div>
```

**Empty State Styling:**
- **Padding**: 48px 24px
- **Text Align**: center
- **Icon Font Size**: 64px
- **Gap**: 16px between elements

---

### 10. SHADOWS (Elevation System)

```css
--shadow-sm: 0 1px 2px 0 rgba(0,0,0,0.05);
/* Card baseline, subtle */

--shadow-md: 0 4px 6px -1px rgba(0,0,0,0.1);
/* Default card shadow */

--shadow-lg: 0 10px 15px -3px rgba(0,0,0,0.1);
/* Card hover state */

--shadow-xl: 0 20px 25px -5px rgba(0,0,0,0.1);
/* Modals, dropdowns */
```

---

## 🎬 ANIMATION SPECIFICATIONS

### Fade In Up (Hero Content)
```css
@keyframes fadeInUp {
  from {
    opacity: 0;
    transform: translateY(30px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.hero-inner {
  animation: fadeInUp 0.8s ease-out;
}
```

### Bounce (Scroll Indicator)
```css
@keyframes bounce {
  0%, 100% {
    transform: translateY(0);
  }
  50% {
    transform: translateY(8px);
  }
}

.scroll-arrow {
  animation: bounce 2s infinite;
}
```

### Pulse (Opacity)
```css
@keyframes pulse {
  0%, 100% {
    opacity: 0.5;
  }
  50% {
    opacity: 1;
  }
}
```

### Scale On Hover (Card)
```css
.mountain-card:hover {
  animation: scaleUp 0.3s ease-out forwards;
}

@keyframes scaleUp {
  from {
    transform: scale(1);
  }
  to {
    transform: scale(1.02);
  }
}
```

---

## 🔄 TRANSITION TIMINGS

- **Quick interactions** (hover color change): 0.2s
- **Medium interactions** (button hover, dropdown): 0.2s - 0.3s
- **Animations** (entrance, scroll): 0.8s - 1.5s

**Easing:**
- Subtle movements: `ease-out`
- Complex animations: `cubic-bezier(0.4, 0, 0.2, 1)`
- Simple color changes: `ease`

---

## 📏 SIZING STANDARDS

### Component Sizes

**Buttons:**
- Small (sm): 32px height, 14px font
- Medium (md): 40px height, 16px font
- Large (lg): 48px height, 18px font

**Input Fields:**
- Height: 40px
- Padding: 12px 16px
- Font Size: 16px (prevents iOS zoom)

**Card:**
- Min Width: 280px
- Height: Auto (flex)
- Image Height: 200px

**Icons:**
- Small: 16px
- Medium: 24px
- Large: 32px
- Hero Icons: 60px+

---

## ✅ QUALITY CHECKLIST

### Visual Consistency
- [ ] All colors use CSS variables (no hardcoded hex)
- [ ] Spacing uses spacing scale (8px baseline)
- [ ] Typography scales consistently
- [ ] Border radius consistent (4px, 8px, 12px, 9999px)
- [ ] Shadows match elevation system

### Responsiveness
- [ ] Mobile view (375px) - looks good
- [ ] Tablet view (768px) - layout adapts
- [ ] Desktop view (1024px+) - full layout
- [ ] No horizontal scrolling
- [ ] Touch targets >= 44px

### Accessibility
- [ ] Color contrast >= 4.5:1 for normal text
- [ ] Heading hierarchy correct (h1 → h2 → h3)
- [ ] Alt text on all images
- [ ] Button labels clear
- [ ] Focus visible on interactive elements
- [ ] Form labels associated with inputs

### Performance
- [ ] Images optimized (< 100KB for web)
- [ ] CSS minified
- [ ] Animations use GPU (transform, opacity)
- [ ] No inline styles
- [ ] Lazy loading for images below fold

### Browser Support
- [ ] Chrome (latest)
- [ ] Firefox (latest)
- [ ] Safari (latest)
- [ ] Edge (latest)
- [ ] Mobile browsers (iOS Safari, Chrome Mobile)

---

## 🎨 DESIGN TOKENS QUICK REFERENCE

```json
{
  "colors": {
    "primary": {
      "dark": "#1B5E20",
      "main": "#2E7D32",
      "light": "#66BB6A"
    },
    "secondary": {
      "main": "#FF8C42",
      "light": "#FFB74D"
    },
    "accent": {
      "main": "#00A86B",
      "hover": "#00916D"
    },
    "gray": {
      "900": "#1F2937",
      "800": "#374151",
      "700": "#4B5563",
      "100": "#F9FAFB",
      "50": "#FFFFFF"
    },
    "status": {
      "success": "#10B981",
      "warning": "#F59E0B",
      "error": "#EF4444"
    }
  },
  "spacing": {
    "2": "8px",
    "3": "12px",
    "4": "16px",
    "6": "24px",
    "8": "32px",
    "10": "40px",
    "12": "48px",
    "16": "64px",
    "20": "80px"
  },
  "fontSize": {
    "xs": "12px",
    "sm": "14px",
    "base": "16px",
    "lg": "18px",
    "xl": "20px",
    "2xl": "24px",
    "3xl": "30px",
    "4xl": "36px"
  },
  "borderRadius": {
    "sm": "4px",
    "md": "8px",
    "lg": "12px",
    "xl": "16px",
    "full": "9999px"
  }
}
```

---

## 📞 COMPONENT USAGE EXAMPLES

### Example 1: Mountain Card with All States

```html
<!-- Available -->
<div class="mountain-card">
  <div class="card-badge tersedia">✓ Tersedia</div>
  <!-- ... rest of card -->
</div>

<!-- Limited -->
<div class="mountain-card">
  <div class="card-badge limited">⚠️ Terbatas</div>
  <!-- ... rest of card -->
</div>

<!-- Sold Out -->
<div class="mountain-card">
  <div class="card-badge soldout">✗ Penuh</div>
  <!-- ... rest of card -->
</div>
```

### Example 2: Button Group (CTA)

```html
<div class="hero-actions">
  <!-- Primary CTA -->
  <a href="/gunung" class="btn btn-primary btn-lg">
    <span>🏔️</span>
    <span>Temukan Gunung Pilihan</span>
  </a>

  <!-- Secondary CTA -->
  <button class="btn btn-secondary btn-lg" id="videoDemo">
    <span>▶️</span>
    <span>Tonton Demo (2 menit)</span>
  </button>
</div>
```

### Example 3: Hero Section

```html
<section class="hero">
  <div class="hero-background">
    <img src="..." alt="..." class="hero-image">
    <div class="hero-overlay"></div>
  </div>

  <div class="hero-content">
    <div class="hero-inner">
      <h1 class="hero-title">
        Booking Pendakian Gunung
        <span class="highlight">Impian Anda</span>
      </h1>
      <!-- ... rest -->
    </div>
  </div>
</section>
```

---

**Last Updated**: June 2026  
**Version**: 1.0  
**Status**: Ready for Implementation

