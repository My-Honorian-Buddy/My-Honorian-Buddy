<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>About Us</title>
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    <link href="{{ asset('vendor/bladewind/css/bladewind-ui.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="{{ asset('vendor/bladewind/js/helpers.js') }}"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <link rel="icon" href="{{ asset('/images/favicon.svg') }}" type="image/x-icon">
    <style>
        @media (max-width: 1024px) {
            .hero-section { flex-direction: column !important; justify-content: center !important; }
            .hero-content-wrapper { width: 100% !important; }
            .hero-image { position: relative !important; top: auto !important; right: auto !important; margin-top: 2rem !important; width: 100% !important; max-width: 400px !important; margin-left: auto !important; margin-right: auto !important; }
        }
        
        @media (max-width: 768px) {
            .hero-section { padding: 2rem 1rem !important; }
            .hero-content-wrapper { text-align: center !important; }
            .hero-title { font-size: 2rem !important; text-align: center !important; }
            .hero-learning-flex { justify-content: center !important; }
            .hero-large-text { font-size: 2.5rem !important; }
            .hero-image { width: 100% !important; max-width: 300px !important; }
            
            .mission-container { flex-direction: column !important; padding: 1rem !important; padding-top: 2rem !important; }
            .mission-box { width: 100% !important; height: auto !important; }
            .mission-title { position: static !important; margin: 1rem 0 !important; }
            .mission-image { position: static !important; margin-top: 1.5rem !important; left: auto !important; }
            .mission-heading { font-size: 1.75rem !important; padding-top: 1rem !important; padding: 1rem !important; position: static !important; }
            .mission-paragraph { font-size: 0.9rem !important; padding-top: 1rem !important; padding-left: 1rem !important; padding-right: 1rem !important; text-align: left !important; margin-top: 0.5rem !important; position: static !important; }
            
            .vision-container { flex-direction: column !important; padding: 1rem !important; margin-top: 2rem !important; margin-bottom: 2rem !important; }
            .vision-box { width: 100% !important; height: auto !important; }
            .vision-title { position: static !important; margin: 1rem 0 !important; bottom: auto !important; right: auto !important; }
            .vision-image { position: static !important; margin-top: 1.5rem !important; right: auto !important; }
            .vision-heading { font-size: 1.75rem !important; padding-top: 1rem !important; padding: 1rem !important; position: static !important; }
            .vision-paragraph { font-size: 0.9rem !important; padding-top: 1rem !important; padding-left: 1rem !important; padding-right: 1rem !important; text-align: left !important; margin-top: 0.5rem !important; position: static !important; }
            
            .how-it-works-title { font-size: 3rem !important; margin-left: 0 !important; }
            .how-it-works-flex { flex-direction: column !important; margin-top: 2rem !important; margin-bottom: 2rem !important; }
            .how-it-works-image { position: static !important; margin: 1.5rem 0 !important; }
            
            .step-box { width: 100% !important; height: auto !important; }
            .step-title { font-size: 2rem !important; margin-left: 0 !important; }
            .step-description { font-size: 1rem !important; margin-left: 0 !important; }
            .step-image { position: static !important; margin-left: auto !important; margin-right: auto !important; width: auto !important; }
            
            .group-section { flex-direction: column !important; gap: 2rem !important; }
            .group-section img { max-width: 80% !important; height: auto !important; }
            .about-creators-title { margin-left: 0 !important; margin-top: 0 !important; }
            .creators-title-text { font-size: 3rem !important; }
            
            .founding-story { width: 100% !important; height: auto !important; }
            .founding-story-text { margin: 1rem !important; }
            
            .team-members-row { flex-direction: column !important; gap: 1.5rem !important; padding: 1rem !important; }
            .team-member-card { width: 100% !important; max-width: 250px !important; margin: 0 auto !important; }
            
            .marquee-text { font-size: 1.5rem !important; }

            .banner { height: 50px !important; }
            .banner-text { font-size: 1.2rem !important; }
        }
        
        @media (max-width: 480px) {
            .hero-section { padding: 1rem 0.5rem !important; }
            .hero-content-wrapper { text-align: center !important; padding: 7rem 0 !important; }
            .hero-title { font-size: 1.5rem !important; text-align: center !important; }
            .hero-learning-flex { flex-direction: column !important; align-items: center !important; justify-content: center !important; }
            .hero-large-text { font-size: 2.5rem !important; padding: 0 0.5rem !important; }
            .hero-is-text { font-size: 1.25rem !important; margin-left: 0 !important; margin-top: 0.5rem !important; }
            .hero-image { width: 100% !important; max-width: 250px !important; }
            
            .how-it-works-title { font-size: 3.5rem !important; }
            .step-title { font-size: 1.3rem !important; }
            .step-description { font-size: 0.9rem !important; }
            
            .founders-title-text { font-size: 1rem !important; }
            .founding-story-text { margin: 0.5rem !important; font-size: 0.9rem !important; padding: 1rem !important; }
            .mission-heading { font-size: 1.4rem !important; padding: 0.75rem !important; }
            .mission-paragraph { font-size: 0.8rem !important; padding: 0.75rem !important; }
            .vision-heading { font-size: 1.4rem !important; padding: 0.75rem !important; }
            .vision-paragraph { font-size: 0.8rem !important; padding: 0.75rem !important; }

            .hidden-image { display: none !important; }

        }
    </style>
