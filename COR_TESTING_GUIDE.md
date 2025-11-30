# COR Verification System - Testing Guide

## ⚠️ IMPORTANT: Test Files

**The following files are for LOCAL TESTING ONLY** and should NOT be pushed to VPS:
- `test_cor_expiration.php` - Check expiration status
- `expire_cor_test.php` - Temporarily expire settings  
- `restore_cor_date.php` - Restore settings after testing
- `original_cor_date.txt` - Temporary storage for original date

These files are now in `.gitignore` and won't be committed to Git.

---

## System Overview

Your COR verification system now works with **dynamic keywords** that are managed through the Filament admin panel. The keywords automatically expire based on the academic year dates.

## Current Configuration

- **University**: PAMPANGA STATE UNIVERSITY
- **Campus**: Bacolor Campus
- **Academic Year**: AY 2025-2026
- **Valid From**: August 1, 2025
- **Valid Until**: July 31, 2026
- **Status**: ✅ Active (expires Jul 31, 2026)

## How Expiration Works

### Automatic Expiration Logic

The system has three layers of validation:

1. **is_active** flag: Must be set to `true`
2. **valid_from** date: Must be less than or equal to today
3. **valid_until** date: Must be greater than or equal to today

If ANY of these conditions fail, the COR verification will reject uploads.

### What Happens When Settings Expire?

When you try to upload a COR after the `valid_until` date:

1. PHP checks `CorSetting::getActive()`
2. The query checks if current date is within `valid_from` and `valid_until`
3. If expired, returns `null`
4. User sees: **"⚠️ COR verification settings have expired. Please contact admin."**

## Testing Expiration

### Method 1: Via Filament Admin Panel (Recommended)

1. Login to admin panel: `http://localhost:8000/admin`
2. Navigate to **System Settings → COR Verification Settings**
3. Click **Edit** on the current setting
4. Change **Valid Until** to yesterday's date (e.g., November 25, 2025)
5. Click **Save**
6. Try uploading a COR - you should see the expiration error

### Method 2: Via Test Scripts (Quick)

**To expire the COR settings:**
```bash
php expire_cor_test.php
```

**To restore the COR settings:**
```bash
php restore_cor_date.php
```

### Method 3: Via Database Query

```php
php artisan tinker
```

Then run:
```php
$s = App\Models\CorSetting::first();
$s->valid_until = now()->subDay();
$s->save();
echo "Expired!";
```

To restore:
```php
$s = App\Models\CorSetting::first();
$s->valid_until = \Carbon\Carbon::create(2026, 7, 31);
$s->save();
echo "Restored!";
```

## Testing Complete Workflow

### Test 1: Valid COR Upload (Should Work)

1. Ensure COR settings are active and not expired
2. Upload a valid COR PDF from PAMPANGA STATE UNIVERSITY
3. Expected result: **"✅ COR is valid!"**

### Test 2: Invalid COR Upload (Should Fail)

1. Ensure COR settings are active and not expired
2. Upload a COR from a different university or different campus
3. Expected result: **"❌ COR is invalid! Missing: [keywords]"**

### Test 3: Expired Settings (Should Block Upload)

1. Run `php expire_cor_test.php` to expire the settings
2. Try uploading any COR
3. Expected result: **"⚠️ COR verification settings have expired. Please contact admin."**
4. Run `php restore_cor_date.php` to restore settings

### Test 4: No Active Settings (Should Block Upload)

```php
php artisan tinker
```

Then:
```php
$s = App\Models\CorSetting::first();
$s->is_active = false;
$s->save();
```

Try uploading - should see: **"⚠️ No active COR verification settings found. Please contact admin."**

Restore:
```php
$s = App\Models\CorSetting::first();
$s->is_active = true;
$s->save();
```

## Monitoring Expiration

### Check Current Status

Run:
```bash
php test_cor_expiration.php
```

This will show:
- Current settings
- Days until expiration
- Validity status

### Check via API

```bash
curl http://localhost:8000/api/cor/keywords
```

Response when valid:
```json
{
  "success": true,
  "keywords": ["PAMPANGA STATE UNIVERSITY", "Certificate of Registration", ...],
  "academic_year": "AY 2025-2026",
  "valid_until": "2026-07-31"
}
```

