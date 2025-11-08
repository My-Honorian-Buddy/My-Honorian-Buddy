@props(['subjects', 'user', 'tutor', 'student'])

@php
    $decodedSubject = json_decode($subjects, true);

    $role = Auth::user()->role;

    $hasBookedSessions = false;
    $userID = Auth::user()->id;
    $percentage = 0;

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
                    }
                }
            }
        }
    } else {
        $hasBookedSessions = false;
        $session = null;
    }
@endphp


<div
    class="w-full h-auto bg-accent rounded-md overflow-hidden shadow-charcoal border-charcoal border-2">
    <div class="flex bg-accent items-center w-full py-2">
        <div
            class="font-dela flex w-full justify-start text-xl text-charcoal font-black ml-8 max-md:ml-4 max-md:text-lg">
            Current Session
        </div>
    </div>
    <span class="flex mx-4 items-center">
        <span class="h-px flex-1 bg-charcoal"></span>
    </span>

    @if ($hasBookedSessions && !empty($decodedSubject))
        @if ($user && $user->role === 'Student')
            @foreach ($decodedSubject as $subject)
                <div
                    class="bg-accent flex items-center w-full border-b-2 border-charcoal py-2 max-md:flex-col max-md:items-start">
                    
                    <div class="grid grid-rows-3 px-8 mt-3 mb-2 ml-3 max-md:ml-4 max-md:mt-0 max-md:w-full">
                        <div>
                            <p class="font-poppins text-darkgray font-extrabold text-2xl max-md:text-lg">
                                {{ $subject }}
                            </p>
                        </div>
                        <div class="font-bold text-xl text-primary max-md:text-base">
                            <p>Tutor: {{ $fname }} {{ $lname }}</p>
                        </div>
                        <div class="font-semibold text-base text-charcoal max-md:text-sm">
                            <p>Sessions: {{ $session->num_session ?? 0 }} of {{ $session->total_session ?? 0 }}
                                completed</p>
                        </div>
                    </div>
                </div>
            @endforeach
        @elseif ($user && $user->role === 'Tutor')
            @foreach ($decodedSubject as $subject)
                <div
                    class="bg-accent flex items-center w-full border-b-2 border-charcoal py-2 max-md:flex-col max-md:items-start">
                    
                    <div class="grid grid-rows-3 px-8 mt-3 mb-2 ml-3 max-md:ml-4 max-md:mt-0 max-md:w-full">
                        <div>
                            <p class="font-poppins text-darkgray font-extrabold text-2xl max-md:text-lg">
                                {{ $subject }}
                            </p>
                        </div>
                        <div class="font-bold text-xl text-primary max-md:text-base">
                            <p>Student: {{ $fname }} {{ $lname }}</p>
                        </div>
                        <div class="font-semibold text-base text-charcoal max-md:text-sm">
                            <p>Sessions: {{ $session->num_session ?? 0 }} of {{ $session->total_session ?? 0 }}
                                completed</p>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif

        {{-- Complete Session and Drop Session Buttons --}}
        <div class="bg-accent flex items-center w-full border-b-0 border-black py-2">
            <div class="bg-accent my-4 flex items-center w-full h-full py-2">
                <div class="text-accent w-full px-4 max-md:px-2">
                    <div class="ml-5 max-md:ml-2 flex justify-end gap-4 max-md:flex-col">

                        {{-- Drop Session Button --}}
                        <x-bladewind::button type="button"
                            class="bg-red-900 !rounded-sm border border-charcoal hover:bg-red-700 text-white font-bold flex justify-items-center max-md:w-full max-md:justify-center"
                            size="small" rounded="true" onclick="showModal('confirm-drop')">
                            Drop Session
                        </x-bladewind::button>

                        @if (Auth::user()->role === 'Tutor')
                            {{-- Complete Session Button (Tutor Only) --}}
                            <x-bladewind::button type="button"
                                class="bg-green-900 !rounded-sm border border-charcoal hover:bg-green-700 text-accent font-bold flex justify-items-center max-md:w-full max-md:justify-center"
                                size="small" rounded="true"
                                onclick="console.log('📌 Opening Complete Session Modal'); showModal('confirm-complete')">
                                Complete Session
                            </x-bladewind::button>
                        @endif
                    </div>

                    @if (Auth::user()->role === 'Tutor')
                        {{-- Complete Session Modal (Tutor Only) --}}
                        <x-bladewind.modal-explore name="confirm-complete" size="large" title="Confirm Session Completion"
                            stretched_action_buttons="true" show_action_buttons="false"
                            cancel_button_action="hideModal('confirm-complete')" close_after_action="true"
                            backdrop_can_close="true">
                            
                                <p class="mx-4 !text-base mt-4">Are you sure you want to mark this session as complete?</p>
                                <p class="mx-4 mt-2 !text-sm text-gray-600">This will update the session progress.</p>
                                <br>

                                <div
                                    class="mt-4 flex justify-end space-x-4 max-md:flex-col max-md:space-x-0 max-md:space-y-2">
                                    <x-bladewind::button type="button"
                                        class="bg-accent text-charcoal !rounded-sm hover:bg-primary/5 border border-charcoal"
                                        size="small" can_submit="false" onclick="hideModal('confirm-complete')">
                                        Cancel
                                    </x-bladewind::button>

                                    <form action="{{ route('complete.session') }}" method="post" class="max-md:w-full"
                                        onsubmit="console.log('========== COMPLETE SESSION FORM SUBMITTED =========='); 
                                          console.log('Session ID:', '{{ $session->id ?? '' }}'); 
                                          console.log('Form Action:', this.action); 
                                          console.log('Form Method:', this.method); 
                                          return true;">
                                        @csrf
                                        <input type="hidden" name="session_id" value="{{ $session->id ?? '' }}">
                                        <x-bladewind::button type="submit"
                                            class="bg-green-900 !rounded-sm text-white hover:bg-green-700 mr-4 border border-charcoal max-md:mr-0 max-md:w-full"
                                            size="small" rounded="true" can_submit="true"
                                            onclick="console.log('✅ Complete button clicked. Session ID: {{ $session->id ?? 'NOT SET' }}');">
                                            Confirm Complete
                                        </x-bladewind::button>
                                    </form>
                                </div>
                            

                        </x-bladewind.modal-explore>
                    @endif

                    {{-- Drop Session Modal for Tutor --}}
                    @if (Auth::user()->role === 'Tutor')
                        <x-bladewind.modal-explore name="confirm-drop" type="warning" title="Request to Drop Session"
                            footer="false" size="large" show_action_buttons="false"
                            cancel_button_action="hideModal('confirm-drop')" backdrop_can_close="true">

                            <p class="mx-4 mt-4 text-amber-600 font-semibold">📬 A drop request will be sent to the
                                student for confirmation.</p>
                            <p class="mx-4 mt-2 text-gray-600">The session will only be dropped once the student accepts
                                your request.</p><br>

                            <div
                                class="mt-4 flex justify-end space-x-4 max-md:flex-col max-md:space-x-0 max-md:space-y-2">
                                <x-bladewind::button type="button"
                                    class="bg-accent text-charcoal !rounded-sm hover:bg-primary/5 border border-charcoal"
                                    stretched_action_buttons="false" size="small" rounded="true" align_buttons="right"
                                    can_submit="false" onclick="hideModal('confirm-drop')">
                                    Cancel
                                </x-bladewind::button>

                                <form action="{{ route('drop.session') }}" method="post" class="max-md:w-full"
                                    onsubmit="console.log('Drop session form submitted (Tutor)'); return true;">
                                    @csrf
                                    <input type="hidden" name="session_id" value="{{ $session->id ?? '' }}">
                                    <x-bladewind::button type="submit"
                                        class="bg-amber-900 !rounded-sm text-accent hover:bg-amber-700 mr-4 border border-charcoal max-md:mr-0 max-md:w-full"
                                        size="small" rounded="true" stretched_action_buttons="false"
                                        align_buttons="right" can_submit="true">
                                        Send Drop Request
                                    </x-bladewind::button>
                                </form>
                            </div>
                        </x-bladewind.modal-explore>

                        {{-- Drop Session Modal for Student --}}
                    @elseif (Auth::user()->role === 'Student')
                        <x-bladewind.modal-explore name="confirm-drop" type="warning" title="Request to Drop Session"
                            footer="false" size="big" show_action_buttons="false"
                            cancel_button_action="hideModal('confirm-drop')" backdrop_can_close="true">

                            <p class="mx-4 mt-4 text-amber-600 font-semibold">📬 A drop request will be sent to your
                                tutor for confirmation.</p>
                            <p class="mx-4 mt-2 text-gray-600">The session will only be dropped once your tutor accepts
                                your request.</p><br>

                            <div
                                class="mt-4 flex justify-end space-x-4 max-md:flex-col max-md:space-x-0 max-md:space-y-2">
                                <x-bladewind::button type="button"
                                    class="bg-accent text-charcoal !rounded-sm hover:bg-primary/5 border border-charcoal"
                                    stretched_action_buttons="false" size="small" rounded="true"
                                    align_buttons="right" can_submit="false" onclick="hideModal('confirm-drop')">
                                    Cancel
                                </x-bladewind::button>

                                <form action="{{ route('drop.session') }}" method="post" class="max-md:w-full"
                                    onsubmit="console.log('Drop session form submitted (Student)'); return true;">
                                    @csrf
                                    <input type="hidden" name="session_id" value="{{ $session->id ?? '' }}">
                                    <x-bladewind::button type="submit"
                                        class="bg-amber-900 !rounded-sm text-accent hover:bg-amber-700 mr-4 border border-charcoal max-md:mr-0 max-md:w-full"
                                        size="small" rounded="true" stretched_action_buttons="false"
                                        align_buttons="right" can_submit="true">
                                        Send Drop Request
                                    </x-bladewind::button>
                                </form>
                            </div>
                        </x-bladewind.modal-explore>
                    @endif


                </div>
            </div>
        </div>
    @else
        {{-- No session in progress --}}
        <div
            class="font-poppins bg-accent flex flex-col items-center h-full w-full border-b-2 border-black py-20 px-4 max-md:py-10">
            <div class="flex flex-col text-primary justify-center items-center h-full w-full">
                <img src="{{ asset('images/autumn.svg') }}" class="w-32 h-32 max-md:w-24 max-md:h-24">
                <span class="font-dela font-black text-charcoal text-xl mt-4 max-md:text-lg">
                    No session in progress
                </span>
                <span class="text-base text-darkgray italic text-center mt-2 max-md:text-sm">
                    @if ($user && $user->role === 'Student')
                        —time to find the perfect tutor and get learning!
                    @elseif ($user && $user->role === 'Tutor')
                        -sit tight and wait for a student to book your expertise!
                    @endif
                </span>
            </div>
        </div>
    @endif
</div>
