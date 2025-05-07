# Subject Code to Name Mapping
subject_code_to_name = {
        "CSS 113" : "Computer System Servicing",
        "CC 113 (A)" : "Introduction to Computing",
        "CC 113(B)" : "Fundamentals of Programming",
        # FIRST YR - 2ND SEM
        "CS 123" : "Discrete Structures",
        "CC 123 (C)" : "Intermediate Programming (Advanced C++)",
        "CSS 123" : "Networking Fundamentals",

        #SECOND YR - 1ST SEM
        "CC 213 (D)": "Data Structure",
        "CC 213 (E)" : "Information Management (DBMS)",
        "CPC 213" : "Object Oriented Programming (JAVA)",

        # SECOND YR - 2ND SEM
        "MOBDEV 223" : "Mobile Application Development",
        "CPC 223(A)" : "Database Programming",
        "CSDA 223" : "Design Analysis and Algorithms",
        "SAD 223" : "Software Analysis and Design",
        "CPC 223(B)" : "Web Application Development",

        # THIRD YR - 1ST SEM
        "CSAC 313" : "Algorithms and Complexity",
        "CSPL 313" : "Programming Languages",
        "CSIAS 313" : "Information Assurance and Security",
        "CSOS 313" : "Operating Systems",
        "CSSE1 313" : "Software Engineering 1",
        "CSWEBSYS 313" : "Web Systems and Technologies",
}

def preprocess_tutors(tutors, connection):
    for tutor in tutors:
        cursor = connection.cursor()
        cursor.execute("SELECT subj_code FROM tutor_Subjects WHERE tutor_id = %s", (tutor['user_id'],))
        rows = cursor.fetchall()

        # Convert subject codes into subject names using the subject_code_to_name mapping
        tutor['subjects'] = [subject_code_to_name.get(row[0], "Unknown Subject") for row in rows]  # Default to "Unknown Subject" if not found
    return tutors

def preprocess_students(students, connection):
    for student in students:
        # Fetch the subjects the student is interested in from the student_subject table
        cursor = connection.cursor()
        cursor.execute("SELECT subj_code FROM student_Subjects WHERE student_id = %s", (student['user_id'],))
        rows = cursor.fetchall()

        # Convert subject codes into subject names using the subject_code_to_name mapping
        student['subjects'] = [subject_code_to_name.get(row[0], "Unknown Subject") for row in rows]  # Default to "Unknown Subject" if not found

    return students