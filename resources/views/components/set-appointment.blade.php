<div class="mt-4 flex justify-center items-center">

        <button class="bg-primary text-accent2 text-center font-poppins font-bold rounded-full px-3 py-1 h-11 text-l border-2 border-black shadow-custom-button
                    hover:bg-[#FFECEC] hover:text-[#8B3A3A] flex items-center space-x-2 mb-4" 
                    onclick="showModal('set-appointment')"
                    type="button"
                    >
                    
            <span class="text-[17px] py-4">SET APPOINTMENT</span>
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

                        <!-- Date -->
                        <div class="mt-4 w-full">
                            <x-input-label class="text-primary" for="date" :value="__('Date:')" />
                            <x-text-input id="date" class=" block border-2 border-black rounded-md shadow-custom-button mt-1 w-full" type="date" name="date" required  />
                            <x-input-error :messages="$errors->get('date')" class="mt-2" />
                        </div>
                        
                        <!-- Time -->
                        <div class="mt-4 w-full">
                            <x-input-label class="text-primary" for="time" :value="__('Time:')" />
                            <x-text-input id="time" class="block border-2 border-black rounded-md mt-1 w-full" type="time" name="time" required />
                            <x-input-error :messages="$errors->get('time')" class="mt-2" />
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
                const tutorSubjects = JSON.parse(this.getAttribute('tutor-subjects' || '[]'));
                
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

                // Show the modal (assuming your modal logic is defined)
                showModal('set-appointment');

            });
        });
    });
</script>