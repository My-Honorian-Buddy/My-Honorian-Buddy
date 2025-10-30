@php
    $user = Auth::user();
@endphp

<div class="flex mt-8 mb-8">
    <div class="w-full bg-accent rounded-md shadow-black border-black border-4">
        <div class="relative rounded-[20px] px-8">

            <!-- Card Content -->
            <div class="flex flex-col my-8 text-left">
                <span class="font-dela font-bold text-4xl mx-5 my-3 leading-relaxed">
                    @if ($user->role === 'Student')
                        Subject Improvement:
                </span>
                <span class="flex mx-4 mb-4 items-center">
                    <span class="h-px flex-1 bg-charcoal"></span>
                </span>
                @foreach ($user->student->subject_student as $subject)
                    <span class="font-poppins font-bold text-2xl ml-5">{{ $subject->subj_code }}</span>
                    <span class="font-semibold italic text-primary text-1xl mb-5 ml-5">{{ $subject->subj_name }}</span>
                @endforeach
            @else
                Subject Expertise:
                </span>
                <span class="flex mx-4 mb-4 items-center">
                    <span class="h-px flex-1 bg-charcoal"></span>
                </span>
                @foreach ($user->tutor->subject_tutor as $subject)
                    <span class="font-poppins font-bold text-2xl ml-5">{{ $subject->subj_code }}</span>
                    <span class="font-semibold italic text-primary text-1xl mb-5 ml-5">{{ $subject->subj_name }}</span>
                @endforeach
                @endif

            </div>
        </div>
    </div>
</div>
