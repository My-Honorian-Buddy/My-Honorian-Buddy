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
                <div class="relative flex items-center">
                    <x-text-input id="password" 
                        class="block mt-2 w-full outline-none duration-200 ring-2 ring-transparent focus:ring-primary/70 text-sm sm:text-base px-3 py-2 sm:px-4 sm:py-2.5 pr-10"
                        type="password"
                        placeholder="Enter your Password"
                        name="password"
                        required 
                        autocomplete="new-password" />
                    
                    <button type="button" id="togglePassword" class="absolute right-3 text-gray-600 hover:text-primary transition-colors focus:outline-none flex items-center justify-center">
                        <svg id="eyeIcon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                    </button>
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div>
                <x-input-label class="text-black text-sm sm:text-base" for="password_confirmation" :value="__('Confirm Password')" />
                <div class="relative flex items-center">
                    <x-text-input id="password_confirmation" 
                        class="block mt-2 w-full outline-none duration-200 ring-2 ring-transparent focus:ring-primary/70 text-sm sm:text-base px-3 py-2 sm:px-4 sm:py-2.5 pr-10"
                        type="password"
                        name="password_confirmation" 
                        placeholder="Confirm your Password"
                        required 
                        autocomplete="new-password" />
                    
                    <button type="button" id="togglePasswordConfirm" class="absolute right-3 text-gray-600 hover:text-primary transition-colors focus:outline-none flex items-center justify-center">
                        <svg id="eyeIconConfirm" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                    </button>
                </div>
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Password toggle
        const toggleButton = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');

        if (toggleButton && passwordInput) {
            toggleButton.addEventListener('click', function(e) {
                e.preventDefault();
                
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                
                if (type === 'text') {
                    eyeIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>';
                } else {
                    eyeIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>';
                }
            });
        }

        // Confirm password toggle
        const toggleButtonConfirm = document.getElementById('togglePasswordConfirm');
        const passwordConfirmInput = document.getElementById('password_confirmation');
        const eyeIconConfirm = document.getElementById('eyeIconConfirm');

        if (toggleButtonConfirm && passwordConfirmInput) {
            toggleButtonConfirm.addEventListener('click', function(e) {
                e.preventDefault();
                
                const type = passwordConfirmInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordConfirmInput.setAttribute('type', type);
                
                if (type === 'text') {
                    eyeIconConfirm.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>';
                } else {
                    eyeIconConfirm.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>';
                }
            });
        }
    });
</script>
