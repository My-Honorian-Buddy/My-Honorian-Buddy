<ul class="space-y-6 flex justify-center items-center flex-col">
    <li class="w-full flex justify-center items-center">
        <a href="{{ route('tutor.profile')}}" class="w-full">
            <div class="w-full flex items-center justify-center bg-accent2 text-primary text-center font-poppins font-bold md:w-4/5 rounded-full px-8 py-1 md:h-11 text-m
            border-2 border-black shadow-custom-button hover:bg-primary hover:text-accent2 cursor-pointer md:text-center">
                PROFILE
            </div>
        </a>
    </li>
    <li class="w-full flex justify-center items-center">
        <a href="{{ route('profile.edit-profile')}}" class="w-full">
        <div class="w-full flex items-center justify-center bg-accent2 text-primary text-center font-poppins font-bold md:w-4/5 rounded-full px-8 py-1 lg:h-11 text-m border-2 border-black 
        shadow-custom-button hover:bg-primary hover:text-accent2 cursor-pointer md:text-center">
                EDIT YOUR PROFILE
        </div>
        </a>
    </li>
    <li class="w-full flex justify-center items-center">
        <a href="{{ route('profile.account-settings')}}" class="w-full">
        <div class="w-full flex items-center justify-center bg-accent2 text-primary text-center font-poppins font-bold md:w-4/5 rounded-full px-8 py-1 md:h-11 text-m border-2 border-black 
        shadow-custom-button hover:bg-primary hover:text-accent2 cursor-pointer md:text-center">
                ACCOUNT SETTINGS
        </div>
        </a>
    </li>
</ul>