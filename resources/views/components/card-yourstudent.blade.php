@php
    use App\Models\bookedSession;

    $bookedSessions = bookedSession::where('student_id', Auth::id())
        ->orWhere('tutor_id', Auth::user()->id)
        ->first();

    if (!$bookedSessions) {
        return redirect()->back()->with('error', 'No sessions found.');
    }

    $tutor_id = $bookedSessions->tutor_id;

    $role = Auth::user()->role;

    $hasBookedSessions = false;
    $userID = Auth::user()->id;

    if ($role === 'Student') {
        $student = Auth::user()->student;

        if ($student) {
            $hasBookedSessions = Auth::user()->student->bookedsessions()->exists() ?? false;
            $session = $student->bookedsessions;

            if ($session) {
                foreach ($tutor as $tutors) {
                    if ($tutors->user_id === $session->tutor_id) {
                        $fname = $tutors->fname;
                        $lname = $tutors->lname;
                        foreach ($allUsers as $allUser) {
                            if ($allUser->id === $tutors->user_id) {
                                $profile_pic = $allUser->profile_pic;
                            }
                        }
                    }
                }
            }
        }
    } elseif ($role === 'Tutor') {
        $tutor = Auth::user()->tutor;

        if ($tutor) {
            $hasBookedSessions = Auth::user()->tutor->bookedsessions()->exists() ?? false;
            $session = $tutor->bookedsessions;

            if ($session) {
                foreach ($student as $students) {
                    if ($students->user_id === $session->student_id) {
                        $fname = $students->fname;
                        $lname = $students->lname;
                        foreach ($allUsers as $allUser) {
                            if ($allUser->id === $students->user_id) {
                                $profile_pic = $allUser->profile_pic;
                            }
                        }
                    }
                }
            }
        }
    } else {
        $hasBookedSessions = false;
        $session = null;
    }
@endphp

@if ($hasBookedSessions)
    <section class="h-full max-h-[322px]" data-aos="fade-up" data-aos-anchor-placement="top-bottom">
        <!-- container -->

        <div class="bg-accent3 h-full overflow-hidden rounded-[20px] pb-2 mb-4 shadow-custom-button shadow-black border-black border-2">
            <div
                class="bg-accent2 text-2xl text-primary text-stroke font-black p-3 border-b-2 border-black">
                @if (Auth::user()->role === 'Student')
                    YOUR BUDDY
                @else
                    YOUR STUDENT
                @endif
            </div>

            <!-- content -->
            <div class="grid grid-cols-2 items-center p-4">
                <!-- profile image -->
                <div class="flex justify-center">
                    <img src="{{ $profile_pic }}" alt="Profile" class="h-32 w-32 lg:h-40 lg:w-40 border-4 border-black rounded-lg">
                </div>
                <!-- profile infos -->
                <div>
                    <p class="font-bold ml-5 text-primary text-[16px]">Firstname</p>
                    <p class="font-bold ml-5 text-[18px] -mt-1">{{ $fname }}</p>
                    <p class="font-bold ml-5 text-primary text-[16px]">Lastname</p>
                    <p class="font-bold ml-5 text-[18px] -mt-1">{{ $lname }}</p>

                </div>

            </div>
            <div class="flex justify-center">
                <!-- @if ($user->role === 'Student')
<a href="{{ route('connect.tutor') }}">
                    <button class="bg-accent2 text-primary text-center font-poppins font-bold rounded-full px-5 py-3 ml-2 h-10 text-[12px] border-2 border-black shadow-custom-button hover:bg-[#FFECEC] hover:text-[#8B3A3A] flex items-center space-x-2">
                        <span>VISIT PROFILE</span>
                    </button>
                </a>
                        review and feedback
                <x-drop :tutor_id="$tutor_id"/>
@elseif ($user->role === 'Tutor')
<a href="{{ route('connect.student') }}">
                    <button class="bg-accent2 text-primary text-center font-poppins font-bold rounded-full px-8 py-1 h-11 text-l border-2 border-black 
            shadow-custom-button hover:bg-primary hover:text-accent2 flex items-center space-x-2">
                        <span>VISIT PROFILE</span>
                    </button>
                </a>
@endif -->
            </div>
        </div>
    </section>
@else
    <section class="m-4 mt-8 mr-8 max-w-s" data-aos="fade-up" data-aos-anchor-placement="top-bottom">
        <div class="bg-[#D9D9D9] overflow-hidden rounded-[20px] pb-2 mb-4 shadow-custom-button shadow-black border-black border-2">
            <div class=" text-2xl text-primary text-stroke font-black p-3 border-b-2 border-black">
                @if (Auth::user()->role === 'Student')
                    YOU HAVE NO BUDDYs
                @else
                    YOU HAVE NO STUDENT
                @endif
            </div>
            <div class="border-black p-4"></div>
            <!-- content -->
            <div class="flex flex-col gap-y-4 justify-center items-center px-4">

                <img src="{{ asset('images/snowman.svg') }}">
                <div class="flex flex-col text-lg text-center  text-primary ">
                    @if (Auth::user()->role === 'Student')
                        <span class="text-2xl text-black font-black ">No Tutors Booked Yet!</span>
                        <span class="leading-6 pt-2"><em>"The tutor's desk is clear—someone’s about to have a very free
                                schedule!"</em></span>
                    @else
                        <span class="text-2xl text-black font-black ">No Students Booked You Yet!</span>
                        <span class="leading-6 pt-2"><em>"Looks like the student seats are still empty—time to spread
                                the word!"</em></span>
                    @endif
                </div>
            </div>
            <div class="border-black p-4"></div>
        </div>

    </section>
@endif

<script>
    document.addEventListener('DOMContentLoaded', function() {

        @if (session('reviewedAlready'))
            showNotification('{{ session('reviewedAlready') }}', 'Cannot review this tutor twice.', 'error');
        @endif

        @if (session('notBooked'))
            showNotification('{{ session('notBooked') }}', 'Please book a session first.', 'error');
        @endif

        @if (session('notCreated'))
            showNotification('{{ session('notCreated') }}', 'Creating a review failed.', 'error');
        @endif

        @if (session('noTutor'))
            showNotification('{{ session('noTutor') }}', 'You have no tutor.', 'error');
        @endif

        @if (session('noAvg'))
            showNotification('{{ session('noAvg') }}', 'Cannot calculate average.', 'error');
        @endif

        @if (session('errorOccur'))
            showNotification('{{ session('errorOccur') }}', 'An error occurred.', 'error');
        @endif

    });
</script>
