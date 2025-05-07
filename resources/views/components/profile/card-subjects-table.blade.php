@php
    $user = Auth::user();
@endphp

<div class="flex mt-8 mb-8">
    <div class="w-full bg-gray-300 rounded-[20px] shadow-custom-button shadow-black border-black border-2">
        <div class="relative rounded-[20px] px-6">

            <!-- Card Tittle-->
            <div class="flex flex-col mt-8 text-left">
                <span class="font-bold text-4xl m-5 leading-relaxed">Subjects</span> 
            </div>

            <!-- Card Content-->
            <div class="flex justify-center">
                <table class="border-separate bg-white border border-black px-2 py-2 mb-8 w-1/2">
                    <thead class="text-lg text-gray-700 uppercase bg-gray-400 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th class="border border-black text-center px-4 py-2">Subject Name</th>
                        <th class="border border-black text-center px-4 py-2">Subject Code</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(Auth::user()->role == 'Student')
                        @foreach($user->student->subject_student as $subject)
                        <tr>
                            <td class="border border-black text-center px-4 py-2">{{$subject->subj_name}}</td>
                            <td class="border border-black text-center px-4 py-2">{{$subject->subj_code}}</td>
                        </tr>
                        @endforeach
                    @elseif(Auth::user()->role == 'Tutor')
                        @foreach($user->tutor->subject_tutor as $subject)
                        <tr>
                            <td class="border border-black text-center px-4 py-2">{{$subject->subj_name}}</td>
                            <td class="border border-black text-center px-4 py-2">{{$subject->subj_code}}</td>
                        </tr>
                        @endforeach
                    @endif

                    </tbody>
                </table>

            </div>

            <!-- Button-->
            <div class="flex justify-end m-8">
                <x-primary-button type="submit" class=" bg-accent text-black ">Save</x-primary-button>
            </div>
        </div>
    </div>
</div>