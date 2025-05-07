@php
    use App\Models\Review;
    use App\Models\bookedSession;
    use App\Models\Tutor;

    $role = Auth::user()->role;
    $hasBookedSessions = false;
    $userID = Auth::user()->id;
    $schedule = $user->schedule;

    if ($role === 'Student') {
        $student = Auth::user()->student;
        

        if($student){
            $hasBookedSessions = Auth::user()->student->bookedsessions()->exists() ?? false;  
            $session = $student->bookedsessions;
            
            if($session){
                foreach ($tutor as $tutors){
                    if($tutors->user_id === $session->tutor_id){
                        $theOthersId = $tutors->user_id;
                        $fname = $tutors->fname;
                        $lname = $tutors->lname;
                        $bio = $tutors->bio;
                        $exp = $tutors->exp;
                        $price = $tutors->rate_session;
                        foreach ($allUsers as $allUser) {
                            if ($allUser->id === $tutors->user_id) {
                                $profile_pic = $allUser->profile_pic;
                            }
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
                        $theOthersId = $students->user_id;
                        $fname = $students->fname;
                        $lname = $students->lname;
                        $bio = $students->bio;
                        $year = $students->year_level . " - " . $students->department;
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

<x-workspace-layout>
    {{-- sidebar --}}
    <x-slot name="sidebar_content">
        <ul class="space-y-6">
            <li>
                <a href="http://">
                    <div class="flex items-center justify-between bg-accent2 text-primary text-right font-poppins font-bold md:w-4/5 rounded-full px-8 py-1 md:h-11 text-m
                    border-2 border-black shadow-custom-button hover:bg-[#FFECEC] hover:text-[#8B3A3A] cursor-pointer md:text-center"> 
                    <x-bladewind.icon name="video-camera" class="justify-self-start" />                    
                        JOIN A NEW CALL    
                    </div>
                </a>
            </li>
            <li>
                <div class="flex items-center justify-between bg-accent2 text-primary text-right font-poppins font-bold md:w-4/5 rounded-full px-8 py-1 md:h-11 text-m border-2 border-black 
                shadow-custom-button hover:bg-[#FFECEC] hover:text-[#8B3A3A] cursor-pointer md:text-center">
                    <x-bladewind.icon name="plus" class="justify-self-start" />
                        CREATE A NEW CALL
                </div>
            </li>
        </ul>
    </x-slot>

    {{-- main content --}}
    <x-slot name="main_content">
        {{-- card --}}
        <section class="m-8">
            <!-- container -->
            <div class="w-full bg-gray-300 rounded-[20px] overflow-hidden shadow-custom-button shadow-black border-black border-2">
                <div class="flex items-center bg-accent2 w-full border-b-2 border-black py-2 rounded-t-[5px]">
                    <div class="flex w-full space-x-2 ml-4 mb-2">
                        <span class="h-6 w-6 bg-primary border-2 border-black rounded-full"></span>
                        <span class="text-l font-black">FULLY BOOKED</span>
                    </div>
                </div>
                        
                <!-- div for the tutor's card -->
                <div class="flex w-full">
                    <!-- First column -->
                    <!-- First column -->
                    <div class="flex flex-col justify-start mt-16">  
                        <img src="{{$profile_pic}}" alt="Profile" class="mb-4 ml-4 w-56 h-56 border-4 border-black rounded-lg">
                    </div>
                        
                    <!-- Second column -->
                    <div class="flex flex-col ml-8 my-3">
                        <span class="font-bold text-red-900 leading-relaxed">First Name</span>
                        <span class="font-bold text-3xl -mt-1 leading-relaxed" name="fName">{{$fname}} {{$lname}}</span>
                        <span class="font-bold text-red-900 mt-4 leading-relaxed">Year Level and College Program</span>
                        <span class="font-bold text-3xl -mt-1 leading-relaxed" name="sYear">{{$year}}</span>
                        <span class="font-bold text-red-900 leading-relaxed">Bio</span>
                        @if($bio !== null) 
                        <p class="flex-grow items-center font-bold text-xl mt-6 ml-24 leading-relaxed" name="quote"> "{{$bio}}" </p> 
                        @else 
                        <p class="flex-grow items-center font-bold text-xl mt-6 ml-24 leading-relaxed" name="quote"> No bio yet </p> 
                        @endif
                        <div class="flex justify-between items-center mt-4">
                                        
                            <!-- Subject Expertise Section -->
                        <div class="flex flex-col space-y-3 mb-4">
                                <span class="font-bold text-red-900 leading-relaxed">Subject Expertise</span>
                            
                            
                            <div class="flex flex-wrap gap-2 mt-2 w-full max-w-lg ">
                            @foreach($pickedSubjects as $subject)
                                <span class="bg-accent2 font-bold text-black font-poppins rounded-full border-2 border-black shadow-custom-button px-4 py-1">{{$subject->subj_code}}</span>
                            @endforeach                      
                            </div>
                        </div>
        
                        <!-- Price Per Session Section -->
                        <div class="flex flex-col space-y-3 mb-4 ml-2">

                            <!-- Schedule Section -->
                            <div class="flex flex-col">
                                    @if ($user->schedule && $user->schedule->days_week)
                                            @php
                                                $days = is_string($user->schedule->days_week) 
                                                    ? json_decode($user->schedule->days_week, true) 
                                                    : $user->schedule->days_week;
                                            @endphp
                                            <div>
                                                <span class="font-bold text-red-900 leading-relaxed">Schedule</span>
                                                <div class="flex flex-row space-x-2">
                                            </div>
                                            
                                            @if(is_array($days))
                                                
                                            <div class="flex flex-wrap gap-2 mt-2 w-full max-w-lg ">
                                                @foreach($days as $day)
                                                <span class="bg-accent2 font-bold text-black font-poppins rounded-full border-2 border-black shadow-custom-button px-4 py-1">{{$day}}</span>
                                                @endforeach
                                            </div>
                
                                            @endif
                                    @endif
                            </div>
                    </div>
                </div>
            </div> 
        </div>       
        </div>
        </section>
        
        <div class="flex lg:flex-row sm:flex-col " >
            <!-- left side column -->
            <div class="w-full">
                <section class="">
                    <x-calendar />
                </section>
            </div>

            <!-- upcoming tasks - stats -->
            <div class="lg:ml-0 sm:ml-7">
                <section class="mt-8 mr-6" style="min-width: 20%">
                    <!-- container -->
                    <div class="bg-accent rounded-[20px] pb-2 mb-4 shadow-custom-button shadow-black border-black border-2 overflow-hidden">
                        <div class="bg-white rounded-t-[20px] md:text-2xl text-accent text-stroke font-black p-3 border-b-2 border-black">
                            STATS
                        </div>
                        <div class="border-black p-4"></div>
                        <!-- content -->
                        <div class="text-center mt-2 space-y-6 px-4">
                            <p class="font-bold sm:text-lg md:text-xl lg:text-2xl text-black break-words">Date Joined:</p>
                            <p class="font-bold sm:text-lg md:text-xl lg:text-2xl text-accent2 text-stroke break-words">{{$user->created_at->format('F d,  Y')}}</p>   
                
                            <p class="font-bold sm:text-lg md:text-xl lg:text-2xl text-black break-words">Sessions Completed:</p>
                            <p class="font-bold sm:text-lg md:text-xl lg:text-2xl text-accent2 text-stroke break-words">{{$session->total_session}} Sessions</p>
                            <div class="border-black p-4"></div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
        
    </x-slot>
</x-workspace-layout>