# riskwisdom_insurance

WordPress site for Risk Wisdom (riskwisdom.com.au).

## Local setup (XAMPP)

1. Clone into `C:\xampp\htdocs\riskwisdom`
2. Copy `wp-config-sample.php` to `wp-config.php` and add DB credentials
3. Create MySQL database and user (see hosting panel or phpMyAdmin)
4. Import database `.sql` backup via phpMyAdmin
5. Start Apache + MySQL in XAMPP
6. Open `http://localhost/riskwisdom/`

## What is NOT in Git

| Item | Reason |
|------|--------|
| `wp-config.php` | Passwords and secret keys |
| `wp-content/uploads/` | Media files (large) |
| `*.sql` | Database backups |

## Deploy code to production server

### First time on server

```bash
cd /path/to/public_html   # or your site root
git clone https://github.com/deepak12-saini/riskwisdom_insurance.git .
# Keep existing wp-config.php on server — do NOT overwrite it
# Keep wp-content/uploads/ on server — media is not in Git
```

### Update production after changes

On your PC:

```bash
git add .
git commit -m "Describe your change"
git push origin main
```

On the server:

```bash
cd /path/to/site
git pull origin main
```

### Database changes

Database is **not** deployed via Git. Export/import separately:

- **Local → Live:** Export from phpMyAdmin, import on server (or use WP migration plugin)
- **Live → Local:** Download `.sql` from server, import in local phpMyAdmin

## Important

- Never commit `wp-config.php` (contains DB password and API tokens)
- After `git pull` on production, verify `wp-config.php` and `uploads/` are still intact
- Test on localhost before pushing to `main`
