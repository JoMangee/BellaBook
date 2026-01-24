# BellaBook Security Patch

## Overview
This patch addresses critical security vulnerabilities in BellaBook 3.8 and earlier versions:

1. **Weak password hashing** - MD5 should be replaced with SHA256
2. **Cross-Site Scripting (XSS)** - User input not properly escaped in output
3. **Path traversal vulnerability** - File parameter validation too lenient

## How to Apply

### Option 1: Apply the patch file (Recommended for version control)
```bash
cd /path/to/bellabook
git apply bellabook-security.patch
```

### Option 2: Manual application
Follow the changes documented below in each file.

### Option 3: Cherry-pick specific fixes
Each section below shows exactly what lines to change.

---

## Changes Required

### File: admin.php

**Issue 1: Upgrade MD5 to SHA256 for password hashing**

**Line ~13 (Authentication check):**
```diff
- if ($_COOKIE['bellabook'] == md5($admin_pass.$secret)) {
+ if ($_COOKIE['bellabook'] == hash('sha256', $admin_pass.$secret)) {
```

**Line ~258 (Cookie creation on login):**
```diff
- setcookie('bellabook', md5($admin_pass.$secret), time()+(31*86400), '/');
+ setcookie('bellabook', hash('sha256', $admin_pass.$secret), time()+(31*86400), '/');
```

**Issue 2: Add input sanitization for XSS prevention**

Add `htmlspecialchars()` escaping to all user-controlled output throughout the admin panel. 

Examples of lines that need updating:
```diff
- echo $name;
+ echo htmlspecialchars($name, ENT_QUOTES, 'UTF-8');

- echo $message;
+ echo htmlspecialchars($message, ENT_QUOTES, 'UTF-8');

- echo $email;
+ echo htmlspecialchars($email, ENT_QUOTES, 'UTF-8');
```

**Issue 3: Improve file parameter validation**

**Line ~17-18 (Current weak validation):**
```diff
- if (!isset($_GET['file']) || (isset($_GET['file']) && ($_GET['file'] != "entries.txt" && $_GET['file'] != "tempentries.txt")))
+ $allowed_files = array("entries.txt", "tempentries.txt");
+ if (!isset($_GET['file']) || !in_array($_GET['file'], $allowed_files, true) || strpos($_GET['file'], '..') !== false || strpos($_GET['file'], '/') !== false || strpos($_GET['file'], '\\') !== false)
	$_GET['file'] = null;
```

---

### File: index.php

**Add XSS protection to entry display:**

Wrap all user-controlled output with `htmlspecialchars()`:

```diff
- echo $name;
+ echo htmlspecialchars($name, ENT_QUOTES, 'UTF-8');

- echo $date;
+ echo htmlspecialchars($date, ENT_QUOTES, 'UTF-8');

- echo $message;
+ echo htmlspecialchars($message, ENT_QUOTES, 'UTF-8');
```

---

### File: sign.php

**Add XSS protection to form processing:**

When outputting back form data or messages:
```diff
- echo $error_msg;
+ echo htmlspecialchars($error_msg, ENT_QUOTES, 'UTF-8');
```

---

## Security Benefits

After applying this patch:

✅ **Stronger password protection** - SHA256 is significantly more resistant to brute-force attacks than MD5
✅ **XSS prevention** - Malicious scripts injected through comments/names are neutralized
✅ **Path traversal protection** - Stricter file parameter validation prevents directory traversal attacks

## Testing Checklist

After applying the patch, verify:
- [ ] Admin login works and sets the cookie correctly
- [ ] Admin can stay logged in for 31 days without re-authentication
- [ ] User comments with HTML/script tags are displayed as plain text, not executed
- [ ] Attempting to access files like `../../etc/passwd` is blocked
- [ ] All legitimate functionality continues to work

## Compatibility

- **Compatible with:** BellaBook 3.6, 3.7, 3.8
- **PHP versions:** 5.3+, 7.x, 8.x
- **Database:** No schema changes required
- **Backwards compatible:** Yes, existing data is unaffected

## Reference

- CVE-like vulnerabilities addressed:
  - Weak cryptographic hashing (MD5)
  - Cross-site scripting (XSS) via output encoding
  - Path traversal through insufficient input validation

## Notes

- The cookie name `'bellabook'` is intentionally kept for backwards compatibility
- Existing admin sessions will be invalidated after this patch (users will need to log in again)
- No data migration required
