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
    class="w-full lg:w-1/2 h-auto bg-accent rounded-md overflow-hidden shadow-charcoal border-charcoal border-2 max-lg:mt-6">
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
                    <span
                        class="h-6 w-6 ml-10 bg-primary border-2 border-charcoal rounded-full shrink-0 max-md:ml-4 max-md:mb-2"></span>
                    <div class="grid grid-rows-2 mt-3 mb-2 ml-3 max-md:ml-4 max-md:mt-0 max-md:w-full">
                        <div>
                            <p class="font-poppins text-darkgray font-extrabold text-2xl max-md:text-lg">
                                {{ $subject }}
                            </p>
                        </div>
                        <div class="font-bold text-xl text-primary max-md:text-base">
                            <p>Tutor: {{ $fname }} {{ $lname }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        @elseif ($user && $user->role === 'Tutor')
            @foreach ($decodedSubject as $subject)
                <div
                    class="bg-accent flex items-center w-full border-b-2 border-charcoal py-2 max-md:flex-col max-md:items-start">
                    <span
                        class="h-6 w-6 ml-10 bg-primary border-2 border-charcoal rounded-full shrink-0 max-md:ml-4 max-md:mb-2"></span>
                    <div class="grid grid-rows-2 mt-3 mb-2 ml-3 max-md:ml-4 max-md:mt-0 max-md:w-full">
                        <div>
                            <p class="font-poppins text-darkgray font-extrabold text-2xl max-md:text-lg">
                                {{ $subject }}
                            </p>
                        </div>
                        <div class="font-bold text-xl text-primary max-md:text-base">
                            <p>Student: {{ $fname }} {{ $lname }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif

        {{-- Complete Session Button --}}
        <div class="bg-accent flex items-center w-full border-b-0 border-black py-2">
            <div class="bg-accent my-4 flex items-center w-full h-full py-2">
                <div class="text-white w-full px-4 max-md:px-2">
                    <div class="ml-5 max-md:ml-2">
                        <x-bladewind::button type="submit"
                            class="bg-primary border-2 border-black hover:bg-primary/70 text-accent font-bold flex justify-items-center max-md:w-full max-md:justify-center"
                            size="small" rounded="true" onclick="showModal('confirm-complete')">
                            complete session
                        </x-bladewind::button>
                    </div>
                        <x-bladewind.modal name="confirm-complete" size="medium" title="Confirm Session Completion"
                            footer="false" class="bg-blue-800 text-white" stretched_action_buttons="true"
                            ok_button_label="" cancel_button_label=""
                            cancel_button_action="hideModal('confirm-complete')" close_after_action="true"
                            backdrop_can_close="true">

                            <p class="mx-4 mt-4">Are you sure you want to complete this session?</p>
                            <br>

                            <div class="mt-4 flex flex-col font-black space-y-4">
                                <x-bladewind::button type="button"
                                    class="bg-secondary text-primary hover:bg-primary hover:text-accent2 border-2 border-black mx-4"
                                    size="small" rounded="true" can_submit="false" close_after_action="true"
                                    onclick=" showModal('confirm-drop'); ">
                                    Drop the session
                                </x-bladewind::button>

                                <x-bladewind::button type="button"
                                    class="bg-primary text-accent2 hover:bg-red-700 border-2 border-black mx-4"
                                    size="small" rounded="true" can_submit="false"
                                    onclick="hideModal('confirm-complete')">
                                    Cancel
                                </x-bladewind::button>
                            </div>
                        </x-bladewind.modal>

                        <!-- Modal of Drop Session for Tutor-->
                        @if (Auth::user()->role === 'Tutor')
                            <x-bladewind.modal name="session-complete" type="warning" title="Confirm Drop Session"
                                footer="false" size="big" ok_button_label="" cancel_button_label=""
                                cancel_button_action="hideModal('confirm-drop')" backdrop_can_close="true">

                                <p class="mx-4 mt-4">Your current session will terminate without
                                    payment for the
                                    previous meetings you attended. </p><br>

                                <div
                                    class="mt-4 flex justify-end space-x-4 max-md:flex-col max-md:space-x-0 max-md:space-y-2">
                                    <x-bladewind::button type="button"
                                        class="bg-primary text-accent2 hover:bg-red-900 hover:text-accent2 border-2 border-black"
                                        stretched_action_buttons="false" size="small" rounded="true"
                                        align_buttons="right" can_submit="false"
                                        onclick="hideModal('confirm-drop'); showModal('confirm-hangup');">
                                        Cancel
                                    </x-bladewind::button>

                                    <form action="{{ route('drop.session') }}" method="post" class="max-md:w-full">
                                        @csrf
                                        <input type="hidden" name="session_id" value="{{-- $session->id --}}">
                                        <x-bladewind::button type="submit"
                                            class="bg-accent2 text-primary hover:bg-primary mr-4 hover:text-accent2 border-2 border-black max-md:mr-0 max-md:w-full"
                                            size="small" rounded="true" stretched_action_buttons="false"
                                            align_buttons="right" can_submit="true">
                                            Confirm
                                        </x-bladewind::button>
                                    </form>
                                </div>
                            </x-bladewind.modal>

                            <!-- Modal of Drop Session for Student -->
                        @elseif (Auth::user()->role === 'Student')
                            <x-bladewind.modal name="confirm-drop" type="warning" title="Confirm Drop Session"
                                footer="false" size="big" ok_button_label="" cancel_button_label=""
                                cancel_button_action="hideModal('confirm-drop')" backdrop_can_close="true">

                                <p class="mx-4 mt-4">A notification regarding the cancellation of the
                                    session will be
                                    delivered to your tutor for confirmation.</p><br>

                                <div
                                    class="mt-4 flex justify-end space-x-4 max-md:flex-col max-md:space-x-0 max-md:space-y-2">
                                    <x-bladewind::button type="button"
                                        class="bg-primary text-accent2 hover:bg-red-900 hover:text-accent2 border-2 border-black"
                                        stretched_action_buttons="false" size="small" rounded="true"
                                        align_buttons="right" can_submit="false"
                                        onclick="hideModal('confirm-drop'); showModal('confirm-hangup');">
                                        Cancel
                                    </x-bladewind::button>

                                    <form action="{{ route('drop.session') }}" method="post" class="max-md:w-full">
                                        @csrf
                                        <input type="hidden" name="session_id" value="{{-- $session->id --}}">
                                        <x-bladewind::button type="submit"
                                            class="bg-accent2 text-primary hover:bg-primary mr-4 hover:text-accent2 border-2 border-black max-md:mr-0 max-md:w-full"
                                            size="small" rounded="true" stretched_action_buttons="false"
                                            align_buttons="right" can_submit="true">
                                            Confirm
                                        </x-bladewind::button>
                                    </form>
                                </div>
                            </x-bladewind.modal>
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
