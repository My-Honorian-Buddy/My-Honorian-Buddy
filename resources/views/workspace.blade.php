@php
    use App\Models\bookedSession;
    use App\Models\Tutor;
    use App\Models\Review;
    use App\Models\User;

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
            $otherUser = User::find($otherUserId);
            $otherUsertemp = $otherUser->tutor->fname;
        } else {
            $otherUserId = $bookedId->student_id;
            $otherUser = User::find($otherUserId);
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
                <li class="w-full">
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
            <li class="w-full flex justify-center items-center">
                <a class="group w-full relative inline-block focus:ring-3 focus:outline-hidden"
                    href="{{ route('video.join.meet') }}">
                    <span
                        class="absolute w-full inset-0 translate-x-0 translate-y-0 bg-primary transition-transform group-hover:translate-x-1.5 group-hover:translate-y-1.5">
                    </span>

                    <span
                        class="relative text-accent font-poppins w-full text-center inline-block border-2 border-charcoal px-8 py-3 text-sm font-bold tracking-widest uppercase">
                        <x-bladewind.icon name="video-camera" class="justify-self-start" />
                        Join a new call
                    </span>
                </a>
            </li>

            <li class="w-full flex justify-center items-center">
                <a class="group w-full relative inline-block focus:ring-3 focus:outline-hidden"
                    href="{{ route('video.call.create') }}">
                    <span
                        class="absolute w-full inset-0 translate-x-0 translate-y-0 bg-primary transition-transform group-hover:translate-x-1.5 group-hover:translate-y-1.5">
                    </span>

                    <span
                        class="relative text-accent font-poppins w-full text-center inline-block border-2 border-charcoal px-8 py-3 text-sm font-bold tracking-widest uppercase">
                        <x-bladewind.icon name="video-camera" class="justify-self-start" />
                        Create a new call
                    </span>
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
                                <div
                                    class="w-full h-auto bg-accent overflow-hidden rounded-md pb-2 border-black border-2">
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

            // Toast notification function
            function showToast(message, type = 'info') {
                const toast = document.createElement('div');
                toast.className = 'fixed top-4 right-4 z-[9999] px-6 py-4 rounded-lg shadow-lg transform transition-all duration-300 ease-in-out max-w-md';
                
                // Set colors based on type
                const colors = {
                    'success': 'bg-green-500 text-white',
                    'error': 'bg-red-500 text-white',
                    'warning': 'bg-amber-500 text-white',
                    'info': 'bg-blue-500 text-white'
                };
                
                toast.className += ' ' + (colors[type] || colors['info']);
                
                // Add icon based on type
                const icons = {
                    'success': '✅',
                    'error': '❌',
                    'warning': '⚠️',
                    'info': 'ℹ️'
                };
                
                toast.innerHTML = `
                    <div class="flex items-center gap-3">
                        <span class="text-2xl">${icons[type] || icons['info']}</span>
                        <span class="font-medium">${message}</span>
                        <button onclick="this.parentElement.parentElement.remove()" class="ml-2 text-white hover:text-gray-200">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </div>
                `;
                
                document.body.appendChild(toast);
                
                // Animate in
                setTimeout(() => toast.style.opacity = '1', 10);
                
                // Auto remove after 5 seconds
                setTimeout(() => {
                    toast.style.opacity = '0';
                    setTimeout(() => toast.remove(), 300);
                }, 5000);
            }

            // Display session flash messages as toasts
            @if (session('success'))
                console.log('✅ SUCCESS:', '{{ session('success') }}');
                showToast('{{ session('success') }}', 'success');
            @endif

            @if (session('error'))
                console.error('❌ ERROR:', '{{ session('error') }}');
                showToast('{{ session('error') }}', 'error');
            @endif

            @if (session('cannotComplete'))
                console.warn('⚠️ CANNOT COMPLETE SESSION:', '{{ session('cannotComplete') }}');
                showToast('{{ session('cannotComplete') }}', 'warning');
            @endif

            @if (session('info'))
                console.info('ℹ️ INFO:', '{{ session('info') }}');
                showToast('{{ session('info') }}', 'info');
            @endif

            @if (session('dropRequest'))
                console.log('📤 DROP REQUEST:', '{{ session('dropRequest') }}');
                showToast('{{ session('dropRequest') }}', 'success');
            @endif

            @if (session('dropSuccess'))
                console.log('✅ DROP SUCCESS:', '{{ session('dropSuccess') }}');
                showToast('{{ session('dropSuccess') }}', 'success');
            @endif
        </script>
    </x-slot>
</x-workspace-layout>
