<x-auth-layout>
    <x-auth.login-card>
        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />
        <form method="POST" action="{{ route('login') }}">
            @csrf
 
            <!-- Email Address -->
            <div>
                <x-input-label class="text-secondary" for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full " 
                                type="email" 
                                name="email" 
                                placeholder="Enter your Email" 
                                required
                                :value="old('email')" required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <div class="flex justify-between">
                    <div>
                        <x-input-label class="text-secondary" for="password" :value="__('Password')" />
                    </div>
                    <div>
                        @if (Route::has('password.request'))
                            <a class=" font-poppins underline text-sm text-secondary hover:text-white rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                                {{ __('Forgot your password?') }}
                            </a>
                        @endif
                    </div>
                </div>
                
                <x-text-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                placeholder="Enter your Password"
                                required autocomplete="current-password" />

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Remember Me -->
            <div class="block mt-4 font-poppins">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                    <span class="ms-2 text-sm text-white">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="font-poppins flex items-center justify-between mt-4">
                <x-primary-button class=" font-semibold">
                    {{ __('Sign In') }}
                </x-primary-button>
                <div>
                        <span class="text-md font-semibold text-secondary 
                            rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            New User?
                            <a class="underline hover:text-white " href="{{ route('register') }}">
                                {{ __('Create Account') }}
                            </a> 
                        </span>   
                </div>

            </div>
            <div class=" py-6">
                <x-auth.line-break />
            </div>
            <div>
                <a href="{{route('google.auth')}}">
                    <x-auth.continue-with-google />
                </a>
                
            </div>
        </form>
    </x-auth.login-card>
</x-auth-layout>
