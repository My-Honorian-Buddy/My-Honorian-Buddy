<x-workspace-layout>
    {{-- sidebar --}}
    <x-slot name="sidebar_content">
        <ul class="space-y-6">
            <li>
                <a href="http://">
                    <div class="flex items-center justify-between bg-accent2 text-primary text-right font-poppins font-bold md:w-4/5 rounded-full px-8 py-1 md:h-11 text-m
                    border-2 border-black shadow-custom-button hover:bg-[#FFECEC] hover:text-[#8B3A3A] cursor-pointer md:text-center"> 
                    <x-bladewind.icon name="video-camera" class="justify-self-start" />                    
                        JOIN A NEW CALL    
                    </div>
                </a>
            </li>
            <li>
                <div class="flex items-center justify-between bg-accent2 text-primary text-right font-poppins font-bold md:w-4/5 rounded-full px-8 py-1 md:h-11 text-m border-2 border-black 
                shadow-custom-button hover:bg-[#FFECEC] hover:text-[#8B3A3A] cursor-pointer md:text-center">
                    <x-bladewind.icon name="plus" class="justify-self-start" />
                        CREATE A NEW CALL
                </div>
            </li>
        </ul>
    </x-slot>

    {{-- main content --}}
    <x-slot name="main_content">
        <div class="m-8">
            <div class="text-5xl sm:text-1xl text-accent2 text-stroke-thick2 stroke-black font-black mb-5 m-8 "> 
                Welcome, (user)!
            </div>

            {{-- daily progress --}}
            <x-daily-progress/>

            {{-- current sessions --}}
            <x-current-session/>
        </div>
        
        <div class="xl:grid grid-cols-4">
            {{-- col 1 --}}
            <div class="w-full col-span-3 space-y-8">
                {{-- calendar | schedule--}}
                <section class="">
                    <x-calendar/>
                </section>
                {{-- upcoming task --}}
                <section class="">             
                    <x-upcoming-task/>
                </section>
            </div>
            
            {{-- col 2 --}}
            <div class="col-span-1 md:ml-5 sm:ml-5 space-y-8">
                {{-- go to my profile card --}}
                <section>
                    <x-card-gotomyprofile/>
                </section>
                
                <section>
                    {{-- your student card --}}
                    <x-card-yourstudent/>
                </section>
                
                <section>
                    {{-- log in streak --}}
                    <x-streak/>
                </section>
            </div>
        </div>
        


    </x-slot>
</x-workspace-layout>