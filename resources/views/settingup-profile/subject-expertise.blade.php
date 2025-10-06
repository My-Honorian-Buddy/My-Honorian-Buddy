<x-auth-layout>

    <x-folder class="h-full">
        <x-slot name="header">
            Subject Expertise
        </x-slot>

        <x-slot name="content">
            <div class="text-center font-bold text-6xl my-8">
                Specify your subject expertise
            </div>

            <div class="flex flex-col pb-44 md:flex-row md:space-x-6 sm:pb-64 lg:pb-20">
                <!-- Left side -->
                <div class="w-auto md:w-1/2 flex justify-center mt-6 md:mt-0">
                    <div class="flex flex-col px-4 justify-center ">
                        <img src="{{ asset('/images/profiling/Tutor.svg') }}" alt="placeholder"
                            class="ml-[20px] max-w-full h-auto mt-8">
                        <p class="text-center font-poppins font-bold text-[22px] mt-2">You're a Tutor!</p>
                    </div>
                </div>

                <!-- Right side -->
                <div class="w-full md:w-1/2 flex flex-col justify-center p-3">
                    <div class="w-4/5">
                        <form method="POST">
                            {{-- subjects dropdown --}}
                            <label class="text-primary font-bold font-poppins text-2xl mt-8 mb-5">Select
                                Subjects:</label>

                            <div class="relative">
                                <!-- Button to open the dropdown, type="button" prevents form submission -->
                                <button type="button" id="dropdownButton"
                                    class="bg-white border-2 font-poppins border-black p-3 rounded shadow-custom-button shadow-black w-full text-left ">
                                    Select Subjects
                                </button>

                                <!-- Dropdown menu -->
                                <div id="dropdownMenu"
                                    class="absolute left-0 right-0 mt-2 mb-10 hidden bg-white border-2 border-black rounded shadow-lg z-10 overflow-y-scroll max-h-[12rem] scroll-smooth">
                                    <div class="flex flex-col items-center space-y-4">
                                        {{-- search bar --}}
                                        <div class="relative w-full m-2 mt-4 px-6">
                                            <input type="text" placeholder="Search subjects..." name="query"
                                                class="w-full py-1 pl-4 pr-10 rounded-full 
                                            border-2 border-black bg-accent3 shadow-inner focus:outline-none font-bold focus:text-[20px] placeholder:text-[20px] text-gray-900" />
                                            <span class="absolute right-10 top-1.5 cursor-pointer">
                                                <x-bladewind::icon name="magnifying-glass" />
                                            </span>
                                        </div>
                                    </div>
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
                            <div
                                class="flex flex-col sm:flex-row justify-between sm:justify-end space-y-4 sm:space-y-0 sm:space-x-4 mt-6 w-full">
                                <x-primary-button onclick="history.back()" type="button"
                                    class="bg-primary text-accent2 font-bold w-full max-w-[120px]">
                                    {{ __('Back') }}
                                </x-primary-button>
                                <x-primary-button id='submitBtn'
                                    class="bg-accent2 text-primary font-bold w-full max-w-[120px]">
                                    {{ __('Next') }}
                                </x-primary-button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>


            <!-- dropdown script -->
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
                let subjectMap = @json($subjects);
                console.log(subjectMap);

                /*const subjectMap = {
                        
                        
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
                    };*/

                const container = document.getElementById('dropdownSubjects');
                const subjectContainer = document.getElementById('subject-container');
                const subjectList = document.getElementById('subject-list');
                const searchInput = document.querySelector('input[name="query"]');
                let selectedSubjects = [];
                let allSubjects = [];

                for (const [code, name] of Object.entries(subjectMap)) {
                    const label = document.createElement('label');
                    label.classList.add('flex', 'gap-2', 'font-poppins', 'font-bold', 'items-center', 'p-2', 'hover:bg-gray-100',
                        'cursor-pointer');
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
                    allSubjects.push(label);
                }

                // ETO NA SON SEARCH FILTER LFG
                function filterSubjects(query) {
                    const searchTerm = query.toLowerCase().trim();


                    container.innerHTML = '';

                    if (searchTerm === '') {

                        allSubjects.forEach(subject => {
                            const clonedSubject = subject.cloneNode(true);
                            container.appendChild(clonedSubject);


                            const checkbox = clonedSubject.querySelector('.courseCheckbox');
                            const isSelected = selectedSubjects.some(s => s.subj_code === checkbox.value);
                            checkbox.checked = isSelected;
                        });
                    } else {

                        const filteredSubjects = allSubjects.filter(subject => {
                            const text = subject.textContent.toLowerCase();
                            const checkbox = subject.querySelector('input[type="checkbox"]');
                            const subjCode = checkbox ? checkbox.value.toLowerCase() : '';
                            const subjName = checkbox ? checkbox.getAttribute('subject-name').toLowerCase() : '';

                            return subjCode.includes(searchTerm) ||
                                subjName.includes(searchTerm) ||
                                text.includes(searchTerm);
                        });

                        if (filteredSubjects.length === 0) {

                            const noResults = document.createElement('div');
                            noResults.classList.add('p-4', 'text-center', 'text-gray-500', 'font-poppins');
                            noResults.textContent = 'No subjects found';
                            container.appendChild(noResults);
                        } else {
                            filteredSubjects.forEach(subject => {
                                const clonedSubject = subject.cloneNode(true);
                                container.appendChild(clonedSubject);


                                const checkbox = clonedSubject.querySelector('.courseCheckbox');
                                const isSelected = selectedSubjects.some(s => s.subj_code === checkbox.value);
                                checkbox.checked = isSelected;
                            });
                        }
                    }
                }


                searchInput.addEventListener('input', function(e) {
                    e.preventDefault();
                    filterSubjects(this.value);
                });

                searchInput.addEventListener('keydown', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        filterSubjects(this.value);
                    }
                });


                const searchForm = searchInput.closest('form');
                searchForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    filterSubjects(searchInput.value);
                });


                container.addEventListener('change', function(e) {
                    const checkbox = e.target;
                    if (!checkbox.classList.contains('courseCheckbox'))
                        return;

                    const checkedCheckboxes = Array.from(
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
                    }));

                    console.log('Selected Subjects After checkedCheckboxes: ', selectedSubjects);

                    updateSubjectList();
                    toggleSubjectContainer();


                    updateAllCheckboxStates();
                });


                function updateAllCheckboxStates() {
                    const currentQuery = searchInput.value;
                    if (currentQuery.trim() !== '') {
                        // Re-filter to maintain search results with updated states
                        filterSubjects(currentQuery);
                    }
                }

                function updateSubjectList() {
                    subjectList.innerHTML = '';
                    selectedSubjects.forEach((subject) => {
                        const listItem = document.createElement('li');
                        listItem.classList.add(
                            'flex',
                            'justify-center',
                            'items-center',
                            'p-2',
                            'rounded-full',
                            'min-w-[100px]',
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
                        removeButton.classList.add('hidden', 'text-red-500', 'hover:text-red-700');
                        removeButton.onclick = function() {
                            selectedSubjects = selectedSubjects.filter(
                                (s) => s.subj_code !== subject.subj_code
                            );


                            document.querySelectorAll(`.courseCheckbox[value="${subject.subj_code}"]`).forEach(cb => {
                                cb.checked = false;
                            });

                            updateSubjectList();
                            toggleSubjectContainer();
                            updateAllCheckboxStates();
                        };

                        listItem.appendChild(removeButton);
                        subjectList.appendChild(listItem);
                        console.log(selectedSubjects);
                    });
                }

                function toggleSubjectContainer() {
                    if (selectedSubjects.length === 0) {
                        subjectContainer.style.visibility = 'hidden';
                    } else {
                        subjectContainer.style.visibility = 'visible';
                    }
                }

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

                    fetch("{{ route('tutor.store') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': "{{ csrf_token() }}"
                            },
                            body: JSON.stringify({
                                subjects: selectedSubjects
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.status === 'success') {
                                console.log('Subjects added successfully');
                                selectedSubjects = [];
                                document.getElementById('subject-list').innerHTML = '';
                                window.location.href = data.redirect;
                            } else {
                                console.log('Failed to add subjects');
                                alert('Failed to add subjects');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('An error occurred while saving subjects. Please try again.');
                        });
                }



                let showCount = 10;
                let showAll = false;

                function renderSubjects() {
                    container.innerHTML = '';
                    let subjectsToShow = showAll ? allSubjects : allSubjects.slice(0, showCount);

                    subjectsToShow.forEach(subject => {
                        const clonedSubject = subject.cloneNode(true);
                        container.appendChild(clonedSubject);
                        const checkbox = clonedSubject.querySelector('.courseCheckbox');
                        const isSelected = selectedSubjects.some(s => s.subj_code === checkbox.value);
                        checkbox.checked = isSelected;
                    });

                    if (!showAll && allSubjects.length > showCount) {
                        const showMoreBtn = document.createElement('button');
                        showMoreBtn.textContent = 'Show more...';
                        showMoreBtn.classList.add('w-full', 'text-accent2', 'hover:text-primary', 'hover:bg-accent2', 'p-2', 
                        'border-2', 'border-black', 'bg-primary', 'rounded', 'mt-2', 'font-bold');
                        showMoreBtn.onclick = function() {
                            event.stopPropagation();
                            showAll = true;
                            renderSubjects();
                        };
                        container.appendChild(showMoreBtn);
                    }
                }


                renderSubjects();


                function filterSubjects(query) {
                    const searchTerm = query.toLowerCase().trim();
                    container.innerHTML = '';
                    showAll = false;

                    if (searchTerm === '') {
                        renderSubjects();
                    } else {
                        const filteredSubjects = allSubjects.filter(subject => {
                            const text = subject.textContent.toLowerCase();
                            const checkbox = subject.querySelector('input[type="checkbox"]');
                            const subjCode = checkbox ? checkbox.value.toLowerCase() : '';
                            const subjName = checkbox ? checkbox.getAttribute('subject-name').toLowerCase() : '';
                            return subjCode.includes(searchTerm) ||
                                subjName.includes(searchTerm) ||
                                text.includes(searchTerm);
                        });

                        filteredSubjects.forEach(subject => {
                            const clonedSubject = subject.cloneNode(true);
                            container.appendChild(clonedSubject);
                            const checkbox = clonedSubject.querySelector('.courseCheckbox');
                            const isSelected = selectedSubjects.some(s => s.subj_code === checkbox.value);
                            checkbox.checked = isSelected;
                        });

                        if (filteredSubjects.length === 0) {
                            const noResults = document.createElement('div');
                            noResults.classList.add('p-4', 'text-center', 'text-gray-500', 'font-poppins');
                            noResults.textContent = 'No subjects found';
                            container.appendChild(noResults);
                        }
                    }
                }
            </script>
        </x-slot>
    </x-folder>
</x-auth-layout>
