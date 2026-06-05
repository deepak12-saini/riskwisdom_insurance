# Production deploy (riskwisdom.com.au)

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

## 2. Files that must stay on the server (not overwritten by Git)

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

## 6. Security

- Change mailbox password after any exposure
- Change WordPress admin password after hack cleanup
- Never commit `wp-config-smtp.php` to Git
- Scan site with Wordfence / Imunify after malware cleanup
