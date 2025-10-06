<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Subject;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subjects = [
            // FIRST YR - 1ST SEM
            ['subj_code' => 'CSS 113', 'subj_name' => 'Computer System Servicing'],
            ['subj_code' => 'CC 113 (A)', 'subj_name' => 'Introduction to Computing'],
            ['subj_code' => 'CC 113 (B)', 'subj_name' => 'Fundamentals of Programming'],
            
            // FIRST YR - 2ND SEM
            ['subj_code' => 'CS 123', 'subj_name' => 'Discrete Structures'],
            ['subj_code' => 'CC 123 (C)', 'subj_name' => 'Intermediate Programming (Advanced C++)'],
            ['subj_code' => 'CSS 123', 'subj_name' => 'Networking Fundamentals'],

            // SECOND YR - 1ST SEM
            ['subj_code' => 'CC 213 (D)', 'subj_name' => 'Data Structure'],
            ['subj_code' => 'CC 213 (E)', 'subj_name' => 'Information Management (DBMS)'],
            ['subj_code' => 'CPC 213', 'subj_name' => 'Object Oriented Programming (JAVA)'],

            // SECOND YR - 2ND SEM
            ['subj_code' => 'MOBDEV 223', 'subj_name' => 'Mobile Application Development'],
            ['subj_code' => 'CPC 223 (A)', 'subj_name' => 'Database Programming'],
            ['subj_code' => 'CSDA 223', 'subj_name' => 'Design Analysis and Algorithms'],
            ['subj_code' => 'SAD 223', 'subj_name' => 'Software Analysis and Design'],
            ['subj_code' => 'CPC 223 (B)', 'subj_name' => 'Web Application Development'],

            // THIRD YR - 1ST SEM
            ['subj_code' => 'CSAC 313', 'subj_name' => 'Algorithms and Complexity'],
            ['subj_code' => 'CSPL 313', 'subj_name' => 'Programming Languages'],
            ['subj_code' => 'CSIAS 313', 'subj_name' => 'Information Assurance and Security'],
            ['subj_code' => 'CSOS 313', 'subj_name' => 'Operating Systems'],
            ['subj_code' => 'CSSE1 313', 'subj_name' => 'Software Engineering 1'],
            ['subj_code' => 'CSWEBSYS 313', 'subj_name' => 'Web Systems and Technologies'],
        ];

        foreach ($subjects as $subject) {
            Subject::updateOrCreate(
                ['subj_code' => $subject['subj_code']],
                ['subj_name' => $subject['subj_name']]
            );
        }
    }
}
