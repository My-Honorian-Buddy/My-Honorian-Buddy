<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>About Us</title>
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    <link href="{{ asset('vendor/bladewind/css/bladewind-ui.min.css') }}" rel="stylesheet" />
    <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
    />
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="{{ asset('vendor/bladewind/js/helpers.js') }}"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <link rel="icon" href="{{ asset('/images/favicon.svg') }}" type="image/x-icon">
</head>

<!-- nav bar -->
<div class="flex-1 font-poppins font-semibold bg-secondary">
    <x-nav-bar />
</div>

<body class="font-poppins font-semibold">

<!-- first page -->
<div class="w-full h-full bg-secondary p-20 overflow-hidden">
    <div class="flex justify-end items-center mt-[100px] mb-[100px]">
        <div class="text-left">
            <h1 class="font-black text-5xl" data-aos="fade-up" data-aos-delay="300" data-aos-duration="1500"> 
                WE BELIEVE THAT
            </h1>
                <div class="flex items-center" data-aos="fade-up" data-aos-delay="300" data-aos-duration="1500">
                    <div class="relative inline-block font-dela bg-accent text-[80px] shadow-custom-button
                        text-stroke px-6 border-2 border-black mb-6 rounded-[50px]">
                        LEARNING
                        <img src="{{ asset('images/firstPageSvg/spark.svg') }}"
                             class="absolute right-[-85px] top-[-80px]">
                    </div>
                    <div class="font-black ml-4 text-[30px] mt-10">
                        IS...   
                    </div>                             
                </div>                        
                <div class="flex flex-col items-center mt-6" data-aos="fade-left" data-aos-delay="300" data-aos-duration="1500">
                    <div class="inline-block font-dela bg-accent2 text-primary border-2 border-black rounded-[20px]
                        text-[80px] shadow-custom-button text-stroke px-6 transform rotate-[3deg]">
                        BETTER
                    </div>
                    <div class="relative inline-block font-dela rounded-[20px] w-auto px-6 bg-primary
                        text-accent2 text-[80px] text-stroke border-2 border-black shadow-custom-button
                        transform rotate-[-3deg] mt-4 mb-6" >
                        TOGETHER
                        <img src="{{ asset('images/stars2.svg') }}"
                        class="absolute top-[-40px] right-[-30px] w-[80px] h-[80px]">
                        <img src="{{ asset('images/stars2.svg') }}"
                        class="absolute bottom-[-50px] left-[-30px] w-[80px] h-[80px] transform">
                    </div>
                </div>
        </div>
        <div class="absolute right-[800px] h-full w-auto" data-aos="fade-right" data-aos-delay="300" data-aos-duration="1500">     
            <img src="{{ asset('images/bro.svg') }}">
        </div>
    </div>
</div>

