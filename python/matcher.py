def calculate_match_score(tutor_subjects, student_subjects):
    # Calculate the number of overlapping subjects
    match = set(tutor_subjects).intersection(set(student_subjects))
    match_score = len(match)  # The score is the number of matched subjects
    
    return match_score, match  # Return both the score and the matched subjects

# def match_tutors(tutors, students, auth_id):
#     matches = []
    
#     auth_user = next((student for student in students if student['user_id'] == auth_id), None)

#     if auth_user:
#         studentSubject = auth_user['subjects']

#         for tutor in tutors:
#             print(f"Tutor: {tutor}")
#             tutorSubject = tutor['subjects']
#             match_score, matched_subjects = calculate_match_score(tutorSubject, studentSubject)
            
#             # Only add tutors with a non-zero match score
#             if match_score > 0:
#                 matches.append({
#                     'tutor_id': tutor['user_id'],
#                     'matched_subjects': matched_subjects,
#                 })
#             print(f"Match Score: {match_score}\n")
#     return matches

def match_tutors(tutors, students, auth_id, min_match_score=1):
    import logging
    logging.basicConfig(level=logging.INFO)

    auth_user = next((student for student in students if student['user_id'] == auth_id), None)

  
    if not auth_user:
        raise ValueError(f"No student found with user_id {auth_id}")

    student_subjects = auth_user.get('subjects', [])
    matches = []

    print(f"Student: {auth_id}, Subjects: {student_subjects}")
    for tutor in tutors:
        tutor_subjects = tutor.get('subjects', [])
        match_score, matched_subjects = calculate_match_score(tutor_subjects, student_subjects)

        if match_score >= min_match_score:
            matches.append({
                'tutor_id': tutor['user_id'],
                'match_score': match_score,
            })

        matches.sort(key=lambda x: x['match_score'], reverse=True)  # Prioritize high scores
    logging.info(f"Matches: {matches}")
    return matches
