<ul class="flex justify-content items-content">
    <li>
        <a href="{{ route('video.join.meet') }}">
            <div class="flex items-center justify-between bg-accent2 text-primary text-right font-poppins font-bold md:w-4/5 rounded-full px-8 py-1 md:h-11 text-m
            border-2 border-black shadow-custom-button hover:bg-[#FFECEC] hover:text-[#8B3A3A] cursor-pointer md:text-center"> 
            <x-bladewind.icon name="video-camera" class="justify-self-start" />                    
                JOIN A NEW CALL    
            </div>
        </a>
    </li>
    <li>
        <a href="{{ route('video.call.create') }}">
            <div class="flex items-center justify-between bg-accent2 text-primary text-right font-poppins font-bold md:w-4/5 rounded-full px-8 py-1 md:h-11 text-m border-2 border-black 
            shadow-custom-button hover:bg-[#FFECEC] hover:text-[#8B3A3A] cursor-pointer md:text-center">
                <x-bladewind.icon name="plus" class="justify-self-start" />
                    CREATE A NEW CALL
            </div>
        </a>
    </li>
    <li>
        <a href="{{ route('video.call.create') }}">
            <div class="flex items-center justify-between bg-accent2 text-primary text-right font-poppins font-bold md:w-4/5 rounded-full px-8 py-1 md:h-11 text-m border-2 border-black 
            shadow-custom-button hover:bg-[#FFECEC] hover:text-[#8B3A3A] cursor-pointer md:text-center">
                <x-bladewind.icon name="plus" class="justify-self-start" />
                    COMPLETE SESSION
            </div>
        </a>
    </li>
</ul>