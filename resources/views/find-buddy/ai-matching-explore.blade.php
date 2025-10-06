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
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
</head>
<body class="font-poppins font-semibold bg-secondary">
    
<div class="flex-1">
        <!-- nav bar -->
        <x-nav-bar />
        <!-- find buddy section -->
    {{--  --}}
    @php
        $user = Auth::user();
    @endphp

    @if($user && $user->role === 'Student' && $user->cor_status !== 'verified')
        <div class="flex flex-col items-center justify-center min-h-screen bg-secondary">
            <div class="bg-accent3 border-2 border-black text-black p-10 rounded-2xl shadow-custom-button mt-20 max-w-xl w-full text-center">
                <svg class="mx-auto mb-4" width="60" height="60" fill="none" viewBox="0 0 24 24" stroke="orange">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p class="font-bold text-3xl mb-2">You are not verified yet</p>
                <p class="text-lg mb-4">Please upload your valid Certificate of Registration (COR) to access Explore and matching features.</p>
                <a href="{{ route('workspace.start') }}" class="inline-block border-2 border-black bg-primary text-white font-bold px-6 py-3 rounded-full shadow-custom-button
                 hover:bg-accent2 hover:text-primary transition">Back to Workspace</a>
            </div>
        </div>
    @elseif($user->role === 'Student')

        <form id="BuddyForm" action="{{ route('ai-matching-result') }}" method="POST">
            @csrf
            <div class="flex flex-col items-center justify-center h-4/5 font-dela py-56">
                <div data-aos="fade-up" data-aos-anchor-placement="top-bottom" class="relative text-center space-y-6" >
                    <h1 class="relative z-30 font-bold leading-snug text-center" >
                        <div  class="bg-accent3 inline-block text-[55px] shadow-custom-button text-stroke ml-6 border-2 border-black px-4 py-2 rounded-[10px] transform rotate-[-3deg]">
                            GET MATCHED WITH
                        </div>
                        <img src="{{ asset('images/firstPageSvg/star.svg') }}"
                        class="absolute top-[-30px] left-[23px] w-20 h-20 transform opacity-80 z-10" 
                        alt="Curly Bracket Icon" />
                        <div class="bg-primary text-[75px] shadow-custom-button text-stroke px-2 border-2 border-black mb-2 rounded-[20px] transform rotate-[1deg] mt-5">
                            THE BEST BUDDY
                            <img src="{{ asset('images/firstPageSvg/spark.svg') }}"
                            class="absolute right-[-60px] top-[-10px] transform -translate-y-1/2 w-[100px] h-[100px] z-50" 
                            alt="Curly Bracket Icon" />
                        </div>
                        <div class="inline-block bg-accent2 text-primary text-[70px] shadow-custom-button text-stroke px-6 py-3 border-2 border-black rounded-[20px] transform rotate-[-3deg] leading-none relative">
                            FOR YOU
                        </div>
                    </h1>
                        <img src="{{ asset('images/firstPageSvg/Vector.svg') }}"
                        class="absolute left-[110px] top-[300px] w-[100px] h-[100px] transform opacity-80 z-10" 
                        alt="Curly Bracket Icon" />
                    
                        <img src="{{ asset('images/firstPageSvg/Line 6.svg') }}"
                        class="absolute left-[470px] bottom-[130px] w-[124px] h-[58px] transform opacity-80 z-10" 
                        alt="Curly Bracket Icon" />

                    {{-- find your buddy button --}}
                    <div data-aos="fade-up"
                                data-aos-anchor-placement="top-bottom" class="flex justify-center">
                        <button id="BuddyButton" class="border-2 border-black bg-accent2 text-black font-bold mt-20 px-4 py-4 rounded-full shadow-custom-button transform active:scale-95 transition duration-300 hover:scale-105">
                            <p class="text-[40px] px-8">FIND YOUR BUDDY</p>
                        </button>
                    </div>
                </div>
                {{-- loader --}}
                <div id="loader" class="hidden flex flex-col justify-center items-center mt-12">
                    <svg width="60" height="60" fill="rgb(107 114 128)" class="mr-2 animate-spin" viewBox="0 0 1792 1792" xmlns="http://www.w3.org/2000/svg">
                        <path d="M526 1394q0 53-37.5 90.5t-90.5 37.5q-52 0-90-38t-38-90q0-53 37.5-90.5t90.5-37.5 90.5 37.5 37.5 90.5zm498 206q0 53-37.5 90.5t-90.5 37.5-90.5-37.5-37.5-90.5 37.5-90.5 90.5-37.5 90.5 37.5 37.5 90.5zm-704-704q0 53-37.5 90.5t-90.5 37.5-90.5-37.5-37.5-90.5 37.5-90.5 90.5-37.5 90.5 37.5 37.5 90.5zm1202 498q0 52-38 90t-90 38q-53 0-90.5-37.5t-37.5-90.5 37.5-90.5 90.5-37.5 90.5 37.5 37.5 90.5zm-964-996q0 66-47 113t-113 47-113-47-47-113 47-113 113-47 113 47 47 113zm1170 498q0 53-37.5 90.5t-90.5 37.5-90.5-37.5-37.5-90.5 37.5-90.5 90.5-37.5 90.5 37.5 37.5 90.5zm-640-704q0 80-56 136t-136 56-136-56-56-136 56-136 136-56 136 56 56 136zm530 206q0 93-66 158.5t-158 65.5q-93 0-158.5-65.5t-65.5-158.5q0-92 65.5-158t158.5-66q92 0 158 66t66 158z">
                        </path>
                    </svg>
                    
                    <div class="font-bold font-poppins text-gray-500 mt-8 text-[18px]">
                        Searching for your perfect buddy...
                    </div>

                    <div class="font-bold font-poppins text-gray-500 mt-4 text-[18px]">
                        Analyzing your needs...
                    </div>

                </div>
            </div>
        </form>
    @else
        <div class="bg-accent3 inline-block text-[55px] shadow-custom-button text-stroke ml-6 border-2 border-black px-4 py-2 rounded-[10px] transform rotate-[-3deg]">
                            Not Available for Tutors
        </div>
    @endif
</div>

<script>

    document.getElementById('BuddyButton').addEventListener('click', function() {
        event.preventDefault(); // prevent default form submission to simulate lang the loading

        // para lumitaw loader
        const loader = document.getElementById('loader');
        loader.classList.remove('hidden');

        // para ano di pwede pindutin multiple times
        this.disable = true;

        // wait time
        // subject to change pag may wifi na
        const delay = 3000;
        setTimeout(() => {
            document.getElementById('BuddyForm').submit();
        }, delay);
    });
    
    AOS.init();
</script>

</body>
</html>