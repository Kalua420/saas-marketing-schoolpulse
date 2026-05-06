# Action Checklist - Fix Database Connection

## Current Problem
- ❌ Database connection failed
- ❌ PDO MySQL driver not available ("could not find driver")
- ❌ Database created with wrong charset (latin1 instead of utf8mb4)

---

## Quick Action Steps

### ✅ Step 1: Check Available Extensions (5 minutes)

1. Upload `check-database-options.php` to your server root
2. Access via browser: `https://yourdomain.com/check-database-options.php`
3. Read the recommendation
4. Delete the file after checking

**This will tell you:**
- Which database extensions are available
- Which approach to take (PDO or MySQLi)
- Current database charset status

---

### ✅ Step 2: Get Database Credentials (2 minutes)

1. Login to **DirectAdmin**
2. Go to **MySQL Management**
3. Write down:
   ```
   Host: localhost
   Database: _________________
   Username: _________________
   Password: _________________
   ```

---

### ✅ Step 3: Fix Database Charset (5 minutes)

1. Edit `fix-charset-mysqli.php` and update credentials:
   ```php
   $host = 'localhost';
   $dbname = 'your_database_name';  // From Step 2
   $username = 'your_username';      // From Step 2
   $password = 'your_password';      // From Step 2
   ```

2. Upload to server root

3. Access via browser: `https://yourdomain.com/fix-charset-mysqli.php`

4. Wait for conversion (should see green checkmarks)

5. Delete the file:
   ```bash
   rm fix-charset-mysqli.php
   ```

---

### ✅ Step 4: Update Database Connection (3 minutes)

Edit `includes/db.php` and update these lines:

```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'your_database_name');  // From Step 2
define('DB_USER', 'your_username');        // From Step 2
define('DB_PASS', 'your_password');        // From Step 2
```

**Keep everything else the same!**

---

### ✅ Step 5: Contact Hosting Provider (If PDO Not Available)

If `check-database-options.php` showed PDO is not available:

**Email to hosting support:**

```
Subject: Please Enable PDO MySQL Extension

Hello,

I need the PDO MySQL extension enabled for my hosting account.

Domain: yourdomain.com
Account: your_username

My application requires PDO for database connectivity and is currently 
showing "could not find driver" error.

Please enable:
- PDO extension
- PDO MySQL driver (pdo_mysql)

Thank you!
```

---

### ✅ Step 6: Test Website (5 minutes)

1. Access your website: `https://yourdomain.com`
2. Try submitting contact form
3. Try accessing admin: `https://yourdomain.com/admin`
4. Login with your admin credentials

**If everything works:**
- ✅ Database connection is fixed!
- ✅ Charset is correct
- ✅ Website is functional

**If still not working:**
- Check error logs
- Share the error message
- Run `check-database-options.php` again

---

### ✅ Step 7: Clean Up (2 minutes)

Delete all diagnostic files:

```bash
rm check-database-options.php
rm check-php-info.php
rm fix-charset-mysqli.php
rm fix-database-charset.php
rm test-db-connection.php
```

Or via FTP/File Manager:
- Delete `check-database-options.php`
- Delete `check-php-info.php`
- Delete `fix-charset-mysqli.php`
- Delete `fix-database-charset.php`
- Delete `test-db-connection.php`

---

## Files You Need

### Already Created:
- ✅ `check-database-options.php` - Check available extensions
- ✅ `check-php-info.php` - Detailed PHP info
- ✅ `fix-charset-mysqli.php` - Fix database charset (MySQLi version)
- ✅ `includes/db-mysqli.php` - MySQLi fallback connection
- ✅ `PDO_NOT_AVAILABLE_FIX.md` - Detailed guide

### Need to Update:
- ⏳ `includes/db.php` - Update with production credentials
- ⏳ `fix-charset-mysqli.php` - Update with production credentials

---

## Decision Tree

```
Start Here
    |
    v
Run check-database-options.php
    |
    +-- PDO MySQL Available? --> YES --> Update db.php credentials
    |                                     Run fix-charset-mysqli.php
    |                                     Test website
    |                                     Done! ✓
    |
    +-- PDO MySQL Available? --> NO --> MySQLi Available?
                                            |
                                            +-- YES --> Use MySQLi temporarily
                                            |           Contact hosting for PDO
                                            |           Update db.php credentials
                                            |           Run fix-charset-mysqli.php
                                            |           Test website
                                            |
                                            +-- NO --> Contact hosting IMMEDIATELY
                                                       Cannot proceed without database extension
```

---

## Expected Timeline

| Step | Time | Status |
|------|------|--------|
| Check extensions | 5 min | ⏳ Pending |
| Get credentials | 2 min | ⏳ Pending |
| Fix charset | 5 min | ⏳ Pending |
| Update db.php | 3 min | ⏳ Pending |
| Contact hosting | 1 min | ⏳ If needed |
| Test website | 5 min | ⏳ Pending |
| Clean up | 2 min | ⏳ Pending |
| **Total** | **~25 min** | |

*Note: If hosting needs to enable PDO, add 2-24 hours wait time*

---

## Common Issues

### Issue: "Access denied for user"
**Solution:** Double-check credentials in DirectAdmin MySQL Management

### Issue: "Unknown database"
**Solution:** Verify database name (check for prefix like `schoolpulse_`)

### Issue: "Table doesn't exist"
**Solution:** Import `database.sql` via phpMyAdmin

### Issue: Still showing "could not find driver"
**Solution:** 
1. Verify PDO is enabled (check-database-options.php)
2. Contact hosting if not enabled
3. Use MySQLi temporarily

---

## Success Criteria

✅ Website loads without errors
✅ Contact form works
✅ Admin panel accessible
✅ Can login to admin
✅ Database charset is utf8mb4
✅ All diagnostic files deleted

---

## Need Help?

If stuck at any step:
1. Share the output of `check-database-options.php`
2. Share any error messages
3. Share which step you're on

**Current Status:**
- ❌ PDO MySQL driver not available
- ⏳ Need to check available extensions
- ⏳ Need to fix database charset
- ⏳ Need to update database credentials

**Next Action:**
Upload and run `check-database-options.php` first!
