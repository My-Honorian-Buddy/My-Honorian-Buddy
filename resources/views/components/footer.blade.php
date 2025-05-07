<!-- Footer -->
@php
$user = null;

if (Auth::check()) {
    $user = Auth::user() ?? null;
}
@endphp
<footer class="bg-secondary text-black mt-0 relative">
    <div class="border-t border-black mx-0 px-0"></div>
    
    {{-- Main contents --}}
    <div class="grid grid-cols-2 mx-[100px] my-[80px]">
        <div class="flex flex-col items-start space-y-4 ">
            <div class="text-[20px] sm:text-lg md:text-xl lg:text-2xl">
                <p class="font-semibold text-primary mb-8">
                    Your Path to the Perfect Buddy <br/>
                    and a Better Learning Experience.
                </p>
            </div>
            @if ($user !== null)
                <div class="mt-8 flex flex-wrap justfify-center sm:space-x-4 md:space-x-8 text-primary font-black z-20">
                    <a href="{{ route('workspace.start') }}" class="hover:underline text-[16px] sm:text-[13px] md:text-[15px] lg:text-[22px]">Workspace</a>
                    @if ($user -> role === 'Student')
                        <a href="{{ route('match.explore') }}" class="hover:underline text-[16px] sm:text-[13px] md:text-[15px] lg:text-[22px]">Explore</a>
                    @else
                        <a href="{{ route('tutor.search') }}" class="hover:underline text-[16px] sm:text-[13px] md:text-[15px] lg:text-[22px]">Explore</a>
                    @endif
                    <a href="{{ route('about') }}" class="hover:underline text-[16px] sm:text-[13px] md:text-[15px] lg:text-[22px]">About us</a>
                </div>
            @else
                <div class="mt-8 flex flex-wrap justfify-center sm:space-x-4 md:space-x-8 text-primary font-black z-20">
                    <a href="{{ route('login') }}" class="hover:underline text-[16px] sm:text-[13px] md:text-[15px] lg:text-[22px]">Workspace</a>

                    <a href="{{ route('login') }}" class="hover:underline text-[16px] sm:text-[13px] md:text-[15px] lg:text-[22px]">Explore</a>

                    <a href="{{ route('login') }}" class="hover:underline text-[16px] sm:text-[13px] md:text-[15px] lg:text-[22px]">About us</a>
                </div>
            @endif
            <!-- Footer Copyright text-->
            <p class="mt-1 md:text-[15px] lg:text-[15px] sm:text-[15px] text-primary font-black">
                ©2024 My Honorian Buddy. All rights reserved.
            </p>
        </div>
        
        <div class="flex justify-end text-right mr-5 sm:text-lg md:mr-10 md:text-xl lg:text-xl xl:text-3xl space-y-4">
            <div class="flex flex-col items-end">
                <p class="text-lg text-black-600 font-bold">
                Got questions? We’re here to help!
                </p>

                {{-- address, gmail, contact --}}
                <address class="not-italic mt-2 text-[15px]">   
                    <i>Cabambangan, Bacolor, Pampanga</i> <br/>
                    <a href="mailto:myhonorianbuddy@gmail.com" class="hover:underline">
                        <i>myhonorianbuddy@gmail.com</i>
                    </a> <br/>
                    <i>+63 (987) 654-321</i>
                </address>

                {{-- social media --}}
                <div class="mt-4 flex justify-end space-x-4 z-20">
                    {{-- instagram --}}
                    <div class="flex items-center justify-center w-12 h-12 cursor-pointer">
                        <a href="https://www.instagram.com/">
                            <img src="{{ asset('images/instagram.svg') }}" alt="myhonorianbuddy" class="object-cover w-full h-full">
                        </a>
                    </div>
                    {{-- facebook --}}
                    <div class="flex items-center justify-center w-12 h-12 cursor-pointer">
                        <a href="https://www.facebook.com/">
                            <img src="{{ asset('images/facebook.svg') }}" alt="myhonorianbuddy" class="object-cover w-full h-full">
                        </a>
                    </div>
                    {{-- twitter --}}
                    <div class="flex items-center justify-center w-12 h-12 cursor-pointer">
                        <a href="https://x.com/">
                            <img src="{{ asset('images/x.svg') }}" alt="myhonorianbuddy" class="object-cover w-full h-full">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Wide logo --}}
    <div class="relative h-64 pointer-events-none">
        <div class="absolute inset-0 flex justify-center items-center">
            <img src="{{ asset('images/footerlogo.svg') }}" alt="Footer Logo" class="object-contain w-full md:w-auto md:h-full">
        </div>
    </div>
</footer>

{{-- <style>
    footer  {
        height: 450px; 
    }
</style> --}}

{{-- <div class="container mx-auto mt-[-125px] sm:mt-[-60px] md:mb-[-100px] text-center relative h-64 sm:h-40 md:h-56 z-20">
    <div class="relative w-full h-auto aspect-w-16 aspect-h-9 mt-0 p-0">
        <img src="{{ asset('images/footerlogo.svg') }}" alt="myhonorianbuddy" class="object-contain w-full h-full -z-40">
    </div>
</div> --}}