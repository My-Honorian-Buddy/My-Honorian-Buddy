@php
    use App\Models\bookedSession;
    use App\Models\Review;
    use App\Models\User;
    use App\Models\Tutor;

    $tutor = Tutor::where('user_id', '1')->first();
    $totalAverageRating = 0;

    $reviews = Review::all();
@endphp
@php
    // Verified tutors only yung papalitaw here
@endphp
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
    <link href="{{ asset('vendor/bladewind/css/bladewind-ui.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="burger.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <script src="{{ asset('vendor/bladewind/js/helpers.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="icon" href="{{ asset('/images/favicon.svg') }}" type="image/x-icon">

</head>

<body class="font-poppins font-semibold bg-[#F5EFEF]">
    <div class="flex-1">
        <!-- nav bar -->
        <x-nav-bar />

        <div style="display: flex; flex-direction: column; align-items: center; justify-content: center; height: auto; margin-top: 40px; margin-bottom: 32px; padding-left: 16px; padding-right: 16px;">
            <div style="position: relative; text-align: center; width: 100%; gap: 24px;">
                <h1 style="position: relative; z-index: 30; font-weight: bold; line-height: 1.375;">
                    <div style="background-color: #550000; padding-left: 8px; padding-right: 8px; border: 2px solid black; margin-bottom: 16px; border-radius: 8px; margin-top: 20px;">
                        <p style="font-family: 'Dela Gothic One', sans-serif; font-size: clamp(24px, 5vw, 58px); padding-left: 12px; padding-right: 12px; padding-top: 8px; padding-bottom: 8px; color: #FDFBFB; word-break: break-word;">
                            MATCHMAKING RESULTS
                        </p>
                    </div>
                </h1>
            </div>
        </div>

        {{-- <div class="w-full h-[60px] flex justify-center items-center">
            <div class="w-[80%] h-[80%] m-10 flex items-center justify-center">
                <x-bladewind.dropmenu hide_after_click="false">
                    <x-slot:trigger>
                        <div
                            class="flex w-30 h-[80%] bg-accent2 border-black rounded-2xl border-2 mx-2 py-2 px-3 text-primary shadow-custom-button text-center">
                            <div>Name</div>

                            <div>
                                <x-bladewind.icon name="chevron-down" class="!h-4 !w-4 ml-2" />
                            </div>
                        </div>
                    </x-slot:trigger>
                    <form action="{{ route('tutor.search') }}" id="sortForm" method="GET">
                        <x-bladewind.dropmenu-item hover="false">
                            <label class="w-full h-full cursor-pointer flex items-center">
                                <input type="radio" class="hidden peer" name="sort" value="asc"
                                    onchange="document.getElementById('sortForm').submit() {{ request('sort') == 'asc' ? 'checked' : '' }} ">
                                <span
                                    class="h-6 w-6 bg-accent3 rounded-full border-2 border-black cursor-pointer peer-checked:bg-primary peer-checked:border-primary transition-colors duration-200"></span>
                                <span class="flex-1 text-center ml-6">A - Z</span>
                            </label>
                        </x-bladewind.dropmenu-item>
                        <x-bladewind.dropmenu-item hover="false">
                            <label class="w-full h-full cursor-pointer flex items-center">
                                <input type="radio" class="hidden peer" name="sort" value="desc"
                                    onchange="document.getElementById('sortForm').submit() {{ request('sort') == 'desc' ? 'checked' : '' }} ">
                                <span
                                    class="h-6 w-6 bg-accent3 rounded-full border-2 border-black cursor-pointer peer-checked:bg-primary peer-checked:border-primary transition-colors duration-200"></span>
                                <span class="flex-1 text-center ml-6">Z - A</span>
                            </label>
                        </x-bladewind.dropmenu-item>
                    </form>
                </x-bladewind.dropmenu>
                <x-bladewind.dropmenu hide_after_click="false" class='w-60'>
                    <x-slot:trigger>

                        <div
                            class="flex w-32 h-[80%] bg-accent2 border-black rounded-2xl border-2 mx-2 py-2 px-3 text-primary shadow-custom-button text-center">
                            <div>Schedule</div>

                            <div>
                                <x-bladewind.icon name="chevron-down" class="!h-4 !w-4 ml-2" />
                            </div>
                        </div>


                    </x-slot:trigger>
                    <form action="{{ route('tutor.search') }}" id="" method="GET">
                        <x-bladewind.dropmenu-item>
                            <label class="w-full h-full cursor-pointer flex items-center">
                                <input type="checkbox" class="hidden peer" name="days[]" id="monday" value="Monday">
                                <span
                                    class="h-6 w-6 bg-accent3 rounded-full border-2 border-black cursor-pointer ml-2 peer-checked:bg-primary peer-checked:border-primary transition-colors duration-200""></span>
                                <span class="flex-1 text-center">MONDAY</span>
                            </label>
                        </x-bladewind.dropmenu-item>
                        <x-bladewind.dropmenu-item>
                            <label class="w-full h-full cursor-pointer flex items-center">
                                <input type="checkbox" class="hidden peer" name="days[]" id="tuesday"
                                    value="Tuesday">
                                <span
                                    class="h-6 w-6 bg-accent3 rounded-full border-2 border-black cursor-pointer ml-2 peer-checked:bg-primary peer-checked:border-primary transition-colors duration-200""></span>
                                <span class="flex-1 text-center">TUESDAY</span>
                            </label>
                        </x-bladewind.dropmenu-item>
                        <x-bladewind.dropmenu-item>
                            <label class="w-full h-full cursor-pointer flex items-center">
                                <input type="checkbox" class="hidden peer" name="days[]" id="wednesday"
                                    value="Wednesday">
                                <span
                                    class="h-6 w-6 bg-accent3 rounded-full border-2 border-black cursor-pointer ml-2 peer-checked:bg-primary peer-checked:border-primary transition-colors duration-200""></span>
                                <span class="flex-1 text-center">WEDNESDAY</span>
                            </label>
                        </x-bladewind.dropmenu-item>
                        <x-bladewind.dropmenu-item>
                            <label class="w-full h-full cursor-pointer flex items-center">
                                <input type="checkbox" class="hidden peer" name="days[]" id="thursday"
                                    value="Thursday">
                                <span
                                    class="h-6 w-6 bg-accent3 rounded-full border-2 border-black cursor-pointer ml-2 peer-checked:bg-primary peer-checked:border-primary transition-colors duration-200""></span>
                                <span class="flex-1 text-center">THURSDAY</span>
                            </label>
                        </x-bladewind.dropmenu-item>
                        <x-bladewind.dropmenu-item>
                            <label class="w-full h-full cursor-pointer flex items-center">
                                <input type="checkbox" class="hidden peer" name="days[]" id="friday" value="Friday">
                                <span
                                    class="h-6 w-6 bg-accent3 rounded-full border-2 border-black cursor-pointer ml-2 peer-checked:bg-primary peer-checked:border-primary transition-colors duration-200""></span>
                                <span class="flex-1 text-center">FRIDAY</span>
                            </label>
                        </x-bladewind.dropmenu-item>
                        <x-bladewind.dropmenu-item>
                            <label class="w-full h-full cursor-pointer flex items-center">
                                <input type="checkbox" class="hidden peer" name="days[]" id="saturday"
                                    value="Saturday">
                                <span
                                    class="h-6 w-6 bg-accent3 rounded-full border-2 border-black cursor-pointer ml-2 peer-checked:bg-primary peer-checked:border-primary transition-colors duration-200""></span>
                                <span class="flex-1 text-center">SATURDAY</span>
                            </label>
                        </x-bladewind.dropmenu-item>
                        <x-bladewind.dropmenu-item>
                            <label class="w-full h-full cursor-pointer flex items-center">
                                <input type="checkbox" class="hidden peer" name="days[]" id="sunday"
                                    value="Sunday">
                                <span
                                    class="h-6 w-6 bg-accent3 rounded-full border-2 border-black cursor-pointer ml-2 peer-checked:bg-primary peer-checked:border-primary transition-colors duration-200""></span>
                                <span class="flex-1 text-center">SUNDAY</span>
                            </label>
                        </x-bladewind.dropmenu-item>
                        <x-bladewind.dropmenu-item hover="false">
                            <button type="submit"
                                class="w-full h-full text-center bg-primary text-white rounded-lg hover:text-primary hover:bg-accent2 py-2 transition-colors duration-200">
                                Apply
                            </button>
                        </x-bladewind.dropmenu-item>
                    </form>
                </x-bladewind.dropmenu>

                <x-bladewind.dropmenu hide_after_click="false" class='w-60'>
                    <x-slot:trigger>
                        <div
                            class="flex w-32 h-[80%] bg-accent2 border-black rounded-2xl border-2 mx-2 py-2 px-3 text-primary shadow-custom-button text-center">
                            <div>Ratings</div>

                            <div>
                                <x-bladewind.icon name="chevron-down" class="!h-4 !w-4 ml-2" />
                            </div>
                        </div>
                    </x-slot:trigger>
                    <form action="{{ route('tutor.search') }}" id="" method="GET">
                        <div class="flex items-center justify-center">
                            <div>
                                <x-bladewind.dropmenu-item hover="false">
                                    <div
                                        class="my-5 bg-accent2 py-1 px-4 rounded-2xl border-2 border-black shadow-custom-button text-primary text-[20px] text-center font-bold cursor-pointer">
                                        <x-bladewind.rating size="small" :rating="{{ $rating }}" rating="0"
                                            color="yellow" type="star" clickable="true" />
                                    </div>

                                </x-bladewind.dropmenu-item>
                                <x-bladewind.dropmenu-item hover="false">
                                    <button type="submit"
                                        class="w-full h-full text-center bg-primary text-white rounded-lg hover:text-primary hover:bg-accent2 py-2 transition-colors duration-200">
                                        Apply
                                    </button>
                                </x-bladewind.dropmenu-item>
                            </div>
                        </div>
                    </form>
                </x-bladewind.dropmenu>

                <x-bladewind.dropmenu hide_after_click="false">
                    <x-slot:trigger>
                        <div
                            class="flex w-36 h-[80%] bg-accent2 border-black rounded-2xl border-2 mx-2 py-2 px-3 text-primary shadow-custom-button text-center">
                            <div>Experience</div>

                            <div>
                                <x-bladewind.icon name="chevron-down" class="!h-4 !w-4 ml-2" />
                            </div>
                        </div>
                    </x-slot:trigger>
                    <form action="{{ route('tutor.search') }}" id="" method="GET">
                        <x-bladewind.dropmenu-item hover="false">
                            <div
                                class="bg-accent2 my-3 py-1 rounded-2xl border-2 border-black shadow-custom-button text-primary text-[20px] text-center font-bold cursor-pointer">
                                <div class="flex flex-col mx-2">
                                    <div class="flex items-center justify-center">
                                        <input type="text" name="" id="" placeholder="MIN"
                                            class="rounded-xl mt-2 border-2 border-black shadow-custom-button placeholder:text-primary 
                                                placeholder:text-[18px] w-24"
                                            min="0">
                                        <span class="mx-4">
                                            -
                                        </span>
                                        <input type="text" name="" id="" placeholder="MAX"
                                            class="rounded-xl mt-2 border-2 border-black shadow-custom-button placeholder:text-primary 
                                                placeholder:text-[18px] w-24"
                                            min="0">
                                    </div>
                                    <div
                                        class="bg-accent p-1 w-24 mt-2 mb-2 rounded-full border-2 border-black shadow-custom-button 
                                                text-[20px] text-center font-bold cursor-pointer hover:bg-[#FFECEC] hover:text-[#8B3A3A]">
                                        <button type="submit">GO</button>
                                    </div>
                                </div>

                            </div>
                        </x-bladewind.dropmenu-item>
                    </form>
                </x-bladewind.dropmenu>


            </div>
        </div> --}}


        {{-- card --}}
        <div class="grid grid-cols-1 p-8 lg:grid-cols-3 gap-6">
            @if (!empty($pagedMatches) && count($pagedMatches) > 0 && !empty($tutors))
                @foreach ($pagedMatches as $match)
                    @php
                        // Check if match is an array and has required keys
                        if (!is_array($match) || !isset($match['tutor_id'])) {
                            continue;
                        }

                        $user = $users->first(function ($u) use ($match) {
                            return isset($u->tutor) && $u->tutor->user_id == $match['tutor_id'];
                        });

                        // Skip if user not found
                        if (!$user || !isset($user->tutor)) {
                            continue;
                        }

                        $authUser = Auth::user();
                        $isSameUser = $authUser->id === $user->id;
                        $isStudent = $authUser->role === 'Student';
                        $isTutor = $authUser->role === 'Tutor';
                        $isCurrentTutor = $isStudent && $user->tutor && $isSameUser;
                        $isCurrentStudent = $isTutor && $user->student && $isSameUser;

                        $days = [];
                        if ($user->schedule && $user->schedule->days_week) {
                            $days = is_string($user->schedule->days_week)
                                ? json_decode($user->schedule->days_week, true)
                                : $user->schedule->days_week;
                        }

                        $subjects = [];
                        if ($user->tutor && $user->tutor->subject_tutor) {
                            $subjects = $user->tutor->subject_tutor;
                        }

                        $reviews = [];
                        if ($user->tutor && $user->tutor->review) {
                            $reviews = $user->tutor->review;
                        }
                    @endphp

                    @if ($isCurrentTutor || $isCurrentStudent)
                        @continue
                    @endif

                    <body class="bg-primary font-poppins font-semibold">
                        <section class="flex mt-8 justify-center w-full">
                            <div class="bg-accent hover:shadow-custom-button mx-auto max-w-md p-6 border border-charcoal
                                transition-shadow duration-300 rounded-md cursor-pointer"
                                onclick='openTutorModal(
                                    @json($user->tutor->fname),
                                    @json($user->tutor->lname),
                                    @json($user->profile_pic),
                                    @json($days),
                                    @json($subjects),
                                    @json($reviews),
                                    @json($user->tutor->year_level),
                                    @json($user->tutor->department),
                                    @json($user->tutor->gender),
                                    @json($user->tutor->address),
                                    @json($user->tutor->id),
                                    @json ($user->schedule->start_time ?? null),
                                    @json ($user->schedule->end_time ?? null)
                                )'>
                                <div class="flex items-center gap-4">
                                    <img alt="" src="{{ $user->profile_pic }}"
                                        class="size-20 rounded object-cover" />

                                    <div>
                                        <h3 class="font-medium text-gray-900 sm:text-lg">
                                            {{ $user->tutor->fname }} {{ $user->tutor->lname }}
                                        </h3>
                                        <p class="text-sm mb-1">
                                            {{ $user->tutor->year_level }} {{ $user->tutor->department }}
                                        </p>

                                        <div class="mb-2">
                                            @foreach ($user->tutor->subject_tutor as $subject)
                                                <span
                                                    class="inline-flex justify-center items-center px-2.5 py-0.5 rounded-full min-w-[50px]
                                                    md:min-w-[50px] max-w-[150px] md:max-w-[175px] bg-primary/5 border-2 text-primary font-bold
                                                    border-primary/50">
                                                    <p class="text-sm whitespace-nowrap">{{ $subject->subj_code }}</p>
                                                </span>
                                            @endforeach
                                        </div>
                                        <span class="flex my-1 items-center">
                                            <span class="h-px flex-1 bg-charcoal"></span>
                                        </span>

                                        @foreach ($user->tutor->review as $review)
                                            @php
                                                $totalAverageRating += $review->rating;
                                            @endphp
                                        @endforeach

                                        <div class="flex items-center justify-between">
                                            <div class="flex justify-start space-x-4">
                                                <div
                                                    class=" my-1 py-1 px-2 rounded-full border-2 border-gray-700 text-gray-700 text-[20px] text-center font-bold">
                                                    <p class="font-bold text-sm">
                                                        @if ($user->tutor->exp === 0)
                                                            No Experience Yet!
                                                        @else
                                                            @if ($user->tutor->exp > 9)
                                                                9+
                                                            @else
                                                                {{ $user->tutor->exp }}
                                                            @endif
                                                            Session Completed
                                                        @endif
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="mt-0.5 text-yellow-500">
                                                <x-bladewind.icon name="star" type="solid" />
                                                <span class="text-gray-700">
                                                    {{ number_format(count($user->tutor->review) > 0 ? $totalAverageRating / count($user->tutor->review) : 0, 1) }}
                                                    ({{ count($user->tutor->review) }})
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </body>
                @endforeach
            @else
                <div class="col-span-1 lg:col-span-3 flex flex-col items-center justify-center py-12">
                    <div class="bg-accent rounded-md p-8 border-2 border-charcoal max-w-2xl">
                        <h3 class="text-2xl font-bold text-primary text-center mb-4">No Matches Found</h3>
                        <p class="text-lg text-primary text-center">
                            We couldn't find any tutors that match your subjects and preferences at the moment.
                        </p>
                        <p class="text-lg text-primary text-center mt-2">
                            Try manual searching or check back later!
                        </p>
                    </div>
                </div>
            @endif
        </div>

        @if (!empty($pagedMatches) && count($pagedMatches) > 0)
            <div class="flex justify-center mt-8">
                {{ $pagedMatches->appends(request()->query())->links('custom-pagination') }}
            </div>
        @endif
        <x-bladewind.modal-explore name="test" size="xl" show_action_buttons="false">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 p-4 md:p-6">
                <div class="flex flex-col items-center col-span-1">
                    <div class="h-auto w-32 md:w-full border-charcoal border-2 rounded-sm overflow-hidden">
                        <img class="h-full w-full object-cover" id="profile-pic" alt="">
                    </div>
                    @if (Auth::user()->role === 'Student')
                        @if (Auth::user()->student->bookedsessions()->exists() ?? false)
                            <div
                                class="flex bg-primary text-secondary text-center font-poppins font-bold rounded-full px-4 md:px-5 py-3 md:py-6 ml-0 md:ml-2 mb-4 h-auto text-sm md:text-[16px] border-2 border-black items-center mt-5 truncate leading-tight md:leading-[2px]">
                                You already have a tutor.
                            </div>
                        @elseif (bookedSession::where('tutor_id', $user->id ?? 0)->exists() ?? false)
                            <div
                                class="flex bg-primary text-secondary text-center font-poppins font-bold rounded-full px-3 md:px-4 py-3 md:py-6 ml-0 md:ml-2 mb-4 h-auto text-sm md:text-[16px] border-2 border-black items-center mt-5 truncate">
                                A student already booked this tutor.
                            </div>
                        @else
                            <div class="w-full" id="set-appointment-wrapper" data-tutor-id="{{ $user->tutor->id ?? '' }}"
                                data-tutor-subjects="{{ json_encode($user->tutor->subject_tutor ?? []) }}">
                                <x-set-appointment />
                            </div>
                        @endif
                    @endif

                    <div class="w-full mt-4 md:mt-0">
                        <p class="font-bold text-primary text-sm md:text-base">Name</p>
                        <p class="font-bold text-black text-lg md:text-xl" id="tutor-name">...</p>
                    </div>
                    <div class="w-full mt-2 md:mt-0">
                        <p class="font-bold text-primary text-sm md:text-base">Gender</p>
                        <p class="font-bold text-black text-lg md:text-xl" id="tutor-gender">...</p>
                    </div>
                </div>

                <!--middle-->
                <div id="modal-middle-section-result" style="grid-column: span 1; margin-top: 1rem;">
                    <h2 style="font-size: 1.5rem; font-weight: 700; color: #550000;">
                        Personal Information
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-8 mb-4">
                        <div>
                            <p class="font-bold text-primary text-sm md:text-[16px]">Year Level And Department</p>
                            <p class="font-bold text-black text-base md:text-[20px]" id="tutor-year-level">...</p>
                        </div>
                        <div>
                            <p class="font-bold text-primary text-sm md:text-[16px]">Address</p>
                            <p class="font-bold text-black text-base md:text-[20px]" id="tutor-address">...</p>
                        </div>
                    </div>

                    <span class="flex my-1 items-center">
                        <span class="h-px flex-1 bg-charcoal"></span>
                    </span>

                    <h2 class="text-2xl md:text-3xl font-bold text-primary mt-4">
                        Schedule & Subjects
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-8 mb-4">
                        <div>
                            <p class="font-bold text-primary text-sm md:text-[16px]">Subject</p>
                            <ul id="tutor-subjects"></ul>
                        </div>
                        <div>
                            <p class="font-bold text-primary text-sm md:text-[16px]">Schedule</p>
                            <div
                                class="inline-flex justify-center items-center rounded-full bg-primary/5 
                                border-2 text-primary font-bold w-full px-3 md:px-4 py-1 md:py-0.5 mb-2 border-primary/50 text-sm md:text-base">
                                <p class="" id="tutor-time">-</p>
                            </div>
                            <div class="grid grid-cols-2 md:grid-cols-2 gap-2" id="tutor-days"></div>
                        </div>
                    </div>

                    <span class="flex my-1 items-center">
                        <span class="h-px flex-1 bg-charcoal"></span>
                    </span>

                    <h2 class="font-bold text-primary text-2xl md:text-3xl mt-4">Reviews</h2>
                    <div class="mt-2" id="tutor-reviews"></div>
                </div>
            </div>
        </x-bladewind.modal-explore>


        {{-- manual searching --}}
        <div class="flex justify-center items-center mt-12">
            <div class="font-bold font-poppins text-gray-700 mt-8 mb-8 text-[18px]">
                Couldn't find the buddy you wanted? Try
                <a href="{{ route('tutor.search') }}" class="hover:text-primary">
                    <u>Manual Searching.</u>
                </a>
            </div>
        </div>


        <script>
            function openTutorModal(fname, lname, profilePic, days, subjects, reviews, year_level, department, gender,
                address, tutorId, startTime, endTime) {

                console.log('Opening modal for tutor ID:', tutorId);

                // Update the set-appointment wrapper with the correct tutor ID
                const wrapper = document.getElementById('set-appointment-wrapper');
                if (wrapper && tutorId) {
                    wrapper.setAttribute('data-tutor-id', tutorId);
                    wrapper.setAttribute('data-tutor-subjects', JSON.stringify(subjects));
                    console.log('Updated wrapper with tutor ID:', tutorId);
                }

                document.getElementById('tutor-name').textContent = fname + ' ' + lname;
                document.getElementById('profile-pic').src = profilePic;
                document.getElementById('tutor-year-level').textContent = year_level + ' ' + department;
                document.getElementById('tutor-gender').textContent = gender;
                document.getElementById('tutor-address').textContent = address;
                console.log(gender, address);

                const daysList = document.getElementById('tutor-days');
                daysList.innerHTML = '';

                if (Array.isArray(days) && days.length > 0) {
                    days.forEach(day => {
                        const div = document.createElement('div');
                        div.textContent = day;
                        div.classList.add(
                            'inline-flex',
                            'justify-center',
                            'items-center',
                            'px-2.5',
                            'py-1',
                            'rounded-full',
                            'min-w-[80px]',
                            'md:min-w-[100px]',
                            'max-w-[150px]',
                            'md:max-w-[175px]',
                            'bg-primary/5',
                            'border-2',
                            'text-primary',
                            'font-bold',
                            'border-primary/50');
                        daysList.appendChild(div);
                    });
                } else {
                    daysList.innerHTML = '<div>No schedule available</div>';
                }


                const timeElement = document.getElementById('tutor-time');
                if (startTime && endTime) {
                    // Format time to h:i A format (12-hour with AM/PM)
                    const formatTime = (timeStr) => {
                        const [hours, minutes] = timeStr.split(':');
                        const hour = parseInt(hours, 10);
                        const ampm = hour >= 12 ? 'PM' : 'AM';
                        const displayHour = hour % 12 || 12;
                        return `${displayHour}:${minutes} ${ampm}`;
                    };
                    timeElement.textContent = `${formatTime(startTime)} - ${formatTime(endTime)}`;
                } else {
                    timeElement.textContent = '-';
                }

                const subjectsList = document.getElementById('tutor-subjects');
                subjectsList.innerHTML = '';

                if (Array.isArray(subjects) && subjects.length > 0) {
                    subjects.forEach(subject => {
                        const div = document.createElement('div');
                        div.textContent =
                            ` ${subject.subj_code ?? 'No Subject Code'} - ${subject.subj_name ?? 'No Subject Name'} `;
                        subjectsList.appendChild(div);
                    });

                } else {
                    subjectsList.innerHTML = '<div>No subjects available</div>';
                }

                const reviewsList = document.getElementById('tutor-reviews');
                reviewsList.innerHTML = '';

                if (Array.isArray(reviews) && reviews.length > 0) {
                    let currentPage = 0;
                    const reviewsPerPage = 2;
                    const totalPages = Math.ceil(reviews.length / reviewsPerPage);

                    const renderReviews = (page) => {
                        const container = document.getElementById('tutor-reviews-container');
                        container.innerHTML = '';

                        const startIdx = page * reviewsPerPage;
                        const endIdx = startIdx + reviewsPerPage;
                        const pageReviews = reviews.slice(startIdx, endIdx);

                        pageReviews.forEach(review => {
                            const div = document.createElement('div');
                            div.innerHTML = `
                            <div>
                                <span class="text-lg font-bold">${review.student?.fname ?? 'Anonymous'} ${review.student?.lname ?? ''}</span>
                                
                                <span class="ml-2 text-yellow-500">★ ${review.rating}</span>
                                <p class=" font-light italic">"${review.comment}"</p>

                                <span class="flex my-1 items-center">
                                    <span class="h-px flex-1 bg-charcoal"></span>
                                </span>
                            </div>
                        `;
                            container.appendChild(div);
                        });
                    };

                    const container = document.createElement('div');
                    container.id = 'tutor-reviews-container';
                    reviewsList.appendChild(container);

                    // Only show pagination if more than 2 reviews
                    if (reviews.length > reviewsPerPage) {
                        const paginationDiv = document.createElement('div');
                        paginationDiv.className = 'flex justify-between items-center mt-4';

                        const leftBtn = document.createElement('button');
                        leftBtn.innerHTML = '← Left';
                        leftBtn.className =
                            'px-4 py-2 border-2 border-primary bg-primary text-white rounded font-bold hover:text-primary hover:bg-accent transition';
                        leftBtn.onclick = () => {
                            if (currentPage > 0) {
                                currentPage--;
                                renderReviews(currentPage);
                                updateButtonStates();
                            }
                        };

                        const pageIndicator = document.createElement('span');
                        pageIndicator.id = 'page-indicator';
                        pageIndicator.className = 'font-bold text-primary';

                        const rightBtn = document.createElement('button');
                        rightBtn.innerHTML = 'Right →';
                        rightBtn.className =
                            'px-4 py-2 border-2 border-primary bg-primary text-white rounded font-bold hover:text-primary hover:bg-accent transition';
                        rightBtn.onclick = () => {
                            if (currentPage < totalPages - 1) {
                                currentPage++;
                                renderReviews(currentPage);
                                updateButtonStates();
                            }
                        };

                        const updateButtonStates = () => {
                            leftBtn.disabled = currentPage === 0;
                            rightBtn.disabled = currentPage === totalPages - 1;
                            pageIndicator.textContent = `${currentPage + 1} / ${totalPages}`;
                            leftBtn.style.opacity = currentPage === 0 ? '0.5' : '1';
                            rightBtn.style.opacity = currentPage === totalPages - 1 ? '0.5' : '1';
                        };

                        paginationDiv.appendChild(leftBtn);
                        paginationDiv.appendChild(pageIndicator);
                        paginationDiv.appendChild(rightBtn);
                        reviewsList.appendChild(paginationDiv);

                        updateButtonStates();
                    }

                    renderReviews(0);
                } else {
                    reviewsList.innerHTML = '<div>No reviews available</div>';
                }
                showModal('test');
            }
        </script>




        <style>
            .hidden {
                display: none !important;
            }

            .bg-maroon {
                background-color: #800000;
            }

            .text-white {
                color: #FFFFFF;
            }

            @media (min-width: 768px) {
                #modal-middle-section-result {
                    grid-column: span 3 !important;
                    margin-left: 2.5rem !important;
                    margin-top: 0 !important;
                }
                
                #modal-middle-section-result h2 {
                    font-size: 1.875rem !important;
                }
            }
        </style>

</body>

</html>
