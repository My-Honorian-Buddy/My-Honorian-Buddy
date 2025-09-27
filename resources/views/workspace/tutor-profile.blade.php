@php
    use App\Models\Review;
    use App\Models\bookedSession;
    use App\Models\Tutor;

    $role = Auth::user()->role;
    $hasBookedSessions = false;
    $userID = Auth::user()->id;
    $schedule = $user->schedule;

    $theOthersId = '0';
    
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
                        foreach ($allUsers as $allUser) {
                            if ($allUser->id === $tutor->user_id) {
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
    if($theOthersId !== '0'){
        $reviews = Review::where('tutor_id', $theOthersId )->with('student')->get();
    }else{
        $reviews = null;
    }

@endphp

<x-workspace-layout>
    <x-slot name="sidebar_content">
        <ul class="flex flex-col items-center justify-center space-y-6">
            <li class="w-4/5">
                <a href="{{ route('video.join.meet') }}">
                    <div class="flex items-center justify-between bg-accent2 text-primary text-right font-poppins font-bold md:w-full rounded-full px-8 py-1 md:h-11 text-m
                    border-2 border-black shadow-custom-button hover:bg-[#FFECEC] hover:text-[#8B3A3A] cursor-pointer md:text-center"> 
                    <x-bladewind.icon name="video-camera" class="justify-self-start" />                    
                        JOIN A NEW CALL    
                    </div>
                </a>
            </li>
            <li class="w-4/5">
                <a href="{{ route('video.call.create') }}">
                    <div class="flex items-center justify-between bg-accent2 text-primary text-right font-poppins font-bold md:w-full rounded-full px-8 py-1 md:h-11 text-m border-2 border-black 
                    shadow-custom-button hover:bg-[#FFECEC] hover:text-[#8B3A3A] cursor-pointer md:text-center">
                        <x-bladewind.icon name="plus" class="justify-self-start" />
                            CREATE A NEW CALL
                    </div>
                </a>
            </li>
        </ul>
    </x-slot>

    <x-slot name="main_content">
    <div class="flex flex-col m-8">
        <section class="flex mb-8 justify-center items-center">
            <!-- container -->
            <div class="w-full bg-accent3 rounded-[20px] overflow-hidden shadow-custom-button shadow-black border-black border-2">
                <div class="flex items-center bg-accent2 w-full border-b-2 border-black py-2 rounded-t-[5px]">
                    <div class="flex w-full space-x-2 ml-4 mb-2">
                        <span class="h-6 w-6 bg-primary border-2 border-black rounded-full"></span>
                        <span class="text-l font-black">FULLY BOOKED</span>
                    </div>
                </div>
        
                <!-- div for the tutor's card -->
                <div class="flex">
                    <!-- First column -->
                    <div class="flex flex-col justify-start mt-16">  
                        <img src="{{$profile_pic}}" alt="Profile" class="mb-4 ml-4 w-56 h-56 border-4 border-black rounded-lg">
                    </div>
                    
                    <!-- Second column -->
                    <div class="flex flex-col ml-8 my-3 flex-grow">
                        <span class="font-bold text-red-900 leading-relaxed">First Name</span>
                        <span class="font-bold text-3xl -mt-1 leading-relaxed" name="fName">{{$fname}} {{$lname}}</span>

                        <span class="font-bold text-red-900 leading-relaxed">Bio</span>
                        @if($bio !== null) 
                        <p class="flex-grow items-center font-bold text-xl mt-6 ml-24 leading-relaxed" name="quote"> "{{$bio}}" </p> 
                        @else 
                        <p class="flex-grow items-center font-bold text-xl mt-6 ml-24 leading-relaxed" name="quote"> No bio yet </p> 
                        @endif
        
                        <div class="grid grid-cols-2 gap-x-8 mt-6">
                            <!-- Left Column of sections -->
                            <div class="flex flex-col space-y-6">
                                <!-- Subject Expertise Section -->
                                <div>
                                    <span class="font-bold text-red-900 leading-relaxed">Subject Expertise</span>
                                    <div class="flex flex-wrap gap-2 mt-2 mb-8">
                                        @foreach ($pickedSubjects as $subject)
                                            <span class="bg-accent2 font-bold text-black font-poppins rounded-full border-2 border-black shadow-custom-button px-4 py-1">
                                                {{ $subject->subj_code }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                            
                                <!-- Schedule Section -->
                                <div>
                                    <span class="font-bold text-red-900 leading-relaxed">Schedule</span>
                                    @if ($user->schedule && $user->schedule->days_week)
                                        @php
                                            $days = is_string($user->schedule->days_week)
                                                ? json_decode($user->schedule->days_week, true)
                                                : $user->schedule->days_week;
                                        @endphp
                                        <div class="flex flex-wrap gap-2 mt-2 mb-8">
                                            @if (is_array($days))
                                                @foreach ($days as $day)
                                                    <span class="bg-accent2 font-bold text-black font-poppins rounded-full border-2 border-black shadow-custom-button px-4 py-1">
                                                        {{ $day }}
                                                    </span>
                                                @endforeach
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            </div>
                        
                            <!-- Right Column of sections-->
                            <div class="flex flex-col space-y-6">
                                <!-- Experience Section -->
                                <div>
                                    <span class="font-bold text-red-900 leading-relaxed">Experience</span>
                                    <div class="flex flex-wrap gap-2 mt-2 mb-6">
                                        <span class="bg-accent2 font-bold text-black font-poppins rounded-full border-2 border-black shadow-custom-button px-4 py-1">
                                            {{ $exp }}
                                        </span>
                                    </div>
                                </div>
                            
                                <!-- Price Per Session Section -->
                                <div>
                                    <span class="font-bold text-red-900 leading-relaxed">Price Per Session</span>
                                    <div class="flex flex-wrap gap-2 mt-2 mb-6">
                                        <span class="bg-accent2 font-bold text-black font-poppins rounded-full border-2 border-black shadow-custom-button px-4 py-1">
                                            Php {{ $price }}.00
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
    {{-- Reviews --}}
    <section class="flex justify-center items-center">
        {{-- container --}}
        <div class="w-full bg-secondary rounded-[20px] overflow-hidden shadow-custom-button shadow-black border-black border-2">
            <div class="flex bg-accent2 mb-2 items-center w-full border-b-2 border-black py-2 rounded-t-[5px]">
                <div class="flex w-full space-x-2 -mt-1 -mb-1 ml-4">
                    <span class="h-6 w-6 bg-accent2 border-2 border-black rounded-full"></span>
                    <span class="h-6 w-6 bg-secondary border-2 border-black rounded-full"></span>
                    <span class="h-6 w-6 bg-accent3 border-2 border-black rounded-full"></span>
                </div>

                <div class="flex w-full justify-end text-2xl text-primary text-stroke font-black mr-8">REVIEWS</div>
            </div> 
                            
                            
            <!-- Main Flex Row Container for Profile, Name, Rating, and Comment -->

        @if($reviews !== null)
            @foreach ($reviews as $review)
                    @php    
                        if($review){
                            foreach ($allUsers as $allUser){
                                if ($allUser->id == $review->student->user_id) {
                                        $profile_pics = $allUser->profile_pic;
                                }
                            }
                        }
                    @endphp
                <div class="w-full flex items-center my-4 space-x-4 px-10">
                    <!-- First Column - User's Profile -->
                    <div class="w-2/5 flex items-center">
                        <div class="shrink-0">
                            <img src="{{$profile_pics}}" alt="User's Avatar" class="w-20 h-20 rounded-full border-4 border-black">
                        </div>
                                        
                        <!-- Second Column - User's Name and Star Ratings -->
                        <div class="flex flex-col ml-2 w-full h-full justify-start items-start space-y-1"> 
                            <span class="font-bold text-primary text-[16px]">{{$review->student->fname}} {{$review->student->lname}}</span>

                            <!-- Star Rating -->
                            <x-bladewind.rating size="small" rating="{{$review->rating}}" color="yellow" type="star" clickable="false" name="star-rating" class="flex md:flex col sm:flex col" />
                                            
                        </div>
                    </div>
                    <!-- Third Column - Review Comment -->
                    <div class="flex-grow w-3/5">
                        <p class="text-black my-2 font-semibold text-xl">"{{$review->comment}}"</p>
                    </div>
                </div>
                                
                <hr class="h-px border-0" style="border-top: 4px solid black;">
            @endforeach
        @else
                <div class="w-full flex justify-center items-center">
                    <p class="text-xl text-gray-600">No reviews available at the moment.</p>
                </div>      
        @endif
        </div>
    </section>

        <div class="grid grid-cols-4 w-full">
            <!-- Calendar -->
            <section class="col-span-3">
                <!-- container -->
                <div class="w-full mt-12">
                    <x-calendar />
                </div>
            </section>
            
             <!-- Expertise -->
             {{-- <div class="">
                <!-- expertise level -->
                <section class="ml-4 max-w-full mt-16">
                    <!-- container -->
                    <div class="bg-accent2 rounded-[20px] pb-2 -mt-4 shadow-custom-button shadow-black border-black border-2">
                        <div class="bg-accent rounded-t-[20px] text-2xl text-accent text-stroke font-black p-3 border-b-2 border-black">
                            <div class="text-accent2">EXPERTISE LEVEL</div>
                        </div>
                        <div class="border-black p-4"></div>
        
                        <div class="">
                            <div class="flex flex-col grid-cols-1 md:grid-cols-3 md:gap-8">
                                <!-- Subject 1 Expertise -->
                                <div class="flex flex-col items-center text-center md:flex-row md:text-left md:items-start">
                                    <p class="font-bold text-2xl md:text-xl lg:text-2xl text-black mr-0 md:mr-4">
                                        CSAC 313
                                    </p>
                                    <div>
                                        <x-bladewind::progress-circle
                                            animate="false"
                                            percentage="70"
                                            show_percent="true"
                                            shade="dark"
                                            color="red"
                                            circle_width="30"
                                            size="medium"
                                            show_label="true" />
                                    </div>
                                </div>
                        
                                <!-- Subject 2 Expertise -->
                                <div class="flex flex-col items-center text-center md:flex-row md:text-left md:items-start -mt-4">
                                    <p class="font-bold text-2xl md:text-xl lg:text-2xl text-black mr-0 md:mr-4 mt-3">
                                        CSOS 313
                                    </p>
                                    <div>
                                        <x-bladewind::progress-circle
                                            animate="false"
                                            percentage="66"
                                            show_percent="true"
                                            shade="dark"
                                            color="red"
                                            circle_width="30"
                                            size="medium"
                                            show_label="true" />
                                    </div>
                                </div>
                        
                                <!-- Subject 3 Expertise -->
                                <div class="flex flex-col items-center text-center md:flex-row md:text-left md:items-start -mt-4 mb-8">
                                    <p class="font-bold text-2xl md:text-xl lg:text-2xl text-black mr-0 md:mr-4 mt-3">
                                        CSIAS 313
                                    </p>
                                    <div>
                                        <x-bladewind::progress-circle
                                            animate="false"
                                            percentage="85"
                                            show_percent="true"
                                            shade="dark"
                                            color="red"
                                            circle_width="30"
                                            size="medium"
                                            show_label="true" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div> --}}
            <section class="ml-4 mt-12 max-w-full">
                <div class="bg-accent3 rounded-[20px] pb-3 mt-1 shadow-custom-button shadow-black border-black border-2">
                    <!-- Header -->
                    <div class="bg-primary rounded-t-[20px] text-2xl md:text-2xl text-accent2 text-stroke font-black p-4 border-b-2 border-black text-center">
                        STATS
                    </div>

                    <!-- Stats Content -->
                    <div class=" p-4 md:p-6 text-center md:text-left">
                        <div class="grid grid-cols-1 md:grid-cols-1 gap-20 -mt-2">
                                        
                            <!-- Date Joined -->
                            <div class="">
                                <p class="font-bold text-2xl md:text-2xl text-black">Date Joined:</p>
                                <p class="font-bold text-2xl md:text-xl text-center text-accent2 text-stroke">{{$user->created_at->format('F d,  Y')}}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <div class="grid grid-cols-4 w-full">
            <section class="col-span-3 ml-10 max-w-[calc(100%-4rem)]">
                <!-- container -->
                <div class="w-full">
                    <div class="bg-accent2 rounded-[20px] pt-2 pb-2 mb-4 shadow-custom-button shadow-black border-black border-2">
                        <div class="flex bg-white -mt-2 items-center w-full border-b-2 border-black py-2 rounded-t-[20px]">
                            <div class="flex w-full space-x-2 -mt-1 -mb-1 ml-4">
                                <span class="h-6 w-6 bg-accent2 border-2 border-black rounded-full"></span>
                                <span class="h-6 w-6 bg-[#ffb6c1] border-2 border-black rounded-full"></span>
                                <span class="h-6 w-6 bg-[#d3d3d3] border-2 border-black rounded-full"></span>
                            </div>
                            <div class="flex w-full justify-end text-2xl text-accent2 text-stroke font-black mr-8">SIMILAR BUDDIES</div>
                        </div>

                   
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mt-2 mr-2 ml-2">
                            <!-- buddy #1 -->
                            @foreach($tutor as $tutors)
                            <div class="flex flex-col items-center bg-gray-300 rounded-[20px] pt-5 pb-2 mb-4 shadow-black border-black border-2 w-full shrink-0 py-4">
                                @php
                                    foreach ($allUsers as $allUser){
                                        if ($allUser->id == $tutors->user_id) {
                                            $profile_pics = $allUser->profile_pic;
                                        }
                                    }
                                @endphp
                                <img src="{{$profile_pics}}" alt="profile" class="w-40 h-40 rounded-full border-4 border-black">
                                <p class="font-bold text-[20px] text-center mt-5">{{$tutors->fname}} {{$tutors->lname}}</p>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </section>

    
            {{-- <section class="ml-4 max-w-full">
                <div class="bg-accent rounded-[20px] pb-3 mt-1 shadow-custom-button shadow-black border-black border-2">
                    <!-- Header -->
                    <div class="bg-white rounded-t-[20px] text-2xl md:text-2xl text-accent text-stroke font-black p-4 border-b-2 border-black text-center">
                        STATS
                    </div>

                    <!-- Stats Content -->
                    <div class=" p-4 md:p-6 text-center md:text-left">
                        <div class="grid grid-cols-1 md:grid-cols-1 gap-20 -mt-2">
                                        
                            <!-- Date Joined -->
                            <div class="">
                                <p class="font-bold text-2xl md:text-2xl text-black">Date Joined:</p>
                                <p class="font-bold text-2xl md:text-xl text-center text-accent2 text-stroke">{{$user->created_at->format('F d,  Y')}}</p>
                            </div>
                        
                            <!-- Sessions Completed -->
                            <div>
                                <p class="font-bold text-2xl md:text-2xl text-black">Sessions Completed:</p>
                                <p class="font-bold text-2xl md:text-xl text-accent2 text-stroke">{{$session->total_session}} Sessions</p>
                            </div>
                        
                            <!-- Students Tutored -->
                            <div>
                                <p class="font-bold sm:text-lg md:text-xl lg:text-2xl text-black break-words">Students Tutored:</p>
                                <p class="font-bold sm:text-lg md:text-xl lg:text-2xl text-accent2 text-stroke break-words">{{$session->total_session}} students</p>
                            </div>

                            <!-- Hours of Working -->
                            <div>
                                <p class="font-bold text-2xl md:text-2xl text-black">Hours Working:</p>
                                <p class="font-bold text-2xl md:text-xl text-accent2 text-stroke">90 hours</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>  --}}
        </div>
    </div>
    </x-slot>
</x-workspace-layout>

<!-- Footer -->







