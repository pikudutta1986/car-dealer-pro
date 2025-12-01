# Car Dealer Pro - Installation Guide

## System Requirements

- **PHP**: 7.4 or higher (PHP 8.x recommended)
- **MySQL**: 5.7 or higher / MariaDB 10.3 or higher
- **Web Server**: Apache or Nginx with URL rewriting support
- **PHP Extensions**: 
  - PDO MySQL
  - JSON
  - MBString
  - OpenSSL
  - cURL
  - GD (for image processing)

## Installation Steps

### 1. Download and Extract
- Download the Car Dealer Pro package
- Extract the files to your web server directory

### 2. Database Setup
1. Create a new MySQL database
2. Create a database user with full privileges
3. Import the database schema:
   ```sql
   mysql -u your_username -p your_database < database.sql
   ```

### 3. Configuration
1. Copy `env.example` to `.env`:
   ```bash
   cp env.example .env
   ```

2. Edit the `.env` file with your database credentials:
   ```env
   DB_HOST=localhost
   DB_USERNAME=your_db_username
   DB_PASSWORD=your_db_password
   DB_NAME=your_database_name
   SITE_URL=http://your-domain.com
   ```

3. Update `config/index.php` if you prefer not to use .env:
   - Set your database credentials
   - Set your website URL

### 4. File Permissions
Set proper permissions for the upload directory:
```bash
chmod 755 uploaded-images/
chmod 755 uploaded-images/car-images/
chmod 755 uploaded-images/make-images/
chmod 755 uploaded-images/bodystyle-images/
chmod 755 uploaded-images/editor-images/
```

### 5. Web Server Configuration

#### Apache (.htaccess)
Ensure mod_rewrite is enabled and .htaccess files are allowed.

#### Nginx
Add the following to your server block:
```nginx
location / {
    try_files $uri $uri/ /index.php?$query_string;
}
```

### 6. Access Admin Panel
1. Navigate to: `http://your-domain.com/admin/login.php`
2. Default credentials:
   - Username: `admin`
   - Password: `password` (change immediately after first login)

### 7. Initial Setup
1. Login to admin panel
2. Go to Settings > Business Info
3. Update your business information
4. Change your admin password
5. Configure email settings (Settings > Email)

## Security Recommendations

1. **Change Default Password**: Immediately change the default admin password
2. **Use HTTPS**: Always use HTTPS in production
3. **Regular Updates**: Keep your server and PHP updated
4. **Backup**: Regularly backup your database and files
5. **File Permissions**: Ensure proper file permissions are set

## Troubleshooting

### Common Issues

1. **White Screen/500 Error**:
   - Check PHP error logs
   - Verify database credentials
   - Ensure all required PHP extensions are installed

2. **Images Not Uploading**:
   - Check directory permissions
   - Verify upload directory exists
   - Check PHP upload limits

3. **Database Connection Error**:
   - Verify database credentials in .env file
   - Ensure database server is running
   - Check if database exists

4. **Email Not Sending**:
   - Configure SMTP settings in admin panel
   - Check SMTP credentials
   - Verify firewall settings

### Support
For technical support, please contact the developer with:
- PHP version
- Server configuration
- Error messages
- Steps to reproduce issues

## License
This software is licensed under the terms specified in the LICENSE file.
