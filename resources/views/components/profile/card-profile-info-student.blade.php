@php
    $user = Auth::user();

    if ($user->role === 'Student') {
        $firstName = $user->student->fname;
        $lastName = $user->student->lname;
        $bio = $user->student->bio;
    } elseif ($user->role === 'Tutor') {
        $firstName = $user->tutor->fname;
        $lastName = $user->tutor->lname;
        $bio = $user->tutor->bio;
    }
@endphp

<div class="flex flex-col mt-8 mb-8">
    <div class="w-full bg-accent rounded-md shadow-black mb-8 border-charcoal border-4">
        <div class="relative rounded-[20px] pt-10 px-8">

            <!-- Profile Picture -->
            <div class="absolute -top-[75px] left-1/2 transform -translate-x-1/2">
                <img src="{{ Auth::user()->profile_pic ?? asset('https://lumiere-a.akamaihd.net/v1/images/a_avatarpandorapedia_neytiri_16x9_1098_01_0e7d844a.jpeg') }}"
                    alt="Profile"
                    class="w-[150px] h-[150px] bg-accent3 object-cover ring-2 ring-charcoal rounded-full border-4 border-white shadow-md">
            </div>
            <form action="{{ route('picture.upload') }}" method="POST" enctype="multipart/form-data" id="profile-picture"
                class="pt-16 ">
                @csrf
                @method('PATCH')
                <x-bladewind.filepicker 
                    type="file" 
                    name="profile_pic" 
                    placeholder_line1="Upload Profile Picture"
                    placeholder_line2="Choose your most beautiful picture!" 
                    accepted_file_types="image/*" 
                    can_crop="true" 
                    crop_aspect_ratio="1:1"
                    max_files="1" 
                    can_resize="true" 
                    image_resize_height="150"
                    required="true"/>

                <div class="w-auto flex m-8 justify-end">
                    <button type="submit" id="upload-btn"
                        class="sm:w-auto bg-accent px-6 sm:px-8 md:px-10 py-2 sm:py-2.5 md:py-1 h-auto sm:h-10 md:h-11 border-2 border-black
                                active:scale-95 transition-all duration-800 ease-in-out flex items-center justify-center rounded-sm font-bold text-sm
                                hover:bg-primary w-auto hover:text-accent tracking-widest uppercase hover:shadow-custom-button">
                        UPLOAD
                    </button>
                </div>
            </form>
        </div>
    </div>


    <div class="w-full bg-accent rounded-md shadow-black border-charcoal border-4">
        <div class="relative rounded-[20px] px-8">


            <!-- Card Content -->
            <div class="grid grid-rows-2 mt-8">
                <span class="font-dela font-bold text-4xl m-5 mb-0 leading-relaxed">Profile Information</span>
                <span class="italic font-semibold text-primary ml-5 mb-8">Update your account's profile
                    information and email address.</span>
            </div>

            <form action="{{ route('profile.update') }}" method="POST">
                @csrf
                @method('PATCH')
                {{-- inputs --}}
                <div class="flex justify-center">
                    <section class="flex flex-col w-3/4">
                        {{-- for email --}}

                        {{-- for first name --}}
                        <span class="font-extrabold text-base mt-4">First Name</span>
                        <x-text-input id="fname" name="fname" type="text" 
                        class="border-black border-2 mb-6 text-darkgray"
                            :value="old('fname', $firstName)" required autocomplete="username" />


                        {{-- for last name --}}
                        <span class="font-extrabold text-base mt-5">Last Name</span>
                        <x-text-input id="lname" name="lname" type="text" class="border-black border-2 mb-6"
                            :value="old('lname', $lastName)" required autocomplete="username" />


                        {{-- for email --}}
                        <span class="font-extrabold text-base mt-5">Email</span>
                        <x-text-input id="email" name="email" type="email" class="border-black border-2 mb-6"
                            :value="old('email', $user->email)" required autocomplete="username" />
                        <x-input-error class="mt-2" :messages="$errors->get('email')" />

                        {{-- for bio --}}
                        <span class="font-extrabold text-base mt-6 "> Bio</span>
                        <span class="italic text-primary text-sm">Update your Bio.</span>
                        <textarea placeholder="Bio.." :value="{{ $bio }}" class="border-black border-2 h-48 mt-2" style=""
                            name="bio">{{ old('bio', $bio) }}</textarea>
                    </section>
                </div>

                <!-- Button-->
                <div class="w-auto mt-6 m-8 flex justify-end">
                    <button type="submit"
                        class="sm:w-auto bg-accent px-6 sm:px-8 md:px-10 py-2 sm:py-2.5 md:py-1 h-auto sm:h-10 md:h-11 border-2 border-black
                                active:scale-95 transition-all duration-800 ease-in-out flex items-center justify-center rounded-sm font-bold text-sm
                                hover:bg-primary w-auto hover:text-accent tracking-widest uppercase hover:shadow-custom-button">
                        Save
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    document.querySelector('#profile-picture').addEventListener('submit', function(event) {
        const fileInput = document.querySelector('input[name="profile_pic"]');
        console.log('Form submitted');
        console.log('File input found:', fileInput);
        console.log('Files selected:', fileInput?.files.length);
        
        if (!fileInput || !fileInput.files || fileInput.files.length === 0) {
            event.preventDefault();
            showNotification('Please select an image file first', 'No File Selected', 'error');
            return false;
        }
    });

    document.addEventListener('DOMContentLoaded', function() {

        @if (session('success'))
            showNotification('{{ session('success') }}', 'Profile picture uploaded successfully!', 'success');
        @endif

        @if (session('error'))
            showNotification('{{ session('error') }}', 'Upload failed', 'error');
        @endif

        @if ($errors->any())
            @foreach ($errors->all() as $error)
                showNotification('{{ $error }}', 'Validation Error', 'error');
            @endforeach
        @endif
    });
</script></script>
