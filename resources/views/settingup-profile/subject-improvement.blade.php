<x-auth-layout>
    <x-folder class="h-auto md:h-full">
        <x-slot name="header">
            Subject Improvement
        </x-slot>

        <x-slot name="content">
            <div class="font-dela text-center text-charcoal font-bold text-3xl md:text-5xl lg:text-6xl my-6 md:my-8 px-4">
                Specify subjects that needed improvement
            </div>

            <div class="flex flex-col pb-20 md:pb-32 lg:pb-20 md:flex-row md:space-x-6 px-4 md:px-6">
                <!-- Left side -->
                <div class="w-full md:w-1/2 flex justify-center mt-6 md:mt-0">
                    <div class="flex flex-col justify-center items-center">
                        <img src="{{ asset('/images/profiling/Student.svg') }}" alt="placeholder"
                            class="w-[200px] md:w-[250px] lg:w-auto max-w-full h-auto">
                        <p class="text-center font-poppins font-bold text-lg md:text-xl lg:text-[22px] mt-2">You're a Student!</p>
                    </div>
                </div>

                <!-- Right side -->
                <div class="w-full md:w-1/2 flex flex-col justify-center p-3 mt-6 md:mt-0">
                    <div class="w-full lg:w-4/5">
                        <form method="POST">
                            <label class="text-darkgray font-bold font-poppins text-lg md:text-xl lg:text-2xl mb-3 md:mb-5 block">Select
                                Subjects:</label>

                            <div class="relative">
                                <!-- Search input field to open the dropdown and search -->
                                <div class="relative w-full">
                                    <input type="text" placeholder="Search and select subjects..." id="dropdownButton"
                                        class="bg-accent text-charcoal border-2 border-charcoal p-3 rounded-sm w-full text-left text-sm md:text-base outline-none duration-200 ring-2 
                                        ring-[transparent] focus:ring-primary/70 focus:border-primary/70" />
                                    <span class="absolute right-3 top-3 cursor-pointer pointer-events-none">
                                        <x-bladewind::icon name="chevron-down" class="w-5 h-5 text-charcoal" />
                                    </span>
                                </div>

                                <!-- Dropdown menu -->
                                <div id="dropdownMenu"
                                    class="absolute left-0 right-0 mt-2 mb-10 hidden bg-accent border-2 border-charcoal rounded-sm shadow-md z-10 max-h-[12rem]" style="display: none; flex-direction: column;">

                                    <!-- Close button -->
                                    <div class="sticky top-0 flex justify-end p-2 border-b border-charcoal/20 bg-accent z-20">
                                        <button type="button" id="closeDropdownBtn"
                                            class="text-charcoal hover:text-accent hover:bg-primary p-1 rounded transition-colors duration-200">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </button>
                                    </div>

                                    <div class="space-y-2 p-2 overflow-y-scroll scroll-smooth" id="dropdownSubjects">
                                    </div>
                                </div>
                                <div class="ml-2 mt-2 text-xs md:text-sm text-gray-500/80 font-medium">Please choose up to 3 subjects only</div>
                            </div>



                            <!-- container ng list and add para aligned -->
                            <div class="mt-2 flex items-center justify-between">
                                <!-- list of selected subjects -->
                                <div id="subject-container" class="flex flex-col gap-2" style="visibility: hidden">
                                    <h1 id="header" class="font-dela text-primary font-bold text-sm md:text-base">ADDED SUBJECTS</h1>
                                    <ul id="subject-list" class="flex flex-wrap gap-2 font-poppins"></ul>
                                </div>
                            </div>

                            <!-- Buttons -->
                            <div
                                class="flex flex-col sm:flex-row justify-between sm:justify-end space-y-4 sm:space-y-0 sm:space-x-4 mt-6 w-full">
                                <x-primary-button onclick="history.back()" type="button"
                                    class="font-bold font-poppins bg-accent text-primary border text-sm md:text-base ring-2 ring-transparent
                                        hover:bg-primary/5 border-charcoal hover:ring-primary/70 hover:border-primary/70 rounded-lg w-full sm:w-auto px-6 py-3">
                                    {{ __('Back') }}
                                </x-primary-button>
                                <x-primary-button id='submitBtn'
                                    class="bg-primary text-accent3 font-bold font-poppins w-full sm:w-auto text-sm md:text-base
                                        hover:bg-primary/70 rounded-lg px-6 py-3">
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
                const closeDropdownBtn = document.getElementById('closeDropdownBtn');

                dropdownButton.addEventListener('focus', () => {
                    dropdownMenu.classList.remove('hidden');
                    dropdownMenu.style.display = 'flex';
                    dropdownButton.classList.add('border-primary/70');
                });

                dropdownButton.addEventListener('blur', (event) => {
                    // Only close if clicking outside the dropdown menu
                    setTimeout(() => {
                        if (!dropdownMenu.contains(document.activeElement)) {
                            dropdownMenu.classList.add('hidden');
                            dropdownMenu.style.display = 'none';
                            dropdownButton.classList.remove('border-primary/70');
                        }
                    }, 100);
                });

                closeDropdownBtn.addEventListener('click', (event) => {
                    event.stopPropagation();
                    dropdownMenu.classList.add('hidden');
                    dropdownMenu.style.display = 'none';
                    dropdownButton.classList.remove('border-primary/70');
                    dropdownButton.value = '';
                });

                dropdownMenu.addEventListener('click', (event) => {
                    event.stopPropagation();
                });

                document.addEventListener('click', (event) => {
                    if (!dropdownButton.contains(event.target) && !dropdownMenu.contains(event.target)) {
                        dropdownMenu.classList.add('hidden');
                        dropdownMenu.style.display = 'none';
                        dropdownButton.classList.remove('border-primary/70');
                    }
                });
            </script>

            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

            <script>
                let subjectMap = @json($subjects);
                console.log(subjectMap);

                const container = document.getElementById('dropdownSubjects');
                const subjectContainer = document.getElementById('subject-container');
                const subjectList = document.getElementById('subject-list');
                const searchInput = document.getElementById('dropdownButton'); // Now references the input field
                let selectedSubjects = [];
                let allSubjects = [];

                for (const [code, name] of Object.entries(subjectMap)) {
                    const label = document.createElement('label');
                    label.classList.add('flex', 'gap-2', 'font-poppins', 'font-bold', 'items-center', 'p-2', 'hover:bg-[#DCDCDC]',
                        'text-darkgray', 'cursor-pointer', 'rounded-lg', 'peer-checked:bg-primary/20');
                    label.innerHTML = `
                        <input
                            type="checkbox"
                            name="subj_code[]"
                            subject-name="${name}"
                            class="courseCheckbox size-5 peer accent-[#550000]"
                            value="${code}"
                        >
                        <span class="peer-checked:text-primary">${code} - ${name}</span>
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
                            'inline-flex',
                            'justify-center',
                            'items-center',
                            'px-2.5',
                            'py-1.5',
                            'rounded-full',
                            'min-w-[100px]',
                            'max-w-[175px]',
                            'bg-primary/5',
                            'border-2',
                            'text-primary',
                            'font-bold',
                            'border-primary/50'
                        );
                        listItem.innerHTML = `

                        <p class="text-sm whitespace-nowrap">${subject.subj_code}</p>`;

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
                    fetch("{{ route('subjects.store') }}", {
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
                        showMoreBtn.classList.add('w-full', 'text-accent', 'hover:bg-primary/80', 'p-2',
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
