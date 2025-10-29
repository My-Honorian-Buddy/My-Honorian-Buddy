
    <div data-aos="fade-up" data-aos-anchor-placement="center-bottom"
        class="bg-accent overflow-hidden rounded-md border-black border-2">

        <!-- content -->
        <div class="grid grid-cols-2 items-center p-4 gap-4 max-md:grid-cols-1 max-md:p-3">
            <!-- profile image -->
            @php
                $user = Auth::user();
            @endphp
            <div class="flex justify-center shrink-0 items-center p-1 w-full max-w-40 aspect-square">
                <img src="{{ $user->profile_pic }}" alt="Profile"
                    class="w-full h-full object-cover border-4 border-black rounded-lg">
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
                <p class="font-bold ml-5 text-primary mt-1 text-base max-md:ml-0 max-md:text-sm">Firstname</p>
                <p class="font-bold ml-5 text-[18px] -mt-1 max-md:ml-0 max-md:text-base">{{ $user->fname }}</p>
                <p class="font-bold ml-5 text-primary text-base max-md:ml-0 max-md:text-sm">Lastname</p>
                <p class="font-bold ml-5 text-[18px] -mt-1 max-md:ml-0 max-md:text-base">{{ $user->lname }}</p>
                <p class="font-bold ml-5 text-primary text-base max-md:ml-0 max-md:text-sm">Role</p>
                @php
                    $user = Auth::user();
                @endphp
                <p class="font-bold ml-5 text-[18px] -mt-1 max-md:ml-0 max-md:text-base">{{ $user->role }}</p>
            </div>
        </div>
        <!-- go to my profile button -->
        <div class="flex justify-center mb-4 p-2">
            <a href="{{ route('profile.update') }}">
                <button
                    class="bg-primary text-accent text-center font-poppins font-bold rounded-full px-8 py-2 h-11 text-l border-2 border-black 
                                        hover:bg-primary/80 flex items-center space-x-2 max-md:px-4 max-md:h-10 max-md:text-sm">
                    <x-bladewind.icon name="user" class="h-6 w-6 max-md:h-5 max-md:w-5" />
                    <span class="max-md:hidden">GO TO MY PROFILE</span>
                    <span class="md:hidden">PROFILE</span>
                </button>
            </a>
        </div>
    </div>
