@props(['subjects', 'user', 'student', 'tutor'])

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
                        $num_session = $session->num_session;
                        $total_session = $session->total_session;

                        if ($total_session > 0) {
                            $percentage = ($num_session / $total_session) * 100;
                        } else {
                            $percentage = 0;
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
                        $num_session = $session->num_session;
                        $total_session = $session->total_session;

                        if ($total_session > 0) {
                            $percentage = ($num_session / $total_session) * 100;
                        } else {
                            $percentage = 0;
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


<div>
    <div data-aos="fade-up" data-aos-anchor-placement="top-bottom"
        class="w-full bg-accent rounded-md shadow-sm overflow-hidden border-2 border-charcoal my-8 ">
        <div class="flex items-center bg-accent w-full border-charcoal py-2">
            <div class="font-dela flex w-full  justify-start text-xl text-darkgray font-bold ml-8">
                Progress
            </div>
        </div>
        <span class="flex mx-4 items-center">
            <span class="h-px flex-1 bg-charcoal"></span>
        </span>

        @if (!empty($decodedSubject))
            <!-- div for grid -->
            <div class="grid grid-cols-[1fr_3fr]">
                <!-- left side column -->
                <div class="flex flex-col space-y-4 border-r border-charcoal bg-accent rounded-bl-lg py-4">
                    @if ($user && $user->role === 'Student')
                        @foreach ($decodedSubject as $subject)
                            <div class="font-poppins w-auto  text-lg text-center underline decoration-2 h-[50px] mt-4">
                                {{ $subject }}
                            </div>
                        @endforeach
                    @elseif ($user && $user->role === 'Tutor')
                        @foreach ($decodedSubject as $subject)
                            <div class="font-poppins w-auto text-lg text-center underline decoration-2 h-[50px] mt-4">
                                {{ $subject }}
                            </div>
                        @endforeach
                    @endif
                </div>


                <!-- right side column -->
                <div class="flex flex-col space-y-4 bg-accent rounded-br-lg py-4 px-2 max-md:space-y-2">
                    <div class="flex items-center justify-center h-full w-full">
                        <x-bladewind.progress-bar :percentage="50" color="purple" shade="dark" striped="true"
                            animated="true" show_percentage_label="true" class="w-full" />
                    </div>
                </div>
            </div>
        @else
            <div class="flex flex-col justify-center items-center w-full h-96 bg-accent max-md:h-64">
                <img src="{{ asset('images/idk.svg') }}" class="w-32 h-32 max-md:w-24 max-md:h-24">
                <div
                    class="font-poppins font-semibold text-primary text-xl w-auto pt-4 text-center underline decoration-2 ">
                    No subjects Available
                </div>
            </div>
        @endif
    </div>
</div>

