<x-auth-layout>
    <x-auth.register-card>
        <form method="POST" action="{{ route('register') }}" class="space-y-4 sm:space-y-5 font-poppins">
            @csrf

            <!-- Name -->
            <div>
                <x-input-label class="text-black text-sm sm:text-base" for="name" :value="__('Username')" />
                <x-text-input id="name" 
                    class="block mt-2 w-full outline-none duration-200 ring-2 ring-transparent focus:ring-primary/70 text-sm sm:text-base px-3 py-2 sm:px-4 sm:py-2.5" 
                    type="text" 
                    name="name" 
                    :value="old('name')"
                    placeholder="Enter your Username"
                    required 
                    autofocus 
                    autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Email Address -->
            <div>
                <x-input-label class="text-black text-sm sm:text-base" for="email" :value="__('Email')" />
                <x-text-input id="email" 
                    class="block mt-2 w-full outline-none duration-200 ring-2 ring-transparent focus:ring-primary/70 text-sm sm:text-base px-3 py-2 sm:px-4 sm:py-2.5" 
                    type="email" 
                    name="email"
                    placeholder="Enter your Email" 
                    :value="old('email')" 
                    required 
                    autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div>
                <x-input-label class="text-black text-sm sm:text-base" for="password" :value="__('Password')" />
                <x-text-input id="password" 
                    class="block mt-2 w-full outline-none duration-200 ring-2 ring-transparent focus:ring-primary/70 text-sm sm:text-base px-3 py-2 sm:px-4 sm:py-2.5"
                    type="password"
                    placeholder="Enter your Password"
                    name="password"
                    required 
                    autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div>
                <x-input-label class="text-black text-sm sm:text-base" for="password_confirmation" :value="__('Confirm Password')" />
                <x-text-input id="password_confirmation" 
                    class="block mt-2 w-full outline-none duration-200 ring-2 ring-transparent focus:ring-primary/70 text-sm sm:text-base px-3 py-2 sm:px-4 sm:py-2.5"
                    type="password"
                    name="password_confirmation" 
                    placeholder="Confirm your Password"
                    required 
                    autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <!-- Submit Button and Login Link -->
            <div class="font-poppins flex flex-col gap-4 pt-2">
                <x-primary-button class="w-full justify-center font-semibold bg-accent3 border-charcoal text-primary hover:text-accent3 hover:bg-primary text-sm sm:text-base py-2.5 sm:py-3 transition-all">
                    {{ __('Create Account') }}
                </x-primary-button>
                
                <div class="text-center">
                    <span class="text-xs sm:text-sm font-medium text-black">
                        Already registered?
                        <a class="underline hover:text-primary font-semibold transition-colors" 
                           href="{{ route('login') }}">
                            {{ __('Log In') }}
                        </a> 
                    </span>   
                </div>
            </div>

            <!-- Divider -->
            <div class="py-4 sm:py-6">
                <x-auth.line-break />
            </div>

            <!-- Google Sign In -->
            <div>
                <a href="{{route('google.auth')}}" class="block">
                    <x-auth.continue-with-google />
                </a>
            </div>
        </form>
    </x-auth.register-card>
</x-auth-layout>
