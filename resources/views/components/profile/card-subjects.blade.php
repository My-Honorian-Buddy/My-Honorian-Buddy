@php
    $user = Auth::user();
@endphp

<div class="flex mt-8 mb-8">
    <div class="w-full bg-gray-300 rounded-[20px] shadow-custom-button shadow-black border-black border-2">
        <div class="relative rounded-[20px] px-6">

            <!-- Card Content -->
            <div class="flex flex-col mt-8 text-left">
                <span class="font-bold text-4xl m-5 leading-relaxed">
                    @if ($user -> role === 'Student')
                        Subject Improvement:
                    </span>
                    @foreach ($user->student->subject_student as $subject)
                        <span class="font-semibold text-2xl ml-5">{{$subject->subj_code}}</span>
                        <span class="font-semibold text-red-900 text-1xl mb-5 ml-5">{{$subject->subj_name}}</span>
                    @endforeach
                    @else
                        Subject Expertise:
                    </span>
                        @foreach ($user->tutor->subject_tutor as $subject)
                            <span class="font-semibold text-2xl ml-5">{{$subject->subj_code}}</span>
                            <span class="font-semibold text-red-900 text-1xl mb-5 ml-5">{{$subject->subj_name}}</span>
                        @endforeach
                    @endif

            </div>
        </div>
    </div>
</div>