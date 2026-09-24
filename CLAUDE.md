# Paint & Fun Norway — Project Context

## What This Is

This repo supports **paintandfun.no**, the WordPress website for **Ingrid Amuri Rutherford** — a visual artist and art instructor based in Son, Vestby, Norway. The site serves dual purposes: showcasing her art portfolio AND promoting her Paint & Fun Norway business (art courses/events).

## The Artist

**Ingrid Amuri Rutherford** (b. 1962)
- Born in Canada (Norwegian mother from Skjeberg, father from New Zealand)
- In Norway since 1988, in Son for 12+ years
- Education: BA Art History (Queen's University, Canada), 4-year art (Ontario College of Art, Toronto), 2-year graphic design
- Works in oil and acrylic — bold, colorful paintings seeking "a place between reality and abstraction"
- Themes: Son architecture/landscapes, fjord vistas, forest scenes, conceptual explorations
- Leader of **Vestby Kunstforening** (Vestby Art Association)
- Founder of **Paint & Fun Norway** (2018, org #920406882)
- Email: ingrid@paintandfun.no
- Facebook: ingrid.rutherford.10
- **No Instagram:** links to Instagram were removed in Sept 2026 at her request. Do not add them back, whether as social links, footer icons or schema `sameAs`.

### Exhibition History
- 2025: Kunstvandring i Son (Art Walk), Cafe Oliven — 26 artists
- 2024: Exhibition at Solhøy, Vestby, with Ann-Cathrin Torp
- 2021: First solo exhibition, Galleri Ppalett, Son — 21 paintings

### Roles & Community
- Leader of Vestby Kunstforening (organizes exhibitions, art walks, book club)
- Jury member, Vestby kommune byggeskikkpris 2022
- Manages rotating exhibitions at Solhøy omsorgsboliger

### IMPORTANT: Do NOT mention "Kulturdøgn Soon" anywhere. Ingrid is no longer involved and does not want it referenced.

## WordPress Site

**URL:** https://www.paintandfun.no/
**Theme:** Crown Art (parent theme by AncoraThemes, from ThemeForest)
**WordPress API:** https://www.paintandfun.no/wp-json/wp/v2
**Credentials:** Username `ingrid.rutherford`, application password stored separately. Claude doesn't handle it. For wp-admin edits, the user logs in via the in-app browser pane and Claude edits pages there.

### Active Plugins
- Polylang (bilingual NO/EN)
- Yoast SEO
- Simple CSS (custom CSS management — this is how we inject styles)
- Disable Comments (by WPDeveloper, set to "Everywhere") — added Sept 2026 after ~24,000 spam comments
- Akismet (installed, never configured — not needed while comments are disabled)
- iThemes Security, WP Super Cache, The Events Calendar (tribe), MailChimp for WP
- Essential Grid, WPBakery, ThemeREX Addons (bundled with Crown Art)

### Inactive / Removed
- **WooCommerce is NOT active** (no `wc` REST namespace). The 10 product posts still exist in the DB but return 404 on the front end and have no admin UI. Spam was being posted to them as comments — Disable Comments now blocks this.
- **Contact form removed (Sept 2026)** due to spam. CF7 form 109 was deleted and the form was removed from the Kontakt/Contact pages. Deactivating the Contact Form 7 plugin itself was recommended, but it hadn't been confirmed when these notes were last updated. Do NOT re-add a contact form — the pages link to `mailto:ingrid@paintandfun.no` instead.
- Vipps plugins (installed but INACTIVE — waiting for merchant agreement)

### Checking the Live Site Without Credentials
- Page content: `GET /wp-json/wp/v2/pages/{id}?_fields=status,content`. A trashed page returns `rest_forbidden` (401); a deleted page returns `rest_post_invalid_id` (404).
- Active plugins show up as REST namespaces in `GET /wp-json/`. Parse the `"namespaces"` array and don't just grep the whole response, because JSON escaping makes naive greps unreliable.
- Comments blocked? `POST /wp-comments-post.php` with `comment_post_ID=<id>&comment=` (empty, so nothing is created) should answer "Beklager, men det er ikke åpent for kommentarer."
- Claude must not handle the application password (safety rule). For authenticated changes, give Ingrid/Charles wp-admin steps instead.

### Page IDs

| Norwegian | ID | English | ID |
|-----------|-----|---------|-----|
| Hjem | 385 | Home | 521 |
| Galleri | 220 | Gallery | 525 |
| Om kunstneren | 299 | About the Artist | 526 |
| Kurs og Arrangementer | 215 | Courses & Events | 527 |
| Butikk | 214 | Shop | 528 |
| Kontakt | 217 | Contact | 529 |

### Menu IDs
- Norwegian menu: ID 5 (Galleri, Om, Kurs, Butikk, Kontakt, EN)
- English menu: ID 33 (Gallery, About, Courses, Shop, Contact, NO)

### Media IDs (Artwork Images)
| ID | Artwork |
|----|---------|
| 433 | Tulipaner og hjort (Tulips and Deer) |
| 442 | Blomster i dekorert vase (Flowers in Painted Vase) |
| 443 | Gatebilde fra Son (Son Street Scene) |
| 444 | Solnedgang ved kysten (Coastal Sunset) |
| 445 | Havnesolnedgang (Harbor Sunset) |
| 446 | Sommerbading (Summer Swimming) |
| 447 | Svingete vei (Winding Road) |
| 448 | Solnedgangsrefleksjon (Sunset Reflection) |
| 449 | Stilleben med jordbær (Still Life with Strawberries) |
| 450 | Vestby Herregaard (Vestby Manor) |

### WooCommerce Products (10 products, IDs 462-471)
All original paintings, prices 3,800–6,500 NOK. Categories: Original Paintings (29), Prints (30), Large Format (31). **Currently orphaned — WooCommerce is inactive, so these 404.** The Butikk/Shop pages say "Nettbutikk kommer snart" and point to the contact page.

### Blog Posts (English SEO)
- ID 459: "Ingrid Amuri Rutherford — Visual Artist in Son, Norway"
- ID 460: "Art in Son, Norway — Galleries, Events & the Oslofjord Artist Tradition"

## Design

- **Accent color:** `#e6b8c4` (pale pink)
- **Background:** `#faf8f6` (warm off-white)
- **Headings:** Cormorant Garamond, weight 300
- **Body:** System sans-serif stack, 16-17px
- **Header layout:** LEFT = "Ingrid Amuri Rutherford" + "Visual Artist — Son, Norway" | RIGHT = "Paint & Fun Norway" + "Art Experiences & Instruction" (injected via CSS pseudo-elements)
- **Footer:** Dark (#2c2c2c) with pink accent links

### CSS Management
All custom CSS lives in the **Simple CSS** plugin (Appearance → Simple CSS in wp-admin). The CSS is NOT injectable via the REST API. The combined CSS file is at `complete-css.css` + `language-fix-css.css` in this repo.

**Do NOT inject `<style>` tags into page content** — WordPress strips them and they render as visible text.

### Key CSS Classes Used in Page Content
- `pf-two-col` — two-column grid layouts (stacks on mobile)
- `pf-gallery-grid` — gallery image grid (3→2→1 columns responsive)
- `pf-contact-grid` — contact page wrapper; now a single column (inline `grid-template-columns:1fr`) since the form was removed

## Repo Structure

```
ingrid-art/
├── index.html, gallery.html, etc.    # Static demo site (GitHub Pages)
├── assets/css/main.css               # Demo site CSS
├── assets/js/i18n.js, main.js        # Demo site JS (bilingual toggle)
├── assets/flags/no.svg, en.svg       # Flag icons
├── content/translations/no.json, en.json  # Translation strings
├── content/seo/meta-tags.json        # SEO meta for all pages
├── content/wordpress/products/       # WooCommerce CSV
├── content/wordpress/settings/wp-checklist.md  # Deployment guide
├── crown-art-child/                  # WordPress child theme (NOT active)
├── pieces/                           # Original artwork images
├── complete-css.css                  # Combined desktop+mobile CSS for Simple CSS plugin
├── language-fix-css.css              # Polylang language switcher CSS
├── desktop-css.css                   # Desktop-only CSS (reference)
├── mobile-css.css                    # Mobile-only CSS (reference)
└── sitemap.xml, robots.txt
```

## Son, Norway — Context for SEO

Son is a historic coastal trading town on the Oslofjord (~40 min south of Oslo), registered as a nationally significant cultural environment since 2013. Artist colony tradition from 1900-1920. Multiple active galleries (Galleri Soon, kunstSONen, Ppalett). Nearby Hvitsten has Edvard Munch's restored property (Ramme). Annual events: Kunstvandring i Son (art walk, July), annual fall exhibition at Vestby Prestegård.

## What's Left To Do

- **Deactivate Contact Form 7:** Plugins → Contact Form 7 → Deactivate (or delete). It was still active on 2026-09-25, although form 109 is gone.
- **WooCommerce / shop decision:** either reactivate WooCommerce (then turn OFF product reviews in WooCommerce → Settings → Products) or leave the shop as "coming soon".
- **WordPress core update:** 7.1.2 available as of Sept 2026.
- **Static demo `contact.html`** still has a form, but it only opens a `mailto:` link and doesn't send anything itself. Remove it if the demo should match the live site.

- **Vipps payment:** Activate plugins when Ingrid has a merchant agreement from portal.vipps.no
- **Polylang page translations:** Link Norwegian and English pages as translation pairs in Polylang admin
- **More artwork:** Upload additional pieces as Ingrid creates them
- **Course listings:** Add actual course dates/details when Paint & Fun Norway schedules them
- **Child theme:** The `crown-art-child/` exists but is NOT active. The parent Crown Art theme is active with Simple CSS handling customizations. The child theme had installation issues.
