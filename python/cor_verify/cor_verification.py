import PyPDF2
import sys
import os
import requests
import json

# API endpoint to get dynamic keywords
API_BASE_URL = "http://localhost:8000"  # Change this to your Laravel app URL
KEYWORDS_ENDPOINT = f"{API_BASE_URL}/api/cor/keywords"

def get_required_keywords():
    """
    Fetch required keywords from Laravel API
    Returns list of keywords or None if error
    """
    try:
        response = requests.get(KEYWORDS_ENDPOINT, timeout=10)
        
        if response.status_code == 200:
            data = response.json()
            if data.get('success'):
                keywords = data.get('keywords', [])
                print(f"Loaded {len(keywords)} keywords from database")
                print(f"Academic Year: {data.get('academic_year')}")
                print(f"Valid Until: {data.get('valid_until')}")
                return keywords
            else:
                print(f"API Error: {data.get('message')}")
                return None
        elif response.status_code == 404:
            print("No active COR verification settings found in admin panel")
            return None
        elif response.status_code == 410:
            print("COR verification settings have expired. Please update in admin panel.")
            return None
        else:
            print(f"HTTP Error {response.status_code}")
            return None
            
    except requests.exceptions.ConnectionError:
        print("Cannot connect to Laravel API. Make sure the server is running.")
        return None
    except requests.exceptions.Timeout:
        print("Request timeout. Server took too long to respond.")
        return None
    except Exception as e:
        print(f"Error fetching keywords: {str(e)}")
        return None

def verify_cor(pdf_path, fname, lname, required_keywords):
    """
    Verify COR PDF against required keywords
    
    Args:
        pdf_path: Path to PDF file
        fname: Student first name
        lname: Student last name
        required_keywords: List of keywords to check (from database)
    
    Returns:
        Verification result string
    """
    try:
        print(f"\nVerifying COR for: {fname} {lname}")
        print(f"PDF Path: {pdf_path}")
        
        # Read PDF
        with open(pdf_path, 'rb') as file:
            reader = PyPDF2.PdfReader(file)
            text = ''
            for page in reader.pages:
                page_text = page.extract_text()
                if page_text:
                    text += page_text

        text = text.lower()  # Convert to lowercase for case-insensitive matching

        # Check for missing keywords
        missing_keywords = [kw for kw in required_keywords if kw.lower() not in text]
        
        # Check if name exists and matches in COR
        if fname.lower() not in text or lname.lower() not in text:
            missing_keywords.append(f"Name ({fname} {lname})")

        # Return result
        if not missing_keywords:
            print("COR is valid - All keywords found")
            return "COR is valid."
        else:
            print(f"COR is invalid - Missing: {', '.join(missing_keywords)}")
            return f"COR is invalid. Missing: {', '.join(missing_keywords)}"

    except FileNotFoundError:
        error_msg = f"Error: PDF file not found at {pdf_path}"
        print(error_msg)
        return error_msg
    except Exception as e:
        error_msg = f"Error processing COR: {str(e)}"
        print(error_msg)
        return error_msg

if __name__ == "__main__":
    print("=" * 60)
    print("COR VERIFICATION SYSTEM")
    print("=" * 60)
    
    if len(sys.argv) < 4 or len(sys.argv) > 5:
        print("Error: Invalid arguments")
        print("\nUsage: python cor_verification.py <pdf_path> <fname> <lname> [keywords_json]")
        print("\nExample:")
        print('  python cor_verification.py "C:/path/to/cor.pdf" "Juan" "Dela Cruz"')
        print('  python cor_verification.py "C:/path/to/cor.pdf" "Juan" "Dela Cruz" \'["keyword1", "keyword2"]\'')
        sys.exit(1)
    
    pdf_path = sys.argv[1]
    fname = sys.argv[2]
    lname = sys.argv[3]
    
    # Check if keywords file path was passed as argument (4th parameter)
    if len(sys.argv) == 5:
        # Keywords provided via file by Laravel - no API call needed
        print("\nStep 1: Loading verification keywords from application...")
        keywords_file = sys.argv[4]
        try:
            if os.path.exists(keywords_file):
                with open(keywords_file, 'r') as f:
                    required_keywords = json.load(f)
                print(f"Loaded {len(required_keywords)} keywords from application")
            else:
                print(f"Error: Keywords file not found at {keywords_file}")
                sys.exit(1)
        except json.JSONDecodeError as e:
            print(f"Error parsing keywords file: {str(e)}")
            sys.exit(1)
        except Exception as e:
            print(f"Error reading keywords file: {str(e)}")
            sys.exit(1)
    else:
        # Fallback: Try to get keywords from API (for standalone testing)
        print("\nStep 1: Loading verification keywords from database...")
        required_keywords = get_required_keywords()
        
        if required_keywords is None:
            print("\nFATAL ERROR: Cannot proceed without active COR settings")
            print("Action Required: Admin must configure COR settings in Filament panel")
            sys.exit(1)
    
    if len(required_keywords) == 0:
        print("\nWARNING: No keywords configured for verification")
        print("Action Required: Admin should add keywords in COR settings")
    
    # Step 2: Verify COR
    print("\nStep 2: Verifying COR document...")
    print(f"Keywords to check: {', '.join(required_keywords)}")
    result = verify_cor(pdf_path, fname, lname, required_keywords)
    
    # Final output
    print("\n" + "=" * 60)
    print("VERIFICATION RESULT:")
    print("=" * 60)
    print(result)
    print("=" * 60)