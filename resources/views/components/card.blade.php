{{-- for card --}}

@php
use App\Models\bookedSession;
use App\Models\Review;
use APp\Models\User;
use App\Models\Tutor;

$tutor = Tutor::where('user_id', '1')->first();

$reviews = Review::all();

@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>card</title> 
    <script src="https://cdn.tailwindcss.com"></script>
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    <link href="{{ asset('vendor/bladewind/css/bladewind-ui.min.css') }}" rel="stylesheet"/>
    <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

    <script src="/public/vendor/bladewind/js/dropmenu.js"></script>
    <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <script src="{{ asset('vendor/bladewind/js/helpers.js') }}"></script>

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=menu" />
</head>

@foreach ($users as $user)
<body class="bg-secondary font-poppins font-semibold">
    <section class="flex justify-center m-4 mt-2 py-5 w-full">
                
        {{-- container --}} 
        <div class="bg-[#D9D9D9] rounded-[20px] w-[60vw] pb-4 mb-4 shadow-custom-button shadow-black border-black border-2 md">
            <div class="p-4">

                {{-- content --}}
                <div class="flex md:flex-row sm:flex-col w-full items-center px-4 py-4">
                    {{-- column 1 --}}
                    <div class="flex flex-col justify-center items-center md:-mt-4 md:w-[25%] sm:mt-5">
                        {{-- profile image --}}
                        <div class="flex justify-center shrink-0 items-center  space-x-4 p-1">
                            <img src="{{ $user->profile_pic }}" 
                            alt="Profile" 
                            class="w-[210px] h-[210px] border-4 border-black rounded-lg">
                        </div> 
                        
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
                        {{-- profile infos --}}
                        <div class="flex-1">
                            {{-- name --}}
                            <p class="font-bold text-primary text-[16px] -mt-5">Name</p>
                            <p class="font-bold text-[30px] -mt-2">{{ $user->tutor->fname }} {{ $user->tutor->lname }}</p> 
                            
                            {{-- yr level and college program --}}
                            <p class="font-bold text-primary text-[16px]">Year Level and College Program</p>
                            <p class="font-bold text-[22px] -mt-1">3rd Year BS in Computer Science</p>

                            {{-- subject expertise --}}
                            <p class="font-bold text-primary text-[16px]">Subject Expertise</p>
                            <div class="flex justify-start space-x-4 mb-2">
                                @foreach($user->tutor->subject_tutor as $subject)
                                <div class="bg-accent2 my-1 py-1 px-2 rounded-2xl border-2 border-black shadow-custom-button text-primary text-[20px] text-center font-bold">
                                    <p class="font-bold text-[18px]">{{$subject->subj_code}}</p>
                                </div>
                                @endforeach
                            </div>

                            {{-- columns for exp and ratings --}}
                            <div class="flex md:flex-row sm:flex-col w-full">
                                <div class="w-[70%]">
                                    {{-- Experience --}}
                                    <p class="font-bold text-primary text-[16px]">Experience</p>
                                    <div class="flex justify-start space-x-4 -mt-1 -ml-5 mb-2">
                                        <div class="bg-accent2 my-1 py-1 px-2 rounded-2xl border-2 border-black shadow-custom-button text-primary text-[20px] text-center font-bold ml-5">
                                            <p class="font-bold text-[18px]">{{$user->tutor->exp}}</p>
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
                                <div class="md:ml-5 md:w-[30%] sm:w-[70%]">
                                        {{-- ratings --}}
                                        <p class="font-bold text-primary text-[16px]">Ratings</p>
                                        <div class="-ml-1 mt-2">
                                            <x-bladewind.rating
                                                size="small"
                                                color="yellow"
                                                type="star"
                                                rating="{{ $reviews->where('tutor_id', $user->tutor->user_id)->avg('rating') ?? 0 }}"
                                                clickable="true" />
                                        </div>
                                        
                                        {{-- price --}}
                                        <div class="flex items-start flex-col mt-1 "> 
                                            <p class="font-bold text-primary text-[16px]">Price</p>
                                            <div class="bg-accent2 my-1 py-1 px-2 rounded-2xl border-2 border-black shadow-custom-button text-primary text-[20px] text-center font-bold">
                                                <p class="font-bold text-[18px]">Php {{$user->tutor->rate_session}}</p>
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
</body>
@endforeach

</html>