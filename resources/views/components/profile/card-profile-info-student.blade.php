@php
    $user = Auth::user();

    if ($user -> role === 'Student') {
        $firstName = $user -> student -> fname;
        $lastName = $user -> student -> lname;
        $bio = $user -> student -> bio;
    } elseif ($user -> role === 'Tutor') {
        $firstName = $user -> tutor -> fname;
        $lastName = $user -> tutor -> lname;
        $bio = $user -> tutor -> bio;
    }
@endphp

<div class="flex mt-8 mb-8">
    <div class="w-full bg-accent3 rounded-[20px] shadow-custom-button shadow-black border-black border-2">
        <div class="relative rounded-[20px] px-6 py-10">

            <!-- Profile Picture -->
            <div class="absolute -top-[75px] left-1/2 transform -translate-x-1/2">
                <img src="{{ Auth::user()->profile_pic ?? asset('https://lumiere-a.akamaihd.net/v1/images/a_avatarpandorapedia_neytiri_16x9_1098_01_0e7d844a.jpeg') }}"
                alt="Profile" 
                class="w-[150px] h-[150px] bg-accent3 object-cover rounded-full border-4 border-white shadow-md">
            </div>
            
            <!-- Card Content -->
            <form action="{{ route('picture.upload') }}" 
            method="POST" enctype="multipart/form-data" 
            id="profile-picture" class="pt-16">
                @csrf
                @method('PATCH')
                <x-bladewind.filepicker
                    type="file"
                    name="profile_pic"
                    placeholder="Upload Profile Picture"
                    accepted_file_types="image/*"  />

                <div class="w-ful flex justify-end">
                    <x-primary-button type="submit" class="bg-accent2">Upload</x-primary-button>
                </div>
            </form>

               
                <div class="grid grid-rows-2">
                    <span class="font-bold text-4xl m-5 leading-relaxed">Profile Information</span>
                    <span class="font-semibold text-red-900 text-1xl mb-8 ml-5">Update your account's profile information and email address.</span>
                </div>
                
                <form action="{{ route('profile.update') }}" method="POST">
                    @csrf
                    @method('PATCH')
                {{-- inputs --}}
                <div class="flex justify-center">
                    <section class="grid grid-rows-4 w-3/5 ">
                        {{-- for first name --}}
                        <span class="font-semibold text-2xl mt-4">First Name</span>
                        <x-text-input id="fname" name="fname" type="text" class="border-black border-2 mb-10" :value="old('fname', $firstName)" required autocomplete="username" />
                        
                        {{-- for last name --}}
                        <span class="font-semibold text-2xl mt-5">Last Name</span>
                        <x-text-input id="lname" name="lname" type="text" class="border-black border-2 mb-10" :value="old('lname',  $lastName)" required autocomplete="username" />
                        
                        {{-- for email --}}
                        <span class="font-semibold text-2xl mt-5">Email</span>
                        <x-text-input id="email" name="email" type="email" class="border-black border-2 mb-10" :value="old('email', $user->email)" required autocomplete="username" />
                        <x-input-error class="mt-2" :messages="$errors->get('email')" />

                        {{-- for bio --}}
                        <span class="font-bold text-red-900 text-1xl mt-10">Update your Bio.</span>
                        <span class="ffont-semibold text-2xl mt-5"> Bio</span>
                        <textarea placeholder="Bio.." :value="{{$bio}}" class="border-black border-2 h-48 mt-2" style="" name="bio">{{old('bio', $bio)}}</textarea>
                    </section>
                </div>
                
                <!-- Button-->
                    <div class="flex justify-end m-8">
                    <x-primary-button type="submit" class="bg-accent2">Save</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
    document.querySelector('#profile_picture').addEventListener('submit', function(event) {
        console.log('Form submitted with method:', event.target.method);
    });

    document.addEventListener('DOMContentLoaded', function () {

            @if (session('success'))
                showNotification('{{ session('success')}}', 'User updated successfully', 'success');
            @endif
    });

    </script>


