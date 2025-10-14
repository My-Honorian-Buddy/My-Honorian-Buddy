<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In / Sign Up</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 flex items-center justify-center p-4">
    
    <div 
        x-data="{ isSignUp: false }" 
        class="w-full max-w-5xl h-[600px] relative overflow-hidden"
    >
         Main Card Container 
        <div class="relative w-full h-full bg-white rounded-2xl shadow-2xl overflow-hidden">
            
             Animated Background Panel (Maroon) 
            <div 
                class="absolute inset-0 w-1/2 h-full bg-[#550000] transition-all duration-700 ease-in-out flex items-center justify-center p-12"
                :class="isSignUp ? 'translate-x-0' : 'translate-x-full'"
            >
                <div class="text-white max-w-md" x-show="!isSignUp" x-transition:enter="transition ease-out duration-500 delay-300" x-transition:enter-start="opacity-0 translate-x-8" x-transition:enter-end="opacity-100 translate-x-0" x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" x-cloak>
                    <h2 class="text-4xl font-bold mb-6">Welcome Back!</h2>
                    <p class="text-lg mb-8 text-gray-200">Sign in to continue your journey with us. Access your account and explore all features.</p>
                    <div class="space-y-4">
                        <div class="flex items-center gap-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>Secure authentication</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>Personalized experience</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>24/7 support access</span>
                        </div>
                    </div>
                </div>

                <div class="text-white max-w-md" x-show="isSignUp" x-transition:enter="transition ease-out duration-500 delay-300" x-transition:enter-start="opacity-0 translate-x-8" x-transition:enter-end="opacity-100 translate-x-0" x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" x-cloak>
                    <h2 class="text-4xl font-bold mb-6">Join Us Today!</h2>
                    <p class="text-lg mb-8 text-gray-200">Create an account and unlock a world of possibilities. Start your journey with us now.</p>
                    <div class="space-y-4">
                        <div class="flex items-center gap-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                            <span>Quick setup process</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                            <span>Free to get started</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                            <span>No credit card required</span>
                        </div>
                    </div>
                </div>
            </div>

             Sign In Form (Left side initially) 
            <div 
                class="absolute inset-0 w-1/2 h-full bg-white transition-all duration-700 ease-in-out flex items-center justify-center p-12"
                :class="isSignUp ? 'translate-x-full' : 'translate-x-0'"
            >
                <div class="w-full max-w-md" x-show="!isSignUp" x-transition:enter="transition ease-out duration-500 delay-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" x-cloak>
                    <h2 class="text-3xl font-bold text-gray-900 mb-2">Sign In</h2>
                    <p class="text-gray-600 mb-8">Enter your credentials to access your account</p>
                    
                    <form action="{{ route('login') }}" method="POST" class="space-y-6">
                        @csrf
                        
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                            <input 
                                type="email" 
                                id="email" 
                                name="email" 
                                required 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#550000] focus:border-transparent transition-all outline-none"
                                placeholder="you@example.com"
                            >
                        </div>

                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                            <input 
                                type="password" 
                                id="password" 
                                name="password" 
                                required 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#550000] focus:border-transparent transition-all outline-none"
                                placeholder="••••••••"
                            >
                        </div>

                        <div class="flex items-center justify-between">
                            <label class="flex items-center">
                                <input type="checkbox" name="remember" class="w-4 h-4 text-[#550000] border-gray-300 rounded focus:ring-[#550000]">
                                <span class="ml-2 text-sm text-gray-600">Remember me</span>
                            </label>
                            <a href="#" class="text-sm text-[#550000] hover:text-[#770000] transition-colors">Forgot password?</a>
                        </div>

                        <button 
                            type="submit" 
                            class="w-full bg-[#550000] text-white py-3 rounded-lg font-semibold hover:bg-[#770000] transition-all duration-300 shadow-lg hover:shadow-xl"
                        >
                            Sign In
                        </button>
                    </form>

                    <div class="mt-8 text-center">
                        <p class="text-gray-600">
                            Don't have an account? 
                            <button 
                                @click="isSignUp = true" 
                                class="text-[#550000] font-semibold hover:text-[#770000] transition-colors"
                            >
                                Sign Up
                            </button>
                        </p>
                    </div>
                </div>

                 Sign Up Form (Right side when active) 
                <div class="w-full max-w-md" x-show="isSignUp" x-transition:enter="transition ease-out duration-500 delay-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" x-cloak>
                    <h2 class="text-3xl font-bold text-gray-900 mb-2">Sign Up</h2>
                    <p class="text-gray-600 mb-8">Create your account to get started</p>
                    
                    <form action="{{ route('register') }}" method="POST" class="space-y-6">
                        @csrf
                        
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                            <input 
                                type="text" 
                                id="name" 
                                name="name" 
                                required 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#550000] focus:border-transparent transition-all outline-none"
                                placeholder="John Doe"
                            >
                        </div>

                        <div>
                            <label for="signup-email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                            <input 
                                type="email" 
                                id="signup-email" 
                                name="email" 
                                required 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#550000] focus:border-transparent transition-all outline-none"
                                placeholder="you@example.com"
                            >
                        </div>

                        <div>
                            <label for="signup-password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                            <input 
                                type="password" 
                                id="signup-password" 
                                name="password" 
                                required 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#550000] focus:border-transparent transition-all outline-none"
                                placeholder="••••••••"
                            >
                        </div>

                        <div>
                            <label for="password-confirm" class="block text-sm font-medium text-gray-700 mb-2">Confirm Password</label>
                            <input 
                                type="password" 
                                id="password-confirm" 
                                name="password_confirmation" 
                                required 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#550000] focus:border-transparent transition-all outline-none"
                                placeholder="••••••••"
                            >
                        </div>

                        <button 
                            type="submit" 
                            class="w-full bg-[#550000] text-white py-3 rounded-lg font-semibold hover:bg-[#770000] transition-all duration-300 shadow-lg hover:shadow-xl"
                        >
                            Sign Up
                        </button>
                    </form>

                    <div class="mt-8 text-center">
                        <p class="text-gray-600">
                            Already have an account? 
                            <button 
                                @click="isSignUp = false" 
                                class="text-[#550000] font-semibold hover:text-[#770000] transition-colors"
                            >
                                Sign In
                            </button>
                        </p>
                    </div>
                </div>
            </div>

        </div>

         Mobile Responsive View 
        <div class="md:hidden absolute inset-0 bg-white rounded-2xl shadow-2xl p-6 flex flex-col">
            <div class="flex-1 flex items-center justify-center">
                <div class="w-full max-w-md" x-show="!isSignUp">
                    <div class="bg-[#550000] text-white p-6 rounded-xl mb-6">
                        <h2 class="text-2xl font-bold mb-2">Welcome Back!</h2>
                        <p class="text-sm text-gray-200">Sign in to continue</p>
                    </div>
                    
                    <form action="{{ route('login') }}" method="POST" class="space-y-4">
                        @csrf
                        <input type="email" name="email" required placeholder="Email" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#550000] focus:border-transparent outline-none">
                        <input type="password" name="password" required placeholder="Password" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#550000] focus:border-transparent outline-none">
                        <button type="submit" class="w-full bg-[#550000] text-white py-3 rounded-lg font-semibold">Sign In</button>
                    </form>
                    
                    <p class="text-center mt-6 text-gray-600">
                        Don't have an account? 
                        <button @click="isSignUp = true" class="text-[#550000] font-semibold">Sign Up</button>
                    </p>
                </div>

                <div class="w-full max-w-md" x-show="isSignUp">
                    <div class="bg-[#550000] text-white p-6 rounded-xl mb-6">
                        <h2 class="text-2xl font-bold mb-2">Join Us Today!</h2>
                        <p class="text-sm text-gray-200">Create your account</p>
                    </div>
                    
                    <form action="{{ route('register') }}" method="POST" class="space-y-4">
                        @csrf
                        <input type="text" name="name" required placeholder="Full Name" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#550000] focus:border-transparent outline-none">
                        <input type="email" name="email" required placeholder="Email" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#550000] focus:border-transparent outline-none">
                        <input type="password" name="password" required placeholder="Password" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#550000] focus:border-transparent outline-none">
                        <input type="password" name="password_confirmation" required placeholder="Confirm Password" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#550000] focus:border-transparent outline-none">
                        <button type="submit" class="w-full bg-[#550000] text-white py-3 rounded-lg font-semibold">Sign Up</button>
                    </form>
                    
                    <p class="text-center mt-6 text-gray-600">
                        Already have an account? 
                        <button @click="isSignUp = false" class="text-[#550000] font-semibold">Sign In</button>
                    </p>
                </div>
            </div>
        </div>
    </div>

</body>
</html>