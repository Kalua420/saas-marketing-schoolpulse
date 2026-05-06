# Database Connection Troubleshooting

## Quick Fix Steps

### Step 1: Upload Test Script
1. Upload `test-db-connection.php` to your server root
2. Access it via browser: `https://yourdomain.com/test-db-connection.php`
3. Follow the diagnostic results
4. **Delete the file after testing!**

### Step 2: Get Your Database Credentials

#### For DirectAdmin:
1. Login to DirectAdmin
2. Go to **MySQL Management**
3. Find your database details:
   - Database Name (e.g., `schoolpulse_schoolpulse_db`)
   - Database User (e.g., `schoolpulse_user`)
   - Database Host (usually `localhost`)
4. If you forgot password, reset it in MySQL Management

#### For cPanel:
1. Login to cPanel
2. Go to **MySQL Databases**
3. Find your database and user
4. Note the full names (they usually have a prefix like `username_dbname`)

### Step 3: Update Database Configuration

Edit `includes/db.php` with your actual credentials:

```php
<?php
define('DB_HOST', 'localhost');                    // ← Usually localhost
define('DB_NAME', 'schoolpulse_schoolpulse_db');  // ← Your actual database name
define('DB_USER', 'schoolpulse_user');            // ← Your actual database user
define('DB_PASS', 'your_actual_password');        // ← Your actual password
define('DB_CHARSET', 'utf8mb4');

try {
    $pdo = new PDO(
        "mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=".DB_CHARSET,
        DB_USER, DB_PASS,
        [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ]
    );
} catch (PDOException $e) {
    error_log("Database connection failed: " . $e->getMessage());
    http_response_code(500);
    die(json_encode(['error' => 'Database connection failed']));
}
```

---

## Common Issues & Solutions

### Issue 1: "Access denied for user"

**Error Message:**
```
SQLSTATE[HY000] [1045] Access denied for user 'username'@'localhost'
```

**Solutions:**
1. ✅ **Wrong username or password**
   - Double-check credentials in hosting control panel
   - Make sure there are no extra spaces
   - Password is case-sensitive

2. ✅ **User not added to database**
   - In cPanel/DirectAdmin, add user to database
   - Grant ALL PRIVILEGES

3. ✅ **Wrong host**
   - Try `localhost`
   - Try `127.0.0.1`
   - Ask hosting provider for correct host

### Issue 2: "Unknown database"

**Error Message:**
```
SQLSTATE[HY000] [1049] Unknown database 'database_name'
```

**Solutions:**
1. ✅ **Database doesn't exist**
   - Create database in hosting control panel
   - Use exact name (case-sensitive on Linux)

2. ✅ **Wrong database name**
   - Check for typos
   - Check for prefix (e.g., `username_dbname`)

3. ✅ **Database not imported**
   - Import `database.sql` via phpMyAdmin

### Issue 3: "Connection refused"

**Error Message:**
```
SQLSTATE[HY000] [2002] Connection refused
```

**Solutions:**
1. ✅ **MySQL not running**
   - Contact hosting provider
   - Check server status

2. ✅ **Wrong host**
   - Try `localhost` instead of `127.0.0.1`
   - Try `127.0.0.1` instead of `localhost`

3. ✅ **Firewall blocking**
   - Contact hosting provider

### Issue 4: "Can't connect to MySQL server"

**Error Message:**
```
SQLSTATE[HY000] [2002] Can't connect to MySQL server
```

**Solutions:**
1. ✅ **Wrong host**
   - Verify host with hosting provider
   - Some hosts use different host (e.g., `mysql.yourdomain.com`)

2. ✅ **MySQL on different port**
   - Ask hosting provider for port number
   - Update connection: `mysql:host=localhost;port=3307;dbname=...`

---

## Step-by-Step Verification

### 1. Verify Database Exists

**Via phpMyAdmin:**
1. Login to phpMyAdmin
2. Check left sidebar for your database name
3. If not there, create it

**Via Command Line:**
```bash
mysql -u your_user -p
SHOW DATABASES;
```

### 2. Verify User Has Access

**Via phpMyAdmin:**
1. Go to **User Accounts**
2. Find your user
3. Check privileges for your database

