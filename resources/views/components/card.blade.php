{{-- for card --}}

@php
    use App\Models\bookedSession;
    use App\Models\Review;
    use App\Models\User;
    use App\Models\Tutor;
    use Illuminate\Pagination\Paginator;
    use Illuminate\Pagination\LengthAwarePaginator;

    $reviews = Review::all();
    $tutors = Tutor::all();
    $authUser = Auth::user();
@endphp


@if ($authUser && $authUser->cor_status === 'verified')
    <div class="grid grid-cols-1 p-8 lg:grid-cols-3 gap-6">
        @foreach ($users as $user)
            @php
                $authUser = Auth::user();
                $tutor = $user->tutor;

                $isSameUser = $authUser->id === $user->id;
                $totalAverageRating = 0;

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
                                        @json ($user->tutor->fname),
                                        @json ($user->tutor->lname),
                                        @json ($user->profile_pic),
                                        @json ($days),
                                        @json ($subjects),
                                        @json($reviews),
                                        @json ($user->tutor->year_level),
                                        @json ($user->tutor->department),
                                        @json ($user->tutor->gender),
                                        @json ($user->tutor->address),
                                        @json ($user->tutor->id),
                                        @json ($user->schedule->start_time ?? null),
                                        @json ($user->schedule->end_time ?? null)
                                        )'>
                        <div class="flex items-center gap-4">
                            <img alt="" src="{{ $user->profile_pic }}" class="size-20 rounded object-cover" />

                            <div>
                                <h3 class="font-medium text-gray-900 sm:text-lg">
                                    {{ $user->tutor->fname }} {{ $user->tutor->lname }}
                                </h3>
                                <p class="text-sm mb-1">
                                    {{ $user->tutor->year_level }} {{ $user->tutor->department }}
                                </p>

                                <div class="mb-2">
                                    @if ($user->tutor->subject_tutor->isEmpty())
                                        <span
                                            class="inline-flex justify-center items-center px-2.5 py-0.5 rounded-full w-full bg-gray-100 border-2 text-gray-500 font-bold
                                            border-gray-600">
                                            <p class="text-sm whitespace-nowrap">No Subjects</p>
                                        </span>
                                    @endif
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
                                            <p class="font-bold text-sm truncate">
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
    </div>
    <div class="flex justify-center mt-6 mb-6">
        {{ $users->appends(request()->query())->links('custom-pagination') }}
    </div>

    {{-- modal --}}
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
                        <div class="w-full" id="set-appointment-wrapper" data-tutor-id="{{ $user->tutor->id }}"
                            data-tutor-subjects="{{ json_encode($user->tutor->subject_tutor) }}">
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
            <div id="modal-middle-section" style="grid-column: span 1; margin-top: 1rem;">
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
                        <p class="font-bold text-black text-base md:text-[20px]" id="tutor-address"></p>
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




        <div class="hidden">
            <div class="flex items-center justify-center p-6">
                <div class="h-32 w-32 border-white border-8 rounded-full overflow-hidden">
                    <img class="h-full w-full object-cover" id="profile-pic" alt="">
                </div>

                <div class="mt-8">
                    <div class="grid grid-cols-3 gap-8">
                        <div>
                            <h2 class="text-3xl font-bold text-primary">
                                Personal Information
                            </h2>
                        </div>
                        <div>

                        </div>
                        <div>
                            <p class="font-bold text-primary text-[16px]">Name</p>
                            <p class="font-bold  text-black text-[20px]" id="tutor-name">...</p>
                        </div>
                        <div>
                            <p class="font-bold text-primary text-[16px]">Year Level And Department</p>
                            <p class="font-bold text-black text-[20px]" id="tutor-year-level">...</p>
                        </div>
                        <div>
                            <p class="font-bold text-primary text-[16px]">Gender</p>
                            <p class="font-bold text-black text-[20px]" id="tutor-gender"></p>
                        </div>
                        <div>
                            <p class="font-bold text-primary text-[16px]">Address</p>
                            <p class="font-bold text-black text-[20px]" id="tutor-address"></p>
                        </div>
                    </div>

                    <hr class="mt-8 border-black">

                    <div class="grid grid-cols-2 gap-6 mt-10">
                        <div>
                            <h2 class="text-3xl font-bold text-primary">
                                Schedule & Subjects
                            </h2>
                        </div>
                        <div>

                        </div>
                        <div>
                            <p class="font-bold text-primary text-[16px]">Schedule</p>
                            <div class="grid grid-cols-3 gap-4 mt-2" id="tutor-days"></div>
                        </div>
                        <div>
                            <p class="font-bold text-primary text-[16px]">Subject</p>
                            <ul id="tutor-subjects"></ul>
                        </div>
                    </div>

                    <hr class="mt-8 border-black">

                    <div class="mt-10">
                        <h2 class="font-bold text-primary text-3xl">Reviews</h2>
                        <div class="mt-2" id="tutor-reviews"></div>
                    </div>

                </div>
            </div>
        </div>
        </div>
    </x-bladewind.modal-explore>

    <style>
        @media (min-width: 768px) {
            #modal-middle-section {
                grid-column: span 3 !important;
                margin-left: 2.5rem !important;
                margin-top: 0 !important;
            }
            
            #modal-middle-section h2 {
                font-size: 1.875rem !important;
            }
        }
    </style>

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

            // Display schedule time
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
@else
    {{-- temporary design for not verified users --}}
    <div class="flex flex-col items-center h-screen mt-8 bg-mainbackground overflow-hidden">
        <div class="bg-accent border-2 border-black text-black p-10 rounded-lg max-w-xl w-full text-center">
            <svg class="mx-auto mb-4" width="60" height="60" fill="none" viewBox="0 0 24 24"
                stroke="orange">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <p class="font-bold text-3xl mb-2">You are not verified yet</p>
            <p class="text-lg mb-4">Please upload your valid Certificate of Registration (COR) to access Explore and
                matching features.</p>
            <a href="{{ route('workspace.start') }}"
                class="inline-block border-2 border-black bg-primary text-white font-bold px-6 py-3 rounded-full
                 hover:bg-accent hover:text-primary transition tracking-widest uppercase">Back
                to Workspace</a>
        </div>
    </div>

@endif
