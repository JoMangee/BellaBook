#!/bin/bash
# bellabook-security-test.sh
# Quick test script to verify security patch was applied correctly

echo "BellaBook Security Patch Verification"
echo "======================================"
echo ""

# Colors
GREEN='\033[0;32m'
RED='\033[0;31m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

PASS=0
FAIL=0

# Test 1: Check for SHA256 hash usage
echo "Test 1: Checking for SHA256 password hashing..."
if grep -q "hash('sha256'" admin.php; then
    echo -e "${GREEN}✓ PASS${NC}: SHA256 hash function found"
    ((PASS++))
else
    echo -e "${RED}✗ FAIL${NC}: SHA256 hash not found (may still be using MD5)"
    ((FAIL++))
fi
echo ""

# Test 2: Check for htmlspecialchars usage
echo "Test 2: Checking for XSS protection (htmlspecialchars)..."
if grep -q "htmlspecialchars" admin.php index.php; then
    COUNT=$(grep -c "htmlspecialchars" admin.php index.php)
    echo -e "${GREEN}✓ PASS${NC}: Found $COUNT instances of htmlspecialchars()"
    ((PASS++))
else
    echo -e "${RED}✗ FAIL${NC}: No htmlspecialchars() found - XSS protection may be missing"
    ((FAIL++))
fi
echo ""

# Test 3: Check for path traversal protection
echo "Test 3: Checking for path traversal protection..."
if grep -q "strpos.*\.\." admin.php; then
    echo -e "${GREEN}✓ PASS${NC}: Path traversal checks found"
    ((PASS++))
else
    echo -e "${YELLOW}⚠ WARNING${NC}: Path traversal protection may not be present"
    ((FAIL++))
fi
echo ""

# Test 4: Check for require_once
echo "Test 4: Checking for proper error handling (require_once)..."
if grep -q "require_once" admin.php; then
    echo -e "${GREEN}✓ PASS${NC}: Using require_once() for better error handling"
    ((PASS++))
else
    echo -e "${YELLOW}⚠ WARNING${NC}: Not using require_once() - may use @require"
    # Don't count as fail, this is optional
fi
echo ""

# Summary
echo "======================================"
echo -e "Results: ${GREEN}$PASS passed${NC}, ${RED}$FAIL failed${NC}"
echo ""

if [ $FAIL -eq 0 ]; then
    echo -e "${GREEN}✓ Security patch appears to be applied correctly!${NC}"
    exit 0
else
    echo -e "${RED}✗ Some security improvements are missing${NC}"
    exit 1
fi
