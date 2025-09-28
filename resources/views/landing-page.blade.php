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
    <link rel="icon" href="{{ asset('/images/favicon.svg') }}" type="image/x-icon">
    <link href="{{ asset('vendor/bladewind/css/bladewind-ui.min.css') }}" rel="stylesheet" />
    <link href="/public/images/myHonorianBuddy.ico" type="image/x-icon">
    <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
    />
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="{{ asset('vendor/bladewind/js/helpers.js') }}"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <link rel="icon" href="{{ asset('/images/favicon.svg') }}" type="image/x-icon">
    
    <x-bladewind::notification />
</head>

{{-- First Page --}}

<body class="font-poppins font-semibold antialiased">
    <div class="w-full h-auto bg-accent3 ">
        <header class="grid grid-cols-2 items-center gap-2 p-5 py-12 lg:grid-cols-2 border-b-[1px] border-black mb-[-3%]" >
            <div class="flex justify-center pl-4">
                <img src="{{ asset('images/logo.svg') }}" alt="My Honorian Buddy logo" class="w-2/12">
            </div>
            @if (Route::has('login'))
                <nav class="-mx-3 flex flex-1 gap-[72px] text-[24px] justify-center pr-5">
                @if (Auth::check())
                    <a
                        href="{{ route('workspace.start') }}"
                        class="border-2 border-black shadow-custom-button rounded-md px-3 py-2 text-black font-black ring-1 ring-transparent transition hover:bg-accent2 hover:text-primary active:scale-95 hover:scale-[1.1]"
                    >
                        WORKSPACE
                    </a>
                @else
                    <a
                        href="{{ route('login') }}"
                        class="border-2 border-black shadow-custom-button rounded-md px-3 py-2 text-primary bg-secondary font-black ring-1 ring-transparent transition hover:bg-primary hover:text-accent2 active:scale-95 hover:scale-[1.1]"
                    >
                        LOG IN
                    </a>

                        @if (Route::has('register'))
                            <a
                                href="{{ route('register') }}"
                                class="border-2 border-black bg-primary shadow-custom-button rounded-md px-3 py-2 text-accent2 font-black ring-1 ring-transparent transition hover:bg-secondary active:scale-95 hover:text-primary hover:scale-[1.1] "
                            >
                                SIGN UP
                            </a>
                        @endif
                @endif
                </nav>
            
                
            @endif
                
        </header>
            
            <div class="flex flex-col items-center justify-center h-4/5 font-dela ml-[-20%] py-56">
                <div class="relative text-center space-y-6" >
                    <h1 class="relative z-30 animate__animated animate__fadeInLeft text-[64px] font-bold leading-snug text-left" >
                        YOUR STUDY  
                        <img src="{{ asset('images/firstPageSvg/star.svg') }}"
                        class="absolute top-[-25px] left-[550px] w-20 h-20 transform opacity-80 z-10" 
                        alt="Curly Bracket Icon" /> <br>
                        <div class="  bg-primary text-[96px] shadow-custom-button text-stroke px-2 py-1 border-2 border-black mb-6 rounded-[20px] transform rotate-[-3deg]">
                            ADVENTURE
                        </div> 
                        BEGINS <span class="text-accent2 drop-shadow-custom-drop-shadow text-stroke">HERE!</span>
                            <img src="{{ asset('images/firstPageSvg/spark.svg') }}"
                            class="absolute w-[100px] bottom-[30px] right-[140px] h-[100px] transform z-50" 
                            alt="Curly Bracket Icon" />
                    </h1>
                        <img src="{{ asset('images/firstPageSvg/Vector.svg') }}"
                        class="absolute bottom-[10px] left-[-90px] w-[100px] h-[100px] transform opacity-80 z-10" 
                        alt="Curly Bracket Icon" />
                    <div class="flex justify-start">
                        <a href=" # " class="border-2 border-black bg-[#fdd835] text-black font-bold px-4 py-2 rounded-md shadow-custom-button transform active:scale-95 transition duration-300 hover:scale-105">
                            LEARN MORE
                        </a>
                        <img src="{{ asset('images/firstPageSvg/Line 6.svg') }}"
                        class="absolute left-[400px] bottom-[10px] w-[124px] h-[58px] transform opacity-80 z-10" 
                        alt="Curly Bracket Icon" />
                    </div>

                    <div class="absolute top-[-100px] right-[-360px] space-y-4 z-0" data-aos="fade-left" data-aos-delay="300" data-aos-duration="1500">
                        <img src="/storage/images/glasses-notebook.png"
                    </div>
                </div>
            </div>
        
    </div>


    <div class="h-[86px] overflow-hidden bg-primary font-dela  text-stroke">
        <div class="animate-marquee whitespace-nowrap flex h-full items-center space-x-8">
            <span class="text-secondary font-bold text-[40px]">FIND YOUR BUDDY</span>
            <span class="text-yellow-400 text-2xl">☀️</span>
            <span class="text-secondary font-bold text-[40px]">FIND YOUR BUDDY</span>
            <span class="text-yellow-400 text-2xl">☀️</span>
            <span class="text-secondary font-bold text-[40px]">FIND YOUR BUDDY</span>
            <span class="text-yellow-400 text-2xl">☀️</span>
            <span class="text-secondary font-bold text-[40px]">FIND YOUR BUDDY</span>
            <span class="text-yellow-400 text-2xl">☀️</span>
            <span class="text-secondary font-bold text-[40px]">FIND YOUR BUDDY</span>
            <span class="text-yellow-400 text-2xl">☀️</span>
            <span class="text-secondary font-bold text-[40px]">FIND YOUR BUDDY</span>
            <span class="text-yellow-400 text-2xl">☀️</span>
            <span class="text-secondary font-bold text-[40px]">FIND YOUR BUDDY</span>
            <span class="text-yellow-400 text-2xl">☀️</span>
            <span class="text-secondary font-bold text-[40px]">FIND YOUR BUDDY</span>
            <!-- Repeat as needed for the marquee effect -->
        </div>
    </div>

