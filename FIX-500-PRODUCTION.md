# Fix 500 error on production (about, life-insurance, etc.)

## Symptom

- `https://riskwisdom.com.au/about/` shows **Internal Server Error**
- Message: *"500 error while trying to use an ErrorDocument"*
- Homepage may still work (cached)

This is **Apache `.htaccess`**, not WordPress SEO or forms.

---

## Fix via SSH (fastest)

```bash
cd /var/www/vhosts/riskwisdom.com.au/httpdocs
php fix-production-500.php --apply
```

Then **WP Fastest Cache → Delete Cache** and test `/about/`.

---

## Fix via Plesk File Manager (no SSH)

1. **Plesk → Files →** `httpdocs/.htaccess`
2. **Delete** the entire file content and replace with:

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

3. **Remove** any extra `.htaccess` files inside `wp-admin/` or `wp-includes/` (hack leftovers)
4. **Do not** include `ErrorDocument` lines
5. **Do not** use `RewriteBase /riskwisdom/` (that is localhost only)
6. Clear **WP Fastest Cache**
7. Test https://riskwisdom.com.au/about/

---

## After fix — run SEO scripts

```bash
php fix-seo-urls.php --apply
php fix-seo-meta.php --apply
php deploy-production-forms.php
```

---

## Prevent on next Git deploy

- Do **not** push root `.htaccess` from localhost (it is in `.gitignore`)
- After deploy, run `php fix-production-500.php --apply` if inner pages break
