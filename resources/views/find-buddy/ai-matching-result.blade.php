@php
    use App\Models\bookedSession;
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>My Honorian Buddy</title>
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    <link href="{{ asset('vendor/bladewind/css/bladewind-ui.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="burger.css">
    <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
    />
    <script src="{{ asset('vendor/bladewind/js/helpers.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="icon" href="{{ asset('/images/favicon.svg') }}" type="image/x-icon">

</head>
<body class="font-poppins font-semibold bg-secondary">
    <div class="flex-1">
            <!-- nav bar -->
            <x-nav-bar />

    <div class="flex flex-col items-center justify-center h-4/5 mt-20">
        <div class="relative text-center space-y-6" >
            <h1 class="relative z-30 font-bold leading-snug text-center">
                <div class="bg-primary shadow-custom-button px-2 border-2 border-black mb-6 rounded-full mt-5">
                    <p class="text-[58px] px-5 py-3 text-accent2" style="-webkit-text-stroke: 2px black; -webkit-text-fill-color: currentColor;">
                    MATCHMAKING RESULTS
                    </p>
                </div> 
        </div>
    </div>

{{-- card --}}
<div class="flex flex-col items-center space-y-4">

    {{-- Match and Tutor Information --}}
    @if (!empty($matches) && !empty($tutors))

        @foreach ($matches as $match)
            @foreach ($users as $user)
                @if (isset($user->tutor) && $match['tutor_id'] == $user->tutor->user_id)
                    {{-- Tutor Card --}}
                    <section class="flex justify-center m-4 mt-2 py-5 w-full">
                        <div class="bg-gray-100 rounded-[20px] w-[60vw] pb-4 mb-4 shadow-custom-button shadow-black border-black border-2 md">
                            <div class="p-4">
                                <div class="flex md:flex-row sm:flex-col w-full items-center px-4 py-4">
                                    {{-- column 1 --}}
                                    <div class="md:-mt-4 md:w-[25%] sm:mt-5">
                                        {{-- profile image --}}
                                        <div class="flex justify-center items-center space-x-4 p-1">
                                            <img src="{{ $user->profile_pic ?? 'default_profile_pic_url' }}" alt="Profile" class="w-[210px] h-[210px] border-4 border-black rounded-lg">
                                        </div> 
                                        {{-- Optional appointment setting for students --}}
                                        @if (Auth::user()->role === 'Student')
                                            @if (Auth::user()->student->bookedsessions()->exists() ?? false)
                                                <div class="inline-block bg-primary text-secondary text-center font-poppins font-bold rounded-full px-5 py-6 ml-2 mb-4 h-10 text-[16px] border-2 border-black shadow-custom-buttonflex items-center mt-10 leading-[2px]">
                                                    You already have a tutor.
                                                </div>
                                            @elseif (bookedSession::where('tutor_id', $user->id)->exists() ?? false)
                                                <div class="bg-primary text-secondary text-center font-poppins font-bold rounded-full px-4 py-6 ml-2 mb-4 h-10 text-[16px] border-2 border-black shadow-custom-button flex items-center mt-5">
                                                    A student already booked this tutor.
                                                </div>
                                            @else
                                                <div class="set-appointment-wrapper" data-user-id="{{ $user->tutor->user_id }}" tutor-subjects="{{ json_encode($user->tutor->subject_tutor) }}">
                                                    <x-set-appointment/>
                                                </div>
                                            @endif
                                        @endif
                                    </div>

                                    {{-- column 2 --}}
                                    <div class="ml-5 w-[75%] mt-5 p-1">
                                        <div class="flex-1">
                                            {{-- name --}}
                                            <p class="font-bold text-primary text-[16px] -mt-5">Name</p>
                                            <p class="font-bold text-[30px] -mt-2">{{ $user->tutor->fname }} {{ $user->tutor->lname }}</p> 
                                            
                                            {{-- subject expertise --}}
                                            <p class="font-bold text-primary text-[16px]">Subject Expertise</p>
                                            <div class="flex justify-start space-x-4 mb-2">
                                                @foreach($user->tutor->subject_tutor as $subject)
                                                    <div class="bg-accent2 my-1 py-1 px-2 rounded-2xl border-2 border-black shadow-custom-button text-primary text-[20px] text-center font-bold">
                                                        <p class="font-bold text-[18px]">{{ $subject->subj_code }}</p>
                                                    </div>
                                                @endforeach
                                            </div>

                                            {{-- Experience and Schedule --}}
                                            <div class="flex flex-row w-full">
                                                <div class="w-[70%]">
                                                    {{-- Experience --}}
                                                    <p class="font-bold text-primary text-[16px]">Experience</p>
                                                    <div class="flex justify-start space-x-4 -mt-1 -ml-5 mb-2">
                                                        <div class="bg-accent2 my-1 py-1 px-2 rounded-2xl border-2 border-black shadow-custom-button text-primary text-[20px] text-center font-bold ml-5">
                                                            <p class="font-bold text-[18px]">{{ $user->tutor->exp }}</p>
                                                        </div>
                                                    </div> 
                                                    
                                                    {{-- schedule --}}
                                                        <p class="font-bold text-primary text-[16px]">Schedule</p>
                                                        <div class="flex flex-wrap justify-start gap-x-2 gap-y-0.5 -mt-1 mb-2">
                                                    @if ($user->schedule && $user->schedule->days_week)
                                                        @php
                                                            $days = is_string($user->schedule->days_week) 
                                                                ? json_decode($user->schedule->days_week, true) 
                                                                : $user->schedule->days_week;
                                                        @endphp

                                                            @if(is_array($days))
                                                                @foreach($days as $day)
                                                                    <div class="bg-accent2 my-1 py-1 px-2 rounded-2xl border-2 border-black shadow-custom-button text-primary text-[20px] text-center font-bold">
                                                                        <p class="font-bold text-[18px]">{{ $day }}</p>
                                                                    </div>
                                                                @endforeach
                                                            @else
                                                            <div class="bg-gray-200 my-1 py-1 px-4 rounded-2xl border-2 border-black shadow-custom-button text-primary text-[20px] text-center font-bold">
                                                            <p class="font-bold text-[18px]">No schedule available</p>
                                                            </div>
                                                            @endif
                                                    @else
                                                        <div class="bg-gray-200 my-1 py-1 px-4 rounded-2xl border-2 border-black shadow-custom-button text-primary text-[20px] text-center font-bold">
                                                        <p class="font-bold text-[18px]">No schedule available</p>
                                                    @endif
                                                    </div>
                                                </div>
                                                
                                                {{-- Rating and Price --}}
                                                <div class="ml-5 w-[30%]">
                                                    {{-- Rating --}}
                                                    <p class="font-bold text-primary text-[16px]">Ratings</p>
                                                    <div class="-ml-1 -mt-2 ">
                                                        <x-bladewind::rating
                                                            size="small"
                                                            color="yellow"
                                                            type="star"
                                                            rating="5"
                                                            clickable="true"
                                                            name="star-rating" />
                                                    </div>
                                                    
                                                    {{-- Price --}}
                                                    <div class="flex items-start flex-col mt-1 "> 
                                                        <p class="font-bold text-primary text-[16px]">Price</p>
                                                        <div class="bg-accent2 my-1 py-1 px-2 rounded-2xl border-2 border-black shadow-custom-button text-primary text-[20px] text-center font-bold">
                                                            <p class="font-bold text-[18px]">Php {{ $user->tutor->rate_session }}</p>
                                                        </div>
                                                    </div> 
                                                </div>    
                                            </div>
                                        </div>     
                                    </div> 
                                </div>                                  
                            </div> 
                        </div>
                    </section>
                @endif
            @endforeach
        @endforeach
    @else
        <p>No matches or tutors found.</p>
    @endif
