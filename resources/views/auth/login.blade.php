<x-auth-layout>
    <x-auth.login-card>
        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />
        <form method="POST" action="{{ route('login') }}" class="space-y-4 sm:space-y-5">
            @csrf
 
            <!-- Email Address -->
            <div>
                <x-input-label class="text-darkgray text-sm sm:text-base" for="email" :value="__('Email')" />
                <x-text-input id="email" 
                    class="block mt-2 w-full outline-none duration-200 ring-2 ring-transparent focus:ring-primary/70 text-sm sm:text-base px-3 py-2 sm:px-4 sm:py-2.5" 
                    type="email" 
                    name="email" 
                    placeholder="Enter your Email" 
                    :value="old('email')" 
                    required 
                    autofocus 
                    autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div>
                <div class="flex flex-col xs:flex-row xs:justify-between xs:items-center gap-2 mb-2">
                    <x-input-label class="text-darkgray text-sm sm:text-base" for="password" :value="__('Password')" />
                    
                </div>
                
                <x-text-input id="password" 
                    class="block mt-2 w-full outline-none duration-200 ring-2 ring-transparent focus:ring-primary/70 text-sm sm:text-base px-3 py-2 sm:px-4 sm:py-2.5"
                    type="password"
                    name="password"
                    placeholder="Enter your Password"
                    required 
                    autocomplete="current-password" />

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Remember Me -->
            <div class="flex flex-row justify-between items-center gap-2 font-poppins">
                <label for="remember_me" class="inline-flex items-center cursor-pointer">
                    <input id="remember_me" 
                        type="checkbox" 
                        class="rounded border-gray-300 text-primary shadow-sm focus:ring-primary w-4 h-4" 
                        name="remember">
                    <span class="ms-2 text-xs sm:text-sm text-gray-900">{{ __('Remember me') }}</span>
                </label>
                
                @if (Route::has('password.request'))
                    <a class="font-poppins underline text-xs sm:text-sm text-darkgray hover:text-primary transition-colors rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary whitespace-nowrap" 
                       href="{{ route('password.request') }}">
                        {{ __('Forgot password?') }}
                    </a>
                @endif
            </div>

            <!-- Submit Button and Register Link -->
            <div class="font-poppins flex flex-col gap-4 pt-2">
                <x-primary-button class="w-full justify-center font-semibold bg-accent3 border-primary/25 text-primary hover:text-accent3 hover:bg-primary text-sm sm:text-base py-2.5 sm:py-3 transition-all">
                    {{ __('Sign In') }}
                </x-primary-button>
                
                <div class="text-center">
                    <span class="text-xs sm:text-sm font-medium text-darkgray">
                        New User?
                        <a class="underline hover:text-primary font-semibold transition-colors" 
                           href="{{ route('register') }}">
                            {{ __('Create Account') }}
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
    </x-auth.login-card>
</x-auth-layout>
