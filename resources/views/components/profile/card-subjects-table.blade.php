@php
    $user = Auth::user();
@endphp

<div class="flex mt-8 mb-8">
    <div class="w-full bg-accent3 rounded-[20px] shadow-custom-button shadow-black border-black border-2">
        <div class="relative rounded-[20px] px-6">

            <!-- Card Tittle-->
            <div class="flex flex-col mt-8 text-left">
                <span class="font-bold text-4xl m-5 leading-relaxed">Subjects</span> 
            </div>

            <!-- Card Content-->
            <div class="flex justify-center">
                <form method="POST">
                            {{-- subjects dropdown --}}
                            <label class="text-primary font-bold font-poppins text-2xl mt-8 mb-5">Select Subjects:</label>

                            <div class="relative">
                                <!-- Button to open the dropdown, type="button" prevents form submission -->
                                <button type="button" id="dropdownButton" class="bg-white border-2 font-poppins border-black p-3 rounded shadow-custom-button shadow-black w-full text-left ">
                                    Select Subjects
                                </button>
                                
                                <!-- Dropdown menu -->
                                <div id="dropdownMenu" class="absolute left-0 right-0 mt-2 mb-10 hidden bg-white border-2 border-black rounded shadow-lg z-10 overflow-y-scroll max-h-[12rem] scroll-smooth">
                                    <div class="space-y-2 p-2" id="dropdownSubjects">

                                    </div>
                                </div>
                                <div class="mt-2 text-gray-500 font-bold"> Please choose up to 3 subjects only </div>
                            </div>
                        
                                        

                            <!-- container ng list and add para aligned -->
                            <div class="mt-2 flex items-center justify-between">
                                <!-- list of selected subjects -->
                                <div id="subject-container" class="flex flex-col gap-2" style="visibility: hidden">
                                    <h1 id="header" class="text-primary font-bold">ADDED SUBJECTS</h1>
                                    <ul id="subject-list" class="flex flex-wrap gap-2"></ul>                                    
                                </div>                    
                            </div>

                            <!-- Buttons -->
                            <div class="flex justify-end m-8">
                <x-primary-button type="submit" class=" bg-accent2 text-black ">Save</x-primary-button>
            </div>
                        </form>

            </div>

            <!-- Button-->
            
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