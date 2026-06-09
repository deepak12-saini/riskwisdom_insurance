# Risk Wisdom SEO Guide

Plain-English guide for the client and digital marketing team.

## Why the site may not show on Google India

**riskwisdom.com.au** is an **Australian** website. If you search from India (or any country outside Australia), Google shows **local** results first. That is normal — it does not mean the site is broken.

To check if Google knows your site, search:

```
site:riskwisdom.com.au
```

If pages appear, the site is **indexed**. Ranking for broad terms like `insurance advisor` takes time, local SEO, and content.

---

## Target keywords (realistic)

Avoid competing only for `insurance advisor` globally. Focus on:

| Priority | Example keywords |
|----------|------------------|
| High | life insurance advisor Sydney |
| High | income protection insurance Australia |
| Medium | TPD insurance Sydney |
| Medium | trauma insurance Australia |
| Medium | business key person insurance |
| Local | insurance advisor Sydney |

Page titles and meta descriptions are set by `fix-seo-meta.php` for these themes.

---

## Google Search Console (required)

1. Go to [Google Search Console](https://search.google.com/search-console)
2. Add property: `https://riskwisdom.com.au`
3. Verify via DNS or HTML file (Plesk can add DNS TXT record)
4. Submit sitemap: `https://riskwisdom.com.au/sitemap.xml`
5. After site updates: **URL Inspection** → Request indexing for homepage and top service pages

---

## Google Business Profile (critical for local search)

This is **not a code plugin** — you set it up in Google’s dashboard. The website already has matching address, phone, and schema (`riskwisdom-seo.php`). GBP is what makes Risk Wisdom appear on **Google Maps** and in **“near me”** results in Sydney.

### How to start (step by step)

**Who does this:** Client or marketing (needs a Google account and access to business phone/email).

1. **Open Google Business Profile**
   - Go to [business.google.com](https://business.google.com) (or search “Google Business Profile” and click **Manage now**).
   - Sign in with a Google account the business will use long term (e.g. `info@riskwisdom.com.au`).

2. **Search for existing listing**
   - Search: `Risk Wisdom` + `Sydney` or the Chifley Tower address.
   - If a listing exists → click **Claim this business** and follow verification.
   - If none exists → click **Add your business to Google**.

3. **Enter business details (must match the website exactly)**

   | Field | Value |
   |-------|--------|
   | Business name | Risk Wisdom (or Risk Wisdom Financial Partners — pick one and use the same everywhere) |
   | Category | Primary: **Insurance agency** or **Financial consultant** |
   | Address | Level 29 Chifley Tower, 2 Chifley Square, Sydney NSW 2000 |
   | Phone | 02 9071 4735 |
   | Website | https://riskwisdom.com.au |
   | Service area | Sydney / Australia (if asked) |

4. **Verify the business**
   - Google usually verifies by **postcard**, **phone**, or **email** to the business address/number.
   - Verification can take a few days (postcard) or minutes (phone/email). Complete this before editing much else.

5. **Complete the profile (after verification)**
   - **Hours** — office hours (or “by appointment” if applicable).
   - **Photos** — logo, office/building, team (with permission).
   - **Services** — Life insurance, Income protection, Trauma, TPD, Business / key person insurance.
   - **Description** — 1–2 sentences: independent insurance advisors in Sydney (align with site copy).
   - **Products / attributes** — fill what Google offers for your category.

6. **Get reviews**
   - In GBP: **Ask for reviews** → copy the review link.
   - Email happy clients after a successful quote or policy setup.
   - Reply politely to all reviews.

7. **Link website ↔ Google (optional but recommended)**
   - Copy your public Google Maps / Business Profile URL (e.g. `https://maps.google.com/...` or a short `https://g.page/...` link).
   - Send that URL to your developer to add to site schema (see below).

### Website integration (developer — after GBP is live)

The site outputs LocalBusiness JSON-LD on every page. Once you have the GBP URL, add this line to production `wp-config.php` (above “That’s all, stop editing!”):

```php
define( 'RISKWISDOM_GBP_URL', 'https://g.page/your-risk-wisdom-link' );
```

Replace with the real profile URL from Google. No redeploy of SEO scripts needed — clear cache and check page source for `sameAs` in the JSON-LD block.

### GBP checklist

- [ ] Profile claimed or created at [business.google.com](https://business.google.com)
- [ ] Business verified by Google
- [ ] NAP matches website (name, address, phone, URL)
- [ ] Category, hours, photos, and services filled in
- [ ] At least 3–5 genuine Google reviews
- [ ] GBP URL added to `wp-config.php` as `RISKWISDOM_GBP_URL` (developer)

This helps queries like `insurance advisor near me` in Sydney — the website alone is not enough for Maps and local pack rankings.

---

## After every developer deploy (SSH)

```bash
cd /var/www/vhosts/riskwisdom.com.au/httpdocs
php post-deploy-production.php --apply
```

This runs: malware/htaccess fix (stops 500 on `/about/` etc.), SEO scripts, and form updates.

Or run individually:

```bash
php fix-production-500.php --apply
php cleanup-spam-posts.php --apply
php fix-seo-urls.php --apply
php fix-seo-meta.php --apply
php fix-seo-content.php --apply
php deploy-production-forms.php
```

Then:

1. **WP Fastest Cache → Delete Cache**
2. Hard-refresh key pages (Ctrl+Shift+R)
3. View page source — check `<title>` and meta description
4. Request re-indexing in Search Console (optional)

Upload mu-plugins:

- `wp-content/mu-plugins/riskwisdom-seo.php` (local business schema)
- `wp-content/mu-plugins/riskwisdom-cf7-fix.php` (forms / spam)

---

## Monthly KPIs to track

| Metric | Tool |
|--------|------|
| Impressions & clicks | Google Search Console |
| Top search queries | Search Console |
| Quote form submissions | Email inbox + optional GA4 event |
| Indexed pages | `site:riskwisdom.com.au` |
| Page speed | PageSpeed Insights |

---

## Content plan

- Publish **2–4 real insurance articles per month** (blog)
- Do not leave spam posts — run `cleanup-spam-posts.php` if needed
- Link blog posts to service pages and quote form
- Use testimonials (Real Testimonials plugin on homepage) — refresh copy with permission

---

## What developers fix vs what marketing owns

| Task | Owner |
|------|--------|
| Meta titles, broken URLs, sitemap, schema | Developer (`fix-seo-meta.php`, `fix-seo-urls.php`) |
| Google Business Profile & reviews | Marketing / client |
| Blog writing | Marketing |
| Backlinks & directories | Marketing |
| Google Ads (while SEO builds) | Marketing |
| Search Console setup | Marketing (with domain access) |

---

## Success checklist (4–8 weeks)

- [ ] `site:riskwisdom.com.au` shows main pages, no spam URLs
- [ ] Service pages have unique titles in browser tab
- [ ] No `localhost` or `riskwisdomfp.com.au` in live HTML
- [ ] Search Console shows impressions for Sydney/Australia queries
- [ ] Quote forms include email field on production
- [ ] Google Business Profile live with reviews
