@php
    use App\Models\bookedSession;
    use App\Models\Tutor;
    use App\Models\Review;

    $bookedId = bookedSession::where('tutor_id', Auth::user()->id)
        ->orWhere('student_id', Auth::user()->id)
        ->first();
    $sessionId = $bookedId ? $bookedId->id : null;
    $authUser = Auth::user();

@endphp
<x-workspace-layout>
    {{-- sidebar --}}
    <x-slot name="sidebar_content">
        <ul class="flex flex-col items-center justify-center space-y-6">
            <li class="w-4/5">
                <a href="{{ route('video.join.meet') }}">
                    <div
                        class="flex items-center justify-between bg-accent2 text-primary text-right font-poppins font-bold md:w-full rounded-full px-8 py-1 md:h-11 text-m
                    border-2 border-black shadow-custom-button hover:bg-primary hover:text-accent2 cursor-pointer md:text-center">
                        <x-bladewind.icon name="video-camera" class="justify-self-start" />
                        JOIN A NEW CALL
                    </div>
                </a>
            </li>
            <li class="w-4/5">
                <a href="{{ route('video.call.create') }}">
                    <div
                        class="flex items-center justify-between bg-accent2 text-primary text-right font-poppins font-bold md:w-full rounded-full px-8 py-1 md:h-11 text-m border-2 border-black 
                    shadow-custom-button hover:bg-primary hover:text-accent2 cursor-pointer md:text-center">
                        <x-bladewind.icon name="plus" class="justify-self-start" />
                        CREATE A NEW CALL
                    </div>
                </a>
            </li>

        </ul>

    </x-slot>

    {{-- main content --}}
    <x-slot name="main_content">
        <div class="m-8">

            @if (Auth::check())
                @php
                    $user = Auth::user();
                    $firstName = '';

                    if ($user->role === 'Student' && $user->student) {
                        $firstName = $user->Student->fname;
                    } elseif ($user->role === 'Tutor' && $user->tutor) {
                        $firstName = $user->Tutor->fname;
                    }
                @endphp
            @endif
            <div data-aos="fade-up" data-aos-anchor-placement="top-bottom"
                class="text-5xl sm:text-1xl text-accent2 text-stroke-thick2 stroke-black font-black mb-5 m-8 ">
                Welcome, {{ $firstName ?: 'User' }}!
            </div>
            <div>
                {{-- ROW 1 --}}
                <div>
                    <x-daily-progress :subjects="$subjects" :user="$user" :student="$student" :tutor="$tutor" />
                </div>

                {{-- ROW 2 --}}
                <div class="flex gap-x-6">
                    <x-current-session :subjects="$subjects" :user="$user" :tutor="$tutor" :student="$student" />
                    <x-yoursubjects :pickedSubjects="$pickedSubjects" :user="$user" />
                </div>

                <div class="flex flex-row">
                    <div class="w-[70%] lg:w-[70%] mt-8 mr-8 ">
                        {{-- calendar | schedule --}}
                        <section data-aos="fade-up" data-aos-anchor-placement="top-bottom" class="w-full">
                            <x-creating-calendar />
                        </section>

                        {{-- upcoming task --}}
                        <section data-aos="fade-up" data-aos-anchor-placement="top-bottom" class="">
                            <x-upcoming-task />
                        </section>
                    </div>
                    <div class="flex max-h-[1060px] flex-col gap-y-6 justify-evenly w-[30%] lg:w-[30%] mt-8">
                        <section class="">
                            <x-card-gotomyprofile />
                        </section>

                        @php
                            // Determine the role and check if the user has a booked session
                            $role = Auth::user()->role;
                            $isStudent = $role === 'Student';
                            $isTutor = $role === 'Tutor';
                            $hasbooked = false;

                            if ($isStudent) {
                                // Check if the authenticated user (Student) has booked sessions
                                $hasbooked =
                                    Auth::user()->student &&
                                    Auth::user()
                                        ->student->bookedSessions()
                                        ->where('student_id', Auth::user()->id)
                                        ->exists();
                            } elseif ($isTutor) {
                                // Check if the authenticated user (Tutor) has booked sessions
                                $hasbooked =
                                    Auth::user()->tutor &&
                                    Auth::user()
                                        ->tutor->bookedSessions()
                                        ->where('tutor_id', Auth::user()->id)
                                        ->exists();
                            }
                        @endphp

                        @if ($hasbooked)
                            <section class="w-full h-full">
                                @if ($isStudent)
                                    {{-- Student card --}}
                                    <x-card-yourstudent :tutor="$tutor" :allUsers="$allUsers" :student="$student"
                                        :user="$user" />
                                @elseif($isTutor)
                                    {{-- Tutor card --}}
                                    <x-card-yourstudent :tutor="$tutor" :allUsers="$allUsers" :student="$student"
                                        :user="$user" />
                                @endif
                            </section>
                        @else
                            <section>
                                <section class="w-full h-full max-h-[322px]" data-aos="fade-up"
                                    data-aos-anchor-placement="top-bottom">
                                    <div
                                        class="bg-accent3 rounded-[20px] pb-2 mb-4 shadow-custom-button shadow-black border-black border-2">
                                        <div
                                            class="bg-accent2 rounded-t-[20px] text-2xl text-primary text-stroke font-black p-3 border-b-2 border-black">
                                            {{ $isStudent ? 'YOU HAVE NO BUDDY' : 'YOU HAVE NO STUDENT' }}
                                        </div>
                                        <div class="border-black p-4"></div>
                                        <!-- content -->
                                        <div class="flex flex-col gap-y-4 justify-center items-center px-4">

                                            <img src="{{ asset('images/snowman.svg') }}">
                                            <div class="flex flex-col text-lg text-center  text-primary ">
                                                @if (Auth::user()->role === 'Student')
                                                    <span class="text-2xl text-black font-black ">No Tutors Booked
                                                        Yet!</span>
                                                    <span class="leading-6 pt-2"><em>"The tutor's desk is
                                                            clear—someone's about to have a very free
                                                            schedule!"</em></span>
                                                @else
                                                    <span class="text-2xl text-black font-black ">No Students Booked You
                                                        Yet!</span>
                                                    <span class="leading-6 pt-2"><em>"Looks like the student seats are
                                                            still empty—time to spread the word!"</em></span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="border-black p-4"></div>
                                    </div>
                                </section>
                            </section>
                        @endif


                        @if (Auth::user()->role === 'Tutor')
                            <section class="flex align-center h-full w-full " data-aos="fade-up"
                                data-aos-anchor-placement="top-bottom">
                                <!-- container -->
                                <div
                                    class="w-full max-h-[390px] bg-accent3 overflow-hidden rounded-[20px] pb-2 mb-4 shadow-custom-button shadow-black border-black border-2">
                                    <div
                                        class="bg-accent2 text-2xl text-primary text-stroke font-black p-3 border-b-2 border-black">
                                        YOUR REWARDS
                                    </div>

                                    <div class="border-black p-2"></div>
                                    <!-- content -->
                                    <div class="grid grid-cols-2 items-center p-4">
                                        <!-- profile image -->
                                        <div class="flex flex-col items-center justify-center">
                                            <x-bladewind::icon name="trophy" type="outline"
                                                class="!h-32 !w-32 text-amber-500" />

                                        </div>
                                        <!-- profile infos -->

                                        <div>
                                            <p class="font-bold text-primary text-[22px]">Your Total Points:</p>
                                            <p class="font-bold text-[18px] -mt-1"> {{ Auth::user()->tutor->college }}
                                                points</p>

                                        </div>
                                    </div>
                                    <div class="flex flex-col justify-between items-center m-2 gap-2">
                                        <a href="{{ route('connect.student') }}">
                                            <button
                                                class="justify-center w-[80%] bg-accent2 text-primary text-center font-poppins font-bold rounded-full px-5 py-3
                                        h-10 text-[16px] border-2 border-black shadow-custom-button hover:bg-primary hover:text-accent2 flex items-center space-x-2">
                                                <span><a href="{{ route('rewards.myRedemptions') }}">My
                                                        REWARDS</a></span>
                                            </button>
                                        </a>
                                        <a href="{{ route('connect.student') }}">
                                            <button
                                                class="justify-center w-[80%] bg-accent2 text-primary text-center font-poppins font-bold rounded-full px-5 py-3 h-10 text-[16px] border-2 border-black shadow-custom-button hover:bg-primary hover:text-accent2 flex items-center space-x-2">
                                                <span><a href="{{ route('rewards.view') }}">SEE AVAILABLE
                                                        REWARDS</a></span>
                                            </button>
                                        </a>
                                    </div>
                                    <div class="border-black p-2"></div>
                                </div>
                            </section>
                        @else
                            <section class="flex align-center h-full w-full ">
                            </section>
                        @endif

                    </div>
                </div>

            </div>
        </div>
        @if ($authUser->cor_status !== 'verified')
            <div
                class="fixed bottom-6 right-6 bg-accent3 text-primary px-5 py-6 border-2 
            border-black rounded-[4px] shadow-custom-button z-[9999]">
                It appears that your COR has not been verified yet. <br>
                Please verify it
                <a class=" font-bold underline" href="{{ route('cor.view') }}">
                    here
                </a>
                .
            </div>
        @endif
        <script>
            document.addEventListener('DOMContentLoaded', function() {

                @if (session('NoRoom'))
                    showNotification('{{ session('NoRoom') }}', 'Create a room', 'error');
                @endif

                @if (session('noSession'))
                    showNotification('{{ session('noSession') }}', 'booked a tutoring session first', 'error');
                @endif

                @if (session('MeetEnded'))
                    showNotification('{{ session('MeetEnded') }}', 'Meeting ended', 'success');
                @endif


            });
        </script>
    </x-slot>
</x-workspace-layout>
