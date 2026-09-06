# State Corps CMS deployment

## Environments

Use separate cPanel subdomains, databases, `.env` files, and storage directories for staging and production. Never copy a staging `.env` file to production.

For local XAMPP development, the checked-in default uses SQLite and Laravel's log mailer. Start from `C:\xampp\htdocs\publicV6\cms` with `C:\xampp\php\php.exe artisan serve`; this keeps the Laravel root private while the public site is being migrated.

## cPanel requirements

The domain or subdomain document root must point to `cms/public`; the Laravel root must not be web-accessible. Ensure the PHP version is 8.2 or later and enable `mbstring`, `openssl`, `pdo_mysql`, `fileinfo`, and `zip`.

## First deployment

1. Create a MySQL/MariaDB database and a least-privilege database user in cPanel.
2. Upload the Laravel application outside `public_html`, or set the document root to its `public` directory.
3. Create `.env` from the matching environment example and set database, application URL, and SMTP values.
4. Install production dependencies with `composer install --no-dev --optimize-autoloader`.
5. Run `php artisan key:generate`, `php artisan migrate --force`, and `php artisan storage:link`.
6. Run `php artisan statecorps:create-admin --role=super_admin` privately over SSH.
7. Cache application configuration only after `.env` is complete: `php artisan config:cache` and `php artisan route:cache`.

## Content workflow

Editors save projects as drafts or submit them for review. Admins and super admins publish approved content immediately or select a future publication time. Add the scheduler cron entry below so scheduled publications are processed every minute.

Contact inquiries are stored in the CMS and sent to `CONTACT_MAIL_TO`, which defaults to `comms@statecorps.com`. Configure the domain SMTP values in the environment before enabling SMTP delivery.

## Cron

When publishing schedules, queued mail, or other scheduled work is enabled, add this cPanel cron entry every minute:

`* * * * * /usr/local/bin/php /path/to/cms/artisan schedule:run >> /dev/null 2>&1`

## Release process

Deploy and test staging first. Back up the production database and `storage/app/public` before production deployment. Run migrations with `--force`, clear and rebuild Laravel caches, then test login, public pages, uploads, contact delivery, and the draft/review/publish flow.
