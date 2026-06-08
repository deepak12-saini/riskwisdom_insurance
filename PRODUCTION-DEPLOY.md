# Production deploy (riskwisdom.com.au)

## URGENT: 500 error after Git push

If **homepage works** but pages like `/life-insurance/` show **Internal Server Error**, the most common cause is the **wrong `.htaccess`** was deployed from localhost (`RewriteBase /riskwisdom/` instead of `/`).

### Fix via Plesk File Manager (no SSH)

1. Open **Plesk → Files →** `httpdocs/.htaccess`
2. Replace the whole file with the contents of **`.htaccess.production`** from this repo (must have `RewriteBase /` and `RewriteRule . /index.php`)
3. **Delete** any extra `.htaccess` inside `wp-admin/` or `wp-includes/` (except normal WordPress ones — if unsure, run cleanup script below)
4. **wp-admin → WP Fastest Cache → Delete Cache**
5. Test: https://riskwisdom.com.au/life-insurance/

### Fix via SSH (recommended)

```bash
cd /var/www/vhosts/riskwisdom.com.au/httpdocs
php cleanup-malware.php
php fix-production-pages.php --apply
```

Then **WP Fastest Cache → Delete Cache**.

### Prevent this on the next deploy

- **Never push** root `.htaccess` from localhost (it is in `.gitignore` now)
- On the server, keep production `.htaccess` with `RewriteBase /`
- Only deploy: theme, plugins, mu-plugins, PHP fix scripts — not local Apache config

---

## 1. Clean malware first (Plesk SSH / Terminal)

Git deploy fails until hacked files are removed manually:

```bash
cd /var/www/vhosts/riskwisdom.com.au/httpdocs
php cleanup-malware.php
```

If permission denied, run as root or fix ownership:

```bash
chown -R your-plesk-user:psacln httpdocs/wp-admin httpdocs/wp-includes
find httpdocs -path '*/wp/*.php' -delete
find httpdocs -name '.htaccess' -exec grep -l 'Allow from all' {} \; | xargs rm -f
```

Then redeploy from Plesk Git.

## 2. After every Git deploy — run form scripts (IMPORTANT)

**Contact Form 7 forms are stored in the database, not in Git.**

Pushing code updates `fix-cf7-spam.php` and `riskwisdom-cf7-fix.php`, but production will **still show the old form** (no email field, lowercase "phone" label) until you run:

```bash
cd /var/www/vhosts/riskwisdom.com.au/httpdocs
php deploy-production-forms.php
```

Or run each script manually:

```bash
php fix-cf7-spam.php
php fix-cf7-mail.php
php fix-contact-us-page.php --apply
```

Then **WP Fastest Cache → Delete Cache** and hard-refresh the homepage.

**Symptom:** Life Insurance form shows name + phone but **no Email field** → scripts above were not run on production DB.

---

## 3. Files that must stay on the server (not overwritten by Git)

- `wp-config.php` — add: `require __DIR__ . '/wp-config-smtp.php';`
- `wp-config-smtp.php` — copy from `wp-config-sample-smtp.php`, set password
- `wp-content/uploads/`

## 3. Contact form email

`setup-smtp.php --test` working but form still errors? That is usually **reCAPTCHA spam** (same message as mail failure). Deploy `wp-content/mu-plugins/riskwisdom-cf7-fix.php` — it allows mail when only reCAPTCHA blocks the submit.

After deploy, run:

```bash
php fix-cf7-mail.php
php setup-smtp.php --test
```

Or configure **WP Mail SMTP → Other SMTP** in wp-admin:

- Host: `smtp.office365.com`
- Port: `587`, TLS
- User: `info@riskwisdom.com.au`

## 4. Inner pages 500 (homepage works, subpages fail)

Symptom: `https://riskwisdom.com.au/financial-planning-process/` shows **Internal Server Error**, but homepage loads. `wp-login.php` may still work.

**Cause (most common on this site):**

1. **Hacked `.htaccess` files** still on production (malware cleanup not run on server)
2. **Wrong `RewriteBase`** — local uses `/riskwisdom/` but production must use `/`
3. **WP Fastest Cache** serving cached homepage only; inner pages hit broken Apache rules
4. Broken `ErrorDocument` in `.htaccess` (double 500 message in browser)

**Fix on server (SSH):**

```bash
cd /var/www/vhosts/riskwisdom.com.au/httpdocs
php cleanup-malware.php
php fix-production-pages.php
php fix-production-pages.php --apply
```

Then in **wp-admin → WP Fastest Cache → Delete Cache**.

Verify root `.htaccess` has `RewriteBase /` (see `.htaccess.production` in repo).

If still failing, read Apache log:

```bash
tail -50 /var/www/vhosts/riskwisdom.com.au/logs/error_log
```

## 5. Blog spam posts (invalid "Uncategorized" crack posts)

Hackers injected SEO spam into **Posts**. Homepage **Blog news** shows latest posts automatically.

```bash
php cleanup-spam-posts.php          # dry run
php cleanup-spam-posts.php --apply  # delete spam (keeps real insurance articles)
```

Then **WP Fastest Cache → Delete Cache**.

## 6. SEO (after forms and malware cleanup)

Git does **not** update SEO titles or fix broken URLs in the database. After deploy:

```bash
cd /var/www/vhosts/riskwisdom.com.au/httpdocs
php cleanup-spam-posts.php --apply
php fix-seo-urls.php --apply
php fix-seo-meta.php --apply
php fix-seo-content.php --apply
php deploy-production-forms.php
```

Upload mu-plugin: `wp-content/mu-plugins/riskwisdom-seo.php`

Then **WP Fastest Cache → Delete Cache**.

Verify:

- View source on homepage — `<title>` should mention **Insurance Advisor Sydney**
- Search Google: `site:riskwisdom.com.au`
- Submit sitemap in **Google Search Console**: `https://riskwisdom.com.au/sitemap.xml`

Full client/marketing guide: [SEO-GUIDE.md](SEO-GUIDE.md)

**Note:** On production only, `fix-seo-urls.php` sets `siteurl`/`home` to `https://riskwisdom.com.au` if they still point at localhost. Do **not** run `--apply` on local XAMPP unless you intend to change local URLs.

---

## 7. Security

- Change mailbox password after any exposure
- Change WordPress admin password after hack cleanup
- Never commit `wp-config-smtp.php` to Git
- Scan site with Wordfence / Imunify after malware cleanup
