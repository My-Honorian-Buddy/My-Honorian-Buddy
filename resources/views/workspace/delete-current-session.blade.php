<x-workspace-layout>
    {{-- sidebar --}}
    <x-slot name="sidebar_content">
        <ul class="space-y-6">
            <li>
                <a href="http://">
                    <div class="flex items-center justify-between bg-accent2 text-primary text-right font-poppins font-bold w-4/5 rounded-full px-8 py-1 h-11 text-m
                    border-2 border-black shadow-custom-button hover:bg-[#FFECEC] hover:text-[#8B3A3A] cursor-pointer">
                    <x-bladewind.icon name="video-camera" class="justify-self-start" />                    
                        JOIN A NEW CALL    
                    </div>
                </a>
            </li>
            <li>
                <div class="flex items-center justify-between bg-accent2 text-primary text-right font-poppins font-bold w-4/5 rounded-full px-8 py-1 h-11 text-m border-2 border-black 
                shadow-custom-button hover:bg-[#FFECEC] hover:text-[#8B3A3A] cursor-pointer">
                    <x-bladewind.icon name="plus" class="justify-self-start" />
                        CREATE A NEW CALL
                </div>
            </li>
        </ul>
    </x-slot>

    {{-- main content --}}
    <x-slot name="main_content">
        <div class="text-5xl text-accent2 text-stroke-thick2 stroke-black font-black mb-5 m-8 "> 
        </div>

        {{-- current sessions --}}
        <section class="m-8">
            {{-- container --}}
            <div class="w-full mt-10 bg-gray-300 rounded-lg shadow-custom-button shadow-black border-black border-2"> 
                <div class="flex items-center w-full border-b-2 border-black py-2">
                    <div class="flex w-full space-x-2 -mt-1 -mb-1 ml-4">
                        <span class="h-6 w-6 bg-accent2 border-2 border-black rounded-full"></span>
                        <span class="h-6 w-6 bg-[#ffb6c1] border-2 border-black rounded-full"></span>
                        <span class="h-6 w-6 bg-[#d3d3d3] border-2 border-black rounded-full"></span>
                    </div>
                    <div class="flex w-full justify-end text-2xl text-[#ffdd57] text-stroke font-black mr-8">CURRENT SESSIONS</div>
                </div>

                {{-- content --}}
                {{-- session #1 --}}
                <div class="bg-accent2 w-full border-b-2 border-black py-4 px-6">

                    {{-- Subject --}}
                    <div class="flex items-center mb-4">
                        <span class="h-6 w-6 bg-primary border-2 border-black rounded-full mr-4"></span>
                        <div class="text-[22px] font-bold text-black mt-1">
                            CSOS 313 (Operating Systems){{-- {{ $session['subject'] }} --}}
                        </div>
                    </div>
                    

                    {{-- User's Information --}}
                    <div class="text-[15px] font-bold text-primary mb-4 ml-10">
                        Tutor:Abcd {{-- {{ $session['tutor'] }} --}}
                    </div>

                    {{-- Buttons --}}
                    <div class="flex justify-between items-center mt-4 ml-10">
                        <button class="bg-accent text-primary font-bold px-4 py-2 text-sm rounded-full border-2 border-black shadow-md">
                            Price: Php 200.00
                        </button>

                        <button class="bg-primary hover:bg-red-700 text-accent2 font-bold px-6 py-2 rounded-full text-sm 
                            border-2 border-black shadow-md cursor-pointer">
                            END SESSION
                        </button>
                    </div>
                </div>

                <hr class="h-px border-0" style="border-top: 4px solid black;">

                {{-- session #2 --}}
                <div class="bg-accent2 w-full border-b-2 border-black py-4 px-6">

                    {{-- Subject --}}
                    <div class="flex items-center mb-4">
                        <span class="h-6 w-6 bg-primary border-2 border-black rounded-full mr-4"></span>
                        <div class="text-[22px] font-bold text-black mt-1">
                            CSOS 313 (Operating Systems){{-- {{ $session['subject'] }} --}}
                        </div>
                    </div>
                    

                    {{-- User's Information --}}
                    <div class="text-[15px] font-bold text-primary mb-4 ml-10">
                        Tutor:Abcd {{-- {{ $session['tutor'] }} --}}
                    </div>

                    {{-- Buttons --}}
                    <div class="flex justify-between items-center mt-4 ml-10">
                        <button class="bg-accent text-primary font-bold px-4 py-2 text-sm rounded-full border-2 border-black shadow-md">
                            Price: Php 200.00
                        </button>

                        <button class="bg-primary hover:bg-red-700 text-accent2 font-bold px-6 py-2 rounded-full text-sm 
                            border-2 border-black shadow-md cursor-pointer">
                            END SESSION
                        </button>
                    </div>
                </div>

                <hr class="h-px border-0" style="border-top: 4px solid black;">

                {{-- session #3 --}}
                <div class="bg-accent2 w-full border-b-2 border-black py-4 px-6">

                    {{-- Subject --}}
                    <div class="flex items-center mb-4">
                        <span class="h-6 w-6 bg-primary border-2 border-black rounded-full mr-4"></span>
                        <div class="text-[22px] font-bold text-black mt-1">
                            CSOS 313 (Operating Systems){{-- {{ $session['subject'] }} --}}
                        </div>
                    </div>
                    

                    {{-- User's Information --}}
                    <div class="text-[15px] font-bold text-primary mb-4 ml-10">
                        Tutor:Abcd {{-- {{ $session['tutor'] }} --}}
                    </div>

                    {{-- Buttons --}}
                    <div class="flex justify-between items-center mt-4 ml-10">
                        <button class="bg-accent text-primary font-bold px-4 py-2 text-sm rounded-full border-2 border-black shadow-md">
                            Price: Php 200.00
                        </button>

                        <button class="bg-primary hover:bg-red-700 text-accent2 font-bold px-6 py-2 rounded-full text-sm 
                            border-2 border-black shadow-md cursor-pointer">
                            END SESSION
                        </button>
                    </div>
                </div>
        </section>
    </x-slot>
</x-workspace-layout>




                        {{-- #1
                        <div class="flex justify-between items-center mt-4 ml-10"> 
                                 @if ($userRole === 'student')
                                    <button class="bg-primary hover:bg-red-700 text-accent2 font-bold px-6 py-2 rounded-full text-sm 
                                            border-2 border-black shadow-md cursor-pointer">
                                            PAY NOW
                                    </button>
                                @elseif ($userRole === 'tutor')
                                    <button class="bg-primary hover:bg-red-700 text-accent2 font-bold px-6 py-2 rounded-full text-sm 
                                            border-2 border-black shadow-md cursor-pointer">
                                            END SESSION
                                    </button>
                                @endif
                            </div>--}}

                          {{-- #2
                          @if ($user->isStudent())--}}
                          {{--<button class="bg-primary hover:bg-red-700 text-accent2 font-bold px-6 py-2 rounded-full text-sm 
                            border-2 border-black shadow-md cursor-pointer">
                            PAY NOW
                        </button>

                        {{--@elseif ($user->isTutor())--}}
                        {{-- <button class="bg-primary hover:bg-red-700 text-accent2 font-bold px-6 py-2 rounded-full text-sm 
                            border-2 border-black shadow-md cursor-pointer">
                            END SESSION
                        </button> --}}
                        {{--@endif--}}
