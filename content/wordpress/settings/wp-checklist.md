# WordPress Configuration Checklist — paintandfun.no

Complete these steps in order after logging into wp-admin.

---

## 1. CRITICAL: Fix Homepage Routing

The root URL currently shows a 404. The home page only works at `/home/`.

1. Go to **Settings > Reading**
2. Select **"A static page"**
3. Set **Homepage** to the "Home" page
4. Click **Save Changes**
5. Go to **Settings > Permalinks**
6. Select **"Post name"** (`/%postname%/`)
7. Click **Save Changes** (do this twice to flush rewrite rules)
8. Verify: visit `https://www.paintandfun.no/` — it should show the home page

---

## 2. Remove Demo Content

1. Go to **Pages > All Pages** — delete all existing pages (they contain Crown Art demo content)
2. Go to **Posts > All Posts** — delete all demo posts
3. Go to **Products > All Products** — delete demo products
4. Go to **Media > Library** — optionally remove demo images (keep any real ones)
5. Empty the **Trash** for each content type

---

## 3. Site Identity

1. Go to **Appearance > Customize > Site Identity**
2. **Site Title:** `Paint & Fun Norway`
3. **Tagline:** `Ingrid Amuri Rutherford — Visual Artist & Instructor`
4. Upload a **Site Icon** (favicon) — ideally Ingrid's logo or a monogram
5. Upload a **Logo** if the theme supports it

---

## 4. Install & Activate Child Theme

1. Zip the `crown-art-child/` folder from this repo
2. Go to **Appearance > Themes > Add New > Upload Theme**
3. Upload and activate the `crown-art-child.zip`
4. Copy the `assets/flags/` folder (no.svg, en.svg) into `wp-content/themes/crown-art-child/assets/flags/`

---

## 5. Install Required Plugins

Install and activate these plugins from **Plugins > Add New**:

| Plugin | Purpose | Free/Paid |
|--------|---------|-----------|
| **Polylang** | Bilingual NO/EN support | Free |
| **Yoast SEO** or **Rank Math** | SEO optimization | Free |
| **WooCommerce** | Art shop / e-commerce | Free |
| **Vipps for WooCommerce** | Norwegian payment (Vipps/MobilePay) | Free |
| **Contact Form 7** or **WPForms Lite** | Contact form | Free |
| **Smush** or **ShortPixel** | Image optimization | Free |

The Crown Art theme bundles: WPBakery, Revolution Slider, Essential Grid, Booked Appointments. These should already be active.

---

## 6. Configure Polylang (Bilingual)

1. Go to **Languages > Languages**
2. Add **Norsk Bokmål (nb)** — set as default
3. Add **English (en)**
4. Go to **Languages > Settings**
5. URL modification: **"The language is set from the directory name"**
   - This gives URLs like: `paintandfun.no/` (Norwegian) and `paintandfun.no/en/` (English)
6. Set **"Detect browser language"** to Yes
7. Go to **Languages > Strings translations** to translate theme strings
8. Add a **Language Switcher widget** or use the shortcode `[pf_language_switcher]` in the header
   - Alternatively: Appearance > Widgets > add Polylang Language Switcher to the header widget area
   - Settings: Show flags (yes), Show names (no), Dropdown (no)

---

## 7. Create Pages (Both Languages)

Create each page in Norwegian first (default), then create the English translation via Polylang's "+" button.

### Norwegian pages to create:
| Page Title (NO) | Slug | Page Title (EN) |
|-----------------|------|-----------------|
| Hjem | hjem | Home |
| Galleri | galleri | Gallery |
| Om kunstneren | om | About the Artist |
| Kurs & Arrangementer | kurs | Courses & Events |
| Butikk | butikk | Shop |
| Kontakt | kontakt | Contact |

Content for each page is in `content/wordpress/pages/` — paste into WPBakery's text editor.

---

## 8. Navigation Menu

1. Go to **Appearance > Menus**
2. Create a new menu called **"Primary Navigation"**
3. Add all 6 pages in order: Hjem, Galleri, Om, Kurs, Butikk, Kontakt
4. Assign to **Primary Menu** location
5. In Polylang, create a separate English menu or use Polylang's menu sync feature

