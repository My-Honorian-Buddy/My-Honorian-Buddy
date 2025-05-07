<div class="flex mt-8 mb-8">
    <div class="w-full bg-gray-300 rounded-[20px] shadow-custom-button shadow-black border-black border-2">
        <div class="relative rounded-[20px] px-6 py-10 text-center">

            <!-- Profile Picture -->
            <div class="absolute -top-[75px] left-1/2 transform -translate-x-1/2">
                <img src="{{ Auth::user()->profile_pic ?? asset('https://lumiere-a.akamaihd.net/v1/images/a_avatarpandorapedia_neytiri_16x9_1098_01_0e7d844a.jpeg') }}" 
                alt="Profile" 
                class="w-[150px] h-[150px] bg-gray-100 rounded-full border-4 border-white shadow-md">
            </div>

            @if(Auth::check())
            @php
                $user = Auth::user();                   
                $firstName = ''; 
                $lastName = '';    
                       
                if ($user -> role === 'Student' && $user->student) {
                    $firstName = $user->student->fname;
                    $lastName = $user->student->lname;
                    $bio = $user->student->bio;
                }
                else if ($user -> role === 'Tutor' && $user->tutor) {
                    $firstName = $user -> tutor -> fname;
                    $lastName = $user-> tutor -> lname;
                    $bio = $user -> tutor -> bio;
                }
            @endphp      
        @endif
            <!-- Card Content -->
            <div class="flex flex-col mt-10">
                <span class="font-bold text-4xl m-5 leading-relaxed">{{$firstName}} {{$lastName}}</span>
                
                @if($user->role === 'Student')
                    <span class="font-semibold text-2xl m-5 leading-relaxed">{{$user -> student -> year_level}} {{$user -> student -> department}} </span>
                @endif
                
                @if($bio !== null)
                    <span class="font-semibold text-2xl m-5 leading-relaxed">"{{$bio}}"</span>
                @else
                    <span class="font-semibold text-2xl m-5 leading-relaxed">No Bio Yet</span>
                @endif

            </div>
        </div>
    </div>
</div>
