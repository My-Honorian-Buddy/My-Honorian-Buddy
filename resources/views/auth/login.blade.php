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
                
                <div class="relative flex items-center">
                    <x-text-input id="password" 
                        class="block mt-2 w-full outline-none duration-200 ring-2 ring-transparent focus:ring-primary/70 text-sm sm:text-base px-3 py-2 sm:px-4 sm:py-2.5 pr-10"
                        type="password"
                        name="password"
                        placeholder="Enter your Password"
                        required 
                        autocomplete="current-password" />
                    
                    <button type="button" id="togglePassword" class="absolute right-3 text-darkgray hover:text-primary transition-colors focus:outline-none flex items-center justify-center">
                        <svg id="eyeIcon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                    </button>
                </div>

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
                <x-primary-button class="w-full justify-center font-semibold bg-accent3 
                text-primary hover:text-accent3 hover:bg-primary text-sm sm:text-base py-2.5 sm:py-3 transition-all">
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggleButton = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');

        if (toggleButton && passwordInput) {
            toggleButton.addEventListener('click', function(e) {
                e.preventDefault();
                
                // Toggle input type
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                
                // Toggle icon
                if (type === 'text') {
                    eyeIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>';
                } else {
                    eyeIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>';
                }
            });
        }
    });
</script>
