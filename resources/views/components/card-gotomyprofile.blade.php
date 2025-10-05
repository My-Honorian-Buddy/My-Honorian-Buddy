

<section class="h-full mx-8 lg:mx-auto">
<div data-aos="fade-up"
     data-aos-anchor-placement="center-bottom" class=" bg-accent3 overflow-hidden rounded-[20px] shadow-custom-button shadow-black border-black border-2">
    <div class="bg-accent2 text-2xl text-primary text-stroke font-black p-3 border-b-2 border-black">
        <div class="flex w-full space-x-2 h-8 -mt-1 -mb-1 ml-4">
        </div>
    </div>

    <div class="border-black"></div>
    <!-- content -->
    <div class="grid grid-cols-2 items-center p-4">
        <!-- profile image -->
        @php
            $user = Auth::user();
        @endphp
        <div class="flex h-full w-full items-center justify-center">
            <img src="{{$user->profile_pic}}" alt="Profile" 
            class="  h-32 w-32 lg:h-40 lg:w-40 object-cover border-4 border-black rounded-lg">
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
    <div class="flex justify-center mb-4 p-2">
        <a href="{{route('profile.update')}}">
            <button class="bg-accent2 text-primary text-center font-poppins font-bold rounded-full px-8 py-1 h-11 text-l border-2 border-black 
            shadow-custom-button hover:bg-primary hover:text-accent2 flex items-center space-x-2">
                <x-bladewind::icon name="user-circle" class="h-10 w-10" />
                <span>GO TO MY PROFILE</span>
            </button>
        </a>
    </div>                             
</div>
</section>