<div class="mt-4 flex justify-center items-center">

        <button class="bg-primary text-accent2 text-center font-poppins font-bold rounded-full px-3 py-1 h-11 text-l border-2 border-black shadow-custom-button
                    transition-all duration-600 ease-in-out hover:bg-accent2 hover:text-primary flex items-center space-x-2 mb-4" 
                    onclick="showModal('set-appointment')"
                    type="button"
                    >
                    
            <span class="text-[12px] py-4">SET APPOINTMENT</span>
        </button>
        <x-bladewind.modal
            title="Application Form"
            name="set-appointment"
            size="large"
            ok_button_label=""
            cancel_button_label="">
            
            <form action="{{route('notif.store')}}" method="post">
                @csrf

                <input type="hidden" id="tutor_id_input" name="tutor_id" value="">

                <div class="w-full flex flex-col px-4 py-6">
                    <span class="text-primary text-md font-bold">What subject would you like to book?</span>
                    <div class="flex justify-center items-center bg-white border-2 border-black rounded-md">
                        <div id="subject-container" class="mt-3 flex flex-col">
                            <p>No Subjects</p>
                        </div>
                    </div>
                    

                    
                        <input type="hidden" id="NotifType" name="NotifType" value="Tutor Request">

                        <!-- Date (Available Days Only) -->
                        <div class="mt-4 w-full">
                            <x-input-label class="text-primary" for="date" :value="__('Available Dates:')" />
                            <select id="date" name="date" class="block border-2 border-black rounded-md shadow-custom-button mt-1 w-full" required>
                                <option value="">Select a date...</option>
                            </select>
                            <x-input-error :messages="$errors->get('date')" class="mt-2" />
                            <div id="schedule-info" class="mt-2 text-sm text-gray-600"></div>
                        </div>
                        
                        <!-- Time (Dropdown Options) -->
                        <div class="mt-4 w-full">
                            <x-input-label class="text-primary" for="time" :value="__('Available Times:')" />
                            <select id="time" name="time" class="block border-2 border-black rounded-md shadow-custom-button mt-1 w-full" required style="max-height: 150px; overflow-y: auto;">
                                <option value="">First select a date to see available times</option>
                            </select>
                            <x-input-error :messages="$errors->get('time')" class="mt-2" />
                            <div id="time-restriction-info" class="mt-1 text-xs text-gray-500"></div>
                        </div>
                    
                        <div class="mt-4 w-full">
                            <x-input-label class="text-primary" for="total_session" :value="__('Number of Session:')" />
                            <x-text-input id="total_session" class="block border-2 border-black rounded-md mt-1 w-full" type="number" name="total_session" required  />
                            <x-input-error :messages="$errors->get('total_session')" class="mt-2" />
                        </div>

                    <div class="mt-4 w-full">
                        <x-input-label class="text-primary" for="total_session" :value="__('Note to Tutor:')" />
                        <input id="unique_message" class=" block mt-1 w-full border-black border-2 rounded-md focus:border-indigo-500 focus:ring-indigo-500 font-poppins px-4 py-3" type="textarea" name="unique_message" required  />
                        <x-input-error :messages="$errors->get('total_session')" class="mt-2" />
                            <p class="text-xs">-simple note only-</p>
                    </div>

                    
                        <!-- Number of Sesion -->
                        
                        <!-- Confirm -->
                        <div class="mt-4 w-full h-16 flex flex-col items-end">
                            <x-input-label class="invisible text-primary" for="first_name" :value="__('First Name:')" />
                            <button type="submit" class="w-full h-full bg-accent2 text-primary rounded-md uppercase border-2 border-primary
                            hover:bg-primary hover:text-accent2 font-black">
                                Confirm 
                            </button>
                        </div>
                    
                </div>
            </form>
        </x-bladewind.modal>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Attach click event to all buttons inside .set-appointment-wrapper
        document.querySelectorAll('.set-appointment-wrapper').forEach(wrapper => {
            wrapper.addEventListener('click', function () {
                const userId = this.getAttribute('data-user-id');
                const tutorSubjects = JSON.parse(this.getAttribute('tutor-subjects') || '[]');
                
                // Set the value of the hidden input in the modal
                document.getElementById('tutor_id_input').value = userId;

                const subjectContainer = document.getElementById('subject-container');
                subjectContainer.innerHTML = ''; 

                if (tutorSubjects.length > 0) {
                    tutorSubjects.forEach(subject => {
                        // Create a checkbox for each subject
                        const checkbox = document.createElement('div');
                        checkbox.innerHTML = `
                            <x-bladewind.radio-button label_css="text-primary" color="black" name="subjects[]" label="${subject.subj_code} - ${subject.subj_name}" value="${subject.subj_code} - ${subject.subj_name}" />
                        `;
                        subjectContainer.appendChild(checkbox);
                    });
                } else {
                    subjectContainer.innerHTML = '<p>No Subjects</p>';
                }

                loadMatchingSchedules(userId);

                // Show the modal
                showModal('set-appointment');
            });
        });

        // Add event listener for date selection
        document.getElementById('date').addEventListener('change', function() {
            const timeSelect = document.getElementById('time');
            const timeInfo = document.getElementById('time-restriction-info');
            
            if (this.value) {
                if (window.currentOverlapTime) {
                    // to generate time
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
    });

    function loadMatchingSchedules(tutorId) {
        const dateSelect = document.getElementById('date');
        const scheduleInfo = document.getElementById('schedule-info');
        
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
                    
                    // sched info
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