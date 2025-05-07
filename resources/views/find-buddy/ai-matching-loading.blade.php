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

</head>
<body class="font-poppins font-semibold bg-secondary">
    
<div class="flex-1">
        <!-- nav bar -->
        <x-nav-bar />
        <!-- find buddy section -->
        <form action="">
            <div class="flex flex-col items-center justify-center h-4/5 font-dela py-56">
                <div class="relative text-center space-y-6" >
                    <h1 class="relative z-30 font-bold leading-snug text-center" >
                        <div class="bg-accent inline-block text-[50px] shadow-custom-button text-stroke ml-6 border-2 border-black px-4 py-2 rounded-[10px] transform rotate-[-3deg]">
                            GET MATCHED WITH
                        </div>
                        <img src="{{ asset('images/firstPageSvg/star.svg') }}"
                        class="absolute top-[-30px] left-[50px] w-20 h-20 transform opacity-80 z-10" 
                        alt="Curly Bracket Icon" />
                        <div class="bg-primary text-[75px] shadow-custom-button text-stroke px-2 border-2 border-black mb-2 rounded-[20px] transform rotate-[1deg] mt-5">
                            THE BEST BUDDY
                            <img src="{{ asset('images/firstPageSvg/spark.svg') }}"
                            class="absolute right-[-60px] top-[-10px] transform -translate-y-1/2 w-[100px] h-[100px] z-50" 
                            alt="Curly Bracket Icon" />
                        </div>
                        <div class="inline-block bg-accent2 text-primary text-[70px] shadow-custom-button text-stroke px-6 py-3 border-2 border-black rounded-[20px] transform rotate-[-3deg] leading-none">
                            FOR YOU
                        </div>
                    </h1>
                        <img src="{{ asset('images/firstPageSvg/Vector.svg') }}"
                        class="absolute left-[110px] top-[300px] w-[100px] h-[100px] transform opacity-80 z-10" 
                        alt="Curly Bracket Icon" />

                    {{-- find your buddy button --}}
                    <div class="flex justify-center">
                        <button class="border-2 border-black bg-accent text-black font-bold mt-20 px-4 py-4 rounded-full shadow-custom-button transform active:scale-95 transition duration-300 hover:scale-105">
                            <p class="text-[40px] px-8">FIND YOUR BUDDY</p>
                        </button>
                    </div>
                </div>
            </div>
        </form>

        
</div>


</body>
</html>