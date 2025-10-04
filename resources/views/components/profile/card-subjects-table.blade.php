@php
    $user = Auth::user();
@endphp

<div class="flex mt-8 mb-8">
    <div class="w-full bg-accent3 rounded-[20px] shadow-custom-button shadow-black border-black border-2">
        <div class="relative rounded-[20px] px-6">
            <!-- Card Content-->
                
                    <div class="flex flex-col mt-8 text-left">
                        <span class="font-bold text-4xl m-5 mb-0 leading-relaxed">
                            @if ($user -> role === 'Student')
                                Subject Improvement:
                            </span>
                            <span class="font-semibold text-red-900 text-1xl mb-8 ml-5">Update your account's profile information and email address.</span>
                                @foreach ($user->student->subject_student as $subject)
                                    <span class="font-semibold text-2xl ml-5">{{$subject->subj_code}}</span>
                                    <span class="font-semibold text-red-900 text-1xl mb-5 ml-5">{{$subject->subj_name}}</span>
                                @endforeach
                            @else
                                Subject Expertise:
                            </span>
                            <span class="font-semibold text-red-900 text-1xl mb-8 ml-5">Update your account's profile information and email address.</span>
                                @foreach ($user->tutor->subject_tutor as $subject)
                                    <span class="font-semibold text-2xl ml-5">{{$subject->subj_code}}</span>
                                    <span class="font-semibold text-red-900 text-1xl mb-5 ml-5">{{$subject->subj_name}}</span>
                                @endforeach
                            @endif

                    </div>

                            <!-- Buttons -->
                    <div class="flex justify-end m-8">
                        <x-primary-button onclick="showModal('changeSubjectModal')" type="submit" class=" bg-accent2 text-black ">Change</x-primary-button>
                        <x-bladewind.modal
                            name="changeSubjectModal"
                            :show_footer="false"
                            :close_on_outside_click="true"
                            :close_on_escape="true"
                            size="large"
                            cancel_button_label=""
                            ok_button_label=""
                        >
                            <form action="" method="post">
                                <div class="flex flex-col m-8 mb-2 text-left h-auto">
                                    <span class="font-bold text-2xl text-black leading-relaxed">
                                        Subject Change Confirmation
                                    </span>
                                    <span class="font-semibold text-primary text-1xl mb-8 ml-0">
                                        Changing your subjects will remove your current selections, 
                                        and you will need to choose them again.
                                    </span>
                                    <button type="submit" class="p-2 shadow-custom-button border-2 border-black rounded-[4px] text-lg
                                    transition-all duration-600 ease-in-out hover:scale-105 hover:bg-primary hover:text-accent2
                                     bg-accent2 text-black ">
                                        Change
                                    </button>
                                </div>
                            </form>
                        </x-bladewind.modal>
                    </div>
                
            
        </div>
    </div>