</div>


    {{-- manual searching --}}
    <div class="flex justify-center items-center mt-12">
        <div class="font-bold font-poppins text-gray-500 mt-8 mb-8 text-[18px]">
            Couldn't find the buddy you wanted? Try <a href="{{route('tutor.search')}}"><u>Manual Searching.</u></a>
        </div>
    </div>

        {{-- dropdown (rating)--}}
        <script>
        document.addEventListener('DOMContentLoaded', function () {
                const ratingBtn = document.querySelector('#rating-btn');
                const dropdownRating = document.querySelector('#dropdown-rating');
                const ratingOptions = dropdownRating.querySelectorAll('.dropdown-option');

                ratingBtn.addEventListener('click', function(e) {
                        e.preventDefault();
                        dropdownRating.classList.toggle('hidden');
                });


                ratingOptions.forEach(option => {
                        option.addEventListener('click', function(e) {
                                e.preventDefault();
                                ratingOptions.forEach(opt => opt.classList.remove('bg-maroon', 'text-white'));
                                option.classList.add('bg-maroon', 'text-white');
                                dropdownRating.classList.add('hidden');
                });
            });

            
            document.addEventListener('click', function(event) {
                if (!dropdownRating.contains(event.target) && !ratingBtn.contains(event.target)) {
                    dropdownRating.classList.add('hidden');
                }
            });
        });
    
        </script>
    
        {{-- dropdown (experience)--}}
        <script>
        document.addEventListener('DOMContentLoaded', function () {
            const experienceBtn = document.querySelector('#experience-btn');
            const dropdown = document.querySelector('#dropdown-experience');
            const dropdownOptions = document.querySelectorAll('.dropdown-option');
    
            
            experienceBtn.addEventListener('click', function(e) {
                e.preventDefault();
                dropdown.classList.toggle('hidden');
            });
    
            
            dropdownOptions.forEach(option => {
                option.addEventListener('click', function(e) {
                    e.preventDefault();
                    dropdownOptions.forEach(opt => opt.classList.remove('bg-maroon', 'text-white'));
                    option.classList.add('bg-maroon', 'text-white');
                    dropdown.classList.add('hidden');
                });
            });
    
            
            document.addEventListener('click', function(event) {
                if (!dropdown.contains(event.target) && !experienceBtn.contains(event.target)) {
                    dropdown.classList.add('hidden');
                }
            });
        });
        </script>
    
        {{-- dropdown (schedule)--}}
        <script>
        document.addEventListener('DOMContentLoaded', function () {
            const scheduleBtn = document.querySelector('#schedule-btn');
            const dropdownSchedule = document.querySelector('#dropdown-schedule');
            const scheduleOptions = dropdownSchedule.querySelectorAll('.dropdown-option');
    
            
            scheduleBtn.addEventListener('click', function(e) {
                e.preventDefault();
                dropdownSchedule.classList.toggle('hidden');
            });
    
    
            scheduleOptions.forEach(option => {
                option.addEventListener('click', function(e) {
                    e.preventDefault();    
                    scheduleOptions.forEach(opt => opt.classList.remove('bg-maroon', 'text-white'));
                    option.classList.add('bg-maroon', 'text-white');
                    dropdownSchedule.classList.add('hidden');
                });
            });
    
            
            document.addEventListener('click', function(event) {
                if (!dropdownSchedule.contains(event.target) && !scheduleBtn.contains(event.target)) {
                    dropdownSchedule.classList.add('hidden');
                }
            });
            });
            </script>
    
            
        <style>
        .hidden {
            display: none !important;
        }
        .bg-maroon {
            background-color: #800000; 
        }
        .text-white {
            color: #FFFFFF;
        }
        </style>
        
</body>
</html>