Response when expired:
```json
{
  "success": false,
  "message": "COR verification settings have expired. Please update the settings.",
  "keywords": []
}
```

## For Next Academic Year

When the academic year changes (August 2026):

1. Login to Filament admin panel
2. Go to **System Settings → COR Verification Settings**
3. Click **New cor setting**
4. Fill in:
   - University Name: PAMPANGA STATE UNIVERSITY
   - COR Title: Certificate of Registration
   - Campus Name: Bacolor Campus
   - Academic Year: AY 2026-2027
   - Valid From: August 1, 2026
   - Valid Until: July 31, 2027
   - Is Active: ✅ (This will automatically deactivate the old setting)
5. Save

The old setting will automatically be deactivated, and all new COR uploads will use the new keywords!

## Troubleshooting

### Issue: COR upload shows "Error during COR verification"

**Check:**
1. Is Python installed? Run: `py --version`
2. Are Python packages installed? Run: `py -m pip list | Select-String "PyPDF2|requests"`
3. Check Laravel logs: `Get-Content storage/logs/laravel.log -Tail 50`

### Issue: COR always shows "expired"

**Check:**
1. Run: `php test_cor_expiration.php`
2. Verify the dates in Filament admin panel
3. Make sure `is_active` is checked

### Issue: Valid COR shows as "invalid"

**Check:**
1. Verify the PDF contains all required keywords
2. Check the keywords in admin panel match what's in the PDF
3. Keywords are case-insensitive

## Files Created for Testing

- `test_cor_expiration.php` - Check current expiration status
- `expire_cor_test.php` - Temporarily expire settings for testing
- `restore_cor_date.php` - Restore settings after testing

## Important Behaviors

### COR Verification Logging

**Current Status**: ❌ Not implemented
- COR verifications are NOT currently logged in Filament
- Only the user's `cor_status` field is updated ('pending' → 'verified')
- No history or audit trail of when users verified their COR

**To implement logging**, you would need to create:
1. A `CorVerificationLog` model
2. A Filament resource to view the logs
3. Log entries every time a COR is verified

### What Happens to Verified Accounts When Settings Expire?

**Current Behavior**:
- ✅ **Already verified accounts**: Keep their 'verified' status
- ❌ **New uploads**: Cannot verify (blocked by expiration)
- ✅ **System access**: Verified users can continue using the platform

**Important**: Once a user is verified for AY 2025-2026, they **stay verified even after July 31, 2026**. The expiration only prevents NEW verifications.

### Should Verified Status Expire Automatically?

This depends on your business requirements:

**Option A: Keep Status (Current)**
- Students verified for AY 2025-2026 stay verified forever
- ✅ Pro: Students don't need to re-verify every year
- ❌ Con: Cannot enforce annual COR updates

**Option B: Auto-Expire Status (Not Implemented)**
- On July 31, 2026, reset all `cor_status='verified'` → `cor_status='pending'`
- ✅ Pro: Forces students to submit new COR each academic year
- ✅ Pro: Ensures current enrollment status
- ❌ Con: Students must re-upload COR annually

**Recommendation**: Implement Option B if you want to ensure students are currently enrolled.

## Summary

✅ **COR verification is now working!**
✅ **Keywords are dynamic and database-driven**
✅ **Automatic expiration based on academic year dates**
✅ **Easy to update via admin panel**
✅ **No code changes needed for future academic years**

⚠️ **Not Yet Implemented**:
- COR verification history/logging in Filament
- Automatic expiration of verified user accounts

The system will automatically prevent COR verification after July 31, 2026, and admin will need to create new settings for the next academic year.

### Testing Checklist

Before deploying to VPS:

1. ✅ Test with valid COR from correct university
2. ✅ Test with invalid COR (different university)
3. ✅ Test expiration by setting valid_until to past date
4. ✅ Test new account COR verification flow
5. ❌ Delete test files (`expire_cor_test.php`, etc.) or ensure they're in `.gitignore`
6. ✅ Verify COR settings in Filament admin panel
7. ❌ Decide if you need COR verification logging
8. ❌ Decide if verified status should expire annually
