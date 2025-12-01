# Car Dealer Pro

A PHP/MySQL car dealer CMS for managing makes, models, body styles, inventory, images, and sales. This package is production-hardened with PDO prepared statements and modern password hashing.

## Features
- Admin panel to manage:
  - Cars, images (drag/drop ordering), sales records
  - Makes, models, body styles
  - Static pages and homepage settings
  - Email/SMTP settings (PHPMailer bundled)
- Public theme with inventory listings, details, and search
- Security hardening:
  - All database access via PDO prepared statements
  - password_hash/password_verify for admin credentials (with md5 fallback + auto-upgrade)

## Requirements
- PHP 7.4+ (PHP 8.x recommended)
  - Extensions: pdo_mysql, json, mbstring, openssl, curl
- MySQL 5.7+ or MariaDB 10.3+
- Apache/Nginx with URL rewriting recommended

## Quick Start
1. **Download & Extract**: Upload the entire project to your web server
2. **Database Setup**: Create a new MySQL database and user
3. **Import Database**: Import the schema and seed data from `database.sql`
4. **Configuration**: 
   - Copy `env.example` to `.env` and configure your settings
   - Or edit `config/index.php` directly with your database credentials
5. **File Permissions**: Ensure web server can write to `uploaded-images/` directory
6. **Access Admin**: 
   - URL: `YOUR_SITE_URL/admin/login.php`
   - Default credentials: username `admin`, password `password`
   - **Important**: Change default password immediately after first login

For detailed installation instructions, see [INSTALLATION.md](INSTALLATION.md)

## Email/SMTP
- Configure SMTP in Admin > Settings > Email.
- PHPMailer is bundled in `PHPMailer/`.

## Security Notes
- All SQL is executed with prepared statements.
- Admin password handling uses `password_hash`/`password_verify` with automatic md5 migration and rehash when needed.
- Recommended next steps:
  - Serve over HTTPS.
  - Keep `config/` outside web root if possible or restrict direct access via web server rules.

## Directory Overview
- `admin/` – Admin panel (classes, pages, ajax endpoints)
- `class/` – Frontend/shared classes
- `config/` – Database bootstrap and global config
- `PHPMailer/` – Vendor mailer library
- `theme-template/` – Frontend theme
- `uploaded-images/` – Uploaded assets (cars, makes, homepage, editor)

## Customization
- Theme: Modify `theme-template/theme1/` for layout, CSS, and JavaScript.
- Admin styles and scripts are under `admin/assets/`.

## Troubleshooting
- White screen / errors:
  - Enable error reporting (in development only): `ini_set('display_errors', 1); error_reporting(E_ALL);`
  - Verify DB credentials and that `database.sql` is imported.
- Images not uploading/reordering:
  - Check directory permissions for `uploaded-images/` and subfolders.
- Emails not sending:
  - Confirm SMTP host/port/credentials and that your host allows outbound SMTP.

## License
- Provide your own purchase/license terms if listing on CodeCanyon. Remove any test/demo content before distribution.

## Changelog (high level)
- Security: Migrated all queries to PDO prepared statements.
- Auth: Implemented `password_hash/password_verify` with md5 fallback + auto-rehash.
- Ajax/Charts: Converted queries to prepared statements.

## Support
For issues or customization, please contact your developer or create a ticket with your server PHP version, error logs, and steps to reproduce.
