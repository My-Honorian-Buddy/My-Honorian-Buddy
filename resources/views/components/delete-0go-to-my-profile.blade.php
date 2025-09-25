<section class="m-4 mt-8 max-w-xs">
    <!-- container -->
    <div class="bg-green-900 rounded-[20px] pb-2 mb-4 shadow-custom-button shadow-black border-black border-2">
        <div class="border-black p-4"></div>
        <!-- content -->
        <div class="grid grid-cols-2 items-center px-4">
            <!-- profile image -->
            <div class="flex justify-center">
                <img src="" alt="Profile" class="w-[150px] h-[150px] border-4 border-black rounded-lg">
            </div>    
            <!-- profile infos -->
            @php
                $user = Auth::user();                   
                $firstName = '';                        
                                                    
                if ($user -> role === 'Student' && $user->student) {
                    $user = $user->Student;
                }
                else if ($user -> role === 'Tutor' && $user->tutor) {
                    $user = $user -> Tutor;
                }
            @endphp
            <div>
                <p class="font-bold ml-5 text-primary text-[16px]">Firstname</p>
                <p class="font-bold ml-5 text-[18px] -mt-1">{{$user->fname}}</p>
                <p class="font-bold ml-5 text-primary text-[16px]">Lastname</p>
                <p class="font-bold ml-5 text-[18px] -mt-1">{{$user->lname}}</p>
                <p class="font-bold ml-5 text-primary text-[16px]">Role</p>
                @php
                    $user = Auth::user();
                @endphp
                <p class="font-bold ml-5 text-[18px] -mt-1">{{$user->role}}</p>
            </div>
        </div>
        <!-- go to my profile button -->
        <div class="flex justify-center mb-5 mt-4">
            <a href="#">
                <button class="bg-accent2 text-primary text-center font-poppins font-bold rounded-full px-8 py-1 h-11 text-l border-2 border-black shadow-custom-button hover:bg-primary hover:text-accent2 flex items-center space-x-2">
                    <img src="https://picsum.photos/400" class="w-7 h-7">
                    <span>GO TO MY PROFILE</span>
                </button>
            </a>
        </div>                             
    </div>
</section>