def calculate_match_score(tutor_subjects, student_subjects, tutor_days, student_days):
    # Calculate the number of overlapping subjects
    matched_subjects = set(tutor_subjects).intersection(set(student_subjects))
    subject_score = len(matched_subjects) 

    # Calculate the number of overlapping days (like yung mga days matched)
    matchched_days = set(tutor_days).intersection(set(student_days))
    schedule_score = len(matchched_days)

    # Total score
    total_score = subject_score + schedule_score
    
    return total_score, matched_subjects, matchched_days  # Return both the score and the matched subjects and matched days

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
    student_days = auth_user.get('days_week', [])

    matches = []

    print(f"Student: {auth_id}, Subjects: {student_subjects}, Days: {student_days}")
    for tutor in tutors:
        tutor_subjects = tutor.get('subjects', [])
        tutor_days = tutor.get('days_week', [])

        match_score, matched_subjects, matched_days = calculate_match_score(tutor_subjects, student_subjects, tutor_days, student_days)

        if match_score >= min_match_score:
            matches.append({
                'tutor_id': tutor['user_id'],
                'match_score': match_score,
                'matched_subjects': list(matched_subjects),
                'matched_days': list(matched_days),
            })

    matches.sort(key=lambda x: x['match_score'], reverse=True)  # Prioritize high scores
    
    logging.info(f"Matches: {matches}")
    return matches