<div class="font-dela text-stroke bg-primary overflow-hidden h-[86px] relative">
    <div class="animate-marquee items-center whitespace-nowrap flex space-x-8 h-full">
        <span class="font-bold text-[40px] text-accent">BETTER TOGETHER</span>
        <span class="text-2xl">☀️</span>
        <span class="font-bold text-[40px] text-accent">BETTER TOGETHER</span>
        <span class="text-2xl">☀️</span>
        <span class="font-bold text-[40px] text-accent">BETTER TOGETHER</span>
        <span class="text-2xl">☀️</span>
        <span class="font-bold text-[40px] text-accent">BETTER TOGETHER</span>
        <span class="text-2xl">☀️</span>
        <span class="font-bold text-[40px] text-accent">BETTER TOGETHER</span>
        <span class="text-2xl">☀️</span>
        <span class="font-bold text-[40px] text-accent">BETTER TOGETHER</span>
        <span class="text-2xl">☀️</span>
        <span class="font-bold text-[40px] text-accent">BETTER TOGETHER</span>
        <span class="text-2xl">☀️</span>
        <span class="font-bold text-[40px] text-accent">BETTER TOGETHER</span>
        <span class="text-2xl">☀️</span>
        <span class="font-bold text-[40px] text-accent">BETTER TOGETHER</span>
        <span class="text-2xl">☀️</span>
        <span class="font-bold text-[40px] text-accent">BETTER TOGETHER</span>
        <span class="text-2xl">☀️</span>
        <span class="font-bold text-[40px] text-accent">BETTER TOGETHER</span>
        <span class="text-2xl">☀️</span>
        <span class="font-bold text-[40px] text-accent">BETTER TOGETHER</span>
        <span class="text-2xl">☀️</span>
        <span class="font-bold text-[40px] text-accent">BETTER TOGETHER</span>
        <span class="text-2xl">☀️</span>
        <span class="font-bold text-[40px] text-accent">BETTER TOGETHER</span>
        <span class="text-2xl">☀️</span>
        <span class="font-bold text-[40px] text-accent">BETTER TOGETHER</span>
        <span class="text-2xl">☀️</span>
        <span class="font-bold text-[40px] text-accent">BETTER TOGETHER</span>
        <span class="text-2xl">☀️</span>
        <span class="font-bold text-[40px] text-accent">BETTER TOGETHER</span>
        <span class="text-2xl">☀️</span>
        <span class="font-bold text-[40px] text-accent">BETTER TOGETHER</span>
        <span class="text-2xl">☀️</span>
        <span class="font-bold text-[40px] text-accent">BETTER TOGETHER</span>
        <span class="text-2xl">☀️</span>
        <span class="font-bold text-[40px] text-accent">BETTER TOGETHER</span>
        <span class="text-2xl">☀️</span>
        <span class="font-bold text-[40px] text-accent">BETTER TOGETHER</span>
        <span class="text-2xl">☀️</span>
        <span class="font-bold text-[40px] text-accent">BETTER TOGETHER</span>
        <span class="text-2xl">☀️</span>
        <span class="font-bold text-[40px] text-accent">BETTER TOGETHER</span>
        <span class="text-2xl">☀️</span>
        <span class="font-bold text-[40px] text-accent">BETTER TOGETHER</span>
        <span class="text-2xl">☀️</span> 
    </div>
</div>

