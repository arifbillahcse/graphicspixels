# Graphics Pixels — Custom WordPress Theme

A complete, custom-built WordPress theme for **Graphics Pixels**, a professional
photo editing, retouching, 3D, and video editing service. This theme was converted
from the original hand-coded HTML website into a fully dynamic, self-manageable
WordPress site — so the content, blog, forms, and contact details can all be
updated from the WordPress dashboard **without hiring a developer**.

> **New to WordPress or non-technical?** Don't worry — this document is written so
> that anyone can understand what this theme is, what it does, and how to run it.
> Sections aimed at developers are clearly marked *(Technical)*.

---

## Table of Contents

1. [What This Theme Is (in plain English)](#1-what-this-theme-is-in-plain-english)
2. [Key Features](#2-key-features)
3. [Technology & Framework](#3-technology--framework)
4. [System Requirements](#4-system-requirements)
5. [What's Inside — Pages & Structure](#5-whats-inside--pages--structure)
6. [Installation Guide](#6-installation-guide)
7. [Managing Your Site (No Coding Needed)](#7-managing-your-site-no-coding-needed)
8. [Form Submissions & Where They Go](#8-form-submissions--where-they-go)
9. [Spam Protection](#9-spam-protection)
10. [Images & Storage](#10-images--storage)
11. [SEO](#11-seo)
12. [Project Statistics (Code Size)](#12-project-statistics-code-size)
13. [Frequently Asked Questions](#13-frequently-asked-questions)
14. [Support & Credits](#14-support--credits)

---

## 1. What This Theme Is (in plain English)

Think of a WordPress **theme** as the "skin" and "brain" of your website — it
controls how every page looks *and* how the site behaves. This particular theme
was **custom-made** for Graphics Pixels (it is not a generic template bought from a
marketplace). Everything — the design, the menus, the service pages, the blog, and
the contact forms — was tailored to this business.

The big advantage: once installed, **you control the website yourself** from a
simple dashboard. You can publish blog posts, read customer enquiries, change your
phone number or address, and more — all by clicking buttons, not writing code.

---

## 2. Key Features

### 🎨 Design & Pages
- **30 ready-made pages** automatically created on setup (Home, Services, Portfolio, Pricing, About, Contact, 11 individual service pages, and more).
- Fully **responsive** — looks great on desktop, tablet, and mobile.
- Shared **header and footer** across the whole site (change once, updates everywhere).
- Interactive elements preserved from the original site: before/after image sliders, dropdown menus, animated sections, a free-trial popup, a floating WhatsApp button, and a back-to-top button.
- **Multilingual landing pages** included (German, Spanish, French, Italian).

### 📝 Blog System
- A fully **dynamic blog** — publish posts from the dashboard and they appear automatically.
- Clean, branded **single-post layout** and a modern **3-column post grid**.
- A **default branded thumbnail** automatically shown for posts without a featured image.
- Comments are **disabled** site-wide (no comment spam to moderate).

### 📩 Lead Capture (Forms)
- **Free Trial form** (appears both as a page and as a popup on every page) and a **Contact form**.
- Every submission is **saved inside WordPress** and viewable in the dashboard.
- Optional **email alerts** to any address you choose when a form is submitted.
- Uploaded files (customer photos) are **stored and previewable** right in the dashboard.
- Optional **automatic forwarding** of submissions to an external app/API.

### ⚙️ Self-Management (No Developer Needed)
- **Editable contact details** — update address, phone, email, and WhatsApp link from a settings screen.
- **Configurable notification email** — decide where enquiry alerts are sent.
- **One-click page creation/repair** tool.

### 🔒 Security & Quality
- **Spam protection** on all forms (honeypot + rate-limiting) — no external service required.
- Built following **WordPress coding standards** with proper data sanitization and escaping.
- **SEO-ready** — fully compatible with the Yoast SEO plugin on every page.

---

## 3. Technology & Framework

| Layer | Technology Used |
|---|---|
| **Platform / Framework** | WordPress (self-hosted, wordpress.org) |
| **Backend language** | PHP 7.4+ |
| **Core WordPress APIs** | Template Hierarchy, Settings API, Options API, Transients API, WP_Query, `wp_mail()`, `wp_remote_post()`, Custom Post Types, `media_handle_upload()` |
| **Frontend** | HTML5, CSS3 (custom, no framework bloat), vanilla JavaScript (no jQuery dependency) |
| **Icons** | Font Awesome 6.5 |
| **Fonts** | Google Fonts (Poppins & Inter) |
| **3D models** | Google `<model-viewer>` (for 3D service pages) |
| **SEO** | Yoast SEO compatible |
| **Data storage** | WordPress database (MySQL/MariaDB) + Media Library |

**No page builder required.** This is a clean, hand-built theme — it does not depend
on Elementor, WPBakery, Divi, or any heavy builder plugin, which keeps it fast and
lightweight.

---

## 4. System Requirements

To run this theme, your web hosting needs:

| Requirement | Minimum | Recommended |
|---|---|---|
| **WordPress** | 6.0 | Latest version |
| **PHP** | 7.4 | 8.1 or newer |
| **MySQL** / MariaDB | 5.6 / 10.1 | 8.0 / 10.5+ |
| **HTTPS (SSL certificate)** | Required | Required |
| **PHP `upload_max_filesize`** | 25 MB | 32 MB+ (for customer file uploads) |
| **PHP `post_max_size`** | 25 MB | 32 MB+ |

Almost every modern WordPress host (SiteGround, Bluehost, Hostinger, Kinsta,
Cloudways, etc.) meets these requirements by default.

**Recommended companion plugins (all free):**
- **Yoast SEO** — for the SEO team to manage titles, keywords, and meta descriptions.
- **An SMTP plugin** (e.g. WP Mail SMTP) — ensures form notification emails reliably reach your inbox.

---

## 5. What's Inside — Pages & Structure

### Pages automatically created (30 total)
Home · Services · 11 individual service pages (Clipping Path, Photo Retouching,
Ghost Mannequin, Headshot Editing, Background Removal, Color Correction, Drop Shadow,
Image Masking, E-commerce Editing, Photo Restoration, AI Image Fixes) · Photo Editing ·
3D Service · 3D Modeling · 3D Rendering · Video Editing · Portfolio · Portfolio 2 ·
Pricing · About Us · Contact · Free Trial · FAQ · Blog · Reviews ·
4 translated landing pages (DE, ES, FR, IT).

### Folder structure *(Technical)*
```
graphicspixels-theme/
├── style.css              → Theme identity + version
├── functions.php          → Core setup, asset loading, comments-off, helpers
├── header.php             → Site-wide header/navigation
├── footer.php             → Site-wide footer, WhatsApp button, free-trial popup
├── front-page.php         → Homepage
├── index.php              → Blog listing (fallback)
├── single.php             → Single blog post layout
├── archive.php            → Category/tag/date listings
├── page.php               → Default page layout
├── template-*.php         → 30 individual page templates
├── inc/
│   ├── submissions.php     → Form handling, storage, email, spam protection
│   ├── auto-pages.php      → Auto-creates all pages on activation
│   └── site-info.php       → Editable address/phone/email settings
├── assets/
│   └── blog-placeholder.svg → Default blog thumbnail
├── css/                   → Stylesheets
├── js/                    → JavaScript (animations, forms, interactions)
└── README-INSTALL.md      → Step-by-step setup instructions
```

---

## 6. Installation Guide

**Step 1 — Install the theme**
1. Zip the `graphicspixels-theme` folder.
2. In WordPress admin, go to **Appearance → Themes → Add New → Upload Theme**.
3. Upload the zip and click **Activate**.

**Step 2 — Set permalinks**
Go to **Settings → Permalinks**, choose **Post name**, and Save.

**Step 3 — Upload the images (one-time)**
The images live outside the theme to keep it lightweight. Using your hosting file
manager or FTP, upload the provided `images/` folder into
`wp-content/uploads/graphicspixels/` so the path becomes
`wp-content/uploads/graphicspixels/images/…`.

**Step 4 — Pages appear automatically**
On activation, all 30 pages are created for you and appear under **Pages → All Pages**.

**Step 5 — Set your Home and Blog pages**
Go to **Settings → Reading**, set the Homepage to "Home". (Leave the Posts page
unset — the Blog page is already dynamic on its own.)

> 📘 A more detailed version of these steps is in **`README-INSTALL.md`**.

---

## 7. Managing Your Site (No Coding Needed)

Everything below is done by clicking in the WordPress dashboard:

| I want to… | Go to… |
|---|---|
| Write a blog post | **Posts → Add New** |
| See customer free-trial requests | **Trial Requests** (left menu) |
| See contact messages | **Contact Messages** (left menu) |
| Change where enquiry emails are sent | **Trial Requests → Notifications** |
| Change address / phone / WhatsApp | **Appearance → Site Info** |
| Re-create a deleted page | **Appearance → Create Pages** |
| Edit any page's text | **Pages → All Pages → Edit** |
| Manage SEO titles & keywords | Yoast box on each page |

---

## 8. Form Submissions & Where They Go

When a visitor submits the **Free Trial** or **Contact** form:

1. ✅ The submission is **saved in WordPress** (under *Trial Requests* / *Contact Messages*) — you can view every field and download any uploaded photo.
2. 📧 An **email notification** is sent to your chosen address (configurable, can be turned off).
3. 🔁 *(Optional)* The submission is **forwarded to your external app/API** if you enable it in `wp-config.php`.

Because submissions are stored in the database, **you never lose a lead**, even if
an email fails to deliver.

---

## 9. Spam Protection

All forms are protected **without** annoying CAPTCHA puzzles:

- **Honeypot trap** — an invisible field that catches automated spam bots.
- **Rate limiting** — blocks repeated rapid submissions from the same visitor.

Spam is silently discarded — it's never saved, emailed, or forwarded.

---

## 10. Images & Storage

- **Design/site images** (logos, banners, service photos) are stored in `wp-content/uploads/graphicspixels/` as static files — this keeps the theme small and fast.
- **Blog images & customer uploads** go into the standard WordPress **Media Library** (`wp-content/uploads/`), fully manageable in the dashboard.
- The two never conflict, and blog/post images added later behave exactly as normal WordPress media.

---

## 11. SEO

- Every page is a normal WordPress Page or Post — so the **Yoast SEO** plugin works on all of them.
- Your SEO specialist can set **SEO titles, focus keywords, and meta descriptions** on each page individually, with no developer involvement.
- The theme deliberately does not hardcode meta tags, leaving full control to Yoast.

---

## 12. Project Statistics (Code Size)

A transparent look at the scale of this project:

| Metric | Value |
|---|---|
| **Total theme size** (code, excluding images) | ~1.8 MB |
| **Total files** | 57 |
| **Total lines of code** (PHP + CSS + JS) | **25,343** |
| **Total words of code** | **105,219** |
| **Page templates** | 30 |

### Breakdown by language

| Language | Files | Lines | Words |
|---|---|---|---|
| **PHP** | 41 | 21,272 | 88,464 |
| **CSS** | 4 | 2,200 | 9,920 |
| **JavaScript** | 9 | 1,871 | 6,835 |
| **SVG** | 1 | 20 | 113 |
| **Documentation (MD)** | 1 | 149 | 991 |

> *Note:* the majority of the PHP lines are the site's design/content markup carried
> over from the original HTML pages during conversion. Roughly **1,500–2,000 lines**
> are original, custom-written functionality (forms, blog system, spam protection,
> settings pages, auto-page creation, and theme scaffolding).

---

## 13. Frequently Asked Questions

**Q: Do I need to know how to code to run this site?**
No. Everything day-to-day (posts, enquiries, contact info, SEO) is managed by
clicking in the WordPress dashboard.

**Q: Will my blog posts show up automatically?**
Yes. Publish a post and it appears on the Blog page instantly, with its image.

**Q: Where do customer enquiries go?**
Into your WordPress dashboard (and optionally your email), so nothing is ever lost.

**Q: Can I change my phone number or address later?**
Yes — **Appearance → Site Info**, no developer required.

**Q: Is it protected from spam?**
Yes, built-in, with no CAPTCHA and no paid service needed.

**Q: Does it work with SEO tools?**
Yes, fully compatible with Yoast SEO on every page.

**Q: Is it fast?**
Yes — it's a lightweight custom theme with no heavy page-builder plugins, and images
are served efficiently from the uploads folder.

---

## 14. Support & Credits

- **Theme:** Graphics Pixels (custom build)
- **Current Version:** 1.4.5
- **Platform:** WordPress (self-hosted)
- **Developed by:** [Softorio](https://softorio.com)

For setup help, refer to `README-INSTALL.md`, or contact your developer/agency.

---

*© 2013–2026 Graphics Pixels. All rights reserved.*
