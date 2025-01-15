<x-auth-layout>
    <x-auth.register-card>
    <form class="font-poppins" method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label  class="text-secondary" for="name" :value="__('Username')" />
            <x-text-input id="name" 
                            class="block mt-1 w-full" type="text" 
                            name="name" :value="old('name')"
                            placeholder="Enter your Username"
                            required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label class="text-secondary" for="email" :value="__('Email')" />
            <x-text-input id="email" 
                            class="block mt-1 w-full" 
                            type="email" name="email"
                            placeholder="Enter your Email" 
                            :value="old('email')" 
                            required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label class="text-secondary" for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            placeholder="Enter your Password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label class="text-secondary" for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" 
                            placeholder="Confirm your Password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex justify-between items-center mt-10">
            <x-primary-button class="font-semibold bg-accent2 lg:text-base">
                {{ __('Create Account') }}
            </x-primary-button>
            <span class="lg:text-sm xl:text-sm font-semibold text-secondary 
                            rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Already registered? 
                <a class="underline hover:text-white " href="{{ route('login') }}">
                    {{ __('Log In') }}
                </a> 
            </span> 

        </div>
        <div class=" py-6 pt-14">
                <x-auth.line-break />
            </div>
            <div>
                <a href="{{route('google.auth')}}">
                    <x-auth.continue-with-google />
                </a>
            </div>
    </form>
</x-auth.register-card>
</x-auth-layout>
