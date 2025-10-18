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
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 px-6 md:px-16 lg:px-[100px] py-10 md:py-[80px]">
        <div class="flex flex-col items-start space-y-4">
            <div class="text-lg sm:text-xl md:text-2xl lg:text-3xl">
                <p class="font-semibold text-primary mb-6 md:mb-8">
                    Your Path to the Perfect Buddy <br />
                    and a Better Learning Experience.
                </p>
            </div>
            @if ($user !== null)
                <div
                    class="mt-6 md:mt-8 flex flex-wrap justify-center sm:space-x-4 md:space-x-8 text-primary font-black z-20">
                    <a href="{{ route('workspace.start') }}"
                        class="hover:underline text-base sm:text-sm md:text-base lg:text-xl">Workspace</a>
                    @if ($user->role === 'Student')
                        <a href="{{ route('match.explore') }}"
                            class="hover:underline text-base sm:text-sm md:text-base lg:text-xl">Explore</a>
                    @else
                        <a href="{{ route('tutor.search') }}"
                            class="hover:underline text-base sm:text-sm md:text-base lg:text-xl">Explore</a>
                    @endif
                    <a href="{{ route('about') }}"
                        class="hover:underline text-base sm:text-sm md:text-base lg:text-xl">About us</a>
                </div>
            @else
                <div
                    class="mt-6 md:mt-8 flex flex-wrap justify-center sm:space-x-4 md:space-x-8 text-primary font-black z-20">
                    <a href="{{ route('login') }}"
                        class="hover:underline text-base sm:text-sm md:text-base lg:text-xl">Workspace</a>
                    <a href="{{ route('login') }}"
                        class="hover:underline text-base sm:text-sm md:text-base lg:text-xl">Explore</a>
                    <a href="{{ route('login') }}"
                        class="hover:underline text-base sm:text-sm md:text-base lg:text-xl">About us</a>
                </div>
            @endif
            <!-- Footer Copyright text-->
            <p class="mt-2 text-sm md:text-base lg:text-lg text-primary font-black">
                ©2024 My Honorian Buddy. All rights reserved.
            </p>
        </div>

        <div class="flex justify-end text-right mr-0 md:mr-5 lg:mr-10 space-y-4">
            <div class="flex flex-col items-end">
                <p class="text-base md:text-lg lg:text-xl text-black-600 font-bold">
                    Got questions? We're here to help!
                </p>

                {{-- address, gmail, contact --}}
                <address class="not-italic mt-2 text-sm md:text-base lg:text-lg">
                    <i>Cabambangan, Bacolor, Pampanga</i> <br />
                    <a href="mailto:myhonorianbuddy@gmail.com" class="hover:underline">
                        <i>myhonorianbuddy@gmail.com</i>
                    </a> <br />
                    <i>+63 (987) 654-321</i>
                </address>

                {{-- social media --}}
                <div class="mt-4 flex justify-end space-x-3 md:space-x-4 z-20">
                    {{-- instagram --}}
                    <div class="flex items-center justify-center w-8 h-8 md:w-12 md:h-12 cursor-pointer">
                        <a href="https://www.instagram.com/">
                            <img src="{{ asset('images/instagram.svg') }}" alt="myhonorianbuddy"
                                class="object-cover w-full h-full">
                        </a>
                    </div>
                    {{-- facebook --}}
                    <div class="flex items-center justify-center w-8 h-8 md:w-12 md:h-12 cursor-pointer">
                        <a href="https://www.facebook.com/">
                            <img src="{{ asset('images/facebook.svg') }}" alt="myhonorianbuddy"
                                class="object-cover w-full h-full">
                        </a>
                    </div>
                    {{-- twitter --}}
                    <div class="flex items-center justify-center w-8 h-8 md:w-12 md:h-12 cursor-pointer">
                        <a href="https://x.com/">
                            <img src="{{ asset('images/x.svg') }}" alt="myhonorianbuddy"
                                class="object-cover w-full h-full">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Wide logo --}}
    <div class="relative h-32 sm:h-40 md:h-56 lg:h-64 pointer-events-none">
        <div class="absolute inset-0 flex justify-center items-center">
            <img src="{{ asset('images/footerlogo.svg') }}" alt="Footer Logo"
                class="object-contain w-full h-full md:w-auto md:h-full">
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
