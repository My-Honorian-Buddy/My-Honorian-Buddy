<div class="flex mt-8 mb-8">
    <div class="w-full bg-accent3 rounded-[20px] shadow-custom-button shadow-black border-black border-2">
        <div class="relative rounded-[20px] px-6 py-10">

            <!-- Profile Picture -->
            <div class="absolute -top-[75px] left-1/2 transform -translate-x-1/2">
                <img src="{{ Auth::user()->profile_pic ?? asset('https://lumiere-a.akamaihd.net/v1/images/a_avatarpandorapedia_neytiri_16x9_1098_01_0e7d844a.jpeg') }}"
                alt="Profile" class="w-[150px] h-[150px] rounded-full border-4 border-white shadow-md">
            </div>
            
            <!-- Card Content -->
            <form action="">
                <div class="flex justify-center">
                    <div class="mt-[60px] w-3/5">
                        <label for="profile_pic"></label>
                        <div class="items-center">
                            <x-bladewind::filepicker
                                type="file"
                                name="profile_pic"
                                placeholder="Upload Profile Picture"
                                accepted_file_types="image/*"  
                                />
                        </div>
                        {{-- @if (button is not clicked) --}}
                        {{-- <x-primary-button type="submit" class=" bg-accent text-black ">Save</x-primary-button> --}}
                        {{-- @endif --}}
                    </div>
                </div>
                
                <div class="grid grid-rows-2">
                    <span class="font-bold text-4xl m-5 leading-relaxed">Profile Information</span>
                    <span class="font-semibold text-red-900 text-1xl mb-8 ml-5">Update your account's profile information and email address.</span>
                </div>
                
                {{-- inputs --}}
                <div class="flex justify-center">
                    <section class="grid grid-rows-4 w-3/5 ">
                        {{-- for first name --}}
                        <span class="font-semibold text-2xl mt-4">First Name</span>
                        <input type="text" placeholder="firstname" class="border-black border-2">
                        
                        {{-- for last name --}}
                        <span class="font-semibold text-2xl mt-5">Last Name</span>
                        <input type="text" placeholder="lastname" class="border-black border-2">
                        
                        {{-- for email --}}
                        <span class="font-semibold text-2xl mt-5">Email</span>
                        <input type="text" placeholder="email" class="border-black border-2">

                        {{-- for bio --}}
                        <span class="font-bold text-red-900 text-1xl mt-10">Update your Bio.</span>
                        <span class="ffont-semibold text-2xl mt-5"> Bio</span>
                        <textarea placeholder="bio" class="border-black border-2 h-48 mt-2" style=""></textarea>
                    </section>
                </div>

                <!-- Button-->
                <div class="flex justify-end m-8">
                    <x-primary-button type="submit" class=" bg-accent2 text-black ">Save</x-primary-button>
                </div>
            </form>
            </div>
        </div>
    </div>
</div>