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

1. Claim or create profile for **Risk Wisdom** in **Sydney**
2. Use exact NAP (name, address, phone):
   - **Risk Wisdom**
   - Level 29 Chifley Tower, 2 Chifley Square, Sydney NSW
   - **02 9071 4735**
   - https://riskwisdom.com.au
3. Add photos, services, and business hours
4. Ask satisfied clients for **Google reviews**

This helps queries like `insurance advisor near me` in Sydney — website alone is not enough.

---

## After every developer deploy (SSH)

```bash
cd /var/www/vhosts/riskwisdom.com.au/httpdocs
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
