<div class="flex" style="margin-top: 2rem; margin-bottom: 2rem; @media (max-width: 768px) { margin-top: 0.5rem; margin-bottom: 0.5rem; }">
    <div class="w-full bg-accent rounded-md shadow-black" style="border: 4px solid #1A1A1A; @media (max-width: 768px) { border: 2px solid #1A1A1A; }">
        <div class="relative rounded-[20px]" style="padding: 2.5rem 1.5rem; @media (max-width: 768px) { padding: 1rem 0.5rem; }">

            <!-- Profile Picture -->
            <div class="absolute left-1/2 transform -translate-x-1/2" style="top: -75px; @media (max-width: 768px) { top: -50px; }">
                <img src="{{ Auth::user()->profile_pic ?? asset('https://lumiere-a.akamaihd.net/v1/images/a_avatarpandorapedia_neytiri_16x9_1098_01_0e7d844a.jpeg') }}" 
                alt="Profile" 
                style="width: 150px; height: 150px; background-color: #F6F6F6; object-fit: cover; border-radius: 50%; border: 4px solid white; box-shadow: 0 4px 6px rgba(0,0,0,0.1); @media (max-width: 768px) { width: 100px; height: 100px; border: 2px solid white; }">
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
            <div style="display: flex; flex-direction: column; margin-top: 2.5rem; text-align: center; @media (max-width: 768px) { margin-top: 1.5rem; }">
                <span style="font-family: 'Dela Gothic One'; font-weight: bold; font-size: 3rem; margin: 1.25rem; line-height: 1.5; @media (max-width: 768px) { font-size: 1.875rem; margin: 0.25rem; }">{{$firstName}} {{$lastName}}</span>
                
                @if($user->role === 'Student')
                    <span style="font-weight: 600; font-size: 1.5rem; margin: 1.25rem; line-height: 1.5; @media (max-width: 768px) { font-size: 1.125rem; margin: 0.25rem; }">{{$user -> student -> year_level}} {{$user -> student -> department}} </span>
                @endif
                
                @if($bio !== null)
                    <span style="font-style: italic; font-weight: 600; font-size: 1.5rem; margin: 1.25rem; line-height: 1.5; @media (max-width: 768px) { font-size: 0.875rem; margin: 0.25rem; }">"{{$bio}}"</span>
                @else
                    <span style="font-weight: 600; font-size: 1.5rem; margin: 1.25rem; line-height: 1.5; @media (max-width: 768px) { font-size: 0.875rem; margin: 0.25rem; }">No Bio Yet</span>
                @endif

                @if ($user -> role === 'Tutor' && $user->tutor)
                    <span style="font-family: 'Dela Gothic One'; font-weight: bold; font-size: 2.25rem; margin: 1.25rem; line-height: 1.5; @media (max-width: 768px) { font-size: 1.5rem; margin: 0.25rem; }">
                    TOTAL POINTS
                    </span>
                    <span style="font-family: 'Dela Gothic One'; font-weight: 600; font-size: 1.5rem; margin: 1.25rem; line-height: 1.5; @media (max-width: 768px) { font-size: 1.125rem; margin: 0.25rem; }">
                        {{ $user->tutor->points ?? 0 }}
                    </span>
                @endif
                
            </div>
        </div>
    </div>
</div>
