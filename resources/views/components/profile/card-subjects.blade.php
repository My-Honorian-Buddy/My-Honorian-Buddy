@php
    $user = Auth::user();
@endphp

<div class="flex" style="margin-top: 2rem; margin-bottom: 2rem; @media (max-width: 768px) { margin-top: 0.5rem; margin-bottom: 0.5rem; }">
    <div class="w-full bg-accent rounded-md shadow-black" style="border: 4px solid black; @media (max-width: 768px) { border: 2px solid black; }">
        <div class="relative rounded-[20px]" style="padding: 2rem; @media (max-width: 768px) { padding: 0.75rem; }">

            <!-- Card Content -->
            <div style="display: flex; flex-direction: column; text-align: left; @media (max-width: 768px) { margin: 0.75rem 0; }">
                <span class="truncate" style="font-family: 'Dela Gothic One'; font-weight: bold; font-size: 2.25rem; margin: 1.25rem; line-height: 1.5; @media (max-width: 768px) { font-size: 1.5rem; margin: 0.25rem; }">
                    @if ($user->role === 'Student')
                        Subject Improvement:
                @else
                        Subject Expertise:
                @endif
                </span>
                <span style="display: flex; margin: 1rem; margin-bottom: 1rem; align-items: center; @media (max-width: 768px) { margin: 0.25rem; margin-bottom: 0.25rem; }">
                    <span style="height: 1px; flex: 1; background-color: #1A1A1A;"></span>
                </span>
                @if ($user->role === 'Student')
                    @foreach ($user->student->subject_student as $subject)
                        <span style="font-weight: bold; font-size: 1.5rem; margin-left: 1.25rem; @media (max-width: 768px) { font-size: 1.125rem; margin-left: 0.25rem; }">{{ $subject->subj_code }}</span>
                        <span style="font-weight: 600; font-style: italic; color: #550000; font-size: 1rem; margin-bottom: 1.25rem; margin-left: 1.25rem; @media (max-width: 768px) { font-size: 0.75rem; margin-bottom: 0.25rem; margin-left: 0.25rem; }">{{ $subject->subj_name }}</span>
                    @endforeach
                @else
                    @foreach ($user->tutor->subject_tutor as $subject)
                        <span style="font-weight: bold; font-size: 1.5rem; margin-left: 1.25rem; @media (max-width: 768px) { font-size: 1.125rem; margin-left: 0.25rem; }">{{ $subject->subj_code }}</span>
                        <span style="font-weight: 600; font-style: italic; color: #550000; font-size: 1rem; margin-bottom: 1.25rem; margin-left: 1.25rem; @media (max-width: 768px) { font-size: 0.75rem; margin-bottom: 0.25rem; margin-left: 0.25rem; }">{{ $subject->subj_name }}</span>
                    @endforeach
                @endif

            </div>
        </div>
    </div>
</div>
