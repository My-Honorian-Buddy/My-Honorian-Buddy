<section class="mx-8 my-8 max-w-s lg:mx-auto">
<div class=" bg-white rounded-[20px] pb-2 shadow-custom-button shadow-black border-black border-2">
    <div class="border-black"></div>
    <!-- content -->
    <div class="grid grid-cols-2 items-center p-4">
        <!-- profile image -->
        @php
            $user = Auth::user();
        @endphp
        <div class="flex justify-center">
            <img src="{{$user->profile_pic}}" alt="Profile" 
            class="md:w-48 md:h-48 lg:w-full lg:h-full w-full h-full border-4 border-black rounded-lg">
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
            <p class="font-bold ml-5 text-primary mt-1 text-[15px]">Firstname</p>
            <p class="font-bold ml-5 text-[18px] -mt-1">{{$user->fname}}</p>
            <p class="font-bold ml-5 text-primary text-[15px]">Lastname</p>
            <p class="font-bold ml-5 text-[18px] -mt-1">{{$user->lname}}</p>
            <p class="font-bold ml-5 text-primary text-[15px]">Role</p>
            @php
                    $user = Auth::user();
            @endphp
            <p class="font-bold ml-5 text-[18px] -mt-1">{{$user->role}}</p>
        </div>
    </div>
    <!-- go to my profile button -->
    <div class="flex justify-center mb-5 mt-4 p-2">
        <a href="{{route('profile.update')}}">
            <button class="bg-accent2 text-primary text-center font-poppins font-bold rounded-full px-8 py-1 h-11 text-l border-2 border-black shadow-custom-button hover:bg-[#FFECEC] hover:text-[#8B3A3A] flex items-center space-x-2">
                <x-bladewind::icon name="user-circle" class="h-10 w-10" />
                <span>GO TO MY PROFILE</span>
            </button>
        </a>
    </div>                             
</div>
</section>