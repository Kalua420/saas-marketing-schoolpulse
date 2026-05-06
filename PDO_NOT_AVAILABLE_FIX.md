# PDO MySQL Driver Not Available - Fix Guide

## Problem
Your production server does not have the PDO MySQL driver enabled, which is causing the "could not find driver" error.

## Solution Options

### Option 1: Enable PDO MySQL (Recommended)
Contact your hosting provider and ask them to enable the PDO MySQL extension in PHP.

**What to tell them:**
> "Please enable the PDO MySQL extension (pdo_mysql) for my hosting account. My application requires it for database connectivity."

### Option 2: Use MySQLi Instead (Temporary Workaround)
If PDO cannot be enabled immediately, you can use MySQLi as a temporary solution.

---

## Step-by-Step Fix (Using MySQLi)

### Step 1: Check Available Extensions

1. Upload `check-php-info.php` to your server root
2. Access it via browser: `https://yourdomain.com/check-php-info.php`
3. Look for these extensions:
   - ✓ **PDO** - PHP Data Objects
   - ✓ **PDO MySQL Driver** - PDO MySQL support
   - ✓ **MySQLi** - MySQLi extension

**If MySQLi is available but PDO is not**, continue with this guide.

**If neither is available**, contact your hosting provider immediately.

### Step 2: Get Your Database Credentials

1. Login to **DirectAdmin**
2. Go to **MySQL Management**
3. Note down:
   - **Database Name**: (e.g., `schoolpulse_schoolpulse_db`)
   - **Database User**: (e.g., `schoolpulse_schoolpulse_user`)
   - **Database Password**: (what you set during creation)
   - **Host**: Usually `localhost`

### Step 3: Fix Database Charset

Your database was created with `latin1` charset, which needs to be converted to `utf8mb4`.

1. **Edit `fix-charset-mysqli.php`** and update these lines:
   ```php
   $host = 'localhost';
   $dbname = 'schoolpulse_schoolpulse_db';  // ← Your actual database name
   $username = 'schoolpulse_schoolpulse_user';  // ← Your actual username
   $password = 'your_actual_password';  // ← Your actual password
   ```

2. **Upload `fix-charset-mysqli.php`** to your server root

3. **Access it via browser**: `https://yourdomain.com/fix-charset-mysqli.php`

4. **Wait for conversion** - You should see:
   - ✓ MySQLi extension is loaded
   - ✓ Connected to MySQL server
   - ✓ Database converted to utf8mb4
   - ✓ All tables converted

5. **DELETE the file** after successful conversion:
   ```bash
   rm fix-charset-mysqli.php
   ```

### Step 4: Update Database Connection

You have two options:

#### Option A: Replace db.php with MySQLi version (Quick Fix)

1. **Backup current `includes/db.php`**:
   ```bash
   cp includes/db.php includes/db.php.backup
   ```

2. **Replace with MySQLi version**:
   ```bash
   cp includes/db-mysqli.php includes/db.php
   ```

3. **Edit `includes/db.php`** with your production credentials:
   ```php
   define('DB_HOST', 'localhost');
   define('DB_NAME', 'schoolpulse_schoolpulse_db');  // ← Your database name
   define('DB_USER', 'schoolpulse_schoolpulse_user');  // ← Your username
   define('DB_PASS', 'your_actual_password');  // ← Your password
   ```

**⚠️ WARNING**: This will require updating all your PHP files that use PDO syntax to MySQLi syntax.

#### Option B: Keep PDO and Contact Hosting (Recommended)

1. **Update `includes/db.php`** with production credentials only:
   ```php
   define('DB_HOST', 'localhost');
   define('DB_NAME', 'schoolpulse_schoolpulse_db');
   define('DB_USER', 'schoolpulse_schoolpulse_user');
   define('DB_PASS', 'your_actual_password');
   ```

2. **Contact hosting provider** to enable PDO MySQL extension

3. **Wait for them to enable it** (usually takes a few hours)

4. **Test your website** after they confirm

### Step 5: Test Your Website

1. Access your website: `https://yourdomain.com`
2. Try submitting a contact form
3. Try accessing admin panel: `https://yourdomain.com/admin`
4. Check for any errors

### Step 6: Clean Up

Delete all diagnostic and fix files:
```bash
rm check-php-info.php
rm fix-charset-mysqli.php
rm fix-database-charset.php
rm test-db-connection.php
```

---

## Files That Need MySQLi Conversion (If Using Option A)

If you chose Option A (using MySQLi), these files need to be updated:

### Admin Files:
- `admin/login.php`
- `admin/dashboard.php`
- `admin/leads.php`
- `admin/contacts.php`
- `admin/clients.php`
- `admin/profile.php`
- `admin/settings.php`
- `admin/api/get-contact.php`
- `admin/api/upload-profile-picture.php`
- `admin/api/delete-profile-picture.php`

### API Files:
- `api/submit-contact.php`
- `api/submit-demo.php`

### Conversion Example:

**PDO Syntax (Current):**
```php
$stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
$stmt->execute([$email]);
$user = $stmt->fetch();
```

**MySQLi Syntax (New):**
```php
$stmt = db_query($conn, "SELECT * FROM users WHERE email = ?", [$email]);
$user = db_fetch($stmt);
```

---

## Recommended Approach

**I strongly recommend Option B** (keeping PDO and asking hosting to enable it) because:

1. ✅ No code changes needed
2. ✅ PDO is more secure and modern
3. ✅ All your code is already written for PDO
4. ✅ Most hosting providers have PDO enabled by default

**Only use Option A** if:
- ❌ Hosting provider refuses to enable PDO
- ❌ You need the site working immediately
- ❌ You're willing to update all database code

---

## What to Tell Your Hosting Provider

**Email Template:**

```
Subject: Please Enable PDO MySQL Extension

Hello,

I need the PDO MySQL extension (pdo_mysql) enabled for my hosting account.

Domain: yourdomain.com
Account: your_username

My PHP application requires PDO for database connectivity and is currently 
showing "could not find driver" error.

Please enable:
- PDO extension
- PDO MySQL driver (pdo_mysql)

Thank you!
```

---

## Verification After Fix

### Test Database Connection:

Create `test-final.php`:
```php
<?php
require_once 'includes/db.php';

try {
    // If using PDO
    if (isset($pdo)) {
        $stmt = $pdo->query("SELECT COUNT(*) as count FROM admin_users");
        $result = $stmt->fetch();
        echo "✓ PDO Connection successful! Found {$result['count']} admin users.";
    }
    // If using MySQLi
    elseif (isset($conn)) {
        $result = $conn->query("SELECT COUNT(*) as count FROM admin_users");
        $row = $result->fetch_assoc();
        echo "✓ MySQLi Connection successful! Found {$row['count']} admin users.";
    }
} catch (Exception $e) {
    echo "✗ Error: " . $e->getMessage();
}
?>
```

Access via browser, then **delete the file**.

---

## Summary

1. ✅ Check available PHP extensions (`check-php-info.php`)
2. ✅ Fix database charset (`fix-charset-mysqli.php`)
3. ✅ Update database credentials in `includes/db.php`
4. ✅ Contact hosting to enable PDO (recommended)
   - OR convert all code to MySQLi (not recommended)
5. ✅ Test website functionality
6. ✅ Delete all diagnostic files

---

## Need Help?

If you're stuck:
1. Share the output of `check-php-info.php`
2. Share any error messages
3. Let me know which option you chose (A or B)

**Current Status:**
- ❌ PDO MySQL driver not available
- ✅ Database charset needs conversion (latin1 → utf8mb4)
- ⏳ Waiting for hosting provider to enable PDO
