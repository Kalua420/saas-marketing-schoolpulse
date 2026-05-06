# SchoolPulse Deployment Guide

Complete guide to configure and host the SchoolPulse Marketing & Admin System.

---

## Table of Contents
1. [Server Requirements](#server-requirements)
2. [Local Development Setup](#local-development-setup)
3. [Production Hosting Setup](#production-hosting-setup)
4. [Database Configuration](#database-configuration)
5. [File Permissions](#file-permissions)
6. [Security Checklist](#security-checklist)
7. [Post-Deployment Steps](#post-deployment-steps)
8. [Troubleshooting](#troubleshooting)

---

## Server Requirements

### Minimum Requirements
- **PHP**: 7.4 or higher (8.0+ recommended)
- **MySQL**: 5.7 or higher (8.0+ recommended)
- **Web Server**: Apache 2.4+ or Nginx 1.18+
- **Disk Space**: 100 MB minimum
- **RAM**: 512 MB minimum (1 GB recommended)

### Required PHP Extensions
```
- mysqli or PDO_MySQL
- mbstring
- json
- session
- fileinfo (for file uploads)
- gd or imagick (for image processing)
```

### Check PHP Extensions
```bash
php -m | grep -E 'mysqli|pdo_mysql|mbstring|json|session|fileinfo|gd'
```

---

## Local Development Setup

### Option 1: XAMPP (Windows/Mac/Linux)

1. **Install XAMPP**
   - Download from: https://www.apachefriends.org/
   - Install to default location

2. **Clone Repository**
   ```bash
   cd C:\xampp\htdocs  # Windows
   # or
   cd /Applications/XAMPP/htdocs  # Mac
   # or
   cd /opt/lampp/htdocs  # Linux
   
   git clone https://github.com/Kalua420/saas-marketing-schoolpulse.git schoolpulse
   cd schoolpulse
   ```

3. **Create Database**
   - Open phpMyAdmin: http://localhost/phpmyadmin
   - Create new database: `schoolpulse_marketing`
   - Import `database.sql` file

4. **Configure Database Connection**
   - Edit `includes/db.php`
   ```php
   $host = 'localhost';
   $dbname = 'schoolpulse_marketing';
   $username = 'root';
   $password = '';  // Empty for XAMPP default
   ```

5. **Access Application**
   - Public site: http://localhost/schoolpulse/
   - Admin panel: http://localhost/schoolpulse/admin/

### Option 2: WAMP (Windows)

1. **Install WAMP**
   - Download from: https://www.wampserver.com/
   
2. **Follow same steps as XAMPP** but use:
   ```
   C:\wamp64\www\schoolpulse
   ```

### Option 3: MAMP (Mac)

1. **Install MAMP**
   - Download from: https://www.mamp.info/
   
2. **Follow same steps as XAMPP** but use:
   ```
   /Applications/MAMP/htdocs/schoolpulse
   ```

---

## Production Hosting Setup

### Recommended Hosting Providers
- **Shared Hosting**: Hostinger, Bluehost, SiteGround
- **VPS**: DigitalOcean, Linode, Vultr
- **Cloud**: AWS, Google Cloud, Azure

### Method 1: Shared Hosting (cPanel)

#### Step 1: Upload Files

**Option A: Using File Manager**
1. Login to cPanel
2. Go to **File Manager**
3. Navigate to `public_html` folder
4. Upload all project files (or upload as ZIP and extract)

**Option B: Using FTP**
1. Use FileZilla or similar FTP client
2. Connect using credentials from hosting provider
3. Upload all files to `public_html` or `public_html/schoolpulse`

**Option C: Using Git (if available)**
```bash
cd public_html
git clone https://github.com/Kalua420/saas-marketing-schoolpulse.git .
```

#### Step 2: Create Database

1. In cPanel, go to **MySQL Databases**
2. Create new database: `username_schoolpulse`
3. Create database user with strong password
4. Add user to database with ALL PRIVILEGES
5. Note down:
   - Database name
   - Database username
   - Database password
   - Database host (usually `localhost`)

#### Step 3: Import Database

1. Go to **phpMyAdmin** in cPanel
2. Select your database
3. Click **Import** tab
4. Choose `database.sql` file
5. Click **Go**

#### Step 4: Configure Database Connection

Edit `includes/db.php`:
```php
<?php
$host = 'localhost';  // or your DB host
$dbname = 'username_schoolpulse';  // Your actual database name
$username = 'username_dbuser';  // Your database username
$password = 'your_strong_password';  // Your database password

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log("Database connection failed: " . $e->getMessage());
    die("Database connection failed. Please contact support.");
}
```

#### Step 5: Set File Permissions

In cPanel File Manager or via FTP:
```
Folders: 755 (drwxr-xr-x)
Files: 644 (-rw-r--r--)
assets/uploads/profiles/: 755 (writable)
```

### Method 2: VPS/Cloud Server (Ubuntu/Debian)

#### Step 1: Connect to Server
```bash
ssh root@your-server-ip
```

#### Step 2: Install LAMP Stack

```bash
# Update system
sudo apt update && sudo apt upgrade -y

# Install Apache
sudo apt install apache2 -y

# Install MySQL
sudo apt install mysql-server -y

# Install PHP and extensions
sudo apt install php php-mysql php-mbstring php-json php-gd php-curl php-zip -y

# Enable Apache modules
sudo a2enmod rewrite
sudo systemctl restart apache2
```

#### Step 3: Secure MySQL
```bash
sudo mysql_secure_installation
```

#### Step 4: Create Database
```bash
sudo mysql -u root -p

# In MySQL prompt:
CREATE DATABASE schoolpulse_marketing CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'schoolpulse_user'@'localhost' IDENTIFIED BY 'strong_password_here';
GRANT ALL PRIVILEGES ON schoolpulse_marketing.* TO 'schoolpulse_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

#### Step 5: Import Database
```bash
mysql -u schoolpulse_user -p schoolpulse_marketing < database.sql
```

#### Step 6: Deploy Application
```bash
# Navigate to web root
cd /var/www/html

# Clone repository
sudo git clone https://github.com/Kalua420/saas-marketing-schoolpulse.git schoolpulse
cd schoolpulse

# Set ownership
sudo chown -R www-data:www-data /var/www/html/schoolpulse

# Set permissions
sudo find /var/www/html/schoolpulse -type d -exec chmod 755 {} \;
sudo find /var/www/html/schoolpulse -type f -exec chmod 644 {} \;
sudo chmod 755 /var/www/html/schoolpulse/assets/uploads/profiles
```

#### Step 7: Configure Apache Virtual Host

Create file: `/etc/apache2/sites-available/schoolpulse.conf`
```apache
<VirtualHost *:80>
    ServerName schoolpulse.in
    ServerAlias www.schoolpulse.in
    DocumentRoot /var/www/html/schoolpulse
    
    <Directory /var/www/html/schoolpulse>
        Options -Indexes +FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>
    
    ErrorLog ${APACHE_LOG_DIR}/schoolpulse_error.log
    CustomLog ${APACHE_LOG_DIR}/schoolpulse_access.log combined
</VirtualHost>
```

Enable site:
```bash
sudo a2ensite schoolpulse.conf
sudo systemctl reload apache2
```

#### Step 8: Install SSL Certificate (Let's Encrypt)
```bash
# Install Certbot
sudo apt install certbot python3-certbot-apache -y

# Get certificate
sudo certbot --apache -d schoolpulse.in -d www.schoolpulse.in

# Auto-renewal is set up automatically
```

---

## Database Configuration

### Create Admin User

After importing database, create your admin account:

```sql
-- Connect to database
USE schoolpulse_marketing;

-- Create admin user (password: Admin@123)
INSERT INTO admin_users (username, email, password, role, created_at) 
VALUES (
    'admin',
    'admin@schoolpulse.in',
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
    'admin',
    NOW()
);
```

**Default Login:**
- Username: `admin`
- Password: `Admin@123`

**⚠️ IMPORTANT: Change this password immediately after first login!**

### Update Password

To create a new password hash:
```php
<?php
// Create this as a temporary file: create_password.php
$password = 'YourNewPassword123!';
echo password_hash($password, PASSWORD_DEFAULT);
// Delete this file after use!
```

Then update in database:
```sql
UPDATE admin_users 
SET password = 'your_new_hash_here' 
WHERE username = 'admin';
```

---

## File Permissions

### Correct Permissions

```bash
# All directories
find . -type d -exec chmod 755 {} \;

# All files
find . -type f -exec chmod 644 {} \;

# Upload directory (needs write permission)
chmod 755 assets/uploads/profiles/

# Make sure .htaccess is readable
chmod 644 .htaccess
chmod 644 assets/uploads/profiles/.htaccess
```

### Verify Permissions
```bash
ls -la assets/uploads/profiles/
# Should show: drwxr-xr-x (755)
```

---

## Security Checklist

### 1. Change Database Credentials
- ✅ Use strong, unique password
- ✅ Don't use 'root' user in production
- ✅ Limit database user privileges

### 2. Update Admin Password
- ✅ Change default admin password
- ✅ Use strong password (12+ characters)
- ✅ Enable 2FA if available

### 3. Secure File Uploads
- ✅ Verify `assets/uploads/profiles/.htaccess` exists
- ✅ Test that PHP files cannot be executed in upload directory

### 4. Hide Sensitive Files
Verify `.htaccess` in root contains:
```apache
# Deny access to sensitive files
<FilesMatch "^\.">
    Require all denied
</FilesMatch>

# Protect includes directory
<Directory "includes">
    Require all denied
</Directory>
```

### 5. Enable HTTPS
- ✅ Install SSL certificate
- ✅ Force HTTPS redirect
- ✅ Update all URLs to use https://

### 6. Disable Error Display
In production, edit `includes/db.php`:
```php
// At the top of the file
error_reporting(0);
ini_set('display_errors', 0);
```

### 7. Regular Backups
- ✅ Set up automated database backups
- ✅ Backup files weekly
- ✅ Store backups off-site

---

## Post-Deployment Steps

### 1. Test All Features

**Public Website:**
- [ ] Homepage loads correctly
- [ ] Features page displays
- [ ] Pricing page works
- [ ] Contact form submits successfully
- [ ] Demo request form works
- [ ] Thank you page redirects properly

**Admin Panel:**
- [ ] Login works with admin credentials
- [ ] Dashboard displays statistics
- [ ] Leads page shows demo requests
- [ ] Contacts page shows messages
- [ ] Clients page loads
- [ ] Profile picture upload works
- [ ] Settings page accessible

### 2. Configure Email (Optional)

For email notifications, you can use:

**Option A: PHP mail() function**
- Already configured in `includes/functions.php`
- May not work on all shared hosting

**Option B: SMTP (Recommended)**
Install PHPMailer:
```bash
composer require phpmailer/phpmailer
```

Update `includes/functions.php`:
```php
use PHPMailer\PHPMailer\PHPMailer;

function send_notification_email(string $to, string $subject, string $body): bool {
    $mail = new PHPMailer(true);
    
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';  // Your SMTP host
        $mail->SMTPAuth = true;
        $mail->Username = 'your-email@gmail.com';
        $mail->Password = 'your-app-password';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        
        $mail->setFrom('noreply@schoolpulse.in', 'SchoolPulse');
        $mail->addAddress($to);
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $body;
        
        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Email error: " . $mail->ErrorInfo);
        return false;
    }
}
```

### 3. Set Up Monitoring

**Basic Monitoring:**
- Set up uptime monitoring (UptimeRobot, Pingdom)
- Monitor disk space
- Check error logs regularly

**Error Logs Location:**
- Apache: `/var/log/apache2/error.log`
- PHP: Check `php.ini` for `error_log` location
- Application: Create `logs/` directory

### 4. Performance Optimization

**Enable Caching:**
Add to `.htaccess`:
```apache
# Browser caching
<IfModule mod_expires.c>
    ExpiresActive On
    ExpiresByType image/jpg "access plus 1 year"
    ExpiresByType image/jpeg "access plus 1 year"
    ExpiresByType image/gif "access plus 1 year"
    ExpiresByType image/png "access plus 1 year"
    ExpiresByType text/css "access plus 1 month"
    ExpiresByType application/javascript "access plus 1 month"
</IfModule>

# Gzip compression
<IfModule mod_deflate.c>
    AddOutputFilterByType DEFLATE text/html text/plain text/xml text/css text/javascript application/javascript
</IfModule>
```

**Enable OPcache:**
In `php.ini`:
```ini
opcache.enable=1
opcache.memory_consumption=128
opcache.max_accelerated_files=10000
```

---

## Troubleshooting

### Issue: White Screen / 500 Error

**Solution:**
1. Check error logs
2. Verify file permissions
3. Check `.htaccess` syntax
4. Enable error display temporarily:
   ```php
   error_reporting(E_ALL);
   ini_set('display_errors', 1);
   ```

### Issue: Database Connection Failed

**Solution:**
1. Verify credentials in `includes/db.php`
2. Check if MySQL is running: `sudo systemctl status mysql`
3. Test connection:
   ```bash
   mysql -u username -p -h localhost database_name
   ```

### Issue: 404 Not Found for Admin Pages

**Solution:**
1. Check if `.htaccess` exists
2. Verify Apache mod_rewrite is enabled:
   ```bash
   sudo a2enmod rewrite
   sudo systemctl restart apache2
   ```
3. Check AllowOverride in Apache config

### Issue: File Upload Not Working

**Solution:**
1. Check directory permissions: `chmod 755 assets/uploads/profiles/`
2. Verify PHP upload settings in `php.ini`:
   ```ini
   upload_max_filesize = 10M
   post_max_size = 10M
   ```
3. Check disk space: `df -h`

### Issue: Session Not Working

**Solution:**
1. Check session directory permissions
2. Verify `session.save_path` in `php.ini`
3. Clear browser cookies

### Issue: CSS/JS Not Loading

**Solution:**
1. Check file paths in HTML
2. Verify file permissions (644)
3. Clear browser cache
4. Check for mixed content (HTTP/HTTPS)

---

## Quick Reference

### Important URLs
- **Public Site**: https://yourdomain.com/
- **Admin Login**: https://yourdomain.com/admin/
- **phpMyAdmin**: https://yourdomain.com/phpmyadmin/ (if available)

### Important Files
- **Database Config**: `includes/db.php`
- **Functions**: `includes/functions.php`
- **Admin Auth**: `includes/auth.php`
- **Main .htaccess**: `.htaccess`
- **Upload .htaccess**: `assets/uploads/profiles/.htaccess`

### Important Directories
- **Uploads**: `assets/uploads/profiles/` (755)
- **CSS**: `assets/css/`
- **JS**: `assets/js/`
- **Admin**: `admin/`
- **API**: `api/`

### Default Credentials
- **Username**: admin
- **Password**: Admin@123
- **⚠️ CHANGE IMMEDIATELY!**

---

## Support

For issues or questions:
1. Check error logs first
2. Review this guide
3. Check GitHub issues: https://github.com/Kalua420/saas-marketing-schoolpulse/issues
4. Contact: admin@schoolpulse.in

---

## License

This project is proprietary software. All rights reserved.

---

**Last Updated**: May 6, 2026
**Version**: 1.0.0