<!-- second page -->
<div class="bg-accent relative w-full h-full p-20">

    <!-- our mission contents container -->
    <div class="flex items-center relative mt-10 p-10" data-aos="fade-right" data-aos-delay="300" data-aos-duration="1000">
        <div class="bg-accent2 rounded-[10px] h-[600px] w-[650px] pt-2 pb-2 mb-4 shadow-custom-button
            shadow-black border-black border-2 overflow-hidden">
            <div class="flex bg-stone-200 -mt-2 items-center w-full border-b-2 border-black py-2 rounded-t-[10px]">
                <div class="flex w-full space-x-2 -mt-1 -mb-1 ml-4">
                    <span class="h-6 w-6 bg-accent2 border-2 border-black rounded-full"></span>
                    <span class="h-6 w-6 bg-[#ffb6c1] border-2 border-black rounded-full"></span>
                    <span class="h-6 w-6 bg-[#d3d3d3] border-2 border-black rounded-full"></span>
                </div>
            </div> 
            
            <!-- our mission contents -->
            <div class="relative items-center" >
              <img src="{{ asset('images/grid.svg') }}" class="opacity-50">
                <h1 class="absolute p-10 inset-0 font-poppins text-5xl font-black">
                    WHY WE ARE HERE.
                </h1>
                <p class="absolute inset-0 pt-20 pl-10 pr-10 text-xl font-bold text-justify mt-10">
                At <i>My Honorian Buddy</i>, we’re driven by a commitment to empower students to thrive academically
                and personally. We believe that learning is most effective when it’s collaborative, adaptive, and tailored
                to individual needs. Through innovative AI-powered matchmaking, we connect students with peers who can
                offer the right support, mentorship, and encouragement. Our platform fosters a supportive learning community
                where students can share knowledge, overcome academic challenges, and build meaningful connections. With
                <i>My Honorian Buddy</i>, every student has the tools, resources, and network to unlock their full potential and
                achieve their educational goals.
                </p>
            </div> 
        </div>

        <!-- our mission title container -->
        <div class="absolute top-[40px] right-[650px] -mt-10 bg-accent2 rounded-[10px] py-2 mb-4 shadow-custom-button 
            shadow-black border-black border-2">
                    <div class="flex bg-stone-200 -mt-2 items-center w-full border-b-2 border-black py-2 rounded-t-[10px]">
                        <div class="flex w-full space-x-2 -mt-1 -mb-1 ml-4">
                            <span class="h-6 w-6 bg-accent2 border-2 border-black rounded-full"></span>
                            <span class="h-6 w-6 bg-[#ffb6c1] border-2 border-black rounded-full"></span>
                            <span class="h-6 w-6 bg-[#d3d3d3] border-2 border-black rounded-full"></span>
                        </div>
                    </div>

                    <!-- our mission title-->
                    <div class="inline-block px-4 py-2 text-center text-lg font-black">
                        <span class="whitespace-nowrap text-4xl font-extrabold font-poppins">OUR MISSION</span>
                    </div>
            </div>

        <div class="absolute h-auto w-auto mt-[100px] left-[550px]" data-aos="fade-left" data-aos-delay="300" data-aos-duration="1000">     
            <img src="{{ asset('images/bro_reading.svg') }}">
        </div>

    </div>

      <!-- our vision contents container -->
      <div class="flex items-center relative p-10 mt-[150px] mb-[150px]" data-aos="zoom-in-left" data-aos-delay="300" data-aos-duration="1000">
        <div class="bg-accent2 rounded-[10px] h-[380px] w-[700px] pt-2 pb-2 mb-4 shadow-custom-button shadow-black
            border-black border-2 ml-auto overflow-hidden">
            <div class="flex bg-stone-200 -mt-2 items-center w-full border-b-2 border-black py-2 rounded-t-[10px]">
                <div class="flex w-full space-x-2 -mt-1 -mb-1 ml-4">
                    <span class="h-6 w-6 bg-accent2 border-2 border-black rounded-full"></span>
                    <span class="h-6 w-6 bg-[#ffb6c1] border-2 border-black rounded-full"></span>
                    <span class="h-6 w-6 bg-[#d3d3d3] border-2 border-black rounded-full"></span>
                </div>
            </div> 
            
            <!-- our vision contents -->
            <div class="relative flex justify-end items-center">
              <img src="{{ asset('images/grid.svg') }}" class="w-full h-full inset-0 opacity-50">
                <h1 class="absolute p-10 inset-0 font-poppins text-5xl font-black">
                THE FUTURE WE AIM FOR.
                </h1>
                <p class="absolute inset-0 pt-20 pl-10 pr-10 text-xl font-bold text-justify mt-10">
                To become a platform that transforms academic journeys by fostering meaningful peer connections,
                personalized support, and collaborative learning, empowering students to achieve their fullest
                potential and excel together in a community built on shared knowledge and trust.
                </p>
            </div> 
        </div>

        <!-- our vision title container -->
                 <div class="absolute bottom-0 right-[85px] translate-y-5 bg-accent2 rounded-[10px] py-2 mb-4 shadow-custom-button
                    shadow-black border-black border-2">
                    <div class="flex bg-stone-200 -mt-2 items-center w-full border-b-2 border-black py-2 rounded-t-[10px]">
                        <div class="flex w-full space-x-2 -mt-1 -mb-1 ml-4">
                            <span class="h-6 w-6 bg-accent2 border-2 border-black rounded-full"></span>
                            <span class="h-6 w-6 bg-[#ffb6c1] border-2 border-black rounded-full"></span>
                            <span class="h-6 w-6 bg-[#d3d3d3] border-2 border-black rounded-full"></span>
                        </div>
                    </div>

                    <!-- our vision title-->
                    <div class="inline-block px-4 py-2 text-center text-lg font-black">
                        <span class="whitespace-nowrap text-4xl font-extrabold font-poppins">OUR VISION</span>
                    </div>
            </div>

        <div class="absolute h-auto w-auto right-[600px]" data-aos="zoom-in-right" data-aos-delay="300" data-aos-duration="1000">     
            <img src="{{ asset('images/bro_imagination.svg') }}">
        </div>

      </div>
