import mysql.connector
import logging
from mysql.connector import Error

def create_db_connection():
    try:
        connection = mysql.connector.connect(
            host="localhost",
            user="root",      # Replace with your MySQL username
            password="12345678",  # Replace with your MySQL password
            database="final_project"    # Replace with your database name
        )
        if connection.is_connected():
            logging.info("Connected to MySQL database")
        return connection
    except Error as e:
        print("Error connecting to MySQL:", e)
        return None

def fetch_tutors(connection):
    cursor = connection.cursor()
    cursor.execute("SELECT * FROM Tutors")
    rows = cursor.fetchall()
    
    tutors = []
    for row in rows:
        tutor = {
            'user_id': row[1],
            'name': f"{row[1]} {row[2]}",  # Assuming first_name and last_name are columns 1 and 2
            'exp': row[4],  # Assuming experience is column 4
            'subjects': fetch_tutor_subjects(connection, row[0])  # Get the subjects for this tutor
        } 
        tutors.append(tutor)
    
    return tutors

def fetch_tutor_subjects(connection, tutor_id):
    cursor = connection.cursor()
    cursor.execute("SELECT subj_name FROM tutor_Subjects WHERE tutor_id = %s", (tutor_id,))
    rows = cursor.fetchall()
    
    subjects = [row[0] for row in rows]
    return subjects

def fetch_students(connection):
    cursor = connection.cursor()
    cursor.execute("SELECT * FROM Students")
    rows = cursor.fetchall()
    
    students = []
    for row in rows:
        student = {
            'user_id': row[1],  # Assuming the first column is the student's ID
            'name': f"{row[1]} {row[2]}",  # Assuming the name columns are first_name (1) and last_name (2)
            'year_level': row[3],  # Assuming year_level is column 3
            'department': row[4],  # Assuming department is column 4
        }
        students.append(student)
    
    return students