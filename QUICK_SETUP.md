# Quick Setup Guide

Fast track deployment for SchoolPulse - Get up and running in 10 minutes!

---

## For Shared Hosting (cPanel)

### Step 1: Upload Files (2 minutes)
1. Login to cPanel
2. Open **File Manager**
3. Go to `public_html`
4. Upload all project files (or upload ZIP and extract)

### Step 2: Create Database (2 minutes)
1. In cPanel, go to **MySQL Databases**
2. Create database: `youruser_schoolpulse`
3. Create user with strong password
4. Add user to database with ALL PRIVILEGES
5. **Write down these details!**

### Step 3: Import Database (1 minute)
1. Go to **phpMyAdmin**
2. Select your database
3. Click **Import**
4. Upload `database.sql`
5. Click **Go**

### Step 4: Configure Database (2 minutes)
Edit `includes/db.php`:
```php
$host = 'localhost';
$dbname = 'youruser_schoolpulse';  // ← Your database name
$username = 'youruser_dbuser';      // ← Your database username
$password = 'your_password';        // ← Your database password
```

### Step 5: Set Permissions (1 minute)
In File Manager, set permissions:
- `assets/uploads/profiles/` → 755

### Step 6: Test (2 minutes)
1. Visit: `https://yourdomain.com/`
2. Visit: `https://yourdomain.com/admin/`
3. Login with:
   - Username: `admin`
   - Password: `Admin@123`
4. **Change password immediately!**

---

## For VPS/Cloud Server (Ubuntu)

### One-Command Setup
```bash
# Run as root
curl -sL https://raw.githubusercontent.com/Kalua420/saas-marketing-schoolpulse/main/install.sh | bash
```

### Manual Setup

```bash
# 1. Install LAMP
sudo apt update && sudo apt upgrade -y
sudo apt install apache2 mysql-server php php-mysql php-mbstring php-gd -y

# 2. Create database
sudo mysql -e "CREATE DATABASE schoolpulse_marketing;"
sudo mysql -e "CREATE USER 'sp_user'@'localhost' IDENTIFIED BY 'StrongPass123!';"
sudo mysql -e "GRANT ALL ON schoolpulse_marketing.* TO 'sp_user'@'localhost';"

# 3. Clone and setup
cd /var/www/html
sudo git clone https://github.com/Kalua420/saas-marketing-schoolpulse.git schoolpulse
cd schoolpulse
sudo mysql schoolpulse_marketing < database.sql

# 4. Configure
sudo nano includes/db.php  # Update credentials

# 5. Set permissions
sudo chown -R www-data:www-data /var/www/html/schoolpulse
sudo find . -type d -exec chmod 755 {} \;
sudo find . -type f -exec chmod 644 {} \;

# 6. Enable site
sudo a2enmod rewrite
sudo systemctl restart apache2
```

---

## Post-Setup Checklist

- [ ] Website loads: `https://yourdomain.com/`
- [ ] Admin login works: `https://yourdomain.com/admin/`
- [ ] Changed admin password
- [ ] Contact form works
- [ ] Demo form works
- [ ] Profile picture upload works
- [ ] SSL certificate installed (HTTPS)

---

## Default Login

**⚠️ CHANGE IMMEDIATELY AFTER FIRST LOGIN!**

- **URL**: https://yourdomain.com/admin/
- **Username**: admin
- **Password**: Admin@123

---

## Common Issues

### Can't login to admin
- Check database imported correctly
- Verify credentials in `includes/db.php`
- Clear browser cache/cookies

### 404 errors
- Check `.htaccess` exists
- Enable mod_rewrite: `sudo a2enmod rewrite`

### Upload not working
- Set permissions: `chmod 755 assets/uploads/profiles/`

### Database connection error
- Verify credentials in `includes/db.php`
- Check MySQL is running

---

## Need Help?

See full guide: `DEPLOYMENT_GUIDE.md`

---

**Setup Time**: ~10 minutes
**Difficulty**: Easy