</div>

<div class="font-dela text-stroke bg-black overflow-hidden h-[86px] relative z-0">
    <div class="animate-reverse_marquee items-center whitespace-nowrap flex space-x-8 h-full">
        <span class="font-bold text-[40px] text-accent2">BUDDY SYSTEM</span>
        <span class="text-2xl">☀️</span>
        <span class="font-bold text-[40px] text-accent2">BRIGHTER MINDS</span>
        <span class="text-2xl">☀️</span>
        <span class="font-bold text-[40px] text-accent2">BUDDY SYSTEM</span>
        <span class="text-2xl">☀️</span>
        <span class="font-bold text-[40px] text-accent2">BRIGHTER MINDS</span>
        <span class="text-2xl">☀️</span>
        <span class="font-bold text-[40px] text-accent2">BUDDY SYSTEM</span>
        <span class="text-2xl">☀️</span>
        <span class="font-bold text-[40px] text-accent2">BRIGHTER MINDS</span>
        <span class="text-2xl">☀️</span>
        <span class="font-bold text-[40px] text-accent2">BUDDY SYSTEM</span>
        <span class="text-2xl">☀️</span>
        <span class="font-bold text-[40px] text-accent2">BRIGHTER MINDS</span>
        <span class="text-2xl">☀️</span>
        <span class="font-bold text-[40px] text-accent2">BUDDY SYSTEM</span>
        <span class="text-2xl">☀️</span>
        <span class="font-bold text-[40px] text-accent2">BRIGHTER MINDS</span>
        <span class="text-2xl">☀️</span>
        <span class="font-bold text-[40px] text-accent2">BUDDY SYSTEM</span>
        <span class="text-2xl">☀️</span>
        <span class="font-bold text-[40px] text-accent2">BRIGHTER MINDS</span>
        <span class="text-2xl">☀️</span>
        <span class="font-bold text-[40px] text-accent2">BUDDY SYSTEM</span>
        <span class="text-2xl">☀️</span>
        <span class="font-bold text-[40px] text-accent2">BRIGHTER MINDS</span>
        <span class="text-2xl">☀️</span>
        <span class="font-bold text-[40px] text-accent2">BUDDY SYSTEM</span>
        <span class="text-2xl">☀️</span>
        <span class="font-bold text-[40px] text-accent2">BRIGHTER MINDS</span>
        <span class="text-2xl">☀️</span>
        <span class="font-bold text-[40px] text-accent2">BUDDY SYSTEM</span>
        <span class="text-2xl">☀️</span>
        <span class="font-bold text-[40px] text-accent2">BRIGHTER MINDS</span>
        <span class="text-2xl">☀️</span>
        <span class="font-bold text-[40px] text-accent2">BUDDY SYSTEM</span>
        <span class="text-2xl">☀️</span>
        <span class="font-bold text-[40px] text-accent2">BRIGHTER MINDS</span>
        <span class="text-2xl">☀️</span>
        <span class="font-bold text-[40px] text-accent2">BUDDY SYSTEM</span>
        <span class="text-2xl">☀️</span>
        <span class="font-bold text-[40px] text-accent2">BRIGHTER MINDS</span>
        <span class="text-2xl">☀️</span>
        <span class="font-bold text-[40px] text-accent2">BUDDY SYSTEM</span>
        <span class="text-2xl">☀️</span>
        <span class="font-bold text-[40px] text-accent2">BRIGHTER MINDS</span>
        <span class="text-2xl">☀️</span>
    </div>
</div>