---

## 9. WooCommerce Setup

1. Go through the **WooCommerce Setup Wizard**:
   - Country: **Norway**
   - Currency: **NOK (kr)**
   - Product type: Physical products
   - Business details: as applicable
2. **Products > Import**: Upload `products.csv` from this repo
   - Map columns to WooCommerce fields
   - After import, replace `<!-- REPLACE: URL -->` image placeholders with uploaded artwork photos
3. **WooCommerce > Settings > Shipping**:
   - Add zone: "Norway" — methods: Local Pickup (free), Flat Rate (set shipping cost)
   - Add zone: "Europe" — Flat Rate (international shipping cost)
4. **WooCommerce > Settings > Payments**:
   - Enable **Vipps/MobilePay** (requires merchant agreement with Vipps)
   - Enable **Stripe** or **PayPal** as fallback for international customers
5. **WooCommerce > Settings > Emails**:
   - Sender name: `Paint & Fun Norway`
   - Sender email: `ingrid@paintandfun.no`
6. Set the **Shop page** to the "Butikk" page in WooCommerce > Settings > Products

### Norwegian VAT (MVA) Note:
If annual revenue from art sales exceeds NOK 50,000, you must register for MVA.
Configure tax rates in WooCommerce > Settings > Tax if applicable.

---

## 10. Contact Form

1. Go to **Contact > Add New** (Contact Form 7) or **WPForms > Add New**
2. Create a form with fields:
   - Name (required)
   - Email (required)
   - Subject (dropdown: General / Commission / Course Booking / Purchase)
   - Message (textarea, required)
3. Set mail recipient to: `ingrid@paintandfun.no`
4. Embed the form on the Contact page using the shortcode

---

## 11. SEO Configuration (Yoast / Rank Math)

1. Run the **setup wizard**
2. For each page, enter the SEO meta from `content/seo/meta-tags.json`:
   - SEO Title
   - Meta Description
   - Open Graph image (upload a representative image)
3. **Social profiles**: Add Facebook and Instagram URLs
4. **Sitemaps**: Enable XML sitemaps (auto-generated)
5. **Breadcrumbs**: Enable if desired

---

## 12. Crown Art Theme Options

1. Go to **Appearance > Customize**
2. **Colors**: Update accent color to `#8b6f4e`
3. **Fonts**: Set heading font to Cormorant Garamond, body to Inter
4. **Header**: Configure logo, enable social icons, add language switcher
5. **Footer**:
   - Copyright text: `© 2026 Ingrid Amuri Rutherford`
   - Add social links: Facebook, Instagram
   - Remove any Crown Art branding
6. **Blog**: Configure if Ingrid wants to write blog posts (art process, exhibition news)

---

## 13. Essential Grid (Gallery)

If using Essential Grid for the gallery page instead of WooCommerce product grid:
1. Go to **Essential Grid > Create New Grid**
2. Source: Custom / Posts (or WooCommerce Products if selling from gallery)
3. Layout: Grid, columns 3, gap 24px
4. Skin: Choose or customize to match the demo site design
5. Add gallery items with artwork images

---

## 14. Booked Appointments (Course Booking)

1. Go to **Appointments > Settings**
2. Set timezone to **Europe/Oslo**
3. Create **services** for each course type (Acrylic Workshop, Watercolor, etc.)
4. Set **available time slots** based on Ingrid's schedule
5. Configure **notification emails** for bookings
6. Embed the booking calendar on the Courses page

---

## 15. Final Checks

- [ ] Homepage loads at root URL (not /home/)
- [ ] All 6 pages load without errors
- [ ] Language toggle works (NO/EN flags)
- [ ] Contact form sends email correctly
- [ ] Shop products display with images and prices
- [ ] Mobile responsive — test on phone
- [ ] Social links work (Facebook, Instagram)
- [ ] No demo/placeholder content remains
- [ ] Google Search Console: submit sitemap
- [ ] Google Business Profile: update website URL
