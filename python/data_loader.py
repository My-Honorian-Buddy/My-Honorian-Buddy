import mysql.connector
import logging
from mysql.connector import Error
import os
from pathlib import Path

def load_env():
    """Load environment variables from .env file"""
    env_path = Path(__file__).resolve().parent.parent / '.env'
    env_vars = {}
    
    if env_path.exists():
        with open(env_path, 'r') as f:
            for line in f:
                line = line.strip()
                if line and not line.startswith('#') and '=' in line:
                    key, value = line.split('=', 1)
                    # Remove quotes if present
                    value = value.strip().strip('"').strip("'")
                    env_vars[key] = value
    
    return env_vars

def create_db_connection():
    env = load_env()
    
    # Validate required environment variables
    required_vars = ['DB_HOST', 'DB_USERNAME', 'DB_PASSWORD', 'DB_DATABASE']
    missing_vars = [var for var in required_vars if var not in env or not env[var]]
    
    if missing_vars:
        raise ValueError(f"Missing required environment variables in .env: {', '.join(missing_vars)}")
    
    try:
        connection = mysql.connector.connect(
            host=env['DB_HOST'],
            user=env['DB_USERNAME'],
            password=env['DB_PASSWORD'],
            database=env['DB_DATABASE']
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