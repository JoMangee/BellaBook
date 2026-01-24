# BellaBook Security Fixes

This document outlines security improvements that should be applied to BellaBook and OpenLetter codebases.

## Issue 1: Cookie Validation Bug (Critical)

**Problem:** The admin login cookie validation uses `session_id()` which changes with each request. This causes the "stay logged in" feature to fail randomly.

**Location:** `admin.php` lines ~13-15 and line ~316

**Current Code:**
```php
if ($_COOKIE['bellabook'] == hash('sha256', $admin_pass.$secret.session_id())) {
    // ... authenticated code
}

setcookie('bellabook', hash('sha256', $_POST['pass'].$secret.session_id()), ...);
```

**Problem:** `session_id()` is different on each request, so the hash never matches after the initial login.

**Fix:**
```php
if ($_COOKIE['bellabook'] == hash('sha256', $admin_pass.$secret)) {
    // ... authenticated code
}

setcookie('bellabook', hash('sha256', $_POST['pass'].$secret), ...);
```

**Impact:** Admin panel login now works reliably with persistent authentication.

---

## Issue 2: XSS Vulnerabilities (High)

**Problem:** User input is output without proper escaping in multiple locations, allowing XSS attacks.

**Affected Files:**
- `index.php` - Entry display
- `admin.php` - Admin panel display
- `sign.php` - Form submission

**Fix:** Add `htmlspecialchars()` with `ENT_QUOTES` and `UTF-8` to all user-controlled output.

**Example:**
```php
// Before (vulnerable):
echo $name;
echo $message;

// After (safe):
echo htmlspecialchars($name, ENT_QUOTES, 'UTF-8');
echo htmlspecialchars($message, ENT_QUOTES, 'UTF-8');
```

**Locations to update:**
- User names display
- Messages/comments display
- Email addresses
- Location fields
- Any user-submitted content

---

## Issue 3: Path Traversal in Admin Panel (Medium)

**Problem:** File parameter validation could allow directory traversal attacks.

**Location:** `admin.php` file handling section

**Fix:** Implement strict whitelist validation:
```php
$allowed_files = array("entries.txt", "tempentries.txt");
if (!isset($_GET['file']) || !in_array($_GET['file'], $allowed_files, true) || 
    strpos($_GET['file'], '..') !== false || strpos($_GET['file'], '/') !== false || 
    strpos($_GET['file'], '\\') !== false) {
    $_GET['file'] = null;
}
```

---

## Summary of Changes

These security fixes should be applied to:
1. **BellaBook** (upstream) - All three fixes
2. **OpenLetter** - All three fixes (if still maintained)
3. **Any BellaBook forks** - Recommended for all

**Recommended approach:**
- Create a new branch `security-fixes` from the main/master branch
- Apply these fixes in a single clean commit
- Create a pull request with clear documentation
- Test thoroughly before merging

**Testing checklist:**
- [ ] Admin login works and persists for 31 days
- [ ] User messages display without XSS
- [ ] Malicious input is properly escaped
- [ ] File operations work correctly
