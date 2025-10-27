<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Tutor;
use App\Models\Student;
use App\Models\bookedSession;
use App\Models\Review;
use App\Models\tutorSubject;
use Illuminate\Support\Facades\Hash;

class BookedSessionDummySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Tutor User
        $tutorUser = User::create([
            'name' => 'John Smith',
            'email' => 'tutor.john@example.com',
            'password' => Hash::make('password123'),
            'role' => 'tutor',
            'mode' => 'tutor',
            'email_verified_at' => now(),
        ]);

        // Create Tutor Profile
        $tutor = Tutor::create([
            'user_id' => $tutorUser->id,
            'fname' => 'John',
            'lname' => 'Smith',
            'gender' => 'Male',
            'address' => '123 University Avenue, Manila',
            'college' => 'College Of Computing Studies',
            'year_level' => '4th Year',
            'department' => 'Bachelor of Science in Computer Science',
            'bio' => 'Experienced tutor specializing in programming and data structures. Passionate about helping students succeed.',
            'points' => 150,
        ]);

        // Create Student User 1
        $studentUser1 = User::create([
            'name' => 'Maria Garcia',
            'email' => 'student.maria@example.com',
            'password' => Hash::make('password123'),
            'role' => 'student',
            'mode' => 'student',
            'email_verified_at' => now(),
        ]);

        // Create Student Profile 1
        $student1 = Student::create([
            'user_id' => $studentUser1->id,
            'fname' => 'Maria',
            'lname' => 'Garcia',
            'gender' => 'Female',
            'address' => '456 College Street, Quezon City',
            'college' => 'College Of Computing Studies',
            'year_level' => '2nd Year',
            'department' => 'Bachelor of Science in Computer Science',
            'bio' => 'Hardworking student eager to learn programming.',
        ]);

        // Create Student User 2
        $studentUser2 = User::create([
            'name' => 'James Rodriguez',
            'email' => 'student.james@example.com',
            'password' => Hash::make('password123'),
            'role' => 'student',
            'mode' => 'student',
            'email_verified_at' => now(),
        ]);

        // Create Student Profile 2
        $student2 = Student::create([
            'user_id' => $studentUser2->id,
            'fname' => 'James',
            'lname' => 'Rodriguez',
            'gender' => 'Male',
            'address' => '789 Campus Road, Manila',
            'college' => 'College Of Computing Studies',
            'year_level' => '1st Year',
            'department' => 'Bachelor of Science in Information Technology',
            'bio' => 'New student looking for help in programming basics.',
        ]);

        // Create Booked Sessions
        
        // Session 1 - Completed with Review
        $session1 = bookedSession::create([
            'student_id' => $studentUser1->id,
            'tutor_id' => $tutorUser->id,
            'tutoring_subject' => json_encode(['Data Structures and Algorithms']),
            'schedule_time' => now()->subDays(5)->setTime(14, 0),
            'duration' => 90,
            'status' => 'completed',
            'is_completed' => true,
            'num_session' => 1,
            'total_session' => 3,
            'room' => 'Online - Google Meet',
            'feedback' => 'Great session! The tutor explained tree traversal very clearly.',
            'reviewed' => true,
            'accept' => 1,
            'sesUpdate' => now()->subDays(5),
        ]);

        // Create Review for Session 1
        Review::create([
            'student_id' => $studentUser1->id,
            'tutor_id' => $tutorUser->id,
            'rating' => 5,
            'comment' => 'Excellent tutor! Very patient and knowledgeable. Highly recommend!',
        ]);

        // Session 2 - Pending (upcoming)
        bookedSession::create([
            'student_id' => $studentUser1->id,
            'tutor_id' => $tutorUser->id,
            'tutoring_subject' => json_encode(['Data Structures and Algorithms']),
            'schedule_time' => now()->addHours(2),
            'duration' => 90,
            'status' => 'pending',
            'is_completed' => false,
            'num_session' => 2,
            'total_session' => 3,
            'room' => 'Online - Google Meet',
            'feedback' => null,
            'reviewed' => false,
            'accept' => 1,
            'sesUpdate' => now(),
        ]);

        // Session 3 - Pending (Future)
        bookedSession::create([
            'student_id' => $studentUser2->id,
            'tutor_id' => $tutorUser->id,
            'tutoring_subject' => json_encode(['Introduction to Programming (Java)']),
            'schedule_time' => now()->addDays(2)->setTime(10, 0),
            'duration' => 60,
            'status' => 'pending',
            'is_completed' => false,
            'num_session' => 1,
            'total_session' => 1,
            'room' => 'Room 301, CS Building',
            'feedback' => null,
            'reviewed' => false,
            'accept' => 1,
            'sesUpdate' => now(),
        ]);

        // Session 4 - Pending
        bookedSession::create([
            'student_id' => $studentUser2->id,
            'tutor_id' => $tutorUser->id,
            'tutoring_subject' => json_encode(['Database Management Systems']),
            'schedule_time' => now()->addDays(3)->setTime(15, 30),
            'duration' => 120,
            'status' => 'pending',
            'is_completed' => false,
            'num_session' => 1,
            'total_session' => 2,
            'room' => 'Online - Zoom',
            'feedback' => null,
            'reviewed' => false,
            'accept' => 0,
            'sesUpdate' => now(),
        ]);

        // Session 5 - Completed with Review
        $session5 = bookedSession::create([
            'student_id' => $studentUser2->id,
            'tutor_id' => $tutorUser->id,
            'tutoring_subject' => json_encode(['Web Development Basics']),
            'schedule_time' => now()->subDays(10)->setTime(16, 0),
            'duration' => 75,
            'status' => 'completed',
            'is_completed' => true,
            'num_session' => 1,
            'total_session' => 1,
            'room' => 'Online - Google Meet',
            'feedback' => 'Learned a lot about HTML and CSS. Very helpful session!',
            'reviewed' => true,
            'accept' => 1,
            'sesUpdate' => now()->subDays(10),
        ]);

        // Create Review for Session 5
        Review::create([
            'student_id' => $studentUser2->id,
            'tutor_id' => $tutorUser->id,
            'rating' => 4,
            'comment' => 'Very good tutor. Explained concepts well, would book again.',
        ]);

        // Session 6 - Cancelled
        bookedSession::create([
            'student_id' => $studentUser1->id,
            'tutor_id' => $tutorUser->id,
            'tutoring_subject' => json_encode(['Mobile App Development']),
            'schedule_time' => now()->subDays(2)->setTime(13, 0),
            'duration' => 60,
            'status' => 'cancelled',
            'is_completed' => false,
            'num_session' => 1,
            'total_session' => 1,
            'room' => 'Room 205, CS Building',
            'feedback' => 'Student had to cancel due to emergency.',
            'reviewed' => false,
            'accept' => 0,
            'sesUpdate' => now()->subDays(2),
        ]);

        $this->command->info('✅ Dummy data created successfully!');
        $this->command->info('');
        $this->command->info('📧 Tutor Login: tutor.john@example.com / password123');
        $this->command->info('📧 Student 1 Login: student.maria@example.com / password123');
        $this->command->info('📧 Student 2 Login: student.james@example.com / password123');
        $this->command->info('');
        $this->command->info('📊 Created 6 booked sessions with different statuses:');
        $this->command->info('   - 2 Completed (with reviews)');
        $this->command->info('   - 3 Pending');
        $this->command->info('   - 1 Cancelled');
    }
}

