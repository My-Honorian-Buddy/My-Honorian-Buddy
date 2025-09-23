import PyPDF2
import sys

# list of required keywords na nasa official COR
REQUIRED_KEYWORDS = ['Don Honorio Ventura State University', # to be changed to PAMSU
                    'Certificate of Registration',
                    'Student No', 
                    'DHVSU - Bacolor Campus', 
                    'AY 2024-2025'] # to be change ang AY

print("TEST RUN TEST RUN TEST RUN") #debug print lang
print("TEST RUN TEST RUN TEST RUN") #debug print lang
print("TEST RUN TEST RUN TEST RUN") #debug print lang

def verify_cor(pdf_path, fname, lname):
    try:
        with open(pdf_path, 'rb') as file:
            reader = PyPDF2.PdfReader(file)
            text = ''
            for page in reader.pages:
                page_text = page.extract_text()
                if page_text:
                    text += page_text

        text = text.lower() # pang convert to lowercase just in case

        missing_keywords = [kw for kw in REQUIRED_KEYWORDS if kw.lower() not in text]
        
        # check if name exists and matches in COR
        if fname.lower() not in text or lname.lower() not in text:
            missing_keywords.append(f"Name ({fname} {lname})")

        if not missing_keywords:
            return "✅ COR is valid."
        else:
            return f"❌ COR is invalid. Missing: {', '.join(missing_keywords)}"

    except Exception as e:
        return f"❌ Error processing COR: {str(e)}"

if __name__ == "__main__":
    if len(sys.argv) == 4:
        pdf_path = sys.argv[1]
        fname = sys.argv[2]
        lname = sys.argv[3]
        result = verify_cor(pdf_path, fname, lname)
        print(result) # output
    else:
        print("error: Missing arguments. Usage: cor_verification.py <pdf_path> <fname> <lname>")