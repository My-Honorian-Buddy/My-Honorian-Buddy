
    <div
        class="bg-accent overflow-hidden rounded-md border-black border-2">

        <!-- content -->
        <div class="grid grid-cols-2 items-center p-4 gap-4 max-md:grid-cols-1 max-md:p-3 max-sm:gap-3 max-sm:p-2 max-md:justify-items-center">
            <!-- profile image -->
            @php
                $user = Auth::user();
            @endphp
            <div class="flex justify-center shrink-0 items-center p-1 w-full max-w-40 aspect-square
             max-md:max-w-36 max-sm:max-w-28 max-md:w-full">
                <img src="{{ $user->profile_pic }}" alt="Profile"
                    class="w-full h-full object-cover border-4 border-black rounded-lg max-sm:border-2">
            </div>
            <!-- profile infos -->
            @php
                if ($user->role === 'Student' && $user->student) {
                    $user = $user->Student;
                } elseif ($user->role === 'Tutor' && $user->tutor) {
                    $user = $user->Tutor;
                }
            @endphp
            <div class="max-md:text-center">
                <p class="font-bold ml-5 text-primary mt-1 text-base max-md:ml-0 max-md:text-sm max-sm:text-xs">Firstname</p>
                <p class="font-bold ml-5 text-[18px] -mt-1 max-md:ml-0 max-md:text-base max-sm:text-sm">{{ $user->fname }}</p>
                <p class="font-bold ml-5 text-primary text-base max-md:ml-0 max-md:text-sm max-sm:text-xs">Lastname</p>
                <p class="font-bold ml-5 text-[18px] -mt-1 max-md:ml-0 max-md:text-base max-sm:text-sm">{{ $user->lname }}</p>
                <p class="font-bold ml-5 text-primary text-base max-md:ml-0 max-md:text-sm max-sm:text-xs">Role</p>
                @php
                    $user = Auth::user();
                @endphp
                <p class="font-bold ml-5 text-[18px] -mt-1 max-md:ml-0 max-md:text-base max-sm:text-sm">{{ $user->role }}</p>
            </div>
        </div>
        <!-- go to my profile button -->
        <div class="flex justify-center mb-4 p-2 max-sm:mb-2 max-sm:p-1">
            <a href="{{ route('profile.update') }}">
                <button
                    class="bg-primary text-accent text-center font-poppins font-bold rounded-full px-8 py-2 h-11 text-l border-2 border-black 
                                        hover:bg-primary/80 flex items-center space-x-2 max-md:px-4 max-md:h-10 max-md:text-sm max-sm:px-3 max-sm:h-9 max-sm:text-xs max-sm:space-x-1">
                    <x-bladewind.icon name="user" class="h-6 w-6 max-md:h-5 max-md:w-5 max-sm:h-4 max-sm:w-4" />
                    <span class="max-md:hidden">GO TO MY PROFILE</span>
                    <span class="md:hidden max-sm:hidden">PROFILE</span>
                    <span class="sm:hidden">PROFILE</span>
                </button>
            </a>
        </div>
    </div>
