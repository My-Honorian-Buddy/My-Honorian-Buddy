# COR System - Quick Answers

## Your Questions Answered

### 1. Should I create a new account to test COR verification in Filament?

**Answer**: Yes, but there's currently NO logging in Filament for COR verifications.

**What currently happens:**
- User uploads COR → Python verifies → Status changes from 'pending' to 'verified'
- That's it! No log entries in Filament

**What you can check in Filament:**
- Go to **Accounts → Users**
- Find the test user
- Check their `cor_status` field (should show 'verified')

**If you want logging:**
You would need to add:
1. Create `CorVerificationLog` model and migration
2. Create Filament resource to view logs
3. Save log entry every time COR is verified

---

### 2. What happens to verified accounts when COR settings expire?

**Answer**: NOTHING (currently)

**Current Behavior:**
- **July 31, 2026 comes** → Settings expire
- **Users already verified** → Stay verified ✅
- **New users trying to verify** → Cannot upload (blocked) ❌
- **System** → Works normally for verified users

**The Expiration ONLY Prevents New Verifications**

Example Timeline:
```
June 2026: Student A verifies COR → Status: 'verified' ✅
July 31, 2026: Settings expire
August 2026: 
  - Student A → Still 'verified' ✅ (can use platform)
  - Student B tries to verify → BLOCKED ❌ (cannot upload COR)
```

---

### 3. Should verified accounts expire automatically?

**This is YOUR decision based on requirements:**

**Option A: Keep Forever (Current System)**
```
Student verifies once → Stays verified forever
```
- ✅ Students only verify once
- ❌ No way to ensure current enrollment

**Option B: Annual Reset (Needs Implementation)**
```
Every July 31st → Reset all 'verified' → 'pending'
Students must re-upload new COR each year
```
- ✅ Ensures current enrollment
- ✅ Fresh COR every academic year
- ❌ More work for students

**Which should you choose?**
- Use Option A if: One-time verification is enough
- Use Option B if: You need proof of current enrollment each year

---

### 4. Why are test files outside folders?

**Answer**: They're temporary test scripts for local development.

**These files should NOT go to VPS:**
- `test_cor_expiration.php`
- `expire_cor_test.php`
- `restore_cor_date.php`
- `original_cor_date.txt`

**I've already fixed this:**
✅ Added them to `.gitignore`
✅ They won't be pushed to Git
✅ They won't go to VPS

**Why are they in root?**
- Quick and easy to run: `php expire_cor_test.php`
- Laravel can easily access them
- Only for testing on your local machine

**After testing:**
You can delete them or keep them (they're ignored by Git anyway).

---

## Testing Plan for New Account

### Step 1: Create Test Account
1. Register new user
2. Check user in Filament → cor_status should be 'pending'

### Step 2: Upload Valid COR
1. Login as test user
2. Go to COR verification page
3. Upload valid COR PDF from PAMPANGA STATE UNIVERSITY, Bacolor Campus
4. Should see: ✅ "COR is valid!"

### Step 3: Check Status
1. Go to Filament → Accounts → Users
2. Find test user
3. Check cor_status → Should be 'verified' now

### Step 4: Test Expiration (Optional)
1. Run: `php expire_cor_test.php`
2. Try uploading COR with another account
3. Should see: ⚠️ "COR verification settings have expired"
4. Run: `php restore_cor_date.php`

---

## Recommendations

### For Production (VPS):

1. **Do NOT deploy test files**
   - Already in `.gitignore` ✅
   
2. **Decide on verification logging**
   - Do you need audit trail?
   - Do admins need to see who verified when?
   
3. **Decide on annual expiration**
   - Should verified status reset each year?
   - Or once verified = verified forever?

4. **Set up monitoring**
   - Check settings expiration date
   - Notify admin 30 days before expiration

---

## Current System Status

✅ **Working**:
- Dynamic COR keywords from database
- COR verification with keywords
- Settings expiration (blocks new uploads)
- Admin panel to manage settings

❌ **Not Implemented**:
- COR verification logging in Filament
- Annual reset of verified accounts
- Email notifications for expiring settings
- COR upload history per user

---

## Next Steps

1. Test with new account (see "Testing Plan" above)
2. Decide if you need logging
3. Decide if verified status should expire annually
4. Test on local then push to VPS
5. Delete or keep test files (they won't be pushed anyway)

