# Graphics Pixels WordPress Theme — Installation Guide

Converted from the static HTML site. Every page is a WordPress **Page** with its own
page template, so your SEO specialist can manage titles/keywords per page with Yoast.

## 1. Install the theme

1. Zip the `graphicspixels-theme` folder (the folder itself, so the zip contains
   `graphicspixels-theme/style.css` at its top level).
2. In wp-admin: **Appearance → Themes → Add New → Upload Theme** → upload the zip → **Activate**.

## 2. Set permalinks

**Settings → Permalinks → Post name** → Save. (Required — all internal links use `/page-slug/` URLs.)

## 3. Create the pages

For each row below: **Pages → Add New**, set the **Title**, make sure the **slug**
matches exactly (Yoast/permalink box under the title), leave content empty, and in
the **Page Attributes → Template** dropdown pick the listed template. Publish.

| Page title | Slug | Template |
|---|---|---|
| Home | (any) | — see step 4 |
| Services | `services` | Services |
| Clipping Path Service | `clipping-path-service` | Clipping Path Service |
| Photo Retouching Service | `photo-retouching-service` | Photo Retouching Service |
| Ghost Mannequin Service | `ghost-mannequin-service` | Ghost Mannequin Service |
| Headshot Photo Editing | `headshot-photo-editing` | Headshot Photo Editing |
| Background Removal Service | `background-removal-service` | Background Removal Service |
| Color Correction Service | `color-correction-service` | Color Correction Service |
| Drop Shadow Service | `drop-shadow-service` | Drop Shadow Service |
| Image Masking Service | `image-masking-service` | Image Masking Service |
| E-commerce Image Editing | `ecommerce-image-editing-services` | Ecommerce Image Editing Services |
| Photo Restoration Service | `photo-restoration-service` | Photo Restoration Service |
| AI-generated Image Fixes | `ai-generated-image-fixes` | Ai Generated Image Fixes |
| Photo Editing | `photo-editing` | Photo Editing |
| 3D Service | `3d-service` | 3D Service |
| 3D Product Modeling | `3d-product-modeling-service` | 3D Product Modeling Service |
| 3D Rendering | `3d-rendering-service` | 3D Rendering Service |
| Video Editing | `video-editing` | Video Editing |
| Portfolio | `portfolio` | Portfolio |
| Portfolio 2 | `portfolio2` | Portfolio2 |
| Pricing | `pricing` | Pricing |
| About Us | `about-us` | About Us |
| Contact | `contact` | Contact |
| Free Trial | `free-trial` | Free Trial |
| FAQ | `faq` | Faq |
| Blog | `blog` | Blog |
| Reviews | `reviews` | Reviews |
| Clipping DE | `freistellen-bilder-ecommerce` | Freistellen Bilder Ecommerce (DE) |
| Clipping ES | `recorte-fotografia-ecommerce` | Recorte Fotografia Ecommerce (ES) |
| Clipping FR | `detourage-image-ecommerce` | Detourage Image Ecommerce (FR) |
| Clipping IT | `scontorno-immagini-ecommerce` | Scontorno Immagini Ecommerce (IT) |

You can change any slug later (Yoast/permalink) — the header/footer nav links point
to the slugs above, so if you rename one of those, update `header.php`/`footer.php` too.

## 4. Set the homepage

**Settings → Reading → A static page → Homepage** = the page you created for Home.
The Home page automatically uses `front-page.php` (no template selection needed).

## 5. Form submissions

Free Trial (page section + popup modal) and Contact form submissions are stored in
wp-admin under **Trial Requests** and **Contact Messages** — click any entry to see
all fields and download attached files. Email notifications go to the site admin email
(**Settings → General**).

### Forward submissions to app.graphicspixels.com (optional)

Add to `wp-config.php`:

```php
define( 'GP_APP_WEBHOOK_URL', 'https://app.graphicspixels.com/api/submissions' );
define( 'GP_APP_API_KEY', 'your-secret-key' );
```

Each submission is then also POSTed as JSON (with `Authorization: Bearer <key>`)
to your app. The WordPress copy is always kept, and the forward status is saved
on each entry (`App Forward Status` / `App Forward Error`).

## 6. Yoast SEO

Install Yoast; it works on all these Pages out of the box (per-page SEO title,
focus keyword, meta description). The theme deliberately does not print its own
meta descriptions so Yoast has full control.

## 7. File upload size

The forms accept attachments up to 25 MB (images, PSD, PDF, ZIP, RAR). Ensure the
server's `upload_max_filesize` and `post_max_size` are at least 25M.
