<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>My Honorian Buddy</title>
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    <link rel="icon" href="{{ asset('/images/favicon.svg') }}" type="image/x-icon">

    <link href="{{ asset('vendor/bladewind/css/bladewind-ui.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="burger.css">
    <link href="{{ asset('vendor/bladewind/css/animate.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <script src="{{ asset('vendor/bladewind/js/helpers.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.css' rel='stylesheet' />

    <style>
        .fc-button {
            background-color: #550000 !important;
            border-color: #550000 !important;
            color: #FDFBFB !important;
            font-weight: bold !important;
        }

        .fc-button:hover {
            background-color: rgb(85 0 0 / 0.8) !important;
            border-color: black !important;
            color: #FDFBFB !important;
            font-weight: bold !important;
        }

        .fc-col-header-cell {
            background-color: #FDFBFB !important;
            color: #550000 !important;
            font-weight: bold !important;
            border-color: black !important;
            border-width: 1px !important;
        }

        .fc-day-today {
            background-color: #FFECAE !important;
            color: #550000 !important;
        }

        .fc-toolbar-title {
            color: #1A1A1A !important;
            font-weight: bold !important;
            font-size: 2rem !important;
            font-family: 'Dela Gothic One', sans-serif !important;
        }

        .fc-view-harness {
            border-width: 1px !important;
            border-color: black !important;
            border-radius: 8px !important;
            overflow: hidden !important;
        }

        .fc-daygrid-day {
            border-width: 1px !important;
            border-color: black !important;
        }

        .fc-daygrid-day-number {
            font-weight: bold !important;
            font-size: 20px !important;
        }
    </style>

    <x-bladewind.notification />
</head>

<body class="bg-[#F5EFEF] text-gray-800">

    <!-- Navbar -->
    <header class="sticky top-0 z-50 bg-accent shadow-md backdrop-blur border-b-2 border-black relative">
        <div class="w-full">
            <x-nav-bar />

            <!-- Burger Menu Button (visible only on small screens) -->
            

            <div class="absolute inset-x-0 bottom-0 h-1 bg-black/5">
                <div id="scroll-progress" class="h-full bg-primary w-0"></div>
            </div>
        </div>
    </header>

    <div class="flex min-h-screen">
        <!-- Sidebar with responsive behavior -->
        <aside id="sidebar"
            class="w-64 bg-accent border-r-2 border-charcoal p-4 flex flex-col sticky space-y-4 top-[88px] self-start h-[calc(100vh-88px)] overflow-y-auto
               lg:translate-x-0 fixed lg:relative -translate-x-full transition-transform duration-300 ease-in-out z-40">

            <!-- Close button for mobile -->
            <button id="sidebar-close" class="lg:hidden absolute top-2 right-2 p-2 hover:bg-gray-100 rounded-md">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <ul class="space-y-1">

                <li>
                    <details class="group [&_summary::-webkit-details-marker]:hidden">
                        <summary
                            class="group flex items-center justify-between rounded-lg px-4 py-2 text-gray-500 hover:bg-gray-100 hover:text-gray-700">
                            <div class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-5 opacity-75" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                    </path>
                                </svg>

                                <span class="text-sm font-medium"> Video Call </span>
                            </div>

                            <span class="shrink-0 transition duration-300 group-open:-rotate-180">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-5" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </span>
                        </summary>

                        <ul class="mt-2 space-y-1 px-4">
                            <li>
                                <a href="#"
                                    class="block rounded-lg px-4 py-2 text-sm font-medium text-gray-500 hover:bg-gray-100 hover:text-gray-700">
                                    Create Call
                                </a>
                            </li>

                            <li>
                                <a href="#"
                                    class="block rounded-lg px-4 py-2 text-sm font-medium text-gray-500 hover:bg-gray-100 hover:text-gray-700">
                                    Join Call
                                </a>
                            </li>
                        </ul>
                    </details>
                </li>

                <li>
                    <details class="group [&_summary::-webkit-details-marker]:hidden">
                        <summary
                            class="group flex items-center justify-between rounded-lg px-4 py-2 text-gray-500 hover:bg-gray-100 hover:text-gray-700">
                            <div class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-5 opacity-75" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                    </path>
                                </svg>

                                <span class="text-sm font-medium"> Rewards </span>
                            </div>

                            <span class="shrink-0 transition duration-300 group-open:-rotate-180">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-5" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </span>
                        </summary>

                        <ul class="mt-2 space-y-1 px-4">
                            <li>
                                <a href="{{ route('rewards.myRedemptions') }}"
                                    class="block rounded-lg px-4 py-2 text-sm font-medium text-gray-500 hover:bg-gray-100 hover:text-gray-700">
                                    My Rewards
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('connect.student') }}"
                                    class="block rounded-lg px-4 py-2 text-sm font-medium text-gray-500 hover:bg-gray-100 hover:text-gray-700">
                                    See Available Rewards
                                </a>
                            </li>
                        </ul>
                    </details>
                </li>

            </ul>
        </aside>

        <!-- Overlay for mobile (when sidebar is open) -->
        <div id="sidebar-overlay" class="lg:hidden fixed inset-0 bg-charcoal/50 z-30 hidden"></div>

        <!-- Main Content -->
        <main class="flex-1 p-6 w-full">
            <!-- Top section (wide card) -->
            @if (Auth::check())
                @php
                    $user = Auth::user();
                    $firstName = '';

                    if ($user->role === 'Student' && $user->student) {
                        $firstName = $user->Student->fname;
                    } elseif ($user->role === 'Tutor' && $user->tutor) {
                        $firstName = $user->Tutor->fname;
                    }
                @endphp
            @endif

            <button id="sidebar-toggle"
                class="lg:hidden fixed top-72 left-4 z-20 p-2 bg-primary rounded-md border-2 border-charcoal">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-accent" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>

            <div data-aos="fade-up" data-aos-anchor-placement="top-bottom"
                class="text-3xl md:text-5xl font-dela text-charcoal font-black mb-5 m-8 max-md:text-2xl max-md:mx-4 max-md:mb-3">
                Welcome, {{ $firstName ?: 'User' }}!
            </div>

            {{-- Progress Section --}}
            <div>
                <div data-aos="fade-up" data-aos-anchor-placement="top-bottom"
                    class="w-full bg-accent rounded-md overflow-hidden border-2 border-charcoal hover:border-primary my-8 max-md:my-4">
                    <div class="flex items-center bg-accent w-full border-charcoal py-2">
                        <div class="font-dela flex w-full justify-start text-xl text-darkgray font-bold ml-8 max-md:ml-4 max-md:text-lg">
                            Progress
                        </div>
                    </div>
                    <span class="flex mx-4 items-center">
                        <span class="h-px flex-1 bg-charcoal"></span>
                    </span>

                    @if (true)
                        <!-- div for grid -->
                        <div class="grid grid-cols-[1fr_3fr] max-md:grid-cols-1">
                            <!-- left side column -->
                            <div class="flex flex-col space-y-4 border-r border-charcoal bg-accent rounded-bl-lg py-4 max-md:border-r-0 max-md:space-y-2">
                                @if (true)
                                    <div class="font-poppins w-auto text-lg text-center underline decoration-2 h-auto min-h-[50px] mt-4 px-2 max-md:text-base max-md:min-h-[40px] max-md:mt-2">
                                        hotdog
                                    </div>
                                    <div class="font-poppins w-auto text-lg text-center underline decoration-2 h-auto min-h-[50px] mt-4 px-2 max-md:text-base max-md:min-h-[40px] max-md:mt-2">
                                        hotdog
                                    </div>
                                @endif
                            </div>
                            <!-- right side column -->
                            <div class="flex flex-col space-y-4 bg-accent rounded-br-lg py-4 px-2 max-md:space-y-2">
                                <div class="flex items-center justify-center h-full w-full">
                                    <x-bladewind.progress-bar :percentage="50" color="purple" shade="dark"
                                        striped="true" animated="true" show_percentage_label="true"
                                        class="w-full" />
                                </div>
                                <div class="flex items-center justify-center h-full w-full">
                                    <x-bladewind.progress-bar :percentage="100" color="purple" striped="true"
                                        animated="true" show_percentage_label="true"
                                        class="w-full" />
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="flex flex-col justify-center items-center w-full h-96 bg-accent3 max-md:h-64">
                            <img src="{{ asset('images/idk.svg') }}" class="w-32 h-32 max-md:w-24 max-md:h-24">
                            <div class="font-poppins font-black text-primary text-2xl w-auto pt-4 text-center underline decoration-2 px-4 max-md:text-lg">
                                No subjects Available
                            </div>
                        </div>
                    @endif
                </div>
            </div>


            {{-- another section --}}
            <div class="flex gap-x-6 max-lg:flex-col max-lg:gap-y-4">
                <div class="w-full lg:w-1/2 h-auto bg-accent rounded-md overflow-hidden shadow-charcoal border-charcoal border-2 max-lg:mt-6">
                    <div class="flex bg-accent items-center w-full py-2">
                        <div class="font-dela flex w-full justify-start text-xl text-charcoal font-black ml-8 max-md:ml-4 max-md:text-lg">
                            Current Session
                        </div>
                    </div>
                    <span class="flex mx-4 items-center">
                        <span class="h-px flex-1 bg-charcoal"></span>
                    </span>

                    @if (true)
                        @if (true)
                            <div class="bg-accent flex items-center w-full border-b-2 border-charcoal py-2 max-md:flex-col max-md:items-start">
                                <span class="h-6 w-6 ml-10 bg-primary border-2 border-charcoal rounded-full shrink-0 max-md:ml-4 max-md:mb-2"></span>
                                <div class="grid grid-rows-2 mt-3 mb-2 ml-3 max-md:ml-4 max-md:mt-0 max-md:w-full">
                                    <div>
                                        <p class="font-poppins text-darkgray font-extrabold text-2xl max-md:text-lg">
                                            WEB SYSTEM
                                        </p>
                                    </div>
                                    <div class="font-bold text-xl text-primary max-md:text-base">
                                        <p>Tutor: Davidson De Leon</p>
                                    </div>
                                </div>
                            </div>
                        @endif
                        
                        @if (true)
                            <div class="bg-accent flex items-center w-full border-b-0 border-black py-2">
                                <div class="bg-accent my-4 flex items-center w-full h-full py-2">
                                    <div class="text-white w-full px-4 max-md:px-2">
                                        <div class="ml-5 max-md:ml-2">
                                            <x-bladewind::button type="submit"
                                                class="bg-primary border-2 border-black hover:bg-primary/70 text-accent font-bold flex justify-items-center max-md:w-full max-md:justify-center"
                                                size="small" rounded="true"
                                                onclick="showModal('confirm-complete')">
                                                complete session
                                            </x-bladewind::button>
                                        </div>
                                        <x-bladewind.modal name="confirm-complete" size="medium"
                                            title="Confirm Session Completion" footer="false"
                                            class="bg-blue-800 text-white" stretched_action_buttons="true"
                                            ok_button_label="" cancel_button_label=""
                                            cancel_button_action="hideModal('confirm-complete')"
                                            close_after_action="true" backdrop_can_close="true">

                                            <p class="mx-4 mt-4">Are you sure you want to complete this session?</p>
                                            <br>

                                            <div class="mt-4 flex flex-col font-black space-y-4">
                                                <x-bladewind::button type="button"
                                                    class="bg-secondary text-primary hover:bg-primary hover:text-accent2 border-2 border-black mx-4"
                                                    size="small" rounded="true" can_submit="false"
                                                    close_after_action="true" onclick=" showModal('confirm-drop'); ">
                                                    Drop the session
                                                </x-bladewind::button>

                                                <x-bladewind::button type="button"
                                                    class="bg-primary text-accent2 hover:bg-red-700 border-2 border-black mx-4"
                                                    size="small" rounded="true" can_submit="false"
                                                    onclick="hideModal('confirm-complete')">
                                                    Cancel
                                                </x-bladewind::button>
                                            </div>
                                        </x-bladewind.modal>

                                        <!-- Modal of Drop Session for Tutor-->
                                        @if (Auth::user()->role === 'Tutor')
                                            <x-bladewind.modal name="session-complete" type="warning"
                                                title="Confirm Drop Session" footer="false" size="big"
                                                ok_button_label="" cancel_button_label=""
                                                cancel_button_action="hideModal('confirm-drop')"
                                                backdrop_can_close="true">

                                                <p class="mx-4 mt-4">Your current session will terminate without
                                                    payment for the
                                                    previous meetings you attended. </p><br>

                                                <div class="mt-4 flex justify-end space-x-4 max-md:flex-col max-md:space-x-0 max-md:space-y-2">
                                                    <x-bladewind::button type="button"
                                                        class="bg-primary text-accent2 hover:bg-red-900 hover:text-accent2 border-2 border-black"
                                                        stretched_action_buttons="false" size="small"
                                                        rounded="true" align_buttons="right" can_submit="false"
                                                        onclick="hideModal('confirm-drop'); showModal('confirm-hangup');">
                                                        Cancel
                                                    </x-bladewind::button>

                                                    <form action="{{ route('drop.session') }}" method="post" class="max-md:w-full">
                                                        @csrf
                                                        <input type="hidden" name="session_id"
                                                            value="{{-- $session->id --}}">
                                                        <x-bladewind::button type="submit"
                                                            class="bg-accent2 text-primary hover:bg-primary mr-4 hover:text-accent2 border-2 border-black max-md:mr-0 max-md:w-full"
                                                            size="small" rounded="true"
                                                            stretched_action_buttons="false" align_buttons="right"
                                                            can_submit="true">
                                                            Confirm
                                                        </x-bladewind::button>
                                                    </form>
                                                </div>
                                            </x-bladewind.modal>

                                            <!-- Modal of Drop Session for Student -->
                                        @elseif (Auth::user()->role === 'Student')
                                            <x-bladewind.modal name="confirm-drop" type="warning"
                                                title="Confirm Drop Session" footer="false" size="big"
                                                ok_button_label="" cancel_button_label=""
                                                cancel_button_action="hideModal('confirm-drop')"
                                                backdrop_can_close="true">

                                                <p class="mx-4 mt-4">A notification regarding the cancellation of the
                                                    session will be
                                                    delivered to your tutor for confirmation.</p><br>

                                                <div class="mt-4 flex justify-end space-x-4 max-md:flex-col max-md:space-x-0 max-md:space-y-2">
                                                    <x-bladewind::button type="button"
                                                        class="bg-primary text-accent2 hover:bg-red-900 hover:text-accent2 border-2 border-black"
                                                        stretched_action_buttons="false" size="small"
                                                        rounded="true" align_buttons="right" can_submit="false"
                                                        onclick="hideModal('confirm-drop'); showModal('confirm-hangup');">
                                                        Cancel
                                                    </x-bladewind::button>

                                                    <form action="{{ route('drop.session') }}" method="post" class="max-md:w-full">
                                                        @csrf
                                                        <input type="hidden" name="session_id"
                                                            value="{{-- $session->id --}}">
                                                        <x-bladewind::button type="submit"
                                                            class="bg-accent2 text-primary hover:bg-primary mr-4 hover:text-accent2 border-2 border-black max-md:mr-0 max-md:w-full"
                                                            size="small" rounded="true"
                                                            stretched_action_buttons="false" align_buttons="right"
                                                            can_submit="true">
                                                            Confirm
                                                        </x-bladewind::button>
                                                    </form>
                                                </div>
                                            </x-bladewind.modal>
                                        @endif


                                    </div>
                                </div>
                            </div>
                        @endif
                    @else
                        <div class="font-poppins bg-accent flex flex-col items-center h-full w-full border-b-2 border-black py-20 px-4 max-md:py-10">
                            <div class="flex flex-col text-primary justify-center items-center h-full w-full">
                                <img src="{{ asset('images/autumn.svg') }}" class="w-32 h-32 max-md:w-24 max-md:h-24">
                                <span class="font-dela font-black text-charcoal text-xl mt-4 max-md:text-lg">
                                    No session in progress
                                </span>
                                <span class="text-base text-darkgray italic text-center mt-2 max-md:text-sm">
                                    @if ($user && $user->role === 'Student')
                                        —time to find the perfect tutor and get learning!
                                    @elseif ($user && $user->role === 'Tutor')
                                        -sit tight and wait for a student to book your expertise!
                                    @endif
                                </span>
                            </div>
                        </div>
                    @endif
                </div>


                {{-- subjects --}}
                <div data-aos="fade-up" data-aos-anchor-placement="top-bottom"
                    class="w-full lg:w-1/2 flex flex-col bg-accent rounded-md overflow-hidden border-charcoal border-2 max-lg:mt-6">
                    <div class="flex bg-accent items-center w-full border-charcoal py-2">
                        <div class="font-dela flex w-full justify-start text-xl text-charcoal font-black ml-8 max-md:ml-4 max-md:text-lg">
                            Your Subjects
                        </div>
                    </div>
                    <span class="flex mx-4 items-center">
                        <span class="h-px flex-1 bg-charcoal"></span>
                    </span>

                    @if (!empty($pickedSubjects))
                        @foreach ($pickedSubjects as $subject)
                            <div class="bg-accent flex items-center w-full border-b-2 border-black py-2 max-md:flex-col max-md:items-start">
                                <span class="h-6 w-6 ml-10 bg-primary border-2 border-black rounded-full shrink-0 max-md:ml-4 max-md:mb-2"></span>
                                <div class="grid grid-rows-1 my-7 ml-3 max-md:ml-4 max-md:my-4 max-md:w-full">
                                    <div>
                                        <p class="font-poppins font-extrabold text-2xl break-words max-md:text-lg">
                                            {{ $subject->subj_code }} -
                                            <span class="font-semibold text-primary italic">{{ $subject->subj_name }}</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="bg-accent flex flex-1 min-h-0 overflow-y-auto justify-center items-center h-auto w-full py-12 max-md:py-8">
                            <div class="flex flex-col w-full items-center justify-center mt-3 mb-2">
                                <x-bladewind.icon name="book-open" type="outline"
                                    class="!h-24 !w-24 !fill-gray-300 !stroke-gray-500 max-md:!h-16 max-md:!w-16" />
                                <div class="flex text-center px-4">
                                    <p class="font-bold text-[23px] max-md:text-lg">No Subjects Available</p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>


            {{-- Last Section --}}
            <div class="flex max-lg:flex-col max-lg:gap-4">
                <div class="w-[70%] mt-8 mr-8 max-lg:w-full max-lg:mr-0 max-lg:mt-6">
                    {{-- calendar | schedule --}}
                    <section data-aos="fade-up" data-aos-anchor-placement="top-bottom" class="w-full">
                        <section class="mb-8 h-full max-md:mb-6">
                            <div class="bg-accent rounded-md h-full pt-2 pb-2 overflow-hidden mb-4 border-charcoal border-2">
                                <div class="flex -mt-2 items-center w-full py-2">
                                    <div class="font-dela flex w-full justify-start text-xl text-charcoal font-bold ml-8 max-md:ml-4 max-md:text-lg">
                                        Calendar
                                    </div>
                                </div>
                                <span class="flex mx-4 items-center">
                                    <span class="h-px flex-1 bg-charcoal"></span>
                                </span>


                                <div class="p-4 pb-16 max-md:p-2 max-md:pb-8">
                                    <div id="calendar"></div>
                                </div>
                            </div>
                        </section>
                    </section>

                    {{-- upcoming task --}}
                    <section data-aos="fade-up" data-aos-anchor-placement="top-bottom">
                        <div class="bg-accent3 rounded-md overflow-hidden pt-2 pb-2 mb-4 border-black border-2">
                            <div class="flex items-center bg-accent w-full border-charcoal py-2">
                                <div class="font-dela flex w-full justify-start text-xl text-darkgray font-bold ml-8 max-md:ml-4 max-md:text-lg">
                                    TO-DO List
                                </div>
                            </div>
                            <span class="flex mx-4 items-center">
                                <span class="h-px flex-1 bg-charcoal"></span>
                            </span>
                            <div class="font-poppins w-full p-2 space-y-3 rounded-[20px]">
                                <form id="addTaskForm" class="flex flex-col px-6 space-y-4 max-md:px-3" method="POST"
                                    action="{{ route('tasks.store') }}">
                                    @csrf
                                    <input type="text" name="title" placeholder="To Do Task"
                                        class="text-primary py-3 px-6 bg-secondary rounded-sm border-2 border-black
                                        text-lg outline-none duration-200 ring-2 ring-transparent focus:ring-primary/70 max-md:py-2 max-md:px-4 max-md:text-base">
                                    <div class="w-full flex justify-end">
                                        <button type="submit"
                                            class="flex bg-primary items-center justify-center w-28 h-12 border-2
                                            border-charcoal py-4 px-8 text-accent rounded-sm font-bold 
                                            hover:bg-primary/70 active:scale-95 transition ease-in-out max-md:w-24 max-md:h-10 max-md:py-3 max-md:px-6 max-md:text-sm">Add</button>
                                    </div>
                                </form>

                                @php
                                    $todolists = Auth::user()->to_do_lists;
                                @endphp
                                <div id="taskList" class="space-y-3 pt-10 px-6 max-md:px-3 max-md:pt-6">
                                    @foreach ($todolists as $task)
                                        <div id="task-{{ $task->id }}"
                                            class="bg-accent3 flex items-center justify-between h-12 border-2
                                            text-primary font-extrabold border-charcoal rounded-sm max-md:min-h-[48px] max-md:h-auto max-md:px-2 max-md:py-2">
                                            <input type="checkbox"
                                                onchange="toggleTaskStatus({{ $task->id }}, this.checked)"
                                                class="peer ml-4 flex-shrink-0 max-md:ml-2" {{ $task->is_completed ? 'checked' : '' }}>
                                            <label class="{{ $task->is_completed ? 'line-through text-red-600' : '' }} flex-1 mx-3 break-words max-md:mx-2 max-md:text-sm">
                                                {{ $task->title }}
                                            </label>
                                            <button onclick="deleteTask({{ $task->id }})"
                                                class="text-primary mr-4 hover:underline flex-shrink-0 max-md:mr-2 max-md:text-sm">Delete</button>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </section>
                </div>

                <div class="flex flex-col gap-y-8 justify-start w-[30%] mt-8 max-lg:w-full max-lg:mt-6 max-lg:gap-y-4">
                    <section>
                        <div data-aos="fade-up" data-aos-anchor-placement="center-bottom"
                            class="bg-accent overflow-hidden rounded-md border-black border-2">

                            <!-- content -->
                            <div class="grid grid-cols-2 items-center p-4 gap-4 max-md:grid-cols-1 max-md:p-3">
                                <!-- profile image -->
                                @php
                                    $user = Auth::user();
                                @endphp
                                <div class="flex h-full w-full items-center justify-center">
                                    <img src="{{ $user->profile_pic }}" alt="Profile"
                                        class="h-40 w-40 object-cover border-4 border-black rounded-lg max-md:h-28 max-md:w-28">
                                </div>
                                <!-- profile infos -->
                                @php
                                    if ($user->role === 'Student' && $user->student) {
                                        $user = $user->Student;
                                    } elseif ($user->role === 'Tutor' && $user->tutor) {
                                        $user = $user->Tutor;
                                    }
                                @endphp
                                <div class="max-md:text-center">
                                    <p class="font-bold ml-5 text-primary mt-1 text-[15px] max-md:ml-0 max-md:text-sm">Firstname</p>
                                    <p class="font-bold ml-5 text-[18px] -mt-1 max-md:ml-0 max-md:text-base">{{ $user->fname }}</p>
                                    <p class="font-bold ml-5 text-primary text-[15px] max-md:ml-0 max-md:text-sm">Lastname</p>
                                    <p class="font-bold ml-5 text-[18px] -mt-1 max-md:ml-0 max-md:text-base">{{ $user->lname }}</p>
                                    <p class="font-bold ml-5 text-primary text-[15px] max-md:ml-0 max-md:text-sm">Role</p>
                                    @php
                                        $user = Auth::user();
                                    @endphp
                                    <p class="font-bold ml-5 text-[18px] -mt-1 max-md:ml-0 max-md:text-base">{{ $user->role }}</p>
                                </div>
                            </div>
                            <!-- go to my profile button -->
                            <div class="flex justify-center mb-4 p-2">
                                <a href="{{ route('profile.update') }}">
                                    <button class="bg-primary text-accent text-center font-poppins font-bold rounded-full px-8 py-2 h-11 text-l border-2 border-black 
                                        hover:bg-primary/80 flex items-center space-x-2 max-md:px-4 max-md:h-10 max-md:text-sm">
                                        <x-bladewind.icon name="user" class="h-6 w-6 max-md:h-5 max-md:w-5" />
                                        <span class="max-md:hidden">GO TO MY PROFILE</span>
                                        <span class="md:hidden">PROFILE</span>
                                    </button>
                                </a>
                            </div>
                        </div>
                    </section>

                    @php
                        $role = Auth::user()->role;
                        $isStudent = $role === 'Student';
                        $isTutor = $role === 'Tutor';
                        $hasbooked = false;

                        if ($isStudent) {
                            $hasbooked = Auth::user()->student && Auth::user()->student->bookedSessions()->where('student_id', Auth::user()->id)->exists();
                        } elseif ($isTutor) {
                            $hasbooked = Auth::user()->tutor && Auth::user()->tutor->bookedSessions()->where('tutor_id', Auth::user()->id)->exists();
                        }
                    @endphp

                    <section class="w-full h-auto">
                        @if (false)
                            <section class="h-auto" data-aos="fade-up" data-aos-anchor-placement="top-bottom">
                                <div class="bg-accent h-full overflow-hidden rounded-md pb-2 mb-4 border-black border-2">
                                    <div class="font-dela text-xl text-charcoal font-black p-3 max-md:text-lg">
                                        @if (Auth::user()->role === 'Student')
                                            YOUR BUDDY
                                        @else
                                            YOUR STUDENT
                                        @endif
                                    </div>
                                    <span class="flex mx-4 items-center">
                                        <span class="h-px flex-1 bg-charcoal"></span>
                                    </span>

                                    <!-- content -->
                                    <div class="grid grid-cols-2 items-center p-4 gap-4 max-md:grid-cols-1 max-md:p-3">
                                        <!-- profile image -->
                                        <div class="flex justify-center">
                                            <img src="{{ Auth::user()->profile_pic }}" alt="Profile"
                                                class="h-40 w-40 border-4 border-black rounded-lg max-md:h-28 max-md:w-28">
                                        </div>
                                        <!-- profile infos -->
                                        <div class="max-md:text-center">
                                            <p class="font-bold ml-5 text-primary text-[16px] max-md:ml-0 max-md:text-sm">Firstname</p>
                                            <p class="font-bold ml-5 text-[18px] -mt-1 max-md:ml-0 max-md:text-base">Davidson</p>
                                            <p class="font-bold ml-5 text-primary text-[16px] max-md:ml-0 max-md:text-sm">Lastname</p>
                                            <p class="font-bold ml-5 text-[18px] -mt-1 max-md:ml-0 max-md:text-base">De Leon</p>

                                        </div>

                                    </div>
                                    <div class="flex justify-center">
                                        @if ($user->role === 'Student')
                                            <x-drop :tutor_id="$tutor_id" />
                                        @endif


                                    </div>
                                </div>
                            </section>
                        @else
                            <section class="w-full h-auto" data-aos="fade-up" data-aos-anchor-placement="top-bottom">
                                <div class="flex flex-col bg-accent rounded-md pb-2 shadow-black border-black border-2 h-auto">
                                    <div class="font-dela text-lg text-charcoal font-black p-3 max-md:text-base">
                                        {{ $isStudent ? 'YOU HAVE NO BUDDY' : 'YOU HAVE NO STUDENT' }}
                                    </div>
                                    <span class="flex mx-4 items-center">
                                        <span class="h-px flex-1 bg-charcoal"></span>
                                    </span>
                                    <!-- content -->
                                    <div class="flex flex-col gap-y-4 justify-center items-center p-6 max-md:p-4">
                                        <img src="{{ asset('images/snowman.svg') }}" class="w-32 h-32 max-md:w-24 max-md:h-24">
                                        <div class="flex flex-col text-lg text-center text-primary px-2 max-md:text-base">
                                            @if (Auth::user()->role === 'Student')
                                                <span class="text-2xl text-black font-black max-md:text-xl">No Tutors Booked Yet!</span>
                                                <span class="leading-6 pt-2"><em>"The tutor's desk is clear—someone's about to have a very free schedule!"</em></span>
                                            @else
                                                <span class="text-2xl text-black font-black max-md:text-xl">No Students Booked You Yet!</span>
                                                <span class="leading-6 pt-2"><em>"Looks like the student seats are still empty—time to spread the word!"</em></span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </section>
                        @endif
                    </section>



                    @if (Auth::user()->role === 'Tutor')
                        <section class="w-full" data-aos="fade-up" data-aos-anchor-placement="top-bottom">
                            <div class="w-full bg-accent overflow-hidden rounded-md pb-2 border-black border-2">
                                <div class="font-dela text-xl text-charcoal font-black p-3 max-md:text-lg">
                                    YOUR TOTAL POINTS
                                </div>
                                <span class="flex mx-4 items-center">
                                    <span class="h-px flex-1 bg-charcoal"></span>
                                </span>

                                <!-- content -->
                                <div class="grid grid-cols-2 items-center p-4 gap-4 max-md:grid-cols-1 max-md:p-3">
                                    <div class="flex flex-col items-center justify-center">
                                        <x-bladewind::icon name="trophy" type="outline"
                                            class="!h-32 !w-32 text-primary max-md:!h-24 max-md:!w-24" />

                                    </div>
                                    <div class="max-md:text-center">
                                        <p class="font-bold text-3xl -mt-1 max-md:text-2xl">{{ Auth::user()->tutor->points }} points</p>
                                    </div>
                                </div>
                            </div>
                        </section>
                    @else
                        <section class="flex align-center h-full w-full"></section>
                    @endif

                </div>
            </div>
        </main>
    </div>

    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.js'></script>

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

        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                height: 600,
                selectable: true,
                editable: true,
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                events: '/calendar/event',
                displayEventTime: false,

                // backgroundColor: '#F6F6F6',
                // eventColor: '#550000',
                // eventTextColor: '#FFD95C',

                // Adding of ur event
                select: function(info) {
                    var title = prompt('Enter Event Title:');
                    if (title) {
                        $.ajax({
                            url: "/calendar/action",
                            type: "POST",
                            data: {
                                title: title,
                                start: info.startStr,
                                end: info.endStr,
                                type: 'add',
                                _token: '{{ csrf_token() }}'
                            },
                            success: function() {
                                calendar.refetchEvents();
                                alert("Event added!");
                            }
                        });
                    }
                    calendar.unselect();
                },

                // Update (drag/drop or resize)
                eventDrop: function(info) {
                    $.ajax({
                        url: "/calendar/action",
                        type: "POST",
                        data: {
                            id: info.event.id,
                            title: info.event.title,
                            start: info.event.start.toISOString(),
                            end: info.event.end ? info.event.end.toISOString() : info.event
                                .start.toISOString(),
                            type: 'update',
                            _token: '{{ csrf_token() }}'
                        },
                        success: function() {
                            alert("Event updated!");
                        }
                    });
                },
                eventResize: function(info) {
                    $.ajax({
                        url: "/calendar/action",
                        type: "POST",
                        data: {
                            id: info.event.id,
                            title: info.event.title,
                            start: info.event.start.toISOString(),
                            end: info.event.end.toISOString(),
                            type: 'update',
                            _token: '{{ csrf_token() }}'
                        },
                        success: function() {
                            alert("Event resized!");
                        }
                    });
                },

                // Delete
                eventClick: function(info) {
                    if (confirm("Do you really want to delete this event?")) {
                        $.ajax({
                            url: "/calendar/action",
                            type: "POST",
                            data: {
                                id: info.event.id,
                                type: 'delete',
                                _token: '{{ csrf_token() }}'
                            },
                            success: function() {
                                calendar.refetchEvents();
                                alert("Event deleted!");
                            }
                        });
                    }
                }
            });

            calendar.render();
        });
    </script>
</body>
<script>
    AOS.init();
</script>

</html>