{{-- second Page --}}

    <div class="relative h-auto bg-accent2">
        <div class="relative" >
            <div class="flex flex-col items-start w-auto h-auto pt-[7%] pl-[7%] text-[64px] font-dela" data-aos="fade-right" data-aos-delay="300" data-aos-duration="1500">
                <div class=" flex rounded-[20px] w-auto px-8 p-1 bg-accent3
                text-primary text-stroke border-2 border-black shadow-custom-button
                transform rotate-[-3deg]" >
                    BUDDY SYSTEM
                </div>

                <div class="flex items-center justify-center pl-6 mt-2 space-x-2">
                    <div class="relative mt-4">
                        <div class="relative w-24 h-24 bg-secondary border-2 rounded-full flex top-[-1rem] z-10 right-[-1rem]
                        border-black items-center justify-center">
                            <span class="text-xl font-bold text-gray-900">FOR</span>
                        </div>
                    </div>
        
                    
            
                    <h2 class="bg-primary text-accent2 text-stroke border-2 border-black shadow-custom-button
                        transform rotate-[3deg] rounded-[20px] px-4 p-1">BRIGHTER MINDS
                    </h2>

                    

                </div>
                
                
            </div>
        
                <img src="{{ asset('images/firstPageSvg/Vector.svg') }}"
                    class="absolute w-[100px] left-[50px] top-[300px] h-[100px] transform z-0" 
                    alt="Curly Bracket Icon" />

                <img src="{{ asset('images/firstPageSvg/spark.svg') }}"
                        class="absolute w-[200px] left-[950px] top-[160px] h-[200px] transform z-0" 
                        alt="Curly Bracket Icon" />

                <img src="{{ asset('images/firstPageSvg/Line 6.svg') }}"
                    class="absolute w-[100px] left-[850px] top-[360px] h-[100px] transform z-0" 
                    alt="Curly Bracket Icon" />
            
            <div class="absolute top-10 right-10">
                <div class="grid grid-cols-2 w-[200px] h-auto">
                    <div>
                        <img src="{{ asset('images/secondPageSvg/Group 43.svg') }}"
                        class=" w-[100px]  h-[100px] transform z-0" 
                        alt="Curly Bracket Icon" />
                    </div>
                    <div>
                        <img src="{{ asset('images/secondPageSvg/Ellipse 7.svg') }}"
                        class=" w-[100px]  h-[100px] transform z-0" 
                        alt="Curly Bracket Icon" />
                    </div>
                    <div class="animate-spin">
                        <img src="{{ asset('images/secondPageSvg/Ellipse 8.svg') }}"
                        class=" w-[100px]  h-[100px] transform z-0" 
                        alt="Curly Bracket Icon" />
                    </div>
                    <div>
                        <img src="{{ asset('images/secondPageSvg/Group 44.svg') }}"
                        class=" w-[100px] h-[100px] transform z-0" 
                        alt="Curly Bracket Icon" />
                    </div>
                </div>
            </div>
        </div>

        <div class="p-16 ">
            <div class="h-[510px] w-[705px] border-2 border-black rounded-[20px] ml-16 mb-8 shadow-custom-button bg-secondary" data-aos="fade-right" data-aos-delay="300" data-aos-duration="1500">
                <div class="flex gap-2 pl-8 items-center rounded-t-[20px] border-b-2 border-black w-full h-[15%] bg-primary">
                    <div class="w-8 h-8 bg-secondary rounded-full border-2 border-black "></div>
                    <div class="w-8 h-8 bg-accent2 rounded-full border-2 border-black "></div>
                    <div class="w-8 h-8 bg-accent3 rounded-full border-2 border-black "></div>
                </div>
                <div class="h-[85%] flex items-center justify-center ">
                    <div class="animate_animated animate__fadeInDown flex flex-col w-4/5 h-full py-6">
                        <h2 class="font-poppins font-black text-[64px]">Our Purpose</h2>
                        <p class="pt-1 font-semibold text-[20px]">
                            Empowering every student of Don Honorio Ventura State University 
                            to reach their academic potential through collaborative
                            learning, innovative AI, and supportive connections. At My Honorian Buddy, we
                            believe in creating space where students can find personalized support, expand their 
                            knowledge, and grow together.
                        </p>
                        <a class="flex items-center justify-center font-black mt-8 bg-accent2 self-end rounded-[15px] hover:cursor-pointer
                        text-black-800 text-[20px] w-auto py-3 px-6 border-2 border-black shadow-custom-button transition transform hover:scale-[1.1] ">
                            READ MORE
                        </a>
                    </div>
                </div>
            </div>
            <div class="absolute bottom-[80px] right-[100px] " data-aos="fade-left">
                <img src="{{ asset('images/gears.svg') }}" alt="Shape SVG">
            </div>
        </div>
        </div>
    </div>

    

    <div class="h-[86px] overflow-hidden bg-black font-dela  text-stroke">
        <div class="animate-reverse_marquee whitespace-nowrap flex h-full items-center space-x-8">
            <span class="text-accent2 font-bold text-[40px]">BRIGHTER MINDS</span>
            <span class="text-secondary text-2xl">☀️</span>
            <span class="text-accent2 font-bold text-[40px]">BRIGHTER MINDS</span>
            <span class="text-secondary text-2xl">☀️</span>
            <span class="text-accent2 font-bold text-[40px]">BRIGHTER MINDS</span>
            <span class="text-secondary text-2xl">☀️</span>
            <span class="text-accent2 font-bold text-[40px]">BRIGHTER MINDS</span>
            <span class="text-secondary text-2xl">☀️</span>
            <span class="text-accent2 font-bold text-[40px]">BRIGHTER MINDS</span>
            <span class="text-secondary text-2xl">☀️</span>
            <span class="text-accent2 font-bold text-[40px]">BRIGHTER MINDS</span>
            <span class="text-secondary text-2xl">☀️</span>
            <span class="text-accent2 font-bold text-[40px]">BRIGHTER MINDS</span>
            <span class="text-secondary text-2xl">☀️</span>
            <span class="text-accent2 font-bold text-[40px]">BRIGHTER MINDS</span>
            <!-- Repeat as needed for the marquee effect -->
        </div>
    </div>
    

    {{-- Third Page --}}
    <div class="flex flex-col h-screen  bg-secondary">
        <div class="flex items-center py-20 justify-center h-[550px] w-full">
            <div class="relative h-auto w-4/5 " data-aos="fade-up">
                <div>
                    <img src="{{ asset('images/stars.svg') }}"
                        class="w-[182px] h-[70px] transform z-0" 
                        alt="Curly Bracket Icon" />
                </div>
                <div class="relative z-50 py-2 font-black text-[64px] text-center "> 
                    DESIGNED TO 
                    <span class="font-dela text-primary text-stroke bg-accent2 px-6 py-1 rounded-full border-2
                    border-black shadow-custom-button">
                        CONNECT,
                    </span>
                    
                    

                </div>
                    <img src="{{ asset('images/firstPageSvg/spark.svg') }}"
                    class="absolute right-[175px] top-[-30px] w-[200px] h-[200px] transform z-0" 
                    alt="Curly Bracket Icon" />

                <div class="py-2 font-black text-[64px] text-center "> 
                    
                    

                    <span class=" mr-4 font-dela text-primary text-stroke bg-accent2 px-6 py-1 rounded-full border-2
                    border-black shadow-custom-button">
                        COLLABORATE,
                    </span>
                        AND
                </div>
                <div class="relative z-50 py-2 font-black text-[64px] text-center "> 
                    <span class=" mr-4 font-dela text-primary text-stroke bg-accent2 px-6 py-1 rounded-full border-2
                    border-black shadow-custom-button">
                        COMPLETE
                    </span>
                    

                        YOUR GOALS 
                </div>
                    <img src="{{ asset('images/firstPageSvg/spark.svg') }}"
                        class="absolute left-[155px] bottom-[-30px] w-[200px] h-[200px] transform rotate-180 z-0" 
                        alt="Curly Bracket Icon" />

                <div class="flex items-center justify-end">
                    <img src="{{ asset('images/stars.svg') }}"
                        class="w-[182px] h-[70px] transform z-0" 
                        alt="Curly Bracket Icon" />
                </div>
            </div>
        </div>
        <div class="flex-1 flex justify-evenly bg-secondary items-center p-20">
            <div class="h-[500px] w-[355px]">
            <div class="group [perspective:1000px]" data-aos="fade-up" data-aos-easing="ease-in-back" data-aos-delay="100" data-aos-duration="1500" data-aos-offset="0">
                <div class="relative shadow-maroon-shadow rounded-[20px] h-[500px] w-[355px] transition-all duration-500 [transform-style:preserve-3d] 
                group-hover:[transform:rotateY(180deg)] border-2 border-black">
                    <div class="backface-hidden absolute flex flex-col h-full w-full items-center justify-center bg-pointedGrid bg-center bg-accent3
                    text-white rounded-[20px]">
                        <img src="{{ asset('images/3.svg') }}" alt="placeholder" class="max-w-full h-auto mt-8">
                        <h1 class="mt-2 text-center drop-shadow-custom-drop-shadow-small text-accent2 text-[32px] font-black text-stroke">
                            AI-POWERED <br> MATCHMAKING
                        </h1>
                    </div>
                    <div class="backface-hidden rounded-[20px] absolute flex flex-col h-full w-full items-center justify-center bg-accent3 text-white
                    [transform:rotateY(180deg)] [backface-visibility:hidden]">
                        <p class="w-4/5 text-black text-center text-[24px] font-black">
                            Find the perfect study buddy with AI-powered matching that understands your learning style and academic needs.
                        </p>
                        <a 
                        class="flex items-center justify-center font-black mt-8 bg-accent2 rounded-[15px] hover:cursor-pointer
                        text-black pointer text-[20px] w-auto py-3 px-6 border-2 border-black transition shadow-maroon-shadow
                        hover:scale-[1.1] ">
                            TRY IT NOW
                        </a>
                    
                    </div>
                </div>
            </div>
            </div>

            <div class="h-[500px] w-[355px]">
            <div class="group [perspective:1000px]" data-aos="fade-up" data-aos-easing="ease-in-back" data-aos-delay="200" data-aos-duration="1500" data-aos-offset="0">
                <div class="relative shadow-maroon-shadow rounded-[20px] h-[500px] w-[355px] transition-all duration-500 [transform-style:preserve-3d] 
                group-hover:[transform:rotateY(180deg)] border-2 border-black">
                    <div class="backface-hidden absolute flex flex-col h-full w-full items-center justify-center bg-pointedGrid bg-accent3
                    text-white rounded-[20px]">
                        <img src="{{ asset('images/2.svg') }}" alt="placeholder" class="max-w-full h-auto mt-8">
                        <h1 class="mt-2 text-center drop-shadow-custom-drop-shadow-small text-accent2 text-[32px] font-black text-stroke">
                            REAL-TIME <br>   CHAT
                        </h1>
                    </div>
                    <div class="backface-hidden rounded-[20px] absolute flex flex-col h-full w-full items-center justify-center bg-accent3 text-white
                    [transform:rotateY(180deg)] [backface-visibility:hidden]">
                        <p class="w-4/5 text-black text-center text-[24px] font-black">
                            Connect instantly with your buddy to share ideas, resources, and support whenever you need it.
                        </p>
                        <a class="flex items-center justify-center font-black mt-8 bg-accent2 rounded-[15px] hover:cursor-pointer
                        text-black text-[20px] w-auto py-3 px-6 border-2 border-black transition shadow-maroon-shadow
                        hover:scale-[1.1] ">
                            START CHATTING
                        </a>
                        
                    </div>
                </div>
            </div>
            </div>
            

            <div class="h-[500px] w-[355px]">
            <div class="group [perspective:1000px]" data-aos="fade-up" data-aos-easing="ease-in-back" data-aos-delay="300" data-aos-duration="1500" data-aos-offset="0">
                <div class="relative shadow-maroon-shadow rounded-[20px] h-[500px] w-[355px] transition-all duration-500 [transform-style:preserve-3d] 
                group-hover:[transform:rotateY(180deg)] border-2 border-black">
                    <div class="backface-hidden absolute flex flex-col h-full w-full items-center justify-center bg-pointedGrid bg-accent3
                            text-white rounded-[20px]">
                        <img src="{{ asset('images/1.svg') }}" alt="placeholder" class="max-w-full h-auto mt-8">
                        <h1 class=" mt-2 text-center drop-shadow-custom-drop-shadow-small text-accent2 text-[32px] font-black text-stroke">
                            VIDEO <br> CONFERENCING
                        </h1>
                    </div>
                    <div class="backface-hidden rounded-[20px] absolute flex flex-col h-full w-full items-center justify-center bg-accent3 text-white
                    [transform:rotateY(180deg)] [backface-visibility:hidden]">
                        <p class="w-4/5 text-black text-center text-[24px] font-black">
                            Seamless video calls for collaborative study sessions, so you can tackle your goals together in real-time.
                        </p>
                        <a class="flex items-center justify-center font-black mt-8 bg-accent2 rounded-[15px] hover:cursor-pointer
                        text-black text-[20px] w-auto py-3 px-6 border-2 border-black transition shadow-maroon-shadow
                        hover:scale-[1.1] ">
                            SCHEDULE A CALL
                        </a>

                    </div>
                </div>
            </div>
            </div>
        </div>
    <div>
        <x-footer/>
    </div>
    </div>
    
    
    <script>
        AOS.init();
    </script>
</body>

</html>