**Via Command Line:**
```bash
mysql -u your_user -p
USE your_database;
SHOW TABLES;
```

### 3. Verify Tables Exist

**Via phpMyAdmin:**
1. Select your database
2. Check for these tables:
   - admin_users
   - demo_requests
   - contact_submissions
   - clients

**If tables missing:**
1. Click **Import**
2. Upload `database.sql`
3. Click **Go**

### 4. Test Connection

**Create test file:** `test-connection.php`
```php
<?php
$host = 'localhost';
$dbname = 'your_database';
$user = 'your_user';
$pass = 'your_password';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    echo "✓ Connection successful!";
} catch (PDOException $e) {
    echo "✗ Connection failed: " . $e->getMessage();
}
```

Access via browser, then **delete the file**.

---

## DirectAdmin Specific Steps

### Create Database:
1. Login to DirectAdmin
2. Go to **MySQL Management**
3. Click **Create new Database**
4. Fill in:
   - Database Name: `schoolpulse_db`
   - Database User: `schoolpulse_user`
   - Password: (generate strong password)
5. Click **Create**

### Import Database:
1. Go to **phpMyAdmin** in DirectAdmin
2. Select your database from left sidebar
3. Click **Import** tab
4. Choose `database.sql` file
5. Click **Go**

### Get Connection Details:
1. In **MySQL Management**
2. Your details will be:
   - Host: `localhost`
   - Database: `schoolpulse_schoolpulse_db` (with prefix)
   - User: `schoolpulse_schoolpulse_user` (with prefix)
   - Password: (what you set)

---

## cPanel Specific Steps

### Create Database:
1. Login to cPanel
2. Go to **MySQL Databases**
3. Under "Create New Database":
   - Database Name: `schoolpulse_db`
   - Click **Create Database**
4. Under "Add New User":
   - Username: `schoolpulse_user`
   - Password: (generate strong password)
   - Click **Create User**
5. Under "Add User To Database":
   - Select user and database
   - Click **Add**
   - Check **ALL PRIVILEGES**
   - Click **Make Changes**

### Import Database:
1. Go to **phpMyAdmin** in cPanel
2. Select your database
3. Click **Import**
4. Upload `database.sql`
5. Click **Go**

### Get Connection Details:
Your details will have a prefix:
- Host: `localhost`
- Database: `cpanel_username_schoolpulse_db`
- User: `cpanel_username_schoolpulse_user`
- Password: (what you set)

---

## Still Not Working?

### Enable Error Display (Temporarily)

Edit `includes/db.php`:
```php
<?php
// Add at the very top
error_reporting(E_ALL);
ini_set('display_errors', 1);

// ... rest of the file
```

This will show the exact error message. **Remove after fixing!**

### Check PHP Error Logs

**Location varies by hosting:**
- cPanel: `public_html/error_log`
- DirectAdmin: `domains/yourdomain.com/logs/error.log`
- Custom: Ask hosting provider

### Contact Hosting Support

Provide them with:
1. Error message
2. What you've tried
3. Ask for:
   - Correct database host
   - Verify MySQL is running
   - Verify user has correct permissions

---

## Security Note

After fixing:
1. ✅ Remove `test-db-connection.php`
2. ✅ Remove any test files
3. ✅ Disable error display in production
4. ✅ Use strong database password
5. ✅ Don't share database credentials

---

## Quick Reference

### Typical DirectAdmin Credentials:
```
Host: localhost
Database: schoolpulse_schoolpulse_db
User: schoolpulse_schoolpulse_user
Password: (your password)
```

### Typical cPanel Credentials:
```
Host: localhost
Database: cpanelusername_schoolpulse
User: cpanelusername_spuser
Password: (your password)
```

### Local Development (XAMPP/WAMP):
```
Host: localhost
Database: schoolpulse_marketing
User: root
Password: (empty or Root@123)
```

---

**Need More Help?**

1. Run `test-db-connection.php` and share the output
2. Check error logs
3. Contact your hosting provider
4. Check GitHub issues: https://github.com/Kalua420/saas-marketing-schoolpulse/issues
