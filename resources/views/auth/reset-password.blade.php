<x-auth-layout>
    <x-folder class="h-full">
        <x-slot name="header">
            Create New Password
        </x-slot>

        <x-slot name="content">
            <div class="flex w-full h-full">
                    <div class="flex w-4/5 md:flex-row justify-center items-center"> 
                        <!-- Left side with image -->
                        <img src="{{ asset('/images/auth/create-new-password.svg') }}" class="h-[400px] w-[400px]" alt="placeholder" class="max-w-full h-auto mt-10">  
                    </div>

                        <!-- Right side with form -->
                        <div class="w-full flex flex-col items-center justify-center p-4">  
                            <div class="w-4/5">
                                <form method="POST" action="{{ route('password.store') }}">
                                    @csrf

                                    <!-- Password Reset Token -->
                                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                                    <!-- Email Address -->
                                    <div class="mt-4">
                                        <x-input-label class="text-primary" for="email" :value="__('Your Email')" />
                                        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" placeholder="Email.." :value="old('email', $request->email)" required autofocus autocomplete="username"/>
                                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                    </div>

                                    <!-- Password -->
                                    <div class="mt-4">
                                        <x-input-label class="text-primary" for="password" :value="__('Your new password')" />
                                        <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" placeholder="Password.." required autocomplete="new-password" />
                                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                    </div>

                                    <!-- Confirm Password -->
                                    <div class="mt-4">
                                        <x-input-label class="text-primary" for="password_confirmation" :value="__('Confirm your new password')"/>
                                        <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" placeholder="Confirm Password.." required autocomplete="new-password" />
                                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                                    </div>

                                    <!-- Save Password Button -->
                                    <div class="flex justify-end mt-5">
                                        <x-primary-button class="text-[#000000] font-bold w-full max-w-[200px]"> 
                                            {{ __('Save Password') }}
                                        </x-primary-button>
                                    </div>
                                </form>
                            </div>
                        </div>
            </div>
        </x-slot>
    </x-folder>
</x-auth-layout>
