# Function to get subject name from database
def get_subject_name(connection, subj_code):
    cursor = connection.cursor()
    cursor.execute("SELECT subj_name FROM subjects WHERE subj_code = %s", (subj_code,))
    result = cursor.fetchone()
    return result[0] if result else "Unknown Subject"

# Function to get all subjects mapping from database (for caching)
def get_all_subjects_mapping(connection):
    cursor = connection.cursor()
    cursor.execute("SELECT subj_code, subj_name FROM subjects")
    rows = cursor.fetchall()
    return {row[0]: row[1] for row in rows}

def preprocess_tutors(tutors, connection):
    # Get all subjects mapping for efficient lookup
    subject_mapping = get_all_subjects_mapping(connection)
    
    for tutor in tutors:
        cursor = connection.cursor()
        cursor.execute("SELECT subj_code FROM tutor_Subjects WHERE tutor_id = %s", (tutor['user_id'],))
        rows = cursor.fetchall()

        # Convert subject codes into subject names using the database mapping
        tutor['subjects'] = [subject_mapping.get(row[0], "Unknown Subject") for row in rows]  # Default to "Unknown Subject" if not found
    return tutors

def preprocess_students(students, connection):
    # Get all subjects mapping for efficient lookup
    subject_mapping = get_all_subjects_mapping(connection)
    
    for student in students:
        # Fetch the subjects the student is interested in from the student_subject table
        cursor = connection.cursor()
        cursor.execute("SELECT subj_code FROM student_Subjects WHERE student_id = %s", (student['user_id'],))
        rows = cursor.fetchall()

        # Convert subject codes into subject names using the database mapping
        student['subjects'] = [subject_mapping.get(row[0], "Unknown Subject") for row in rows]  # Default to "Unknown Subject" if not found

    return students