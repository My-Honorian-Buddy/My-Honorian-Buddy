<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>My Honorian Buddy</title>
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    <link rel="icon" href="{{ asset('/images/favicon.svg') }}" type="image/x-icon">
    <link href="{{ asset('vendor/bladewind/css/bladewind-ui.min.css') }}" rel="stylesheet" />
    <link href="/public/images/myHonorianBuddy.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="{{ asset('vendor/bladewind/js/helpers.js') }}"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <link rel="icon" href="{{ asset('/images/favicon.svg') }}" type="image/x-icon">

    <x-bladewind::notification />
</head>

<body class="font-poppins antialiased bg-[#F0F0F0] text-black">
    <!-- Navbar -->
    <header
        class="sticky top-0 z-50 bg-accent/90 supports-[backdrop-filter]:bg-white/60 backdrop-blur border-b border-black/10 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="h-16 flex items-center justify-between">
                <a href="/" class="inline-flex items-center gap-3">
                    <img src="{{ asset('images/logo.svg') }}" alt="My Honorian Buddy" class="h-8 w-auto">
                    <span class="sr-only">My Honorian Buddy</span>
                </a>
                @if (Route::has('login'))
                    <nav class="flex items-center gap-3 sm:gap-4">
                        @if (Auth::check())
                            <a href="{{ route('workspace.start') }}"
                                class="inline-flex items-center rounded-lg border border-black/20 px-4 py-2 text-sm font-medium hover:bg-black/5 transition">
                                Workspace
                            </a>
                        @else
                            <a href="{{ route('login') }}"
                                class="inline-flex border-2 items-center rounded-lg px-4 py-2 text-sm font-medium text-black hover:text-primary hover:border-2 
                                hover:border-primary/30 transition">
                                Login
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}"
                                    class="inline-flex border-2 border-primary items-center rounded-lg bg-primary text-accent3 px-4 py-2 text-sm font-semibold shadow-sm hover:opacity-85 transition">
                                    Sign Up
                                </a>
                            @endif
                        @endif
                    </nav>
                @endif
            </div>
            <div class="absolute inset-x-0 bottom-0 h-1 bg-black/5">
                <div id="scroll-progress" class="h-full bg-primary w-0"></div>
            </div>
        </div>
    </header>

    <!-- Hero -->
    <section class="relative overflow-hidden bg-gradient-to-br from-primary to-black text-accent3">
        <!-- Subtle pattern + vignette -->
        <div class="absolute inset-0 pointer-events-none">
            <div
                class="h-full w-full opacity-20 bg-[radial-gradient(ellipse_at_top_right,rgba(255,255,255,0.25)_0%,transparent_55%)]">
            </div>
            <div
                class="h-full w-full opacity-10 bg-[repeating-linear-gradient(90deg,rgba(255,255,255,0.15)_0,rgba(255,255,255,0.15)_1px,transparent_1px,transparent_14px)]">
            </div>
        </div>
        <!-- Diagonal white split on right side -->
        <div class="pointer-events-none absolute inset-y-0 right-0 hidden lg:block w-1/2 bg-accent"
            style="clip-path: polygon(18% 0, 100% 0, 100% 100%, 0% 100%);"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center py-16 sm:py-20 lg:py-28">
                <div>
                    <p class="text-sm uppercase tracking-widest text-accent3/70">Focused. Accountable. Together.</p>
                    <h1 class="mt-3 text-4xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight leading-tight">
                        Your Study Adventure Begins Here!
                    </h1>
                    <p class="mt-5 text-base sm:text-lg text-accent3/80 max-w-prose">
                        Find the right study buddy, stay accountable, and reach your goals with a platform designed for
                        productive collaboration.
                    </p>
                    <div class="mt-8 flex items-center gap-3">
                        <a href="#about"
                            class="inline-flex items-center rounded-lg bg-accent text-primary px-6 py-3 text-sm sm:text-base font-semibold shadow-sm hover:bg-white/90 transition">
                            Learn More
                        </a>
                        @if (!Auth::check() && Route::has('register'))
                            <a href="{{ route('register') }}"
                                class="inline-flex items-center rounded-lg border border-accent/30 text-accent3 px-6 py-3 text-sm sm:text-base font-medium hover:bg-white/10 transition">
                                Create Account
                            </a>
                        @endif
                    </div>
                </div>
                <div class="relative">
                    <!-- Minimal supporting vector -->
                    <div
                        class="aspect-[4/3] rounded-2xl bg-white/5 ring-1 ring-white/10 flex items-center justify-center
                        overflow-hidden">
                        <img src="/images/tutoring.jpg" class="w-full h-full object-cover">
                    </div>
                </div>
            </div>
            <div class="border-t border-white/10"></div>
    </section>

    <!-- About -->
    <section id="about" class="py-16 sm:py-20 lg:py-40">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div class="flex justify-center items-center">
                <!-- Minimal supporting vector -->
                <div class="h-[70%] w-[70%] rounded-2xl bg-white/5 ring-1 ring-white/10 flex items-center justify-center
                overflow-hidden">
                    <img src="/images/graduating.jpg" class="w-full h-full object-cover">
                </div>
            </div>
            <div class="max-w-7xl mx-auto px-20 sm:px-6 lg:px-8">
                <div class="relative bg-accent rounded-xl border-2 border-primary/20 shadow-sm overflow-hidden">
                    <div class="absolute inset-y-0 left-0 w-1.5 bg-primary" aria-hidden="true"></div>
                    <div class="p-6 sm:p-8 lg:p-10">
                        <h2 class="text-2xl sm:text-3xl font-bold text-black">Our Purpose</h2>
                        <p class="mt-3 text-lg sm:mt-4 text-black/70 leading-relaxed max-w-3xl">
                            Empowering students to reach their academic potential through collaborative learning, smart
                            matching, and supportive connections. My Honorian Buddy is a focused space to find
                            personalized
                            support, expand knowledge, and grow together.
                        </p>
                    </div>
                </div>
            </div>
        </div>
        
    </section>
    <div class="mt-16 border-t border-black/10"></div>
    <!-- Features -->
    <section class="py-16 sm:py-20 lg:py-24 lg:pb-44">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h3 class="text-2xl sm:text-3xl font-bold text-black text-center">Features</h3>
            <div class="mt-10 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
                <!-- Feature 1 -->
                <div
                    class="group rounded-xl border border-black/10 p-6 bg-accent transition hover:border-2 hover:border-primary/20 hover:-translate-y-1 hover:shadow-md">
                    <div class="flex items-center gap-4">
                        <span
                            class="inline-flex h-10 w-10 items-center justify-center rounded-lg bg-primary/10 text-primary ring-1 ring-primary/20">
                            <!-- Minimal AI icon -->
                            <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <circle cx="12" cy="12" r="3" />
                                <path
                                    d="M12 3v3M21 12h-3M12 21v-3M6 12H3M18 6l-2.1 2.1M6 18l2.1-2.1M6 6l2.1 2.1M18 18l-2.1-2.1" />
                            </svg>
                        </span>
                        <h4 class="text-lg font-semibold text-black">AI-Powered Matching</h4>
                    </div>
                    <p class="mt-3 text-sm text-black/70 leading-relaxed">
                        Get paired with the right study buddy based on goals, schedule, and learning style.
                    </p>
                    <div class="mt-5 h-0.5 bg-black/10 group-hover:bg-primary/30 transition"></div>
                </div>
                <!-- Feature 2 -->
                <div
                    class="group rounded-xl border border-black/10 p-6 bg-accent transition hover:border-2 hover:border-primary/20  hover:-translate-y-1 hover:shadow-md">
                    <div class="flex items-center gap-4">
                        <span
                            class="inline-flex h-10 w-10 items-center justify-center rounded-lg bg-primary/10 text-primary ring-1 ring-primary/20">
                            <!-- Minimal 1-on-1 icon -->
                            <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <path d="M16 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                                <circle cx="9" cy="7" r="3" />
                                <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
                                <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                            </svg>
                        </span>
                        <h4 class="text-lg font-semibold text-black">1-on-1 Study</h4>
                    </div>
                    <p class="mt-3 text-sm text-black/70 leading-relaxed">
                        Focused sessions with accountability to keep momentum and build consistent habits.
                    </p>
                    <div class="mt-5 h-0.5 bg-black/10 group-hover:bg-primary/30 transition"></div>
                </div>

                <!-- Feature 3 -->
                <div
                    class="group rounded-xl border border-black/10 p-6 bg-accent transition hover:border-2 hover:border-primary/20 hover:-translate-y-1 hover:shadow-md">
                    <div class="flex items-center gap-4">
                        <span
                            class="inline-flex h-10 w-10 items-center justify-center rounded-lg bg-primary/10 text-primary ring-1 ring-primary/20">
                            <!-- Minimal video icon -->
                            <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                                <rect x="3" y="5" width="13" height="14" rx="2" />
                                <path d="M16 8l5-3v14l-5-3z" />
                            </svg>
                        </span>
                        <h4 class="text-lg font-semibold text-black">Video Conferencing</h4>
                    </div>
                    <p class="mt-3 text-sm text-black/70 leading-relaxed">
                        Seamless calls for real-time collaboration, screen sharing, and pair problem-solving.
                    </p>
                    <div class="mt-5 h-0.5 bg-black/10 group-hover:bg-primary/30 transition"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats -->
    <section class="py-16 sm:py-20 lg:py-24 pb-16 bg-primary/5 border-y border-black/10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                <div class="text-center">
                    <div class="text-3xl sm:text-4xl font-extrabold text-primary">10k+</div>
                    <p class="mt-1 text-sm text-black/70">Sessions booked</p>
                </div>
                <div class="text-center">
                    <div class="text-3xl sm:text-4xl font-extrabold text-primary">2k+</div>
                    <p class="mt-1 text-sm text-black/70">Active students</p>
                </div>
                <div class="text-center">
                    <div class="text-3xl sm:text-4xl font-extrabold text-primary">95%</div>
                    <p class="mt-1 text-sm text-black/70">Satisfaction rate</p>
                </div>
                <div class="text-center">
                    <div class="text-3xl sm:text-4xl font-extrabold text-primary">
                        < 2min</div>
                            <p class="mt-1 text-sm text-black/70">Avg. match time</p>
                    </div>
                </div>
            </div>
    </section>

    <!-- How it works -->
    <section class="py-16 sm:py-20 lg:py-56">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h3 class="text-2xl sm:text-3xl font-bold text-black text-center">How it works</h3>
            <div class="mt-10 grid grid-cols-1 md:grid-cols-3 gap-6 lg:gap-8">
                <div class="relative rounded-xl border border-black/10 bg-accent p-6">
                    <div
                        class="absolute -top-3 left-6 h-8 w-8 rounded-full bg-primary text-accent3 text-sm font-bold flex items-center justify-center ring-2 ring-white">
                        1</div>
                    <h4 class="text-lg font-semibold text-black">Create your profile</h4>
                    <p class="mt-2 text-sm text-black/70">Add your programs, subjects, availability, and learning
                        preferences.</p>
                </div>
                <div class="relative rounded-xl border border-black/10 bg-accent p-6">
                    <div
                        class="absolute -top-3 left-6 h-8 w-8 rounded-full bg-primary text-accent3 text-sm font-bold flex items-center justify-center ring-2 ring-white">
                        2</div>
                    <h4 class="text-lg font-semibold text-black">Get matched</h4>
                    <p class="mt-2 text-sm text-black/70">Our AI suggests the best buddies based on your goals and
                        schedule.</p>
                </div>
                <div class="relative rounded-xl border border-black/10 bg-accent p-6">
                    <div
                        class="absolute -top-3 left-6 h-8 w-8 rounded-full bg-primary text-accent3 text-sm font-bold flex items-center justify-center ring-2 ring-white">
                        3</div>
                    <h4 class="text-lg font-semibold text-black">Study together</h4>
                    <p class="mt-2 text-sm text-black/70">Chat, schedule calls, and stay accountable as you reach
                        milestones.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="py-16 sm:py-20 lg:py-56 bg-accent3">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h3 class="text-2xl sm:text-3xl font-bold text-black text-center">What students say</h3>
            <div class="mt-10 grid grid-cols-1 md:grid-cols-3 gap-6 lg:gap-8">
                <figure class="rounded-xl border border-black/10 bg-accent p-6">
                    <blockquote class="text-black/80">“I finally stuck to a study routine. Having the right buddy
                        changed everything.”</blockquote>
                    <figcaption class="mt-4 flex items-center gap-3 text-sm text-black/70">
                        <span
                            class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-primary text-white">A</span>
                        <span>Ana, BSIT</span>
                    </figcaption>
                </figure>
                <figure class="rounded-xl border border-black/10 bg-accent p-6">
                    <blockquote class="text-black/80">“Matches were actually relevant to my courses. Super quick and
                        easy.”</blockquote>
                    <figcaption class="mt-4 flex items-center gap-3 text-sm text-black/70">
                        <span
                            class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-primary text-white">J</span>
                        <span>Jared, BSA</span>
                    </figcaption>
                </figure>
                <figure class="rounded-xl border border-black/10 bg-accent p-6">
                    <blockquote class="text-black/80">“The accountability helped me finish projects faster without
                        burning out.”</blockquote>
                    <figcaption class="mt-4 flex items-center gap-3 text-sm text-black/70">
                        <span
                            class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-primary text-white">M</span>
                        <span>Mika, BSHM</span>
                    </figcaption>
                </figure>
            </div>
        </div>
    </section>

    <!-- FAQ -->
    <section class="py-16 sm:py-20 lg:py-24">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <h3 class="text-2xl sm:text-3xl font-bold text-black text-center">FAQ</h3>
            <div class="mt-8 space-y-4">
                <details class="group rounded-xl border border-black/10 bg-accent p-5 open:shadow-sm">
                    <summary class="flex cursor-pointer list-none items-center justify-between">
                        <span class="text-sm sm:text-base font-semibold text-black">Is it free to use?</span>
                        <span
                            class="ml-4 h-6 w-6 rounded-full bg-primary/10 text-primary flex items-center justify-center">+</span>
                    </summary>
                    <div class="mt-3 text-sm text-black/70">Core features are free for students. Advanced tools may be
                        added later.</div>
                </details>
                <details class="group rounded-xl border border-black/10 bg-accent p-5 open:shadow-sm">
                    <summary class="flex cursor-pointer list-none items-center justify-between">
                        <span class="text-sm sm:text-base font-semibold text-black">How are matches made?</span>
                        <span
                            class="ml-4 h-6 w-6 rounded-full bg-primary/10 text-primary flex items-center justify-center">+</span>
                    </summary>
                    <div class="mt-3 text-sm text-black/70">We blend AI with your preferences (subjects, goals, time)
                        for relevant pairs.</div>
                </details>
                <details class="group rounded-xl border border-black/10 bg-accent p-5 open:shadow-sm">
                    <summary class="flex cursor-pointer list-none items-center justify-between">
                        <span class="text-sm sm:text-base font-semibold text-black">Can I use it on mobile?</span>
                        <span
                            class="ml-4 h-6 w-6 rounded-full bg-primary/10 text-primary flex items-center justify-center">+</span>
                    </summary>
                    <div class="mt-3 text-sm text-black/70">Yes. The app is responsive and works well on phones and
                        tablets.</div>
                </details>
            </div>
        </div>
    </section>

    <!-- Final CTA -->
    <section class="pb-16 sm:pb-20 lg:pb-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div
                class="rounded-2xl bg-gradient-to-r from-primary to-black text-accent3 p-8 sm:p-10 lg:p-12 flex flex-col md:flex-row items-start md:items-center justify-between gap-6 ring-1 ring-white/10">
                <div>
                    <h3 class="text-2xl sm:text-3xl font-extrabold">Ready to study smarter?</h3>
                    <p class="mt-2 text-accent3/80 max-w-prose">Join a growing community of focused students. Get
                        matched
                        and start your session in minutes.</p>
                </div>
                <div class="flex items-center gap-3">
                    @if (!Auth::check() && Route::has('register'))
                        <a href="{{ route('register') }}"
                            class="inline-flex items-center rounded-lg bg-accent text-primary px-6 py-3 text-sm sm:text-base font-semibold shadow-sm hover:bg-white/90 transition">Create
                            Account</a>
                    @endif
                    <a href="#about"
                        class="inline-flex items-center rounded-lg border border-white/30 text-accent3 px-6 py-3 text-sm sm:text-base font-medium hover:bg-white/10 transition">Learn
                        More</a>
                </div>
            </div>
        </div>
    </section>

    <div>
        <x-footer />
    </div>

    <script>
        (function() {
            const progressEl = document.getElementById('scroll-progress');

            function updateProgress() {
                const scrollTop = window.scrollY || document.documentElement.scrollTop;
                const docHeight = document.documentElement.scrollHeight - document.documentElement.clientHeight;
                const progress = docHeight > 0 ? (scrollTop / docHeight) * 100 : 0;
                if (progressEl) progressEl.style.width = progress + '%';
            }
            window.addEventListener('scroll', updateProgress, {
                passive: true
            });
            window.addEventListener('resize', updateProgress);
            document.addEventListener('DOMContentLoaded', updateProgress);
        })();
    </script>
</body>

</html>
