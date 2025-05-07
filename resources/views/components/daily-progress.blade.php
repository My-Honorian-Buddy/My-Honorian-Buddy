@props(['subjects', 'user', 'student', 'tutor'])

@php
    $decodedSubject = json_decode($subjects, true);

    $role = Auth::user()->role;

    $hasBookedSessions = false;
    $userID = Auth::user()->id;
    $percentage = 0;

    if ($role === 'Student') {
        $student = Auth::user()->student;

        if($student){
            $hasBookedSessions = Auth::user()->student->bookedsessions()->exists() ?? false;  
            $session = $student->bookedsessions;
            
            if($session){
                foreach ($tutor as $tutors){
                    if($tutors->user_id === $session->tutor_id){
                        $num_session = $session->num_session;
                        $total_session = $session->total_session;

                        if($total_session > 0){
                            $percentage = ($num_session / $total_session) * 100;
                        }else{
                            $percentage = 0;
                        }
                    }
                }
            }
        } 
    } else if ($role === 'Tutor'){
        $tutor = Auth::user()->tutor;

        if($tutor){
            $hasBookedSessions = Auth::user()->tutor->bookedsessions()->exists() ?? false;
            $session = $tutor->bookedsessions;
            
            if($session){
                foreach ($student as $students){
                    if ($students->user_id === $session->student_id) {
                        $num_session = $session->num_session;
                        $total_session = $session->total_session;

                        if($total_session > 0){
                            $percentage = ($num_session / $total_session) * 100;
                        }else{
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

<div class="w-full bg-accent rounded-[20px] overflow-hidden shadow-custom-button shadow-black border-black border-2 "> 
    <div class="flex items-center w-full border-b-2 border-black py-2">
        <div class="flex w-full space-x-2 -mt-1 -mb-1 ml-4">
            <span class="h-6 w-6 bg-accent2 border-2 border-black rounded-full"></span>
            <span class="h-6 w-6 bg-[#ffb6c1] border-2 border-black rounded-full"></span>
            <span class="h-6 w-6 bg-[#d3d3d3] border-2 border-black rounded-full"></span>
        </div>
        <div class="flex w-full justify-end text-2xl text-[#ffdd57] text-stroke font-black mr-8">DAILY PROGRESS</div>
    </div>


    @if(!empty($decodedSubject))
    <!-- div for grid -->
    <div class="grid grid-cols-[1fr_3fr]">
        <!-- left side column -->
        <div class="flex flex-col space-y-4 border-r-2 border-black bg-accent2 rounded-bl-lg py-4">
        @if($user && $user->role === 'Student')
            @foreach($decodedSubject as $subject)
            <div class="font-poppins w-auto  text-lg text-center underline decoration-2 h-[50px] mt-4">
                {{ $subject }}
            </div>
            
            @endforeach
        @elseif ($user && $user->role === 'Tutor')
            @foreach($decodedSubject as $subject)
            <div class="font-poppins w-auto  text-lg text-center underline decoration-2 h-[50px] mt-4">
                {{ $subject }}
            </div>
        
            @endforeach
        @else
        
        @endif
    
        </div>
        <!-- right side column -->
        
            <div class="flex flex-col space-y-4 bg-white rounded-br-lg py-4">
                <div class="flex items-center h-[50px] w-full">
                    <x-bladewind.progress-bar :percentage="$percentage" color="primary" show_percentage_label="true" class="w-full ml-2 mr-2"/>
                </div>
            </div>
       
        </div>
    @else
        <div class=" flex flex-col justify-center items-center w-full h-96 bg-gray-300">
            <img src="{{ asset('images/idk.svg') }}">
            <div class="font-poppins font-black text-primary text-2xl w-auto pt-4 text-center underline decoration-2 ">
                No subjects Available
            </div>
        </div>
    @endif
</div>