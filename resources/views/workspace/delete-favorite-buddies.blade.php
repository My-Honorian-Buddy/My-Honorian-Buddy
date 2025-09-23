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
        <div class="text-5xl text-accent2 text-stroke-thick2 stroke-black font-black mb-5 m-8"> 
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
                    <div class="flex w-full justify-end text-2xl text-[#ffdd57] text-stroke font-black mr-8">FAVORITE BUDDIES</div>
                </div>

                {{-- content --}}
                {{-- fav. buddy 1 --}}
                <div class="bg-accent2 w-full border-b-2 border-black py-4 px-6 flex items-center justify-between">
                    {{-- Left content (image + name) --}}
                    <div class="flex items-center space-x-4 pl-6">
                        <img src="https://picsum.photos/400" alt="external photo" class="w-20 h-20 rounded-lg object-cover border-2 border-black">
                        <span class="text-2xl font-bold text-black">
                            Mireyl Fatima Nulud
                        </span>
                    </div>

                    {{-- button --}} 
                    <button class="mt-12 bg-primary text-accent2 font-bold px-10 py-2 text-sm rounded-full border-2 border-black shadow-md hover:bg-[#FFECEC] hover:text-[#8B3A3A]">
                        DELETE
                    </button>
                </div>

                {{-- fav. buddy 2--}}
                <div class="bg-accent2 w-full border-b-2 border-black py-4 px-6 flex items-center justify-between">
                    {{-- Left content (image + name) --}}
                    <div class="flex items-center space-x-4 pl-6">
                        <img src="https://picsum.photos/400" alt="external photo" class="w-20 h-20 rounded-lg object-cover border-2 border-black">
                        <span class="text-2xl font-bold text-black">
                            Maria Fiona Rabanal
                        </span>
                    </div>

                    {{-- button --}}
                    <button class="mt-12 bg-primary text-accent2 font-bold px-10 py-2 text-sm rounded-full border-2 border-black shadow-md hover:bg-[#FFECEC] hover:text-[#8B3A3A]">
                        DELETE
                    </button>
                </div>

                {{-- fav. buddy 3--}}
                <div class="bg-accent2 w-full border-b-2 border-black py-4 px-6 flex items-center justify-between">
                    {{-- Left content (image + name) --}}
                    <div class="flex items-center space-x-4 pl-6">
                        <img src="https://picsum.photos/400" alt="external photo" class="w-20 h-20 rounded-lg object-cover border-2 border-black">
                        <span class="text-2xl font-bold text-black">
                            Antoinette Cabang
                        </span>
                    </div>

                    {{-- {{-- button --}}
                    <button class="mt-12 bg-primary text-accent2 font-bold px-10 py-2 text-sm rounded-full border-2 border-black shadow-md hover:bg-[#FFECEC] hover:text-[#8B3A3A]">
                        DELETE
                    </button>
                </div>
            </div>
        </section>
    </x-slot>
</x-workspace-layout>
