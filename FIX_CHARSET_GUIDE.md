# Fix Database Character Set (latin1 → utf8mb4)

## Problem
Your database was created with `latin1` charset instead of `utf8mb4`. This can cause issues with:
- Special characters (é, ñ, ü, etc.)
- Emojis (😀, 🎉, etc.)
- International characters (中文, العربية, etc.)

## Solution

You have **two options**:

---

## Option 1: Convert Existing Database (Recommended)

### Step 1: Upload Fix Script
1. Download `fix-database-charset.php` from your repository
2. Edit the file and update these lines with your credentials:
   ```php
   $host = 'localhost';
   $dbname = 'schoolpulse_schoolpulse_db';  // Your database name
   $username = 'schoolpulse_schoolpulse_user';  // Your username
   $password = 'your_password_here';  // Your password
   ```
3. Upload to your server root (same location as index.php)

### Step 2: Run the Script
1. Access via browser: `https://schoolpulse.in/fix-database-charset.php`
2. Wait for it to complete
3. You should see "✓ SUCCESS!" message

### Step 3: Verify
The script will show you:
- Database charset (should be utf8mb4)
- All table charsets (should all be utf8mb4)

### Step 4: Clean Up
**⚠️ IMPORTANT:** Delete `fix-database-charset.php` after running!

---

## Option 2: Recreate Database (Fresh Start)

If you haven't added any data yet, this is cleaner:

### Step 1: Drop Existing Database
In DirectAdmin phpMyAdmin:
1. Select your database
2. Click **Operations** tab
3. Scroll down to "Remove database"
4. Click **Drop the database (DROP)**

### Step 2: Create New Database with Correct Charset

**Via DirectAdmin:**
1. Go to **MySQL Management**
2. Click **Create new Database**
3. Database Name: `schoolpulse_db`
4. **Character Set**: Select `utf8mb4`
5. **Collation**: Select `utf8mb4_unicode_ci`
6. Create user and set password

**Via phpMyAdmin:**
1. Click **New** in left sidebar
2. Database name: `schoolpulse_schoolpulse_db`
3. **Collation**: Select `utf8mb4_unicode_ci`
4. Click **Create**

### Step 3: Import Database
1. Select your new database
2. Click **Import**
3. Upload `database.sql`
4. Click **Go**

### Step 4: Update Configuration
Edit `includes/db.php` with new credentials if they changed.

---

## Verification

After fixing, verify the charset:

### Via phpMyAdmin:
1. Select your database
2. Click **Operations** tab
3. Check "Collation" - should show `utf8mb4_unicode_ci`

### Via SQL Query:
```sql
SELECT DEFAULT_CHARACTER_SET_NAME, DEFAULT_COLLATION_NAME 
FROM information_schema.SCHEMATA 
WHERE SCHEMA_NAME = 'your_database_name';
```

Should return:
- `DEFAULT_CHARACTER_SET_NAME`: utf8mb4
- `DEFAULT_COLLATION_NAME`: utf8mb4_unicode_ci

---

## Why utf8mb4?

| Feature | latin1 | utf8mb4 |
|---------|--------|---------|
| English characters | ✓ | ✓ |
| Special characters (é, ñ) | ✗ | ✓ |
| Emojis (😀, 🎉) | ✗ | ✓ |
| International (中文, العربية) | ✗ | ✓ |
| Storage per character | 1 byte | 1-4 bytes |
| Modern standard | ✗ | ✓ |

**utf8mb4** is the modern standard and supports all Unicode characters.

---

## Common Issues

### Issue: "Access denied" when running fix script
**Solution:** Make sure database user has `ALTER` privilege

### Issue: Script times out
**Solution:** 
1. Increase PHP timeout in php.ini: `max_execution_time = 300`
2. Or convert tables one by one manually in phpMyAdmin

### Issue: Some tables still show latin1
**Solution:** Run these SQL commands for each table:
```sql
ALTER TABLE table_name CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

---

## Manual Conversion (If Script Fails)

If the automated script doesn't work, convert manually:

### 1. Convert Database:
```sql
ALTER DATABASE your_database_name 
CHARACTER SET utf8mb4 
COLLATE utf8mb4_unicode_ci;
```

### 2. Convert Each Table:
```sql
ALTER TABLE admin_users CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE clients CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE contact_submissions CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE demo_requests CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

Run these in phpMyAdmin SQL tab.

---

## After Fixing

1. ✅ Verify charset is utf8mb4
2. ✅ Test website functionality
3. ✅ Test special characters in forms
4. ✅ Delete fix-database-charset.php
5. ✅ Your `includes/db.php` already has `utf8mb4` set, so no changes needed there

---

## Prevention for Future

When creating new databases:
- **Always** select `utf8mb4` charset
- **Always** select `utf8mb4_unicode_ci` collation
- This is now the default in MySQL 8.0+

---

## Need Help?

If you encounter issues:
1. Check error logs
2. Contact hosting support
3. Share error message for assistance

---

**Last Updated:** May 6, 2026
