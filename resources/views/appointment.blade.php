<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Set Appointment - My Honorian Buddy</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    
    <script src="{{ asset('vendor/bladewind/js/helpers.js') }}"></script>
    <script src="{{ asset('vendor/bladewind/js/notification.js') }}"></script>
    <link href="{{ asset('vendor/bladewind/css/animate.min.css') }}" rel="stylesheet" />
    <link rel="icon" href="{{ asset('/images/favicon.svg') }}" type="image/x-icon">
    <x-bladewind.notification />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="overflow-x-hidden bg-[#F5EFEF] min-h-screen">
    <div class="flex justify-center items-center w-full py-4 sm:py-8 lg:py-16 px-3 sm:px-4 lg:px-6">
        <div class="w-full max-w-2xl">
            <!-- Back Button -->
            <div class="mb-4 sm:mb-6">
                <a href="javascript:history.back()" class="inline-flex items-center text-primary font-poppins font-bold text-base sm:text-lg hover:underline transition">
                    ← Back
                </a>
            </div>

            <!-- Tutor Info Card -->
            @if($tutor)
                <div class="bg-accent border border-charcoal rounded-md p-4 sm:p-6 mb-4 sm:mb-6">
                    <div class="flex flex-col sm:flex-row items-center sm:items-start gap-4">
                        <div class="h-20 w-20 sm:h-24 sm:w-24 flex-shrink-0 rounded border-2 border-black overflow-hidden">
                            <img src="{{ $tutorUser->profile_pic ?? asset('images/default-avatar.png') }}" 
                                 alt="{{ $tutor->fname }}" class="h-full w-full object-cover">
                        </div>
                        <div class="text-center sm:text-left flex-1">
                            <h2 class="font-poppins text-primary font-bold text-xl sm:text-2xl">{{ $tutor->fname }} {{ $tutor->lname }}</h2>
                            <p class="font-poppins text-gray-600 text-sm sm:text-base">{{ $tutor->year_level }} - {{ $tutor->department }}</p>
                            <div class="flex flex-wrap gap-2 mt-3 justify-center sm:justify-start">
                                @foreach($tutorSubjects as $subject)
                                    <span class="bg-primary/10 border border-primary text-primary px-2 sm:px-3 py-1 rounded-full text-xs sm:text-sm font-semibold">
                                        {{ $subject->subj_code }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Appointment Form -->
            <form action="{{route('notif.store')}}" method="post" id="appointment-form">
                @csrf

                <input type="hidden" id="tutor_id_input" name="tutor_id" value="{{ $tutorId }}">

                <div class="bg-accent border border-charcoal rounded-md p-4 sm:p-6 space-y-4 sm:space-y-6">
                    <h3 class="text-primary text-base sm:text-lg font-bold">What subject would you like to book?</h3>
                    <div class="flex justify-center items-center bg-accent border border-charcoal rounded-sm p-3 sm:p-4">
                        <div id="subject-container" class="w-full flex flex-col space-y-2 sm:space-y-3">
                            <p class="text-gray-500">Loading subjects...</p>
                        </div>
                    </div>
                    
                    <div id="subject-error" class="text-sm text-red-600 hidden font-medium p-3 bg-red-50 rounded-md">
                        ⚠️ Please select a subject before confirming.
                    </div>
                    
                    <input type="hidden" id="NotifType" name="NotifType" value="Tutor Request">

                    <!-- Date (Available Days Only) -->
                    <div class="w-full">
                        <x-input-label class="text-primary font-bold text-sm sm:text-base" for="date" :value="__('Available Dates:')" />
                        <select id="date" name="date" class="block border border-charcoal rounded-sm mt-2 w-full p-2 sm:p-3 text-sm sm:text-base" required>
                            <option value="">Loading available dates...</option>
                        </select>
                        <x-input-error :messages="$errors->get('date')" class="mt-2 text-xs sm:text-sm" />
                        <div id="schedule-info" class="mt-3 text-xs sm:text-sm text-gray-600"></div>
                    </div>
                    
                    <!-- Time (Dropdown Options) -->
                    <div class="w-full">
                        <x-input-label class="text-primary font-bold text-sm sm:text-base" for="time" :value="__('Available Times:')" />
                        <select id="time" name="time" class="block border border-charcoal rounded-sm mt-2 w-full p-2 sm:p-3 text-sm sm:text-base" required style="max-height: 150px; overflow-y: auto;">
                            <option value="">First select a date to see available times</option>
                        </select>
                        <x-input-error :messages="$errors->get('time')" class="mt-2 text-xs sm:text-sm" />
                        <div id="time-restriction-info" class="mt-1 text-xs text-gray-500"></div>
                    </div>

                    <!-- Number of Sessions -->
                    <div class="w-full">
                        <x-input-label class="text-primary font-bold text-sm sm:text-base" for="total_session" :value="__('Number of Sessions:')" />
                        <input id="total_session" class="block border border-charcoal rounded-sm mt-2 w-full p-2 sm:p-3 text-sm sm:text-base" type="number" name="total_session" min="1" max="10" required  />
                        <x-input-error :messages="$errors->get('total_session')" class="mt-2 text-xs sm:text-sm" />
                        <p class="text-xs text-gray-500 mt-1">Maximum 10 sessions allowed</p>
                    </div>

                    <!-- Note to Tutor -->
                    <div class="w-full">
                        <x-input-label class="text-primary font-bold text-sm sm:text-base" for="unique_message" :value="__('Note to Tutor:')" />
                        <textarea id="unique_message" class="block mt-2 w-full border border-charcoal rounded-sm focus:border-primary focus:ring-primary font-poppins px-3 sm:px-4 py-2 sm:py-3 text-sm sm:text-base" name="unique_message" rows="4" required></textarea>
                        <x-input-error :messages="$errors->get('unique_message')" class="mt-2 text-xs sm:text-sm" />
                        <p class="text-xs text-gray-500 mt-2">-simple note only-</p>
                    </div>

                    <!-- Confirm Button -->
                    <div class="mt-8 w-full flex flex-col sm:flex-row gap-3 sm:gap-4">
                        <a href="javascript:history.back()" class="flex-1 border-2 border-black bg-accent text-primary rounded-sm py-2.5 sm:py-3 uppercase font-bold text-center text-sm sm:text-base hover:bg-primary/5 transition">
                            Cancel
                        </a>
                        <button type="submit" class="flex-1 bg-primary text-accent rounded-sm py-2.5 sm:py-3 uppercase border-2 border-primary font-black text-sm sm:text-base hover:bg-primary/70 transition">
                            Confirm 
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Initialize appointment form with passed data
        document.addEventListener('DOMContentLoaded', () => {
            const tutorId = @json($tutorId);
            const tutorSubjects = @json($tutorSubjects);

            console.log('Tutor ID:', tutorId);
            console.log('Tutor Subjects:', tutorSubjects);
            console.log('Tutor Name:', '{{ $tutor->fname ?? '' }} {{ $tutor->lname ?? '' }}');

            if (tutorId) {
                document.getElementById('tutor_id_input').value = tutorId;
            }

            const subjectContainer = document.getElementById('subject-container');
            subjectContainer.innerHTML = '';

            if (tutorSubjects && tutorSubjects.length > 0) {
                tutorSubjects.forEach((subject, index) => {
                    const div = document.createElement('div');
                    div.innerHTML = `
                        <label class="subject-label flex items-center justify-between gap-4 rounded border-2 border-gray-300 bg-white p-3 text-sm font-medium shadow-sm transition-all duration-200 hover:bg-gray-50 cursor-pointer">
                            <input type="radio" name="subjects[]" value="${subject.subj_code} - ${subject.subj_name}" class="sr-only subject-input">
                            <span class="font-semibold text-gray-800">${subject.subj_code} - ${subject.subj_name}</span>
                        </label>
                    `;
                    subjectContainer.appendChild(div);
                    
                    // Add event listener for border change on check
                    const input = div.querySelector('.subject-input');
                    const label = div.querySelector('.subject-label');
                    
                    input.addEventListener('change', function() {
                        // Remove checked class from all labels
                        document.querySelectorAll('.subject-label').forEach(l => {
                            l.classList.remove('border-primary', 'ring-2', 'ring-primary', 'bg-primary/5');
                            l.classList.add('border-gray-300');
                        });
                        
                        // Add checked class to current label
                        if (this.checked) {
                            label.classList.remove('border-gray-300');
                            label.classList.add('border-primary', 'ring-2', 'ring-primary', 'bg-primary/5');
                        }
                    });
                });
            } else {
                subjectContainer.innerHTML = '<p class="text-gray-500">No subjects available</p>';
            }

            if (tutorId) {
                loadMatchingSchedules(tutorId);
            }

            // Form submission validation
            const appointmentForm = document.getElementById('appointment-form');
            if (appointmentForm) {
                appointmentForm.addEventListener('submit', function(e) {
                    const selectedSubject = document.querySelector('input[name="subjects[]"]:checked');
                    const subjectError = document.getElementById('subject-error');
                    
                    if (!selectedSubject) {
                        e.preventDefault();
                        subjectError.classList.remove('hidden');
                        subjectError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        
                        const subjectContainerWrapper = document.getElementById('subject-container').parentElement;
                        subjectContainerWrapper.classList.add('animate-shake');
                        setTimeout(() => {
                            subjectContainerWrapper.classList.remove('animate-shake');
                        }, 500);
                        
                        return false;
                    }
                    
                    subjectError.classList.add('hidden');
                });
            }

            // Hide the error message when a subject is selected
            document.addEventListener('change', function(e) {
                if (e.target.name === 'subjects[]') {
                    document.getElementById('subject-error').classList.add('hidden');
                }
            });

            // Add event listener for date selection
            const dateSelect = document.getElementById('date');
            if (dateSelect) {
                dateSelect.addEventListener('change', function() {
                    const timeSelect = document.getElementById('time');
                    const timeInfo = document.getElementById('time-restriction-info');
                    
                    if (this.value) {
                        if (window.currentOverlapTime) {
                            generateTimeOptions(window.currentOverlapTime);
                        } else {
                            generateTimeOptions('7:00 AM - 9:00 PM');
                            timeInfo.innerHTML = `
                                <span class="text-blue-600 font-medium">General hours: 7:00 AM - 9:00 PM</span><br>
                                <span class="text-gray-500">No schedule restrictions found - showing general hours</span>
                            `;
                        }
                    } else {
                        timeSelect.innerHTML = '<option value="">First select a date to see available times</option>';
                        timeInfo.textContent = '';
                    }
                });
            }
        });

        function loadMatchingSchedules(tutorId) {
            const dateSelect = document.getElementById('date');
            const scheduleInfo = document.getElementById('schedule-info');
            
            if (!dateSelect || !scheduleInfo) return;
            
            dateSelect.innerHTML = '<option value="">Loading available dates...</option>';
            scheduleInfo.innerHTML = '';

            console.log('Fetching schedules for tutor ID:', tutorId);
            fetch(`{{ route('session.matching-schedules') }}?tutor_id=${tutorId}`, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => {
                console.log('Response status:', response.status);
                return response.json();
            })
            .then(data => {
                console.log('Received data:', data);
                if (data.success) {
                    dateSelect.innerHTML = '<option value="">Select a date...</option>';
                    
                    data.available_dates.forEach(dateInfo => {
                        const option = document.createElement('option');
                        option.value = dateInfo.date;
                        option.textContent = `${dateInfo.formatted_date} (${dateInfo.day_name})`;
                        dateSelect.appendChild(option);
                    });

                    if (data.matching_days && data.matching_days.length > 0) {
                        window.currentOverlapTime = data.overlapping_time;
                        
                        scheduleInfo.innerHTML = `
                            <div class="bg-green-50 p-3 rounded border border-green-200">
                                <p class="text-green-700 font-medium">✅ Perfect Match</p>
                                <p class="text-sm text-gray-600 mt-1">Matching Days: ${data.matching_days.join(', ')}</p>
                                <p class="text-sm text-gray-600">Available Time: ${data.overlapping_time}</p>
                            </div>
                        `;
                    }
                } else {
                    dateSelect.innerHTML = '<option value="">No matching schedules found</option>';
                    
                    let errorMessage = '';
                    if (data.message.includes('not set up their schedules')) {
                        errorMessage = 'Schedule Setup Required - Please set up your schedules first.';
                    } else if (data.message.includes('No matching schedule days')) {
                        errorMessage = 'No Common Days Available - Different available days.';
                    } else if (data.message.includes('No overlapping time found')) {
                        errorMessage = 'No Overlapping Time - Different time slots.';
                    } else {
                        errorMessage = 'Schedule Conflict';
                    }

                    scheduleInfo.innerHTML = `
                        <div class="bg-red-50 p-3 rounded border border-red-200">
                            <p class="text-red-700 font-medium">${errorMessage}</p>
                        </div>
                    `;
                }
            })
            .catch(error => {
                console.error('Error loading matching schedules:', error);
                dateSelect.innerHTML = '<option value="">Error loading schedules</option>';
                scheduleInfo.innerHTML = `
                    <div class="bg-red-50 p-3 rounded border border-red-200">
                        <p class="text-red-700 font-medium">Connection Error</p>
                    </div>
                `;
            });
        }

        function generateTimeOptions(overlappingTime) {
            const timeSelect = document.getElementById('time');
            const timeInfo = document.getElementById('time-restriction-info');
            
            if (!timeSelect || !timeInfo) return;
            
            console.log('Generating time options for:', overlappingTime);
            
            const [startTimeStr, endTimeStr] = overlappingTime.split(' - ');
            console.log('Start time string:', startTimeStr);
            console.log('End time string:', endTimeStr);
            
            const startTime = convertTo24Hour(startTimeStr);
            const endTime = convertTo24Hour(endTimeStr);
            
            console.log('Converted start time (24h):', startTime);
            console.log('Converted end time (24h):', endTime);
            
            timeSelect.innerHTML = '<option value="">Select a time...</option>';
            
            let current = new Date(`2000-01-01 ${startTime}`);
            const end = new Date(`2000-01-01 ${endTime}`);
            let slotCount = 0;
            
            while (current <= end) {
                const timeValue = current.toTimeString().substr(0, 5);
                const timeDisplay = formatTime12Hour(timeValue);
                
                const option = document.createElement('option');
                option.value = timeValue;
                option.textContent = timeDisplay;
                timeSelect.appendChild(option);
                
                current.setMinutes(current.getMinutes() + 30);
                slotCount++;
            }
            
            timeInfo.innerHTML = `
                <span class="text-green-600 font-medium">⏰ Available time slots: ${overlappingTime}</span><br>
                <span class="text-gray-500">${slotCount} time slots available (30-minute intervals)</span>
            `;
            
            console.log('Generated', slotCount, 'time slots');
        }
        
        function convertTo24Hour(time12h) {
            const [time, modifier] = time12h.split(' ');
            let [hours, minutes] = time.split(':');
            hours = parseInt(hours, 10);
            
            if (modifier === 'AM') {
                if (hours === 12) {
                    hours = 0;
                }
            } else if (modifier === 'PM') {
                if (hours !== 12) {
                    hours += 12;
                }
            }
            
            return `${hours.toString().padStart(2, '0')}:${minutes}`;
        }
        
        function formatTime12Hour(time24) {
            const [hours, minutes] = time24.split(':');
            const hour12 = ((parseInt(hours) + 11) % 12) + 1;
            const ampm = parseInt(hours) >= 12 ? 'PM' : 'AM';
            return `${hour12}:${minutes} ${ampm}`;
        }
    </script>
</body>
</html>
