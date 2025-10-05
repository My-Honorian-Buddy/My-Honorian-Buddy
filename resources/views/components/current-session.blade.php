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
<div data-aos="fade-up" data-aos-anchor-placement="top-bottom"
    class="w-full h-auto mt-10 bg-accent3 rounded-[20px] overflow-hidden shadow-custom-button shadow-black border-black border-2 ">
    <div class="flex bg-primary items-center w-full border-b-2 border-black py-2">

        <div class="flex w-full justify-start text-2xl text-[#ffdd57] text-stroke font-black ml-8">CURRENT SESSIONS</div>
    </div>
    {{-- session #1 --}}

    @if (!empty($decodedSubject))
        @if ($user && $user->role === 'Student')
            @foreach ($decodedSubject as $subject)
                <div class="bg-accent3 flex items-center w-full border-b-2 border-black py-2">
                    <span class="h-6 w-6 ml-10 bg-primary border-2 border-black rounded-full shrink-0"></span>
                    <div class="grid grid-rows-2 mt-3 mb-2">
                        <div class="">
                            <p class="font-bold ml-5 text-[23px]">{{ $subject }}</p>
                        </div>
                        <div class="font-bold ml-5 text-[20px] text-primary">
                            <p>Tutor: {{ $fname }} {{ $lname }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        @elseif ($user && $user->role === 'Tutor')
            @foreach ($decodedSubject as $subject)
                <div class="bg-accent3 flex items-center w-full border-b-2 border-black py-2">
                    <span class="h-6 w-6 ml-10 bg-primary border-2 border-black rounded-full shrink-0"></span>
                    <div class="grid grid-rows-2 mt-3 mb-2">
                        <div class="">
                            <p class="font-bold ml-5 text-[23px]">{{ $subject }}</p>
                        </div>
                        <div class="font-bold ml-5 text-[20px] text-primary">
                            <p>Student: {{ $fname }} {{ $lname }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
        @if ($hasBookedSessions)
            <div class="bg-accent3 flex items-center w-full border-b-0 border-black py-2">
                <div class="bg-accent3 my-4 flex items-center w-full h-full py-2">
                    {{-- modal button --}}
                    <div class="text-white">
                        <div class=" ml-5">
                            <x-bladewind::button type="submit"
                                class="bg-primary border-2 border-b-0 border-black hover:bg-red-900 text-accent2 font-bold flex justify-items-center"
                                size="small" rounded="true" onclick="showModal('confirm-complete')">
                                complete session
                            </x-bladewind::button>
                        </div>
                        <x-bladewind.modal name="confirm-complete" size="medium" title="Confirm Session Completion"
                            footer="false" class="bg-blue-800 text-white" stretched_action_buttons="true"
                            ok_button_label="" cancel_button_label=""
                            cancel_button_action="hideModal('confirm-complete')" close_after_action="true"
                            backdrop_can_close="true">

                            <p class="mx-4 mt-4">Are you sure you want to complete this session?</p><br>

                            <div class="mt-4 flex flex-col font-black space-y-4">
                                <x-bladewind::button type="button"
                                    class="bg-secondary text-primary hover:bg-primary hover:text-accent2 border-2 border-black mx-4"
                                    size="small" rounded="true" can_submit="false" close_after_action="true"
                                    onclick=" showModal('confirm-drop'); ">
                                    Drop the session
                                </x-bladewind::button>


                                {{-- <x-bladewind::button
                                                type="button"
                                                class="bg-accent2 text-primary hover:bg-secondary border-2 border-black mx-4"
                                                size="small"
                                                rounded="true"
                                                can_submit="false"
                                                close_after_action="true"
                                                onclick="showModal('session-complete');">
                                                Complete with payment
                                            </x-bladewind::button> --}}

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

                                <p class="mx-4 mt-4">Your current session will terminate without payment for the
                                    previous meetings you attended. </p><br>

                                <div class="mt-4 flex justify-end space-x-4">
                                    <x-bladewind::button type="button"
                                        class="bg-primary text-accent2 hover:bg-red-900 hover:text-accent2 border-2 border-black"
                                        stretched_action_buttons="false" size="small" rounded="true"
                                        align_buttons="right" can_submit="false"
                                        onclick="hideModal('confirm-drop'); showModal('confirm-hangup');">
                                        Cancel
                                    </x-bladewind::button>

                                    <form action="{{ route('drop.session') }}" method="post">
                                        @csrf
                                        <input type="hidden" name="session_id" value="{{ $session->id }}">
                                        <x-bladewind::button type="submit"
                                            class="bg-accent2 text-primary hover:bg-primary mr-4 hover:text-accent2 border-2 border-black"
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

                                <p class="mx-4 mt-4">A notification regarding the cancellation of the session will be
                                    delivered to your tutor for confirmation.</p><br>

                                <div class="mt-4 flex justify-end space-x-4">
                                    <x-bladewind::button type="button"
                                        class="bg-primary text-accent2 hover:bg-red-900 hover:text-accent2 border-2 border-black"
                                        stretched_action_buttons="false" size="small" rounded="true"
                                        align_buttons="right" can_submit="false"
                                        onclick="hideModal('confirm-drop'); showModal('confirm-hangup');">
                                        Cancel
                                    </x-bladewind::button>

                                    <form action="{{ route('drop.session') }}" method="post">
                                        @csrf
                                        <input type="hidden" name="session_id" value="{{ $session->id }}">
                                        <x-bladewind::button type="submit"
                                            class="bg-accent2 text-primary hover:bg-primary mr-4 hover:text-accent2 border-2 border-black"
                                            size="small" rounded="true" stretched_action_buttons="false"
                                            align_buttons="right" can_submit="true">
                                            Confirm
                                        </x-bladewind::button>
                                    </form>
                                </div>
                            </x-bladewind.modal>
                        @endif

                        <!-- Modal of Complete Payment for Tutor -->
                        {{--    @if (Auth::user()->role === 'Tutor')
                                        <x-bladewind.modal
                                            name="confirm-payment"
                                            type="warning"
                                            title="Confirm Complete Payment"
                                            footer="false"
                                            size="big"
                                            ok_button_label=""
                                            cancel_button_label=""
                                            cancel_button_action="hideModal('confirm-payment')"
                                            backdrop_can_close="true">
                                            
                                            <p class="mx-4 mt-4">A link will be provided to the student for the purpose of sending 
                                                                the payment for the total number of meetings or sessions attended. </p><br>

                                            <div class="mt-4 flex justify-end space-x-4">
                                                <x-bladewind::button
                                                    type="button"
                                                    class="bg-primary text-accent2 hover:bg-red-900 hover:text-accent2 border-2 border-black"
                                                    size="small"
                                                    stretched_action_buttons="false"
                                                    rounded="true"
                                                    can_submit="false"
                                                    onclick="hideModal('confirm-payment')">
                                                    Cancel
                                                </x-bladewind::button>

                                                <form action="{{ route('complete.session') }}" method="post">
                                                    @csrf
                                                    <input type="hidden" name="session_id" value="{{ $session->id }}">
                                                    <x-bladewind::button 
                                                        type="submit"
                                                        class="bg-accent2 text-primary hover:bg-primary hover:text-accent2 border-2 border-black"
                                                        size="small"
                                                        stretched_action_buttons="false"
                                                        rounded="true"
                                                        can_submit="true">
                                                        Confirm
                                                    </x-bladewind::button>
                                                </form> 
                                            </div>
                                        </x-bladewind.modal>
                                        <!-- Modal of Complete Payment for Student -->
                                    @elseif(Auth::user()->role === 'Student')
                                        <x-bladewind.modal
                                            name="confirm-payment"
                                            type="warning"
                                            title="Confirm Complete Payment"
                                            footer="false"
                                            size="big"
                                            ok_button_label=""
                                            cancel_button_label=""
                                            cancel_button_action="hideModal('confirm-payment')"
                                            backdrop_can_close="true">
                                            
                                            <p class="mx-4 mt-4">A notification will be delivered to you containing a link for the payment 
                                                                according to the number of meetings or sessions with your honorian buddy.</p><br>

                                            <div class="mt-4 flex justify-end space-x-4">
                                                <x-bladewind::button
                                                    type="button"
                                                    class="bg-primary text-accent2 hover:bg-red-900 hover:text-accent2 border-2 border-black"
                                                    size="small"
                                                    stretched_action_buttons="false"
                                                    rounded="true"
                                                    can_submit="false"
                                                    onclick="hideModal('confirm-payment')">
                                                    Cancel
                                                </x-bladewind::button>

                                                <form action="{{ route('complete.session') }}" method="post">
                                                    @csrf
                                                    <input type="hidden" name="session_id" value="{{ $session->id }}">
                                                    <x-bladewind::button 
                                                        type="submit"
                                                        class="bg-accent2 text-primary hover:bg-primary hover:text-accent2 border-2 border-black"
                                                        size="small"
                                                        stretched_action_buttons="false"
                                                        rounded="true"
                                                        can_submit="true">
                                                        Confirm
                                                    </x-bladewind::button>
                                                </form> 
                                            </div>
                                        </x-bladewind.modal>
                                    @endif --}}
                    </div>
                </div>
            </div>
        @endif
    @else
        <div class="font-poppins bg-accent3 flex flex-col items-center h-full w-full border-b-2 border-black py-20">

            <div class="flex flex-col  text-primary justify-center items-center h-full w-full">
                <img src="{{ asset('images/autumn.svg') }}">
                <span class="font-black text-2xl">
                    No session in progress
                </span>
                <span class="text-base italic">
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