<!-- third page -->
<div class="bg-stone-200 relative w-full h-full p-20">
    <div class="flex justify-center items-center mt-[100px] mb-[100px] space-x-10 space-y-[-100px]" data-aos="zoom-in-down" data-aos-delay="300" data-aos-duration="1000"">
        <h1 class="text-accent drop-shadow-custom-drop-shadow text-stroke font-dela text-8xl ml-[-100px] mt-[100px]"> 
            HOW IT <br> WORKS
        </h1>
            <div class="flex items-center justify-center">
                <img src="{{ asset('images/bro_thinking.svg') }}"
                    class="absolute">
            </div>
    </div> 
    
    <!-- contents container -->
    <div class="flex flex-col space-y-10 items-center justify-center relative mt-5">

        <!-- sign up -->
        <div class="relative bg-accent rounded-[10px] h-[260px] w-[1000px] shadow-custom-button shadow-black
            border-black border-2 p-10" data-aos="fade-up" data-aos-anchor-placement="top-bottom" data-aos-delay="300" data-aos-duration="1000">
            <h1 class="font-poppins font-black text-7xl ml-[300px]">
                Sign Up
            </h1>
            <p class="font-poppins font-semibold text-2xl mt-[30px] ml-[300px]">
                Create a profile as a tutor or student showcase your interests, expertise, and academic goals.
            </p>
            <div class="absolute ml-10 h-auto w-auto inset-0">
                <img src="{{ asset('images/bro_signup.svg') }}" alt="sign up">
            </div>
        </div>

        <!-- match with a buddy -->
        <div class="relative bg-accent rounded-[10px] h-[260px] w-[1000px] shadow-custom-button shadow-black
            border-black border-2 p-10 overflow-hidden" data-aos="fade-up" data-aos-anchor-placement="top-bottom" data-aos-delay="300" data-aos-duration="1000">
            <h1 class="font-poppins font-black text-6xl ml-[20px]">
                Match with a Buddy
            </h1>
            <p class="font-poppins font-semibold text-2xl mt-[30px] ml-[20px]">
                Use AI-powered recommendations to discover the
                <br> perfect tutor suited to your unique learning needs.
            </p>
            <div class="absolute ml-[720px] mt-[15px] h-auto w-[220px] inset-0">
                <img src="{{ asset('images/bro_buddy.svg') }}" alt="match with a buddy">
            </div>
        </div>

        <!-- book sessions -->
        <div class="relative bg-accent rounded-[10px] h-[260px] w-[1000px] shadow-custom-button shadow-black
            border-black border-2 p-10" data-aos="fade-up" data-aos-anchor-placement="top-bottom" data-aos-delay="300" data-aos-duration="1000">
            <h1 class="font-poppins font-black text-7xl ml-[350px]">
                Book Sessions
            </h1>
            <p class="font-poppins font-semibold text-2xl mt-[30px] ml-[350px]">
                Set appointments with available tutors and schedule sessions at your convenience.
            </p>
            <div class="absolute mt-8 ml-10 h-auto w-full inset-0">
                <img src="{{ asset('images/bro_sessions.svg') }}" alt="book sessions">
            </div>   
        </div>

        <!-- learn and connect -->
        <div class="relative bg-accent rounded-[10px] h-[260px] w-[1000px] shadow-custom-button shadow-black
            border-black border-2 p-10 overflow-hidden" data-aos="fade-up" data-aos-anchor-placement="top-bottom" data-aos-delay="300" data-aos-duration="1000">
            <h1 class="font-poppins font-black text-6xl ml-[20px]">
                Learn and Connect
            </h1>
            <p class="font-poppins font-semibold text-2xl mt-[30px] ml-[20px]">
                Participate in sessions and receive personalized
                <br> guidance to enhance your learning experience.
            </p>
            <div class="absolute ml-[680px] mt-[25px] h-auto w-[250px] inset-0">
                <img src="{{ asset('images/bro_connect.svg') }}" alt="learn and connect">
            </div>
        </div>
    </div>
</div>
    
