{{-- temp blade file for testing --}}

@php
    use App\Models\Student;
    $students = Student::all();


@endphp

<!DOCTYPE html>
<html>
<head>
    <title>Matches</title>
</head>
<body>
    <h1>Matched Tutors</h1>

    @foreach ($students as $student)
        @if ($student['user_id'] === Auth::user()->id)
            <p>Authenticated User: {{ $student->fname }} {{ $student->lname }}</p>
            @foreach ($student->subject_student as $subjects)    
                @if ($student['user_id'] === Auth::user()->id)
                    <p>Student Subject: {{$subjects ? $subjects->subj_code : 'No Code'}}</p>
                @endif
            @endforeach
        @endif
    @endforeach

    <pre>{{var_dump($matches)}}</pre>
    <pre>{{var_dump($tutors)}}</pre>

    @if (!empty($matches) && !empty($tutors))
    <ul>
        @foreach ($matches as $match)          
            @foreach ($tutors as $tutor)
                {{-- Check if $tutor is an array or object before proceeding --}}
                @if (is_array($tutor) || is_object($tutor))
                    @if (is_object($tutor))
                        <li>
                            {{ $tutor->fname }} {{ $tutor->lname }}<br>
                            Rate: ₱{{ $tutor->rate_session ?? 'N/A' }}<br>
                            Experience: {{ $tutor->exp ?? 'N/A' }} years<br>
                            Rating: {{ $tutor->rating ?? 'N/A' }} stars<br><br>
                        </li>
                    @elseif (is_array($tutor))
                        <li>
                            {{ $tutor['fname'] ?? 'N/A' }} {{ $tutor['lname'] ?? 'N/A' }}<br>
                            Rate: ₱{{ $tutor['rate_session'] ?? 'N/A' }}<br>
                            Experience: {{ $tutor['exp'] ?? 'N/A' }} years<br>
                            Rating: {{ $tutor['rating'] ?? 'N/A' }} stars<br><br>
                        </li>
                    @endif
                @else
                    {{-- Handle unexpected string or other types --}}
                    <li>
                        Unexpected data format for tutor: {{ $tutor }}<br>
                    </li>
                @endif
            @endforeach
        @endforeach
    </ul>
@else
    <p>No matches or tutors found.</p>
@endif
</body>
</html>