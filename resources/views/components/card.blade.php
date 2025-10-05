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
    <div class="grid grid-cols-1 p-8 lg:grid-cols-2 gap-6">
        @foreach ($users as $user)
            @php
                $authUser = Auth::user();
                $tutor = $user->tutor;

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
                <section class="flex  mt-8 justify-center w-full">

                    {{-- container --}}
                    <div
                        class="bg-accent3 rounded-[20px] w-full mb-4 shadow-custom-button shadow-black border-black border-2 md">
                        <div class="p-4">
                            {{-- content --}}
                            <div class="flex flex-row md:flex-row sm:flex-col w-full items-center px-4 py-4">
                                {{-- column 1 --}}
                                <div class="flex flex-col justify-center items-center md:-mt-4 md:w-[25%] sm:mt-5">
                                    {{-- profile image --}}
                                    <div class="flex h-40 w-40 justify-center shrink-0 items-center  space-x-4 p-1">
                                        <img src="{{ $user->profile_pic }}" alt="Profile"
                                            class="w-full h-full object-cover border-4 border-black rounded-lg">
                                    </div>

                                    @if (Auth::user()->role === 'Student')
                                        @if (Auth::user()->student->bookedsessions()->exists() ?? false)
                                            <div
                                                class="inline-block bg-primary text-secondary text-center font-poppins font-bold rounded-full px-5 py-6 ml-2 mb-4 h-10 text-[16px] border-2 border-black shadow-custom-buttonflex items-center mt-10 leading-[2px]">
                                                You already have a tutor.
                                            </div>
                                        @elseif (bookedSession::where('tutor_id', $user->id)->exists() ?? false)
                                            <div
                                                class="bg-primary text-secondary text-center font-poppins font-bold rounded-full px-4 py-6 ml-2 mb-4 h-10 text-[16px] border-2 border-black shadow-custom-button flex items-center mt-5">
                                                A student already booked this tutor.
                                            </div>
                                        @else
                                            <div class="set-appointment-wrapper"
                                                data-user-id="{{ $user->tutor->user_id }}"
                                                tutor-subjects="{{ json_encode($user->tutor->subject_tutor) }}">
                                                <x-set-appointment />
                                            </div>
                                        @endif
                                    @endif
                                </div>
                                {{-- column 2 --}}
                                <div class="ml-5 w-[75%] mt-5 p-1">
                                    {{-- profile infos --}}
                                    <div class="flex-1">
                                        {{-- name --}}
                                        <p class="font-bold text-primary text-[16px] -mt-5">Name</p>
                                        <p class="font-bold text-[30px] -mt-2">{{ $user->tutor->fname }}
                                            {{ $user->tutor->lname }}</p>

                                        {{-- yr level and college program --}}
                                        <p class="font-bold text-primary text-[16px]">Year Level and College Program</p>
                                        <p class="font-bold text-[22px] -mt-1"> {{ $user->tutor->year_level }}
                                            {{ $user->tutor->department }} </p>

                                        {{-- subject expertise --}}
                                        <p class="font-bold text-primary text-[16px]">Subject Expertise</p>
                                        <div class="flex justify-start space-x-4 mb-2">
                                            @foreach ($user->tutor->subject_tutor as $subject)
                                                <div
                                                    class="bg-accent2 my-1 py-1 px-2 rounded-2xl border-2 border-black shadow-custom-button text-primary text-[20px] text-center font-bold">
                                                    <p class="font-bold text-[18px]">{{ $subject->subj_code }}</p>
                                                </div>
                                            @endforeach
                                        </div>
                                        {{-- columns for exp and ratings --}}
                                        <div class="flex md:flex-row sm:flex-col w-full">
                                            <div class="w-full">

                                                {{-- schedule --}}
                                                <p class="font-bold text-primary text-[16px]">Schedule</p>
                                                <div class="flex flex-wrap justify-start gap-x-2 gap-y-0.5 -mt-1 mb-2">
                                                    @if (is_array($days))
                                                        @foreach ($days as $day)
                                                            <div
                                                                class=" my-1 py-1 px-2 rounded-2xl border-2 border-black text-primary text-[20px] text-center font-bold">
                                                                <p class="font-bold text-[18px]">{{ $day }}</p>
                                                            </div>
                                                        @endforeach
                                                    @else
                                                        <div
                                                            class="bg-gray-200 my-1 py-1 px-4 rounded-2xl border-2 border-black text-primary text-[20px] text-center font-bold">
                                                            <p class="font-bold text-[18px]">No schedule available</p>
                                                        </div>
                                                    @endif
                                                    <div class="flex flex-row justify-center gap-4">
                                                        <span
                                                            class="flex items-center justify-center font-bold text-lg">{{ \Carbon\Carbon::parse($user->schedule->start_time)->format('h:i A') }}
                                                            -
                                                            {{ \Carbon\Carbon::parse($user->schedule->end_time)->format('h:i A') }}</span>
                                                    </div>
                                                </div>
                                                <div class="flex w-full">
                                                    {{-- Experience --}}
                                                    <div class="w-full">
                                                        <p class="font-bold text-primary text-[16px]">Experience</p>
                                                        <div class="flex justify-start space-x-4 -mt-1 -ml-5 mb-2">
                                                            <div
                                                                class=" my-1 py-1 px-2 rounded-2xl border-2 border-black text-primary text-[20px] text-center font-bold ml-5">
                                                                <p class="font-bold text-[18px]">
                                                                    @if ($user->tutor->exp === 0)
                                                                        No Experience Yet!
                                                                    @else
                                                                        {{ $user->tutor->exp }} Session Completed
                                                                    @endif
                                                                </p><!--$user->tutor->exp-->
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="w-full sm:w-[70%]">
                                                        {{-- ratings --}}
                                                        <p class="font-bold text-primary text-[16px]">Ratings</p>
                                                        @if ($user->tutor->NoOfReviews > 0)
                                                            @foreach ($reviews as $review)
                                                                <div class="flex gap-6 items-center w-full mt-2">
                                                                    <p class="font-bold text-primary text-[16px]">
                                                                        {{ number_format($review->where('tutor_id', $user->tutor->user_id)->avg('rating') ?? 0, 1) }}
                                                                    </p>
                                                                    <x-bladewind.rating class="w-full" size="small"
                                                                        color="yellow" type="star"
                                                                        rating="{{ number_format($review->where('tutor_id', $user->tutor->user_id)->avg('rating') ?? 0, 1) }}"
                                                                        clickable="false" />

                                                                    <p class="font-bold text-primary text-[16px]">
                                                                        {{ '(' . $user->tutor->NoOfReviews . ')' }}
                                                                    </p>
                                                                </div>
                                                            @endforeach
                                                        @elseif($user->tutor->NoOfReviews === 0)
                                                            {{-- No ratings yet --}}
                                                            <div
                                                                class="w-full my-1 py-1 px-2 rounded-2xl border-2 border-black text-primary text-[20px] text-center font-bold">
                                                                <p class="font-bold text-[18px]">No Ratings Yet!</p>
                                                            </div>
                                                        @endif

                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- view more --}}
                            <div class="mb-1 pb-1 px-2 text-primary text-[50px] text-center font-bold">

                                <p class="font-bold text-[20px] cursor-pointer transition delay-150 ease-in-out
                                        hover:underline"
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
                                        @json ($user->tutor->address)
                                        )'>
                                    View More

                                </p>
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

    <x-bladewind.modal-explore name="test" size="xl" show_action_buttons="false">
        <div class="flex flex-col items-center justify-center p-6">
            <div class="h-32 w-32 border-white border-8 rounded-full overflow-hidden">
                <img class="h-full w-full object-cover" id="profile-pic" alt="">
            </div>

            <div class="mt-8">
                <div class="grid grid-cols-2 gap-6">
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

    </x-bladewind.modal-explore>

    <script>
        function openTutorModal(fname, lname, profilePic, days, subjects, reviews, year_level, department, gender,
            address) {
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
                        'text-primary',
                        'text-[15px]',
                        'bg-accent2',
                        'max-w-[155px]',
                        'font-bold',
                        'rounded-full',
                        'border-2',
                        'border-black',
                        'text-center',
                        'p-2',
                        'mb-2');
                    daysList.appendChild(div);
                });
            } else {
                daysList.innerHTML = '<div>No schedule available</div>';
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
                reviews.forEach(review => {
                    const div = document.createElement('div');
                    div.innerHTML = `
                        <div>
                            <span class="font-bold">${review.student?.fname ?? 'Anonymous'} ${review.student?.lname ?? ''}</span>
                            
                            <span class="ml-2 text-yellow-500">★ ${review.rating}</span>
                            <p class="italic">"${review.comment}"</p>
                        </div>
                    `;
                    reviewsList.appendChild(div);
                });
            } else {
                reviewsList.innerHTML = '<div>No reviews available</div>';
            }
            showModal('test');
        }
    </script>
@else
    {{-- temporary design for not verified users --}}
    <div class="flex flex-col items-center justify-center min-h-screen bg-secondary">
        <div
            class="bg-accent3 border-2 border-black text-black p-10 rounded-2xl shadow-custom-button mt-20 max-w-xl w-full text-center">
            <svg class="mx-auto mb-4" width="60" height="60" fill="none" viewBox="0 0 24 24"
                stroke="orange">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <p class="font-bold text-3xl mb-2">You are not verified yet</p>
            <p class="text-lg mb-4">Please upload your valid Certificate of Registration (COR) to access Explore and
                matching features.</p>
            <a href="{{ route('workspace.start') }}"
                class="inline-block border-2 border-black bg-primary text-white font-bold px-6 py-3 rounded-full shadow-custom-button
                 hover:bg-accent2 hover:text-primary transition">Back
                to Workspace</a>
        </div>
    </div>

@endif