<div class="font-dela text-stroke bg-primary overflow-hidden h-[86px] relative">
    <div class="animate-marquee items-center whitespace-nowrap flex space-x-8 h-full">
        <span class="font-bold text-[40px] text-accent">MEET THE TEAM</span>
        <span class="text-2xl">☀️</span>
        <span class="font-bold text-[40px] text-accent">MEET THE TEAM</span>
        <span class="text-2xl">☀️</span>
        <span class="font-bold text-[40px] text-accent">MEET THE TEAM</span>
        <span class="text-2xl">☀️</span>
        <span class="font-bold text-[40px] text-accent">MEET THE TEAM</span>
        <span class="text-2xl">☀️</span>
        <span class="font-bold text-[40px] text-accent">MEET THE TEAM</span>
        <span class="text-2xl">☀️</span>
        <span class="font-bold text-[40px] text-accent">MEET THE TEAM</span>
        <span class="text-2xl">☀️</span>
        <span class="font-bold text-[40px] text-accent">MEET THE TEAM</span>
        <span class="text-2xl">☀️</span>
        <span class="font-bold text-[40px] text-accent">MEET THE TEAM</span>
        <span class="text-2xl">☀️</span>
        <span class="font-bold text-[40px] text-accent">MEET THE TEAM</span>
        <span class="text-2xl">☀️</span>
        <span class="font-bold text-[40px] text-accent">MEET THE TEAM</span>
        <span class="text-2xl">☀️</span>
        <span class="font-bold text-[40px] text-accent">MEET THE TEAM</span>
        <span class="text-2xl">☀️</span>
        <span class="font-bold text-[40px] text-accent">MEET THE TEAM</span>
        <span class="text-2xl">☀️</span>
        <span class="font-bold text-[40px] text-accent">MEET THE TEAM</span>
        <span class="text-2xl">☀️</span>
        <span class="font-bold text-[40px] text-accent">MEET THE TEAM</span>
        <span class="text-2xl">☀️</span>
        <span class="font-bold text-[40px] text-accent">MEET THE TEAM</span>
        <span class="text-2xl">☀️</span>
        <span class="font-bold text-[40px] text-accent">MEET THE TEAM</span>
        <span class="text-2xl">☀️</span>
        <span class="font-bold text-[40px] text-accent">MEET THE TEAM</span>
        <span class="text-2xl">☀️</span>
        <span class="font-bold text-[40px] text-accent">MEET THE TEAM</span>
        <span class="text-2xl">☀️</span>
        <span class="font-bold text-[40px] text-accent">MEET THE TEAM</span>
        <span class="text-2xl">☀️</span>
        <span class="font-bold text-[40px] text-accent">MEET THE TEAM</span>
        <span class="text-2xl">☀️</span>
        <span class="font-bold text-[40px] text-accent">MEET THE TEAM</span>
        <span class="text-2xl">☀️</span>
        <span class="font-bold text-[40px] text-accent">MEET THE TEAM</span>
        <span class="text-2xl">☀️</span>
        <span class="font-bold text-[40px] text-accent">MEET THE TEAM</span>
        <span class="text-2xl">☀️</span>
        <span class="font-bold text-[40px] text-accent">MEET THE TEAM</span>
        <span class="text-2xl">☀️</span> 
    </div>
</div>

