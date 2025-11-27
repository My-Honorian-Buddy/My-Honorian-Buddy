# COR Verification System - Dynamic Keywords

## Overview
This system allows administrators to manage COR (Certificate of Registration) verification keywords dynamically through the Filament admin panel. Keywords are no longer hard-coded and can be updated each academic year.

## Features
✅ Dynamic keyword management via Filament admin panel
✅ Automatic expiration of outdated settings
✅ Multiple academic year configurations
✅ RESTful API for Python integration
✅ Real-time keyword loading from database
✅ Support for additional custom keywords

## System Components

### 1. Database (cor_settings table)
Stores all COR verification configurations:
- `university_name`: University name to verify
- `cor_title`: COR document title
- `campus_name`: Campus location
- `academic_year`: Academic year (e.g., AY 2025-2026)
- `valid_from`: Start date
- `valid_until`: End date
- `is_active`: Active status (only one can be active)
- `additional_keywords`: Extra keywords (JSON array)

### 2. Laravel Components
- **Model**: `App\Models\CorSetting`
- **Controller**: `App\Http\Controllers\CorVerificationController`
- **Filament Resource**: `App\Filament\Resources\CorSettingResource`
- **API Endpoints**:
  - `GET /api/cor/keywords` - Get active keywords
  - `POST /api/cor/verify` - Verify COR through API

### 3. Python Script
Location: `python/cor_verify/cor_verification.py`
- Fetches keywords from Laravel API
- Verifies PDF against dynamic keywords
- Shows detailed verification results

## Admin Panel Usage

### Accessing COR Settings
1. Login to Filament admin panel
2. Navigate to **System Settings** → **COR Verification Settings**
3. You'll see a list of all configurations with their status

### Creating New Configuration
1. Click **New COR Setting**
2. Fill in the form:
   - **University Name**: e.g., "PAMPANGA STATE AGRICULTURAL UNIVERSITY"
   - **COR Title**: Usually "Certificate of Registration"
   - **Campus Name**: e.g., "Magalang Campus"
   - **Academic Year**: e.g., "AY 2025-2026"
   - **Valid From**: Start date (e.g., August 1, 2025)
   - **Valid Until**: End date (e.g., July 31, 2026)
   - **Active**: Toggle to activate (will deactivate others)
   - **Additional Keywords**: Optional extra keywords

3. Click **Create**

### Updating for New Academic Year
**Before the new academic year starts:**
1. Go to **COR Verification Settings**
2. Click **New COR Setting**
3. Enter new academic year details (AY 2026-2027)
4. Set **Valid From** to the start of new academic year
5. Set **Valid Until** to the end of academic year
6. Enable **Active** toggle
7. Save

**The old configuration will automatically deactivate!**

### Managing Multiple Configurations
- View all configurations (active and inactive)
- Filter by:
  - Active status
  - Currently valid period
  - Deleted items
- Actions available:
  - View details
  - Edit existing configuration
  - Delete configuration
  - Set as active
  - Restore deleted items

## Python Script Usage

### Basic Usage
```bash
python python/cor_verify/cor_verification.py "path/to/cor.pdf" "FirstName" "LastName"
```

### Example
```bash
python python/cor_verify/cor_verification.py "C:/Users/Student/Downloads/cor.pdf" "Juan" "Dela Cruz"
```

### What Happens:
1. Script connects to Laravel API
2. Fetches active COR settings from database
3. Loads required keywords dynamically
4. Verifies PDF against those keywords
5. Checks if student name is in PDF
6. Returns detailed verification result

### Sample Output
```
============================================================
COR VERIFICATION SYSTEM
============================================================

🔄 Step 1: Loading verification keywords from database...
✓ Loaded 7 keywords from database
✓ Academic Year: AY 2025-2026
✓ Valid Until: 2026-07-31

🔄 Step 2: Verifying COR document...
📋 Keywords to check: PAMPANGA STATE AGRICULTURAL UNIVERSITY, Certificate of Registration, Student No, Magalang Campus, AY 2025-2026, First Semester, Regular Student

📄 Verifying COR for: Juan Dela Cruz
📂 PDF Path: C:/Users/Student/Downloads/cor.pdf
✅ COR is valid - All keywords found

============================================================
VERIFICATION RESULT:
============================================================
COR is valid.
============================================================
```

