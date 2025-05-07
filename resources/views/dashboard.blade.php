<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                    <img
                        src="{{ Auth::user()->profile_pic ?? asset('https://lumiere-a.akamaihd.net/v1/images/a_avatarpandorapedia_neytiri_16x9_1098_01_0e7d844a.jpeg') }}"
                        alt="user's profile pic"
                        class="w-16 h-16 rounded-full object-cover">
                    <form action="{{ route('picture.upload') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <label for="profile_pic">Upload Profile Picture</label>
                        <x-bladewind::filepicker
                            type="file"
                            name="profile_pic"
                            placeholder="Upload Profile Picture"
                            accepted_file_types="image/*"  />
                        <x-primary-button type="submit">Upload</x-primary-button>
                        
                    </form>
                </div>
            </div>
            <img src="/final-project/storage/app/public/profile_pictures/9yaF0GNwUGQHhYjiXQmT8ZN1hrYo8RlbX6zm3wRb.png" alt="user's profile pic" class="w-16 h-16 rounded-full object-cover">
        </div>
    </div>
    <div class="flex mt-8 mb-8">
        <div class="w-full bg-gray-300 rounded-[20px] shadow-custom-button shadow-black border-black border-2">
            <div class="relative rounded-[20px] px-6">
    
                <!-- Card Content -->
                <div class="flex flex-col mt-8 text-left">
                    <span class="font-bold text-4xl m-5 leading-relaxed">Delete Account:</span>
                    <span class="font-bold text-red-900 text-1xl ml-5 mb-5">Once your account is deleted, all of its resouces and data will be permanently deleted. 
                                                                                Before deleting your account, please download any data or information that you wish to retain.</span>
                </div>
    
                    <!-- Button-->
                    <div class="flex justify-end m-8">
                        <x-danger-button 
                        x-data=""
                        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
                        type="submit" 
                        class=" bg-red-900 h-11 rounded-[4px] text-lg  shadow-custom-button text-black ">
                            Delete Account
                        </x-danger-button>
                    </div>
                    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
                        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
                            @csrf
                            @method('delete')
                
                            <h2 class="text-lg font-medium text-gray-900">
                                {{ __('Are you sure you want to delete your account?') }}
                            </h2>
                
                            <p class="mt-1 text-sm text-gray-600">
                                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
                            </p>
                
                            <div class="mt-6">
                                <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />
                
                                <x-text-input
                                    id="password"
                                    name="password"
                                    type="password"
                                    class="mt-1 block w-3/4"
                                    placeholder="{{ __('Password') }}"
                                />
                
                                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
                            </div>
                
                            <div class="mt-6 flex justify-between ">
                
                                <p class="mt-1 text-sm text-gray-600">
                                    {!! __('Note: If you logged in using your Google Account, <br>you do not need to enter your password to delete.') !!}
                                </p>
                
                                <div>
                                    <x-secondary-button x-on:click="$dispatch('close')">
                                        {{ __('Cancel') }}
                                    </x-secondary-button>
                
                                    <x-danger-button class="ms-3">
                                        {{ __('Delete Account') }}
                                    </x-danger-button>
                                </div>
                            </div>
                        </form>
                    </x-modal>
            </div>
        </div>
    </div>
    <script>
    document.querySelector('form').addEventListener('submit', function(event) {
        console.log('Form submitted with method:', event.target.method);
    });
    </script>

</x-app-layout>
