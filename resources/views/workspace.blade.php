@php
    use App\Models\bookedSession;
    use App\Models\Tutor;
    use App\Models\Review;

    $bookedId = bookedSession::where('tutor_id', Auth::user()->id)
        ->orWhere('student_id', Auth::user()->id)
        ->first();
    $sessionId = $bookedId ? $bookedId->id : null;
    $authUser = Auth::user();

    // Get the other user in the session for video call
    $otherUserId = null;
    $otherUserName = 'User';
    $otherUsertemp = '';

    if ($bookedId) {
        if ($bookedId->student_id == Auth::id()) {
            $otherUserId = $bookedId->tutor_id;
            $otherUser = \App\Models\User::find($otherUserId);
            $otherUsertemp = $otherUser->tutor->fname;
        } else {
            $otherUserId = $bookedId->student_id;
            $otherUser = \App\Models\User::find($otherUserId);
            $otherUsertemp = $otherUser->student->fname;
        }
        if ($otherUser) {
            $otherUserName = $otherUsertemp;
        }
    }

@endphp
<x-workspace-layout>
    {{-- sidebar --}}
    <x-slot name="sidebar_content">
        <ul class="flex flex-col items-center justify-center space-y-6">
            @if ($otherUserId)
                <li class="w-4/5">
                    <div onclick="initiateVideoCall({{ $otherUserId }})" class="cursor-pointer">
                        <div
                            class="flex items-center justify-between bg-green-500 text-white text-right font-poppins font-bold md:w-full rounded-full px-8 py-1 md:h-11 text-m
                    border-2 border-black shadow-custom-button hover:bg-green-600 cursor-pointer md:text-center">
                            <x-bladewind.icon name="phone" class="justify-self-start" />
                            CALL {{ strtoupper(explode(' ', $otherUserName)[0]) }}
                        </div>
                    </div>
                </li>
            @endif
            <li class="w-4/5">
                <a href="{{ route('video.join.meet') }}">
                    <div
                        class="flex items-center justify-between bg-primary text-accent text-right font-poppins font-bold md:w-full rounded-full px-8 py-1 md:h-11 text-m
                    border-2 border-charcoal hover:bg-primary/70 cursor-pointer md:text-center">
                        <x-bladewind.icon name="video-camera" class="justify-self-start" />
                        JOIN A NEW CALL
                    </div>
                </a>
            </li>
            <li class="w-4/5">
                <a href="{{ route('video.call.create') }}">
                    <div
                        class="flex items-center justify-between bg-primary text-accent text-right font-poppins font-bold md:w-full rounded-full px-8 py-1 md:h-11 text-m 
                        border-2 border-charcoal hover:bg-primary/70 cursor-pointer md:text-center">
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
                class="text-3xl md:text-5xl font-dela text-charcoal font-black mb-5 m-8 max-md:text-2xl max-md:mx-4 max-md:mb-3">
                Welcome, {{ $firstName ?: 'User' }}!
            </div>
            <div>
                {{-- ROW 1 --}}
                <div class="my-8">
                    <x-daily-progress :subjects="$subjects" :user="$user" :student="$student" :tutor="$tutor" />
                </div>

                {{-- ROW 2 --}}
                <div class="flex my-8 gap-x-6 max-lg:flex-col max-lg:gap-y-4">
                    <x-current-session :subjects="$subjects" :user="$user" :tutor="$tutor" :student="$student" />
                    <x-yoursubjects :pickedSubjects="$pickedSubjects" :user="$user" />
                </div>

                <div class="flex my-8 max-lg:flex-col max-lg:gap-4">
                    <div class="w-[70%] mr-8 max-lg:w-full max-lg:mr-0 max-lg:mt-6">
                        {{-- calendar | schedule --}}
                        <section  class="w-full">
                            <x-creating-calendar />
                        </section>

                        {{-- upcoming task --}}
                        <section data-aos="fade-up" data-aos-anchor-placement="top-bottom" class="">
                            <x-upcoming-task />
                        </section>
                    </div>
                    <div
                        class="flex flex-col gap-y-8 justify-start w-[30%] max-lg:w-full max-lg:mt-6 max-lg:gap-y-4">
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
                            <section class="w-full h-auto" data-aos="fade-up" data-aos-anchor-placement="top-bottom">
                                <div
                                    class="flex flex-col bg-accent rounded-md pb-2 shadow-black border-black border-2 h-auto">
                                    <div class="font-dela text-lg text-charcoal font-black p-3 max-md:text-base">
                                        {{ $isStudent ? 'YOU HAVE NO BUDDY' : 'YOU HAVE NO STUDENT' }}
                                    </div>
                                    <span class="flex mx-4 items-center">
                                        <span class="h-px flex-1 bg-charcoal"></span>
                                    </span>
                                    <!-- content -->
                                    <div class="flex flex-col gap-y-4 justify-center items-center p-6 max-md:p-4">
                                        <img src="{{ asset('images/snowman.svg') }}"
                                            class="w-32 h-32 max-md:w-24 max-md:h-24">
                                        <div
                                            class="flex flex-col text-lg text-center text-primary px-2 max-md:text-base">
                                            @if (Auth::user()->role === 'Student')
                                                <span class="text-2xl text-black font-black max-md:text-xl">No Tutors
                                                    Booked Yet!</span>
                                                <span class="leading-6 pt-2"><em>"The tutor's desk is clear—someone's
                                                        about to have a very free
                                                        schedule!"</em></span>
                                            @else
                                                <span class="text-2xl text-black font-black max-md:text-xl">No Students
                                                    Booked You Yet!</span>
                                                <span class="leading-6 pt-2"><em>"Looks like the student seats are still
                                                        empty—time to spread
                                                        the word!"</em></span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </section>
                        @endif


                        @if (Auth::user()->role === 'Tutor')
                            <section class="flex align-center h-auto w-full " data-aos="fade-up"
                                data-aos-anchor-placement="top-bottom">
                                <!-- container -->
                                <div class="w-full h-auto bg-accent overflow-hidden rounded-md pb-2 border-black border-2">
                                    <div class="font-dela text-xl text-charcoal font-black p-3 max-md:text-lg">
                                        YOUR TOTAL POINTS
                                    </div>
                                    <span class="flex mx-4 items-center">
                                        <span class="h-px flex-1 bg-charcoal"></span>
                                    </span>

                                    <!-- content -->
                                    <div class="grid grid-cols-2 items-center p-4 gap-4 max-md:grid-cols-1 max-md:p-3">
                                        <div class="flex flex-col items-center justify-center">
                                            <x-bladewind::icon name="trophy" type="outline"
                                                class="!h-32 !w-32 text-primary max-md:!h-24 max-md:!w-24" />

                                        </div>
                                        <div class="max-md:text-center">
                                            <p class="font-dela font-bold text-3xl -mt-1 max-md:text-2xl">
                                                {{ Auth::user()->tutor->points }} points</p>
                                        </div>

                                    </div>
                                    <div class="flex flex-col justify-between items-center m-2 gap-2">
                                        <a href="{{ route('connect.student') }}">
                                            <button
                                                class="justify-center w-[80%] bg-primary text-accent text-center font-poppins font-bold rounded-full px-5 py-3
                                        h-10 text-[16px] border-2 border-charcoal hover:bg-primary/80 flex items-center space-x-2">
                                                <span><a href="{{ route('rewards.myRedemptions') }}">
                                                    My Rewards</a></span>
                                            </button>
                                        </a>
                                        <a href="{{ route('connect.student') }}">
                                            <button
                                                class="justify-center w-[80%] bg-primary text-accent text-center font-poppins font-bold rounded-full 
                                                px-5 py-3 h-10 text-[16px] border-2 border-charcoal hover:bg-primary/80 flex items-center space-x-2">
                                                <span><a href="{{ route('rewards.view') }}">
                                                    See Available Rewards
                                                </a></span>
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


            window.initiateVideoCall = function(receiverId) {

                const callingSound = new Audio('/sounds/ringtone-incoming.mp3');
                callingSound.loop = true;


                const playPromise = callingSound.play();
                if (playPromise !== undefined) {
                    playPromise.catch(e => console.log('Sound play failed:', e));
                }

                fetch('/video-call/initiate', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({
                            receiver_id: receiverId
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            console.log('Call initiated to:', data.receiver_name);
                            console.log('Room:', data.room_name);
                            console.log('Call ID:', data.call_id);

                            // Show waiting for response popup instead of redirecting
                            if (typeof window.showWaitingForCall === 'function') {
                                window.showWaitingForCall(data.receiver_name, data.call_id, data.room_name);
                            }
                            
                            // Store call info for later including receiver ID
                            window.currentOutgoingCall = {
                                callId: data.call_id,
                                roomName: data.room_name,
                                receiverName: data.receiver_name,
                                receiverId: receiverId,
                                callingSound: callingSound
                            };
                        } else {
                            callingSound.pause();
                            callingSound.currentTime = 0;
                            alert('Error: ' + (data.message || 'Failed to initiate call'));
                        }
                    })
                    .catch(error => {
                        callingSound.pause();
                        callingSound.currentTime = 0;
                        console.error('Call initiation error:', error);
                        alert('Error: Failed to initiate call');
                    });
            };
        </script>
    </x-slot>
</x-workspace-layout>
