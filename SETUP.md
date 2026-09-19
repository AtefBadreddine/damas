# Local setup — what we changed

This is a Laravel 5.1 production dump. It needed PHP 8.2.33 (same as prod), missing public files, and a few compatibility fixes so it would run on Laragon.

Open the site at **http://damas.test/**

---

## 1. PHP 8.2.33 in Laragon

- Installed to `D:\laragon\bin\php\php-8.2.33-Win32-vs16-x64`
- Laragon PHP version set to that folder
- Apache `mod_php.conf` pointed at PHP 8.2.33
- Enabled extensions: curl, gd, mbstring, mysqli, pdo_mysql, openssl, zip, …

Use the project wrappers so Composer/Artisan always hit 8.2, even if a terminal still has 8.3:

```powershell
.\composer.cmd i
.\artisan.cmd --version
.\serve.cmd
```

Restart Laragon once (**Stop All → Start All**) so new terminals also use 8.2.33.

---

## 2. Composer on PHP 8.2

Laravel 5.1 is old. Changes so `composer install` succeeds:

- `composer.json`: `platform-check: false`, skip `artisan optimize`
- After install, `scripts/php82-compat.php` re-applies PHP 8.2 patches
- `bootstrap/autoload.php`: `each()` polyfill
- `vendor/.../HandleExceptions.php`: deprecations are not turned into fatal errors
- `vendor/nesbot/carbon/.../Carbon.php`: `setLastErrors()` accepts `false` (PHP 8.2)

Run:

```powershell
.\composer.cmd install --ignore-platform-reqs
```

---

## 3. Missing `public/` folder and CSS

The dump had no `public/` (images, CSS, JS, fonts). Production document root is the project root, but Laravel still expects `public/`.

What we did:

- Added `public/index.php` (Laravel front controller)
- Copied CSS/JS/images/fonts/favicons from production into `public/`
- Junctions: `css`, `js`, `img`, `fonts`, `admin`, `uploads`, `imgwebp` → `public/...`
- Empty `index.html` renamed so Apache serves `index.php`
- `.htaccess`: serve files from `public/` when they exist; static files (`.css`, `.png`, `.svg`, …) never go through Laravel
- Invalid `rel="Asynchronously load stylesheet"` changed to `rel="stylesheet"` so the browser actually loads CSS
- 404 page no longer crashes if `css/404.min.css` is missing

---

## 4. How to run it

Apache (preferred): **http://damas.test/**

Or:

```powershell
.\serve.cmd
```

then open http://127.0.0.1:8000

MySQL database `damas` must exist. CRM databases are separate (`u555101700_crm`, `u555101700_omancrm`).

---

## Files added or edited (local only)

| File | Why |
|------|-----|
| `composer.cmd`, `artisan.cmd`, `serve.cmd`, `bin/php.cmd` | Always use PHP 8.2.33 |
| `public/index.php`, `public/.htaccess` | Laravel web entry |
| `server.php` | `artisan serve` |
| `.htaccess`, `index.php` | Static files + front controller |
| `composer.json` | Composer works on PHP 8.2 |
| `scripts/php82-compat.php` | Re-patch vendor after `composer i` |
| `bootstrap/autoload.php` | `each()` polyfill |
| Front layout CSS `<link>` tags | CSS actually loads |
| `resources/views/errors/404.blade.php` | Missing CSS include no longer 500s |