</head>

<!-- nav bar -->
<x-nav-bar />

<body class="font-poppins font-semibold">

    <!-- first page -->
    <div class="hero-section w-full h-full bg-[#F5EFEF] overflow-hidden" style="padding: 5rem; display: flex; justify-content: space-between; align-items: center; gap: 2rem; flex-wrap: wrap;">
        <div class="hero-content-wrapper" style="display: flex; flex-direction: column; text-align: left; flex: 1; min-width: 300px;">
            <h1 class="hero-title font-black text-charcoal" style="font-size: 3rem;" data-aos="fade-up" data-aos-delay="300"
                data-aos-duration="1500">
                WE BELIEVE THAT
            </h1>
            <div class="hero-learning-flex justify-center" style="display: flex; align-items: center; justify-content: items-center; flex-wrap: wrap;" data-aos="fade-up" data-aos-delay="300" data-aos-duration="1500">
                <div class="hero-large-text relative inline-block font-dela text-primary" style="font-size: 5rem; padding: 0 1.5rem; position: relative;">
                    LEARNING
                </div>
                <div class="hero-is-text font-black" style="margin-left: 1rem; font-size: 1.875rem;">
                    IS...
                </div>
            </div>
            <div style="display: flex; flex-direction: column; align-items: center; margin-top: 1rem;" data-aos="fade-left" data-aos-delay="300"
                data-aos-duration="1500">
                <div class="hero-large-text font-dela"
                    style="display: inline-block; background-color: #FDFBFB; color: #550000; border: 2px solid black; border-radius: 0.375rem; font-size: 5rem; padding: 0 1.5rem; transform: translateZ(0);">
                    BETTER
                </div>
                <div class=" hero-large-text font-dela"
                    style="position: relative; display: inline-block; border-radius: 0.375rem; width: auto; padding: 0 1.5rem; background-color: #550000; color: #FDFBFB; font-size: 5rem; border: 2px solid black; transform: translateZ(0); margin-top: 0.5rem; margin-bottom: 1.5rem;">
                    TOGETHER
                </div>
            </div>
        </div>
        <div class="hero-image hidden-image" style="flex: 1; min-width: 250px; display: flex; justify-content: center; align-items: center;" data-aos="fade-right" data-aos-delay="300"
            data-aos-duration="1500">
            <img src="{{ asset('/images/teaching.svg') }}" style="width: 100%; height: auto; max-width: 500px;">
        </div>
    </div>

    <div class="banner font-dela bg-primary overflow-hidden h-[86px] relative">
        <div class="banner-text text-[40px] animate-marquee tracking-widest items-center whitespace-nowrap flex space-x-8 h-full">
            <span class="font-bold text-accent">BETTER TOGETHER</span>
            <span class="text-2xl">☀️</span>
            <span class="font-bold text-accent">BETTER TOGETHER</span>
            <span class="text-2xl">☀️</span>
            <span class="font-bold text-accent">BETTER TOGETHER</span>
            <span class="text-2xl">☀️</span>
            <span class="font-bold text-accent">BETTER TOGETHER</span>
            <span class="text-2xl">☀️</span>
            <span class="font-bold text-accent">BETTER TOGETHER</span>
            <span class="text-2xl">☀️</span>
            <span class="font-bold text-accent">BETTER TOGETHER</span>
            <span class="text-2xl">☀️</span>
            <span class="font-bold text-accent">BETTER TOGETHER</span>
            <span class="text-2xl">☀️</span>
            <span class="font-bold text-accent">BETTER TOGETHER</span>
            <span class="text-2xl">☀️</span>
            <span class="font-bold text-accent">BETTER TOGETHER</span>
            <span class="text-2xl">☀️</span>
            <span class="font-bold text-accent">BETTER TOGETHER</span>
            <span class="text-2xl">☀️</span>
            <span class="font-bold text-accent">BETTER TOGETHER</span>
            <span class="text-2xl">☀️</span>
            <span class="font-bold text-accent">BETTER TOGETHER</span>
            <span class="text-2xl">☀️</span>
            <span class="font-bold text-accent">BETTER TOGETHER</span>
            <span class="text-2xl">☀️</span>
            <span class="font-bold text-accent">BETTER TOGETHER</span>
            <span class="text-2xl">☀️</span>
            <span class="font-bold text-accent">BETTER TOGETHER</span>
            <span class="text-2xl">☀️</span>
            <span class="font-bold text-accent">BETTER TOGETHER</span>
            <span class="text-2xl">☀️</span>
            <span class="font-bold text-accent">BETTER TOGETHER</span>
            <span class="text-2xl">☀️</span>
            <span class="font-bold text-accent">BETTER TOGETHER</span>
            <span class="text-2xl">☀️</span>
            <span class="font-bold text-accent">BETTER TOGETHER</span>
            <span class="text-2xl">☀️</span>
            <span class="font-bold text-accent">BETTER TOGETHER</span>
            <span class="text-2xl">☀️</span>
            <span class="font-bold text-accent">BETTER TOGETHER</span>
            <span class="text-2xl">☀️</span>
            <span class="font-bold text-accent">BETTER TOGETHER</span>
            <span class="text-2xl">☀️</span>
            <span class="font-bold text-accent">BETTER TOGETHER</span>
            <span class="text-2xl">☀️</span>
            <span class="font-bold text-accent">BETTER TOGETHER</span>
            <span class="text-2xl">☀️</span>
        </div>
    </div>

    <!-- second page -->
    <div class="bg-[#F5EFEF] relative w-full h-full !pb-[5rem]" style="padding: 0 1.25rem;">

        <!-- our mission contents container -->
        <div class="mission-container" style="display: flex; align-items: center; position: relative; padding: 2.5rem;" data-aos="fade-right" data-aos-delay="300"
            data-aos-duration="1000">
            <div
                class="mission-box bg-accent rounded-md border-black border-2 overflow-hidden"
                style="height: auto; width: 650px; padding-bottom: 0.5rem; margin-bottom: 1rem;">
                <!-- our mission contents -->
                <div style="height: auto; position: relative; display: flex; align-items: center; flex-direction: column;">
                    
                    <h1 class="mission-heading" style="position: relative; z-index: 10; padding-top: 5.5rem; padding: 1.5rem; font-family: poppins; font-size: 3rem; font-weight: 900;">
                        WHY WE ARE HERE.
                    </h1>
                    <p class="mission-paragraph text-justify" style="position: relative; z-index: 10; padding-left: 2.5rem; padding-right: 2.5rem; font-size: 1.25rem; font-weight: 700;">
                        At <i>My Honorian Buddy</i>, we're driven by a commitment to empower students to thrive
                        academically
                        and personally. We believe that learning is most effective when it's collaborative, adaptive,
                        and tailored
                        to individual needs. Through content-based matching algorithm, we connect students with peers
                        who can
                        offer the right support, mentorship, and encouragement. Our platform fosters a supportive
                        learning community
                        where students can share knowledge, overcome academic challenges, and build meaningful
                        connections. With
                        <i>My Honorian Buddy</i>, every student has the tools, resources, and network to unlock their
                        full potential and
                        achieve their educational goals.
                    </p>
                </div>
            </div>

            <!-- our mission title container -->
            <div
                class="mission-title text-charcoal border-charcoal"
                style="position: absolute; top: 155px; right: 650px; margin-top: -2.5rem; background-color: #FDFBFB; border-radius: 0.375rem; padding-top: 0.5rem; padding-bottom: 0.5rem; border: 2px solid;">
                <!-- our mission title-->
                <div style="display: inline-block; padding: 0.5rem 1rem; text-align: center; font-size: 1.125rem; font-weight: 900;">
                    <span style="white-space: nowrap; font-size: 2.25rem; font-weight: 800; font-family: poppins;">OUR MISSION</span>
                </div>
            </div>

            <div class="mission-image hidden-image" style="height: auto; width: auto; margin-top: 6.25rem; left: 550px;" data-aos="fade-left" data-aos-delay="300"
                data-aos-duration="1000">
                <img src="{{ asset('images/bro_reading.svg') }}" style="width: 100%; height: auto;">
            </div>

        </div>

        <!-- our vision contents container -->
        <div class="vision-container" style="display: flex; align-items: center; position: relative; padding: 2.5rem; margin-top: 9.375rem; margin-bottom: 9.375rem;" data-aos="zoom-in-left"
            data-aos-delay="300" data-aos-duration="1000">
            <div
                class="vision-box bg-accent rounded-md border-black border-2 pt-0.5 pb-0.5 mb-1 shadow-black
            overflow-hidden"
                style="height: 380px; width: 700px; margin-left: auto;">
                <!-- our vision contents -->
                <div style="position: relative; display: flex; flex-direction: column; align-items: center;">
                    <h1 class="vision-heading" style="position: relative; z-index: 10; padding: 2.5rem; font-family: poppins; font-size: 3rem; font-weight: 900;">
                        THE FUTURE WE AIM FOR.
                    </h1>
                    <p class="vision-paragraph" style="position: relative; z-index: 10; padding-left: 2.5rem; padding-right: 2.5rem; font-size: 1.25rem; font-weight: 700; text-align: justify;">
                        To become a platform that transforms academic journeys by fostering meaningful peer connections,
                        personalized support, and collaborative learning, empowering students to achieve their fullest
                        potential and excel together in a community built on shared knowledge and trust.
                    </p>
                </div>
            </div>

            <!-- our vision title container -->
            <div
                class="vision-title text-charcoal border-charcoal"
                style="position: absolute; bottom: 1.25rem; right: 85px; transform: translateY(1.25rem); background-color: #FDFBFB; border-radius: 0.375rem; padding-top: 0.5rem; padding-bottom: 0.5rem; border: 2px solid;">
               <!-- our vision title-->
                <div style="display: inline-block; padding: 0.5rem 1rem; text-align: center; font-size: 1.125rem; font-weight: 900;">
                    <span style="white-space: nowrap; font-size: 2.25rem; font-weight: 800; font-family: poppins;">OUR VISION</span>
                </div>
            </div>

            <div class="vision-image hidden-image" style="position: absolute; height: auto; width: auto; right: 600px;" data-aos="zoom-in-right" data-aos-delay="300"
                data-aos-duration="1000">
                <img src="{{ asset('images/bro_imagination.svg') }}" style="width: 100%; height: auto;">
            </div>

        </div>
    </div>

    <div class="banner font-dela text-stroke bg-charcoal overflow-hidden h-[86px] relative z-0">
        <div class="banner-text text-[40px] animate-reverse_marquee items-center whitespace-nowrap flex space-x-8 h-full">
            <span class="font-bold text-accent">BUDDY SYSTEM</span>
            <span class="text-2xl">☀️</span>
            <span class="font-bold text-accent">BRIGHTER MINDS</span>
            <span class="text-2xl">☀️</span>
            <span class="font-bold text-accent">BUDDY SYSTEM</span>
            <span class="text-2xl">☀️</span>
            <span class="font-bold text-accent">BRIGHTER MINDS</span>
            <span class="text-2xl">☀️</span>
            <span class="font-bold text-accent">BUDDY SYSTEM</span>
            <span class="text-2xl">☀️</span>
            <span class="font-bold text-accent">BRIGHTER MINDS</span>
            <span class="text-2xl">☀️</span>
            <span class="font-bold text-accent">BUDDY SYSTEM</span>
            <span class="text-2xl">☀️</span>
            <span class="font-bold text-accent">BRIGHTER MINDS</span>
            <span class="text-2xl">☀️</span>
            <span class="font-bold text-accent">BUDDY SYSTEM</span>
            <span class="text-2xl">☀️</span>
            <span class="font-bold text-accent">BRIGHTER MINDS</span>
            <span class="text-2xl">☀️</span>
            <span class="font-bold text-accent">BUDDY SYSTEM</span>
            <span class="text-2xl">☀️</span>
            <span class="font-bold text-accent">BRIGHTER MINDS</span>
            <span class="text-2xl">☀️</span>
            <span class="font-bold text-accent">BUDDY SYSTEM</span>
            <span class="text-2xl">☀️</span>
            <span class="font-bold text-accent">BRIGHTER MINDS</span>
            <span class="text-2xl">☀️</span>
            <span class="font-bold text-accent">BUDDY SYSTEM</span>
            <span class="text-2xl">☀️</span>
            <span class="font-bold text-accent">BRIGHTER MINDS</span>
            <span class="text-2xl">☀️</span>
            <span class="font-bold text-accent">BUDDY SYSTEM</span>
            <span class="text-2xl">☀️</span>
            <span class="font-bold text-accent">BRIGHTER MINDS</span>
            <span class="text-2xl">☀️</span>
            <span class="font-bold text-accent">BUDDY SYSTEM</span>
            <span class="text-2xl">☀️</span>
            <span class="font-bold text-accent">BRIGHTER MINDS</span>
            <span class="text-2xl">☀️</span>
            <span class="font-bold text-accent">BUDDY SYSTEM</span>
            <span class="text-2xl">☀️</span>
            <span class="font-bold text-accent">BRIGHTER MINDS</span>
            <span class="text-2xl">☀️</span>
            <span class="font-bold text-accent">BUDDY SYSTEM</span>
            <span class="text-2xl">☀️</span>
            <span class="font-bold text-accent">BRIGHTER MINDS</span>
            <span class="text-2xl">☀️</span>
        </div>
    </div>

    <!-- third page -->
    <div class="bg-[#F5EFEF] relative w-full h-full" style="padding: 5rem 1.25rem;">
        <div class="how-it-works-flex" style="display: flex; justify-content: center; align-items: center; margin-bottom: 6.25rem; gap: 2.5rem; margin-bottom: 0;"
            data-aos="zoom-in-down" data-aos-delay="300" data-aos-duration="1000">
            <h1
                class="how-it-works-title text-charcoal font-dela" style="font-size: 6rem; margin-left: -6.25rem; text-align: center;">
                HOW IT <br> WORKS
            </h1>
            <div class="how-it-works-image hidden-image" style="display: flex; align-items: center; justify-content: center;">
                <img src="{{ asset('images/bro_thinking.svg') }}" style="width: 80%; height: auto;">
            </div>
        </div>

        <!-- contents container -->
        <div style="display: flex; flex-direction: column; gap: 2.5rem; align-items: center; justify-content: center; position: relative; margin-top: 1.25rem;">

            <!-- sign up -->
            <div class="step-box relative bg-accent rounded-md border-charcoal border-2"
                style="height: 260px; width: 1000px; padding: 2.5rem;"
                data-aos="fade-up" data-aos-anchor-placement="top-bottom" data-aos-delay="300"
                data-aos-duration="1000">
                <h1 class="step-title font-poppins font-black" style="font-size: 4.375rem; margin-left: 300px;">
                    Sign Up
                </h1>
                <p class="step-description font-poppins font-semibold" style="font-size: 1.5rem; margin-left: 300px;">
                    Create a profile as a tutor or student showcase your interests, expertise, and academic goals.
                </p>
                <div class="step-image" style="position: absolute; margin-top: 1.5rem; margin-left: 2.5rem; height: auto; width: 220px; inset: 0;">
                    <img src="{{ asset('images/bro_signup.svg') }}" alt="sign up" style="width: 100%; height: auto;">
                </div>
            </div>

            <!-- match with a buddy -->
            <div class="step-box relative bg-accent rounded-md border-charcoal border-2 overflow-hidden"
                style="height: 260px; width: 1000px; padding: 2.5rem;"
                data-aos="fade-up" data-aos-anchor-placement="top-bottom" data-aos-delay="300"
                data-aos-duration="1000">
                <h1 class="step-title font-poppins font-black" style="font-size: 3.75rem; margin-left: 0.5rem;">
                    Match with a Buddy
                </h1>
                <p class="step-description font-poppins font-semibold" style="font-size: 1.5rem; margin-left: 0.5rem;">
                    Use content-based algorithm to discover the
                    <br> perfect tutor suited to your unique learning needs.
                </p>
                <div class="step-image" style="position: absolute; margin-left: 45rem; margin-top: 0.938rem; height: auto; width: 220px; inset: 0;">
                    <img src="{{ asset('images/bro_buddy.svg') }}" alt="match with a buddy" style="width: 100%; height: auto;">
                </div>
            </div>

            <!-- book sessions -->
            <div class="step-box relative bg-accent rounded-md border-charcoal border-2"
                style="height: 260px; width: 1000px; padding: 2.5rem;"
                data-aos="fade-up" data-aos-anchor-placement="top-bottom" data-aos-delay="300"
                data-aos-duration="1000">
                <h1 class="step-title font-poppins font-black" style="font-size: 4.375rem; margin-left: 350px;">
                    Book Sessions
                </h1>
                <p class="step-description font-poppins font-semibold" style="font-size: 1.5rem; margin-left: 350px;">
                    Set appointments with available tutors and schedule sessions at your convenience.
                </p>
                <div class="step-image" style="position: absolute; margin-top: 4rem; margin-left: 2.5rem; height: auto; width: 220px; inset: 0;">
                    <img src="{{ asset('images/bro_sessions.svg') }}" alt="book sessions" style="width: 100%; height: auto;">
                </div>
            </div>

            <!-- learn and connect -->
            <div class="step-box relative bg-accent rounded-md border-charcoal border-2 overflow-hidden"
                style="height: 260px; width: 1000px; padding: 2.5rem;"
                data-aos="fade-up" data-aos-anchor-placement="top-bottom" data-aos-delay="300"
                data-aos-duration="1000">
                <h1 class="step-title font-poppins font-black" style="font-size: 3.75rem; margin-left: 0.5rem;">
                    Learn and Connect
                </h1>
                <p class="step-description font-poppins font-semibold" style="font-size: 1.5rem; margin-left: 0.5rem;">
                    Participate in sessions and receive personalized
                    <br> guidance to enhance your learning experience.
                </p>
                <div class="step-image" style="position: absolute; margin-left: 42.5rem; margin-top: 1.563rem; height: auto; width: 250px; inset: 0;">
                    <img src="{{ asset('images/bro_connect.svg') }}" alt="learn and connect" style="width: 100%; height: auto;">
                </div>
            </div>
        </div>
    </div>

    <div class="banner font-dela text-stroke bg-primary overflow-hidden h-[86px] relative">
        <div class="banner-text text-[40px] animate-marquee items-center whitespace-nowrap flex space-x-8 h-full">
            <span class="font-bold text-accent">MEET THE TEAM</span>
            <span class="text-2xl">☀️</span>
            <span class="font-bold text-accent">MEET THE TEAM</span>
            <span class="text-2xl">☀️</span>
            <span class="font-bold text-accent">MEET THE TEAM</span>
            <span class="text-2xl">☀️</span>
            <span class="font-bold text-accent">MEET THE TEAM</span>
            <span class="text-2xl">☀️</span>
            <span class="font-bold text-accent">MEET THE TEAM</span>
            <span class="text-2xl">☀️</span>
            <span class="font-bold text-accent">MEET THE TEAM</span>
            <span class="text-2xl">☀️</span>
            <span class="font-bold text-accent">MEET THE TEAM</span>
            <span class="text-2xl">☀️</span>
            <span class="font-bold text-accent">MEET THE TEAM</span>
            <span class="text-2xl">☀️</span>
            <span class="font-bold text-accent">MEET THE TEAM</span>
            <span class="text-2xl">☀️</span>
            <span class="font-bold text-accent">MEET THE TEAM</span>
            <span class="text-2xl">☀️</span>
            <span class="font-bold text-accent">MEET THE TEAM</span>
            <span class="text-2xl">☀️</span>
            <span class="font-bold text-accent">MEET THE TEAM</span>
            <span class="text-2xl">☀️</span>
            <span class="font-bold text-accent">MEET THE TEAM</span>
            <span class="text-2xl">☀️</span>
            <span class="font-bold text-accent">MEET THE TEAM</span>
            <span class="text-2xl">☀️</span>
            <span class="font-bold text-accent">MEET THE TEAM</span>
            <span class="text-2xl">☀️</span>
            <span class="font-bold text-accent">MEET THE TEAM</span>
            <span class="text-2xl">☀️</span>
            <span class="font-bold text-accent">MEET THE TEAM</span>
            <span class="text-2xl">☀️</span>
            <span class="font-bold text-accent">MEET THE TEAM</span>
            <span class="text-2xl">☀️</span>
            <span class="font-bold text-accent">MEET THE TEAM</span>
            <span class="text-2xl">☀️</span>
            <span class="font-bold text-accent">MEET THE TEAM</span>
            <span class="text-2xl">☀️</span>
            <span class="font-bold text-accent">MEET THE TEAM</span>
            <span class="text-2xl">☀️</span>
            <span class="font-bold text-accent">MEET THE TEAM</span>
            <span class="text-2xl">☀️</span>
            <span class="font-bold text-accent">MEET THE TEAM</span>
            <span class="text-2xl">☀️</span>
        </div>
    </div>

    <!-- fourth page -->
    <div class="w-full h-auto bg-[#F5EFEF]" style="position: relative;">

        <!-- group image -->
        <div class="group-section" style="display: flex; align-items: center; justify-content: center; gap: 1.25rem; padding-top: 2.5rem;">
            <img src="{{ asset('images/group.svg') }}" alt="group" style="width: auto; height: auto;" data-aos="fade-right"
                data-aos-delay="300" data-aos-duration="1000">
            <!-- title section -->
            <div class="about-creators-title" style="position: relative; display: flex; flex-direction: column; justify-content: center; margin-top: 6.25rem;" data-aos="fade-left"
                data-aos-delay="300" data-aos-duration="1000">
                <h1 style="font-weight: 900; font-size: 2.25rem;" class="text-charcoal">
                    ABOUT THE
                </h1>
                <div style="display: flex; align-items: center;">
                    <div
                        class="creators-title-text"
                        style="font-weight: 900; background-color: var(--accent); color: var(--primary); font-size: 5rem; border: 2px solid var(--charcoal); padding: 0 1rem; border-radius: 0.375rem;">
                        CREATORS
                    </div>
                </div>
            </div>
        </div>

        <!-- line -->
        <div style="width: 100%;">
            <hr style="border-top: 2px solid var(--charcoal);">
        </div>


        <div style="padding: 5rem 1.25rem;">
            <!-- Founding Story Container -->
            <div style="display: flex; align-items: center; justify-content: center; position: relative; margin-top: 2.5rem; margin-bottom: 5rem;">
                <div class="founding-story border-charcoal bg-accent" style=" border-radius: 10px; height: 700px; width: 850px; border: 2px solid;"
                    data-aos="fade-up" data-aos-delay="300" data-aos-duration="1000">
                    
                    <!-- Founding Story Content -->
                    <div style="position: relative; text-align: center;">
                        <h1 class="founding-title-text" style="font-family: poppins; font-size: 3rem; font-weight: 900; margin-top: 2.5rem; margin-bottom: 1.5rem;">
                            OUR FOUNDING STORY
                        </h1>
                        <p class="founding-story-text" style="font-size: 1.25rem; font-weight: 700; text-align: justify; margin-left: 2.8125rem; margin-right: 2.8125rem; width: auto;">
                            Our journey began with a vision to create an innovative, purpose-driven platform that would
                            truly
                            serve the students of Pampanga State University. As proud students of 4B from the
                            Bachelor
                            of Science in Computer Science, we recognized a gap in how academic support was being
                            delivered and
                            saw an opportunity to make a meaningful impact. <br><br>

                            Motivated by our shared passion for technology and a desire to help our fellow students, we
                            set out on a journey
                            to design a platform that goes beyond traditional learning methods. <i>My Honorian Buddy</i>
                            was born out of
                            countless brainstorming sessions, late nights, and the enduring commitment that education
                            thrives
                            when it is accessible, collaborative, and personalized.<br><br>

                            With the goal to create a platform where students could connect and build meaningful
                            relationships,
                            <i>My Honorian Buddy</i> empowers every aspect of the student journey, nurturing a
                            supportive community
                            for Pampanga State University and inspiring a culture of collaboration and
                            growth.
                        </p>
                    </div>
                </div>
            </div>

            <!-- members first row -->
            <div class="team-members-row" style="display: flex; flex-direction: row; align-items: center; justify-content: center; padding: 2.5rem 1.25rem; gap: 2.5rem;">
                <div class="team-member-card relative bg-accent rounded-md border-charcoal border-2"
                    style="height: 300px; width: 230px; padding: 1.25rem; display: flex; flex-direction: column; align-items: center;"
                    data-aos="zoom-in-right" data-aos-delay="300" data-aos-duration="1000">
                    <div style="height: auto; width: auto;">
                        <img src="/images/images/son.jpg" alt="de leon"
                            style="margin-bottom: 1.5rem; border-radius: 9999px; object-fit: cover; border: 2px solid var(--charcoal); width: 180px; height: 180px;">
                    </div>
                    <h1 style="text-align: center; font-family: poppins; font-weight: 900; font-size: 1.125rem;">
                        Alain Davidson <br> De Leon
                    </h1>
                </div>
                <div class="team-member-card relative bg-accent rounded-md border-charcoal border-2"
                    style="height: 300px; width: 230px; padding: 1.25rem; display: flex; flex-direction: column; align-items: center;"
                    data-aos="zoom-in" data-aos-delay="300" data-aos-duration="1000">
                    <div style="height: auto; width: auto;">
                        <img src="/images/images/nion.jpg" alt="tongol"
                            style="margin-bottom: 1.5rem; border-radius: 9999px; object-fit: cover; border: 2px solid var(--charcoal); width: 180px; height: 180px;">
                    </div>
                    <h1 style="text-align: center; font-family: poppins; font-weight: 900; font-size: 1.125rem;">
                        Nion Czryll <br> Tongol
                    </h1>
                </div>


                <div class="team-member-card relative bg-accent rounded-md border-charcoal border-2"
                    style="height: 300px; width: 230px; padding: 1.25rem; display: flex; flex-direction: column; align-items: center;"
                    data-aos="zoom-in-left" data-aos-delay="300" data-aos-duration="1000">
                    <div style="height: auto; width: auto;">
                        <img src="/images/images/jc.jpg" alt="bulaon"
                            style="margin-bottom: 1.5rem; border-radius: 9999px; object-fit: cover; border: 2px solid var(--charcoal); width: 180px; height: 180px;">
                    </div>
                    <h1 style="text-align: center; font-family: poppins; font-weight: 900; font-size: 1.125rem;">
                        John Carl <br> Angelo Bulaon
                    </h1>
                </div>
                
            </div>

            <!-- members second row -->
            <div class="team-members-row" style="display: flex; flex-direction: row; align-items: center; justify-content: center; padding: 2.5rem 1.25rem; gap: 2.5rem;">
                <div class="team-member-card relative bg-accent rounded-md border-charcoal border-2"
                    style="height: 300px; width: 230px; padding: 1.25rem; display: flex; flex-direction: column; align-items: center;"
                    data-aos="zoom-in-right" data-aos-delay="300" data-aos-duration="1000">
                    <div style="height: auto; width: auto;">
                        <img src="/images/images/pyo.jpg" alt="rabanal"
                            style="margin-bottom: 1.5rem; border-radius: 9999px; object-fit: cover; border: 2px solid var(--charcoal); width: 180px; height: 180px;">
                    </div>
                    <h1 style="text-align: center; font-family: poppins; font-weight: 900; font-size: 1.125rem;">
                        Maria Fiona <br> Rabanal
                    </h1>
                </div>
                <div class="team-member-card relative bg-accent rounded-md border-charcoal border-2"
                    style="height: 300px; width: 230px; padding: 1.25rem; display: flex; flex-direction: column; align-items: center;"
                    data-aos="zoom-in" data-aos-delay="300" data-aos-duration="1000">
                    <div style="height: auto; width: auto;">
                        <img src="/images/images/mireyl.jpg" alt="nulud"
                            style="margin-bottom: 1.5rem; border-radius: 9999px; object-fit: cover; border: 2px solid var(--charcoal); width: 180px; height: 180px;">
                    </div>
                    <h1 style="text-align: center; font-family: poppins; font-weight: 900; font-size: 1.125rem;">
                        Mireyl Fatima <br> Nulud
                    </h1>
                </div>
                <div class="team-member-card relative bg-accent rounded-md border-charcoal border-2"
                    style="height: 300px; width: 230px; padding: 1.25rem; display: flex; flex-direction: column; align-items: center;"
                    data-aos="zoom-in-left" data-aos-delay="300" data-aos-duration="1000">
                    <div style="height: auto; width: auto;">
                        <img src="/images/images/cil.jpg" alt="trinidad"
                            style="margin-bottom: 1.5rem; border-radius: 9999px; object-fit: cover; border: 2px solid var(--charcoal); width: 180px; height: 180px;">
                    </div>
                    <h1 style="text-align: center; font-family: poppins; font-weight: 900; font-size: 1.125rem;">
                        Cecil Rico <br> Trinidad
                    </h1>
                </div>
            </div>

        </div>

        {{-- Global COR Verification Notification --}}
        @auth
            @if(Auth::user()->cor_status !== 'verified')
                <div class="fixed bottom-6 md:right-6 bg-accent text-primary px-5 py-6 border-2 
                    border-primary shadow-xl rounded-md z-[9999] mr-8 max-md:mr-4 max-md:bottom-4">
                    It appears that your COR has not been verified yet. <br>
                    Please verify it
                    <a class="font-bold underline" href="{{ route('cor.view') }}">
                        here
                    </a>.
                </div>
            @endif
        @endauth

        <script>
            AOS.init();
        </script>


</body>

</html>

<!-- footer -->
<x-footer />