</div>
<script>
                const dropdownButton = document.getElementById('dropdownButton');
                const dropdownMenu = document.getElementById('dropdownMenu');
            
                dropdownButton.addEventListener('click', () => {
                    dropdownMenu.classList.toggle('hidden');
                });

                document.addEventListener('click', (event) => {
                if (!dropdownButton.contains(event.target) && !dropdownMenu.contains(event.target)) {
            dropdownMenu.classList.add('hidden');
        }
                });
            </script>
            
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script>

                // Subject Mapping
                const subjectMap = {
                    // FIRST YR - 1ST SEM
                    "CSS 113" : "Computer System Servicing",
                    "CC 113 (A)" : "Introduction to Computing",
                    "CC 113(B)" : "Fundamentals of Programming",
                    // FIRST YR - 2ND SEM
                    "CS 123" : "Discrete Structures",
                    "CC 123 (C)" : "Intermediate Programming (Advanced C++)",
                    "CSS 123" : "Networking Fundamentals",

                    // SECOND YR - 1ST SEM
                    "CC 213 (D)": "Data Structure",
                    "CC 213 (E)" : "Information Management (DBMS)",
                    "CPC 213" : "Object Oriented Programming (JAVA)",

                    // SECOND YR - 2ND SEM
                    "MOBDEV 223" : "Mobile Application Development",
                    "CPC 223(A)" : "Database Programming",
                    "CSDA 223" : "Design Analysis and Algorithms",
                    "SAD 223" : "Software Analysis and Design",
                    "CPC 223(B)" : "Web Application Development",

                    // THIRD YR - 1ST SEM
                    "CSAC 313" : "Algorithms and Complexity",
                    "CSPL 313" : "Programming Languages",
                    "CSOS 313" : "Operating Systems",
                    "CSSE1 313" : "Software Engineering 1",
                    "CSWEBSYS 313" : "Web Systems and Technologies",
                    "CSIAS 313" : "Information Assurance and Security",
                };

                const container = document.getElementById('dropdownSubjects');   
                const subjectContainer = document.getElementById('subject-container');
                const subjectList = document.getElementById('subject-list');
                let selectedSubjects = [];
                
                for (const [code, name] of Object.entries(subjectMap)) {
                    const label = document.createElement('label');
                    label.classList.add('flex', 'gap-2', 'font-poppins', 'font-bold', 'items-center');
                    label.innerHTML = `
                        <input
                            type="checkbox"
                            name="subj_code[]"
                            subject-name="${name}"
                            class="courseCheckbox"
                            value="${code}"
                        >${code} - ${name}
                    `;
                    container.appendChild(label);
                }
    
                    container.addEventListener('change', function(e) {
                        const checkbox = e.target;
                        if (!checkbox.classList.contains('courseCheckbox')) 
                            return;
                        const checkedCheckboxes = Array.from (
                            document.querySelectorAll('.courseCheckbox:checked')
                        );
    
                        if (checkedCheckboxes.length > 3) {
                            checkbox.checked = false;
                            showNotification(
                                'You can not add more than 3 subjects',
                                'Cannot add more than 3 subjects',
                                'error',
                                15,
                                'small'
                            );
                            return;
                        }
    
                        selectedSubjects = checkedCheckboxes.map((cb) => ({
                                subj_code: cb.value,
                                subj_name: cb.getAttribute('subject-name'),
                        }
                    ));
                        
                        console.log('Selected Subjects After checkedCheckboxes: ', selectedSubjects)
    
                        updateSubjectList();
                        toggleSubjectContainer();
                    });

                function updateSubjectList() {
                    subjectList.innerHTML = '';
                    selectedSubjects.forEach((subject) => {
                        const listItem =document.createElement('li');
                        listItem.classList.add(
                            'flex',
                            'justify-between',
                            'items-center',
                            'p-2',
                            'rounded-full',
                            'max-w-[175px]',
                            'bg-accent2',
                            'border-2',
                            'font-poppins',
                            'shadow-black',
                            'shadow-custom-button',
                            'font-bold',
                            'border-black'
                        );
                        listItem.textContent = `${subject.subj_code}`;
                        
                        const removeButton = document.createElement('button');
                        // removeButton.textContent = 'x';
                        removeButton.classList.add('ml-2', 'text-red-500', 'hover:text-red-700');
                        removeButton.onclick = function() {
                            selectedSubjects = selectedSubjects.filter(
                                (s) => s.subj_code !== subject.subj_code
                            );
                            document.querySelector(
                                '.courseCheckbox[value="${subject.subj_code}"]'
                            ).checked = false;
                            updateSubjectList();
                            toggleSubjectContainer();                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        leSubjectContainer();
                        };

                        listItem.appendChild(removeButton);
                        subjectList.appendChild(listItem);                       
                        console.log(selectedSubjects);                                   
                    });
                }

                function toggleSubjectContainer() {
                    if (selectedSubjects.length === 0) {
                        subjectContainer.style.visibility = 'hidden';
                        hr.style.visibility = 'hidden';
                    } else {
                        subjectContainer.style.visibility = 'visible';
                        header.style.visibility = 'visible';
                    }
                };

                document.getElementById('submitBtn').addEventListener('click', function(event) {
                    event.preventDefault();
                    submitForm();
                });

                
                console.log('Subjects array sending', selectedSubjects);

                function submitForm() {

                    if (selectedSubjects.length === 0) {
                        showNotification(
                                'Choose one at least one subject',
                                'Please select at least one subject',
                                'error',
                                15,
                                'small'
                            );
                        return;
                    }
                    fetch('{{ route('tutor.store') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ subjects: selectedSubjects }),
                    }).then (response => {
                        if (response.ok) {
                            console.log('Subjects added successfully');
                            subjects = [];
                            document.getElementById('subject-list').innerHTML = '';
                            window.location.href = "{{ route('user.schedule') }}";
                        } else {
                            console.log('Failed to add subjects');
                            alert('Failed to add subjects');
                        }
                    }).catch (error => {
                        console.error('Error:', error);
                    });
                }
                
            </script>