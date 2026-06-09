# Fix 500 error on production (about, life-insurance, etc.)

## Symptom

- `https://riskwisdom.com.au/about/` shows **Internal Server Error**
- Apache log: **`AH00124: Request exceeded the limit of 10 internal redirects`**
- Or: *"500 error while trying to use an ErrorDocument"*

**Cause:** Broken `.htaccess` — usually **WP Fastest Cache rules** + wrong `RewriteBase /riskwisdom/` from localhost deploy.

---

## Fix via SSH (run again on server)

```bash
cd /var/www/vhosts/riskwisdom.com.au/httpdocs
php post-deploy-production.php --apply
```

Or 500 fix only:

```bash
php fix-production-500.php --apply
```

This now:
1. Removes bad `.htaccess` in `wp-admin/` / `wp-includes/`
2. Writes **clean WordPress-only** `.htaccess` (removes WP Fastest Cache block that causes redirect loop)
3. Clears cached HTML files
4. Fixes `siteurl`/`home` if still pointing to localhost

Then:
1. **WP Fastest Cache → Delete Cache**
2. Test https://riskwisdom.com.au/about/
3. If OK, **WP Fastest Cache → Options → Save** (regenerates cache rules safely)

**Do not** use `--keep-wpfc` unless you know the cache block is clean.

---

## Fix via Plesk File Manager (no SSH)

1. **Plesk → Files →** `httpdocs/.htaccess`
2. **Delete everything** and paste **only** this (no WP Fastest Cache block):

```apache
# BEGIN WordPress
<IfModule mod_rewrite.c>
RewriteEngine On
RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]
RewriteBase /
RewriteRule ^index\.php$ - [L]
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule . /index.php [L]
</IfModule>
# END WordPress
```

3. Delete extra `.htaccess` in `wp-admin/` and `wp-includes/`
4. **Settings → General** in WordPress: ensure URLs are `https://riskwisdom.com.au` (not localhost)
5. **WP Fastest Cache → Delete Cache**
6. Test `/about/`

---

## Verify error log after fix

```bash
tail -10 /var/www/vhosts/riskwisdom.com.au/logs/error_log
```

Should show **no new AH00124** lines when you load `/about/`.

---

## After pages work — SEO scripts

```bash
php fix-seo-urls.php --apply
php fix-seo-meta.php --apply
php deploy-production-forms.php
```