<!-- fourth page -->
<div class="w-full h-auto bg-accent2 absolute">

    <!-- group image -->
    <div class="flex items-center justify-center space-x-5 pt-10">
        <img src="{{ asset('images/group.svg') }}" alt="group" class="w-auto h-auto" data-aos="fade-right" data-aos-delay="300" data-aos-duration="1000">
        <!-- title section -->
        <div class="relative flex flex-col justify-center mt-[100px] ml-[500px]" data-aos="fade-left" data-aos-delay="300" data-aos-duration="1000">
            <h1 class="font-black text-4xl text-black">
                ABOUT THE
            </h1>
            <div class="flex items-center">
                <div class="font-black bg-accent text-primary text-[80px] shadow-custom-button text-stroke
                    border-2 px-4 border-black rounded-[10px]">
                    CREATORS
                </div>
            </div>
        </div>
    </div>

    <!-- line -->
    <div class="w-full">
        <hr class="border-t-2 border-black">
    </div>


    <div class="p-20">
    <!-- Founding Story Container -->
    <div class="flex items-center justify-center relative mt-10 mb-20">
        <div class="bg-accent rounded-[10px] h-[700px] w-[850px] shadow-custom-button shadow-black border-black
            border-2 overflow-hidden" data-aos="fade-up" data-aos-delay="300" data-aos-duration="1000">
            <div class="flex bg-stone-200 items-center w-full border-b-2 border-black py-2 rounded-t-[10px]">
                <div class="flex space-x-2 ml-4">
                    <span class="h-6 w-6 bg-accent2 border-2 border-black rounded-full"></span>
                    <span class="h-6 w-6 bg-accent border-2 border-black rounded-full"></span>
                    <span class="h-6 w-6 bg-[#d3d3d3] border-2 border-black rounded-full"></span>
                </div>
            </div>
            <!-- Founding Story Content -->
            <div class="relative text-center">
                <h1 class="font-poppins text-5xl font-black mt-[40px] mb-6">
                    OUR FOUNDING STORY
                </h1>
                <p class="text-xl font-bold text-justify mx-[45px] w-auto">
                Our journey began with a vision to create an innovative, purpose-driven platform that would truly
                serve the students of Don Honorio Ventura State University. As proud students of 3B from the Bachelor 
                of Science in Computer Science, we recognized a gap in how academic support was being delivered and
                saw an opportunity to make a meaningful impact. <br><br>

                Motivated by our shared passion for technology and a desire to help our fellow students, we set out on a journey
                to design a platform that goes beyond traditional learning methods. <i>My Honorian Buddy</i> was born out of
                countless brainstorming sessions, late nights, and the enduring commitment that education thrives
                when it is accessible, collaborative, and personalized.<br><br>

                With the goal to create a platform where students could connect and build meaningful relationships,
                <i>My Honorian Buddy</i> empowers every aspect of the student journey, nurturing a supportive community
                for Don Honorio Ventura State University and inspiring a culture of collaboration and growth.
                </p>
            </div>
        </div>
    </div>

    <!-- members first row -->
    <div class="flex flex-row items-center justify-center px-10 space-x-10">
        <div class="relative bg-stone-200 rounded-[10px] h-[300px] w-[230px] shadow-custom-button shadow-black border-black
            border-2 p-5 flex flex-col items-center" data-aos="zoom-in-right" data-aos-delay="300" data-aos-duration="1000">
            <div class="h-auto w-auto">
                <img src="/storage/images/son.jpg" alt="de leon" class="mb-6 rounded-full object-cover border-2 border-black">
            </div>
            <h1 class="text-center font-poppins font-black text-lg">
                Alain Davidson <br> De Leon
            </h1>
        </div>
        <div class="relative bg-stone-200 rounded-[10px] h-[300px] w-[230px] shadow-custom-button shadow-black border-black
            border-2 p-5 flex flex-col items-center" data-aos="zoom-in-right" data-aos-delay="300" data-aos-duration="1000">
            <div class="h-auto w-auto">
                <img src="/storage/images/nion.jpg" alt="tongol" class="mb-6 rounded-full object-cover border-2 border-black">
            </div>
            <h1 class="text-center font-poppins font-black text-lg">
                Nion Czryll <br> Tongol
            </h1>
        </div>
        <div class="relative bg-stone-200 rounded-[10px] h-[300px] w-[230px] shadow-custom-button shadow-black border-black
            border-2 p-5 flex flex-col items-center" data-aos="zoom-in" data-aos-delay="300" data-aos-duration="1000">
            <div class="h-auto w-auto">
                <img src="/storage/images/dwight.jpg" alt="pingul" class="mb-6 rounded-full object-cover border-2 border-black">
            </div>
            <h1 class="text-center font-poppins font-black text-lg">
                Dwight Jairo <br> Pingul
            </h1>
        </div>
        <div class="relative bg-stone-200 rounded-[10px] h-[300px] w-[230px] shadow-custom-button shadow-black border-black
            border-2 p-5 flex flex-col items-center" data-aos="zoom-in-left" data-aos-delay="300" data-aos-duration="1000">
            <div class="h-auto w-auto">
                <img src="/storage/images/jc.jpg" alt="bulaon" class="mb-6 rounded-full object-cover border-2 border-black">
            </div>
            <h1 class="text-center font-poppins font-black text-lg">
                John Carl <br> Angelo Bulaon
            </h1>
        </div>
        <div class="relative bg-stone-200 rounded-[10px] h-[300px] w-[230px] shadow-custom-button shadow-black border-black
            border-2 p-5 flex flex-col items-center" data-aos="zoom-in-left" data-aos-delay="300" data-aos-duration="1000">
            <div class="h-auto w-auto">
                <img src="/storage/images/jd.jpg" alt="canlas" class="mb-6 rounded-full object-cover border-2 border-black">
            </div>
            <h1 class="text-center font-poppins font-black text-lg">
                John Daniel <br> Canlas
            </h1>
        </div>
    </div>

    <!-- members second row -->
    <div class="flex flex-row items-center justify-center px-10 py-10 space-x-10">
        <div class="relative bg-stone-200 rounded-[10px] h-[300px] w-[230px] shadow-custom-button shadow-black border-black
            border-2 p-5 flex flex-col items-center" data-aos="zoom-in-right" data-aos-delay="300" data-aos-duration="1000">
            <div class="h-auto w-auto">
                <img src="/storage/images/pyo.jpg" alt="rabanal" class="mb-6 rounded-full object-cover border-2 border-black">
            </div>
            <h1 class="text-center font-poppins font-black text-lg">
                Maria Fiona <br> Rabanal
            </h1>
        </div>
        <div class="relative bg-stone-200 rounded-[10px] h-[300px] w-[230px] shadow-custom-button shadow-black border-black
            border-2 p-5 flex flex-col items-center" data-aos="zoom-in-right" data-aos-delay="300" data-aos-duration="1000">
            <div class="h-auto w-auto">
                <img src="/storage/images/mireyl.jpg" alt="nulud" class="mb-6 rounded-full object-cover border-2 border-black">
            </div>
            <h1 class="text-center font-poppins font-black text-lg">
                Mireyl Fatima <br> Nulud
            </h1>
        </div>
        <div class="relative bg-stone-200 rounded-[10px] h-[300px] w-[230px] shadow-custom-button shadow-black border-black
            border-2 p-5 flex flex-col items-center" data-aos="zoom-in" data-aos-delay="300" data-aos-duration="1000">
            <div class="h-auto w-auto">
                <img src="/storage/images/ac.jpg" alt="cabang" class="mb-6 rounded-full object-cover border-2 border-black">
            </div>
            <h1 class="text-center font-poppins font-black text-lg">
                Antoinette <br> Cabang
            </h1>
        </div>
        <div class="relative bg-stone-200 rounded-[10px] h-[300px] w-[230px] shadow-custom-button shadow-black border-black
            border-2 p-5 flex flex-col items-center" data-aos="zoom-in-left" data-aos-delay="300" data-aos-duration="1000">
            <div class="h-auto w-auto">
                <img src="/storage/images/cil.jpg" alt="trinidad" class="mb-6 rounded-full object-cover border-2 border-black">
            </div>
            <h1 class="text-center font-poppins font-black text-lg">
                Cecil Rico <br> Trinidad
            </h1>
        </div>
        <div class="relative bg-stone-200 rounded-[10px] h-[300px] w-[230px] shadow-custom-button shadow-black border-black
            border-2 p-5 flex flex-col items-center" data-aos="zoom-in-left" data-aos-delay="300" data-aos-duration="1000">
            <div class="h-auto w-auto">
                <img src="/storage/images/ian.jpg" alt="gonzales" class="mb-6 rounded-full object-cover border-2 border-black">
            </div>
            <h1 class="text-center font-poppins font-black text-lg">
                Ian Joshua <br> Gonzales
            </h1>
        </div>
    </div>

</div>

<script>
    AOS.init();
</script>


</body>
</html>

<!-- footer -->
<x-footer/>