## API Endpoints

### Get Active Keywords
**Endpoint**: `GET /api/cor/keywords`

**Response (Success)**:
```json
{
  "success": true,
  "keywords": [
    "PAMPANGA STATE AGRICULTURAL UNIVERSITY",
    "Certificate of Registration",
    "Student No",
    "Magalang Campus",
    "AY 2025-2026",
    "First Semester",
    "Regular Student"
  ],
  "academic_year": "AY 2025-2026",
  "valid_until": "2026-07-31"
}
```

**Response (No Active Settings)**:
```json
{
  "success": false,
  "message": "No active COR verification settings found",
  "keywords": []
}
```

**Response (Expired Settings)**:
```json
{
  "success": false,
  "message": "COR verification settings have expired",
  "keywords": []
}
```

## Workflow Example

### Scenario: Transitioning to New Academic Year

**Current State (June 2026)**:
- Active: AY 2025-2026 (valid until July 31, 2026)
- All COR verifications use these keywords

**Actions Needed (July 2026)**:
1. Admin logs into Filament
2. Creates new COR setting for AY 2026-2027
3. Sets dates: Aug 1, 2026 to July 31, 2027
4. Activates new setting
5. Old setting automatically deactivates

**Result**:
- After August 1, 2026: All verifications use AY 2026-2027 keywords
- Old keywords no longer used
- System automatically handles the transition

## Troubleshooting

### Python Script Errors

**"Cannot connect to Laravel API"**
- Solution: Make sure Laravel server is running (`php artisan serve`)
- Check API_BASE_URL in cor_verification.py matches your server

**"No active COR verification settings found"**
- Solution: Admin must create and activate a COR setting in Filament

**"COR verification settings have expired"**
- Solution: Admin must update the valid dates or create new setting for current academic year

### Admin Panel Issues

**Cannot see COR Settings menu**
- Solution: Check if you have admin privileges
- Verify Filament is properly installed

**Multiple active settings**
- Solution: System allows only one active setting at a time
- When you activate a setting, others auto-deactivate

## Database Schema

```sql
CREATE TABLE cor_settings (
    id BIGINT PRIMARY KEY,
    university_name VARCHAR(255),
    cor_title VARCHAR(255) DEFAULT 'Certificate of Registration',
    campus_name VARCHAR(255),
    academic_year VARCHAR(255),
    valid_from DATE,
    valid_until DATE,
    is_active BOOLEAN DEFAULT true,
    additional_keywords TEXT,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    deleted_at TIMESTAMP
);
```

## Security Notes

- Only authenticated admins can modify COR settings
- Soft deletes preserve historical data
- API endpoints can be protected with middleware if needed
- Python script validates API responses before processing

## Best Practices

1. **Create new settings in advance**: Set up next year's configuration before the academic year starts
2. **Use consistent naming**: Follow standard formats (e.g., "AY YYYY-YYYY")
3. **Test before activating**: Create as inactive first, test, then activate
4. **Keep history**: Don't force delete old settings - they're useful for auditing
5. **Monitor expiration**: Check validity periods regularly

## Migration from Hard-coded Keywords

The old hard-coded system:
```python
REQUIRED_KEYWORDS = ['Don Honorio Ventura State University',
                    'Certificate of Registration',
                    'Student No', 
                    'Bacolor Campus', 
                    'AY 2025-2026']
```

New dynamic system:
- Keywords loaded from database
- Admin manages through GUI
- Automatic expiration
- No code changes needed for updates

## Support

For issues or questions:
1. Check this README
2. Review Filament admin panel
3. Check Laravel logs: `storage/logs/laravel.log`
4. Check Python output for detailed error messages
