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



<section class="h-auto" data-aos="fade-up" data-aos-anchor-placement="top-bottom">
        <div class="bg-accent h-full overflow-hidden rounded-md pb-2 mb-4 border-black border-2">
            <div class="font-dela text-xl text-charcoal font-black p-3 max-md:text-lg">
                @if (Auth::user()->role === 'Student')
                    YOUR BUDDY
                @else
                    YOUR STUDENT
                @endif
            </div>
            <span class="flex mx-4 items-center">
                <span class="h-px flex-1 bg-charcoal"></span>
            </span>

            <!-- content -->
            <div class="grid grid-cols-2 items-center p-4 gap-4 max-md:grid-cols-1 max-md:p-3">
                <!-- profile image -->
                <div class="flex justify-center">
                    <img src="{{ $profile_pic ?? Auth::user()->profile_pic }}" alt="Profile"
                        class="h-40 w-40 border-4 border-black rounded-lg max-md:h-28 max-md:w-28">
                </div>
                <!-- profile infos -->
                <div class="max-md:text-center">
                    <p class="font-bold ml-5 text-primary text-[16px] max-md:ml-0 max-md:text-sm">Firstname</p>
                    <p class="font-bold ml-5 text-[18px] -mt-1 max-md:ml-0 max-md:text-base">{{ $fname ?? 'N/A' }}</p>
                    <p class="font-bold ml-5 text-primary text-[16px] max-md:ml-0 max-md:text-sm">Lastname</p>
                    <p class="font-bold ml-5 text-[18px] -mt-1 max-md:ml-0 max-md:text-base">{{ $lname ?? 'N/A' }}</p>

                </div>

            </div>
            <div class="flex justify-center">
                @if ($user->role === 'Student')
                    <x-drop :tutor_id="$tutor_id" />
                @endif


            </div>
        </div>
    </section>
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
