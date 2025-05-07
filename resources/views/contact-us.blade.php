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
        
        <!-- main content -->
        <div class="grid lg:grid-cols-2 gap-8 m-[100px]">
            <!-- got questions | column 1 -->
            <div class="grid 2xl:grid-cols-2 lg:border-black border-r-2 mt-8">
                <!-- picture -->
                <div class="w-3/4 ml-14 flex justify-center">
                    <img src="{{ asset('images/contactus.svg') }}">
                </div>
                <!-- got question -->
                <div class="font-black xl:text-start text-center xl:ml-[-130px] mt-[50px]">
                    <div class="text-4xl mt-3">
                        Got questions?
                    </div>

                    <div class="text-6xl mt-3">
                        REACH OUT
                    </div>

                    <div class="text-6xl mt-3">
                        TO US!
                    </div>
                </div>
            </div>
            
            <!-- form | column 2 -->
            <form action="">
                <div class="font-poppins font-bold mt-6 lg:ml-8 mb-10">
                    <p class="text-[18px]">Name:</p>
                    <input type="text" class="w-full mb-4 rounded-md bg-gray-300">
                    <p class="text-[18px]">Email:</p>
                    <input type="email" class="w-full mb-4 rounded-md bg-gray-300">
                    <p class="text-[18px]">Address:</p>
                    <input type="text" class="w-full mb-4 rounded-md bg-gray-300">
                    <p class="text-[18px]">Mobile Number:</p>
                    <input type="text" class="w-full mb-4 rounded-md bg-gray-300">
                </div>
        </div>

                {{-- concerns --}}
                <div class="mx-[100px] -mt-[60px]">
                    <label for="concerns" class="text-[18px] font-poppins font-bold">Concerns:</label>
                    <textarea id="concerns" rows="4" class="w-full px-3 py-2 border border-black rounded-md bg-gray-300"></textarea>
                </div>
                {{-- submit button --}}
                <div class="mx-[100px]  flex justify-end">
                    <div class="inline-block justify-self-end bg-primary font-accent2 px-2 py-2 rounded-full border-2 border-black shadow-custom-button mt-8 mb-1 text-[22px] text-accent2 text-center font-bold cursor-pointer hover:bg-[#FFECEC] hover:text-[#8B3A3A]">
                        <button type="submit" class="px-5">SUBMIT</button>
                    </div>
                </div>
            </form>
            
        {{-- info details --}}
        <div class="grid grid-cols-2 mx-[100px] my-[80px]">
            {{-- socials | column 1 --}}
            <div class="flex flex-col items-start space-y-4 ">
                {{-- instagram --}}
                <div class="flex items-center space-x-4 text-[18px]">
                    <div class="flex items-center justify-center w-12 h-12">
                        <a href="#">
                            <img src="{{ asset('images/instagram.svg') }}" alt="myhonorianbuddy" class="object-cover w-full h-full">
                        </a>
                    </div>
                    <p class="font-poppins font-semibold">@myhonorianbuddy</p>
                </div>
                {{-- facebook --}}
                <div class="flex items-center space-x-4 text-[18px]">
                    <div class="flex items-center justify-center w-12 h-12">
                        <a href="#">
                            <img src="{{ asset('images/facebook.svg') }}" alt="myhonorianbuddy" class="object-cover w-full h-full">
                        </a>
                    </div>
                    <p class="font-poppins font-semibold">My Honorian Buddy</p>
                </div>
                {{-- twitter --}}
                <div class="flex items-center space-x-4 text-[18px]">
                    <div class="flex items-center justify-center w-12 h-12">
                        <a href="#">
                            <img src="{{ asset('images/x.svg') }}" alt="myhonorianbuddy" class="object-cover w-full h-full">
                        </a>
                    </div>
                    <p class="font-poppins font-semibold">@myhonorianbuddy</p>
                </div>
            </div>
            {{-- column 2 --}}
            <div class="flex flex-col items-end space-y-4 mr-5 mt-3 sm:text-lg md:text-xl lg:text-xl xl:text-3xl">
                {{-- address --}}
                <div class="flex items-center text-right space-x-4 text-[16px] sm:text-[18px] md:text-[20px] lg:text-[22px]">
                    <p class="font-poppins font-semibold ">Cabambangan, Bacolor, Pampanga</p>
                    <a href="#">
                        <img src="{{ asset('images/home.svg') }}" alt="icon1" class="w-8 h-8 sm:w-10 sm:h-10 md:w-12 md:h-12">
                    </a>
                </div>
                {{-- email --}}
                <div class="flex items-center text-right space-x-4 text-[16px] sm:text-[18px] md:text-[20px] lg:text-[22px]">
                    <p class="font-poppins font-semibold">My Honorian Buddy</p>
                    <a href="#">
                        <img src="{{ asset('images/mail.svg') }}" alt="icon2" class="w-8 h-8 sm:w-10 sm:h-10 md:w-12 md:h-12">
                    </a>
                </div>
                {{-- contact num --}}
                <div class="flex items-center text-right space-x-4 text-[16px] sm:text-[18px] md:text-[20px] lg:text-[22px]">
                    <p class="font-poppins font-semibold">+63 (987) 654-321</p>
                    <a href="#">
                        <img src="{{ asset('images/phone.svg') }}" alt="icon3" class="w-8 h-8 sm:w-10 sm:h-10 md:w-12 md:h-12">
                    </a>
                </div>
            </div>
        </div>

    </div>   
</body>

{{-- footer --}}
<x-footer/>

</html>