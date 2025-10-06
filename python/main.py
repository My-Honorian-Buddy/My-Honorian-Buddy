# main.py
import sys
import logging
import json
from data_loader import create_db_connection, fetch_tutors, fetch_students
from data_preprocessor import preprocess_tutors, preprocess_students
from matcher import match_tutors  # file is named matcher.py

# Set up logging
logging.basicConfig(
    filename='debug.log',  # Log file for storing errors
    level=logging.INFO,    # Log info-level messages for better debugging
    format='%(asctime)s - %(levelname)s - %(message)s'
)

# Wrapper function for handling database operations with refreshed connections
def with_db_connection(operation, *args, **kwargs):

    try:
        connection = create_db_connection()
        if connection is None:
            raise ValueError("Failed to establish a database connection.")
        
        result = operation(connection, *args, **kwargs)
        connection.close()
        return result
    except Exception as e:
        logging.error(f"Error during database operation: {e}", exc_info=True)
        if 'connection' in locals() and connection:
            try:
                connection.close()
            except Exception as close_error:
                logging.warning(f"Error closing the database connection: {close_error}")
        raise

def main():
    try:
        # Get the auth_id passed as an argument
        try:
            if len(sys.argv) < 2:
                raise ValueError("Missing auth_id argument")
            
            auth_id = int(sys.argv[1])
            
            
            logging.info(f"Received auth_id: {auth_id}")
        except ValueError as ve:
            raise ValueError(f"Invalid or missing auth_id argument: {ve}")

        # Step 1: Connect to the database
        try:
            connection = create_db_connection()
            if connection is None:
                raise ValueError("Failed to establish a database connection.")
        except Exception as e:
            raise RuntimeError(f"Error connecting to the database: {e}")

        # Step 2: Load tutors and students data
        try:
            tutors = with_db_connection(fetch_tutors)
            students = with_db_connection(fetch_students)
        except Exception as e:
            raise RuntimeError(f"Error fetching data from the database: {e}")

        # Step 3: Preprocess data
        try:
            tutors = preprocess_tutors(tutors, connection)
            students = preprocess_students(students, connection)
        except Exception as e:
            raise RuntimeError(f"Error preprocessing data: {e}")

        # Step 4: Run matchmaking algorithm
        try:
            matches = match_tutors(tutors, students, auth_id)
            # Ensure we always return a valid response even if no matches found
            if not matches:
                matches = {"message": "No tutors found matching your criteria", "matches": []}
            else:
                matches = {"message": "Matches found successfully", "matches": matches}
        except Exception as e:
            raise RuntimeError(f"Error running the matchmaking algorithm: {e}")    

        # Step 5: Output matches in JSON format
        try:
            # Ensure the output is always valid JSON
            output = json.dumps(matches, indent=2, ensure_ascii=False)
            print(output)
        except Exception as e:
            # If JSON serialization fails, return a proper error response
            error_response = {"error": f"Error converting matches to JSON: {str(e)}", "matches": []}
            print(json.dumps(error_response))
            raise RuntimeError(f"Error converting matches to JSON: {e}")

        # Step 6: Close the database connection
        try:
            connection.close()
        except Exception as e:
            logging.warning(f"Error closing the database connection: {e}")

    except Exception as e:
        # Log any unexpected errors
        logging.error(f"Error occurred: {e}", exc_info=True)
        sys.exit(json.dumps({"error": str(e)}))


if __name__ == "__main__":
    main()

