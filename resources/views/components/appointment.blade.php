@props(['tutorId' => null, 'tutorSubjects' => []])

<form action="{{route('notif.store')}}" method="post" id="appointment-form">
                @csrf

                <input type="hidden" id="tutor_id_input" name="tutor_id" value="">

                <div class="w-full flex flex-col px-3 sm:px-4 lg:px-6 py-4 sm:py-6 space-y-4 sm:space-y-6">
                    <span class="text-primary text-base sm:text-lg font-bold">What subject would you like to book?</span>
                    <div class="flex justify-center items-center bg-white border-2 border-black rounded-md p-3 sm:p-4">
                        <div id="subject-container" class="w-full flex flex-col space-y-2 sm:space-y-3">
                            <p class="text-gray-500 text-sm">No Subjects</p>
                        </div>
                    </div>
                    
                    <div id="subject-error" class="text-sm text-red-600 hidden font-medium p-3 bg-red-50 rounded-md">
                        ⚠️ Please select a subject before confirming.
                    </div>
                    
                        <input type="hidden" id="NotifType" name="NotifType" value="Tutor Request">

                        <!-- Date (Available Days Only) -->
                        <div class="w-full">
                            <x-input-label class="text-primary font-bold text-sm sm:text-base" for="date" :value="__('Available Dates:')" />
                            <select id="date" name="date" class="block border-2 border-black rounded-md mt-2 w-full p-2 sm:p-3 text-sm sm:text-base" required>
                                <option value="">Select a date...</option>
                            </select>
                            <x-input-error :messages="$errors->get('date')" class="mt-2 text-xs sm:text-sm" />
                            <div id="schedule-info" class="mt-3 text-xs sm:text-sm text-gray-600"></div>
                        </div>
                        
                        <!-- Time (Dropdown Options) -->
                        <div class="w-full">
                            <x-input-label class="text-primary font-bold text-sm sm:text-base" for="time" :value="__('Available Times:')" />
                            <select id="time" name="time" class="block border-2 border-black rounded-md mt-2 w-full p-2 sm:p-3 text-sm sm:text-base" required style="max-height: 150px; overflow-y: auto;">
                                <option value="">First select a date to see available times</option>
                            </select>
                            <x-input-error :messages="$errors->get('time')" class="mt-2 text-xs sm:text-sm" />
                            <div id="time-restriction-info" class="mt-1 text-xs text-gray-500"></div>
                        </div>
                    
                        <div class="w-full">
                            <x-input-label class="text-primary font-bold text-sm sm:text-base" for="total_session" :value="__('Number of Session:')" />
                            <x-text-input id="total_session" class="block border-2 border-black rounded-md mt-2 w-full p-2 sm:p-3 text-sm sm:text-base" type="number" name="total_session" required  />
                            <x-input-error :messages="$errors->get('total_session')" class="mt-2 text-xs sm:text-sm" />
                        </div>

                    <div class="w-full">
                        <x-input-label class="text-primary font-bold text-sm sm:text-base" for="unique_message" :value="__('Note to Tutor:')" />
                        <textarea id="unique_message" class="block mt-2 w-full border-black border-2 rounded-md focus:border-indigo-500 focus:ring-indigo-500 font-poppins px-3 sm:px-4 py-2 sm:py-3 text-sm sm:text-base" name="unique_message" rows="4" required></textarea>
                        <x-input-error :messages="$errors->get('unique_message')" class="mt-2 text-xs sm:text-sm" />
                            <p class="text-xs text-gray-500 mt-2">-simple note only-</p>
                    </div>

                    
                        <!-- Number of Sesion -->
                        
                        <!-- Confirm -->
                        <div class="mt-6 w-full flex flex-col sm:flex-row gap-3 sm:gap-4">
                            <a href="javascript:history.back()" class="flex-1 border-2 border-black bg-accent2 text-primary rounded-md py-2.5 sm:py-3 uppercase font-bold text-center text-sm sm:text-base hover:bg-primary/10 transition">
                                Cancel
                            </a>
                            <button type="submit" class="flex-1 bg-accent2 text-primary rounded-md py-2.5 sm:py-3 uppercase border-2 border-primary font-black text-sm sm:text-base hover:bg-primary hover:text-accent2 transition">
                                Confirm 
                            </button>
                        </div>
                    
                </div>
            </form>

<script>
    // Initialize appointment form with passed data
    document.addEventListener('DOMContentLoaded', () => {
        // First try to get data from component props, then fall back to window object
        let tutorId = @json($tutorId);
        let tutorSubjects = @json($tutorSubjects);
        
        // If data was passed via window object (from set-appointment), use that instead
        if (window.appointmentData) {
            tutorId = window.appointmentData.tutorId;
            tutorSubjects = window.appointmentData.tutorSubjects;
        }

        if (tutorId) {
            document.getElementById('tutor_id_input').value = tutorId;
        }

        const subjectContainer = document.getElementById('subject-container');
        subjectContainer.innerHTML = '';

        if (tutorSubjects && tutorSubjects.length > 0) {
            tutorSubjects.forEach(subject => {
                const checkbox = document.createElement('div');
                checkbox.innerHTML = `
                    <x-bladewind.radio-button label_css="text-primary" color="black" name="subjects[]" label="${subject.subj_code} - ${subject.subj_name}" value="${subject.subj_code} - ${subject.subj_name}" />
                `;
                subjectContainer.appendChild(checkbox);
            });
        } else {
            subjectContainer.innerHTML = '<p>No Subjects</p>';
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
                            <span class="text-blue-600 font-medium"> General hours: 7:00 AM - 9:00 PM</span><br>
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
                        <p class="text-red-700 font-medium"> ${errorMessage}</p>
                    </div>
                `;
            }
        })
        .catch(error => {
            console.error('Error loading matching schedules:', error);
            dateSelect.innerHTML = '<option value="">Error loading schedules</option>';
            scheduleInfo.innerHTML = `
                <div class="bg-red-50 p-3 rounded border border-red-200">
                    <p class="text-red-700 font-medium"> Connection Error</p>
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