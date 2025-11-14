<x-auth-layout>

    <x-folder class="h-full">
        <x-slot name="header">
            Subject Expertise
        </x-slot>

        <x-slot name="content">
            <div class="font-dela text-center text-charcoal font-bold text-3xl md:text-5xl lg:text-6xl my-6 md:my-8 px-4">
                Specify your subject expertise
            </div>

            <div class="flex flex-col pb-20 md:pb-32 lg:pb-20 md:flex-row md:space-x-6 px-4 md:px-6">
                <!-- Left side -->
                <div class="w-full md:w-1/2 flex justify-center mt-6 md:mt-0">
                    <div class="flex flex-col justify-center items-center">
                        <img src="{{ asset('/images/profiling/Tutor.svg') }}" alt="placeholder"
                            class="w-[200px] md:w-[250px] lg:w-auto max-w-full h-auto">
                        <p class="text-center font-poppins font-bold text-lg md:text-xl lg:text-[22px] mt-2">You're a Tutor!</p>
                    </div>
                </div>

                <!-- Right side -->
                <div class="w-full md:w-1/2 flex flex-col justify-center p-3 mt-6 md:mt-0">
                    <div class="w-full lg:w-4/5">
                        <form method="POST">
                            {{-- subjects dropdown --}}
                            <label class="text-darkgray font-bold font-poppins text-lg md:text-xl lg:text-2xl mb-3 md:mb-5 block">Select
                                Subjects:</label>

                            <div class="relative">
                                <!-- Search input field to open the dropdown and search -->
                                <div class="relative w-full">
                                    <input type="text" placeholder="Search and select subjects..." id="dropdownButton"
                                        class="bg-accent text-charcoal border-2 border-charcoal p-3 rounded-sm shadow-black w-full text-left 
                                        text-sm md:text-base outline-none duration-200 ring-2 ring-[transparent] focus:ring-primary/70 focus:border-primary/70" />
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

                                    <div class="sticky top-11 bg-accent flex flex-col items-center space-y-4 border-b border-charcoal/20 z-20">
                                    </div>
                                    <div class="space-y-2 p-2 overflow-y-scroll scroll-smooth" id="dropdownSubjects">
                                    </div>
                                </div>
                                <div class="mt-2 text-xs md:text-sm text-gray-500/80 font-medium"> Please choose up to 3 subjects only </div>
                            </div>



                            <!-- container ng list and add para aligned -->
                            <div class="mt-2 flex items-center justify-between">
                                <!-- list of selected subjects -->
                                <div id="subject-container" class="flex flex-col gap-2" style="visibility: hidden">
                                    <h1 id="header" class="font-dela text-primary font-bold text-sm md:text-base">Added Subjects:</h1>
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
                    }, 200);
                });

                // Prevent closing dropdown when clicking inside it
                dropdownMenu.addEventListener('mousedown', (event) => {
                    event.preventDefault();
                    if (event.target.classList.contains('courseCheckbox')) {
                        event.target.checked = !event.target.checked;
                        event.target.dispatchEvent(new Event('change', { bubbles: true }));
                    }
                });

                closeDropdownBtn.addEventListener('click', (event) => {
                    event.stopPropagation();
                    dropdownMenu.classList.add('hidden');
                    dropdownMenu.style.display = 'none';
                    dropdownButton.classList.remove('border-primary/70');
                    dropdownButton.value = '';
                });

                document.addEventListener('click', (event) => {
                    if (!dropdownButton.contains(event.target) && !dropdownMenu.contains(event.target)) {
                        dropdownMenu.classList.add('hidden');
                        dropdownMenu.style.display = 'none';
                        dropdownButton.classList.remove('border-primary/70');
                    }
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
                let allSubjectsData = []; // Store as data, not as DOM elements

                // Create subjects data array instead of DOM elements
                for (const [code, name] of Object.entries(subjectMap)) {
                    allSubjectsData.push({
                        code: code,
                        name: name
                    });
                }

                console.log('All subjects data:', allSubjectsData);

                // Create label element from subject data
                function createSubjectLabel(subjectData) {
                    const label = document.createElement('label');
                    label.classList.add('flex', 'gap-2', 'font-poppins', 'font-bold', 'items-center', 'p-2', 'hover:bg-[#DCDCDC]',
                        'text-darkgray', 'cursor-pointer', 'rounded-lg', 'peer-checked:bg-primary/20', 'text-sm', 'md:text-base');
                    
                    const checkbox = document.createElement('input');
                    checkbox.type = 'checkbox';
                    checkbox.name = 'subj_code[]';
                    checkbox.setAttribute('subject-name', subjectData.name);
                    checkbox.classList.add('courseCheckbox', 'size-5', 'peer');
                    checkbox.style.accentColor = '#550000';
                    checkbox.value = subjectData.code;
                    checkbox.checked = selectedSubjects.some(s => s.subj_code === subjectData.code);
                    
                    const span = document.createElement('span');
                    span.classList.add('peer-checked:text-primary');
                    span.textContent = `${subjectData.code} - ${subjectData.name}`;
                    
                    label.appendChild(checkbox);
                    label.appendChild(span);
                    
                    return label;
                }

                // ETO NA SON SEARCH FILTER LFG
                function filterSubjects(query) {
                    const searchTerm = query.toLowerCase().trim();
                    container.innerHTML = '';

                    let subjectsToShow = allSubjectsData;

                    if (searchTerm !== '') {
                        subjectsToShow = allSubjectsData.filter(subject => {
                            const code = subject.code.toLowerCase();
                            const name = subject.name.toLowerCase();
                            return code.includes(searchTerm) || name.includes(searchTerm);
                        });

                        if (subjectsToShow.length === 0) {
                            const noResults = document.createElement('div');
                            noResults.classList.add('p-4', 'text-center', 'text-gray-500', 'font-poppins', 'text-sm', 'md:text-base');
                            noResults.textContent = 'No subjects found';
                            container.appendChild(noResults);
                            return;
                        }
                    }

                    renderVisibleSubjects(subjectsToShow);
                }

                function renderVisibleSubjects(subjectsToRender) {
                    subjectsToRender.forEach(subjectData => {
                        const label = createSubjectLabel(subjectData);
                        container.appendChild(label);
                    });
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


                document.addEventListener('change', function(e) {
                    const checkbox = e.target;
                    if (!checkbox.classList.contains('courseCheckbox'))
                        return;

                    // Check the total number of selected subjects (from selectedSubjects array)
                    const isChecked = checkbox.checked;
                    const subjectCode = checkbox.value;
                    const subjectName = checkbox.getAttribute('subject-name');

                    // If checking a box, verify limit
                    if (isChecked) {
                        if (selectedSubjects.length >= 3) {
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
                        // Add to selected subjects
                        selectedSubjects.push({
                            subj_code: subjectCode,
                            subj_name: subjectName
                        });
                    } else {
                        // Remove from selected subjects
                        selectedSubjects = selectedSubjects.filter(s => s.subj_code !== subjectCode);
                    }

                    console.log('Selected Subjects: ', selectedSubjects);

                    updateSubjectList();
                    toggleSubjectContainer();
                });


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
                            'min-w-[80px]',
                            'md:min-w-[100px]',
                            'max-w-[150px]',
                            'md:max-w-[175px]',
                            'bg-primary/5',
                            'border-2',
                            'text-primary',
                            'font-bold',
                            'border-primary/50'
                        );
                        listItem.innerHTML = `

                        <p class="text-xs md:text-sm whitespace-nowrap">${subject.subj_code}</p>`;
                        

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
                    let subjectsToShow = showAll ? allSubjectsData : allSubjectsData.slice(0, showCount);

                    renderVisibleSubjects(subjectsToShow);

                    if (!showAll && allSubjectsData.length > showCount) {
                        const showMoreBtn = document.createElement('button');
                        showMoreBtn.textContent = 'Show more...';
                        showMoreBtn.classList.add('w-full', 'text-accent', 'hover:bg-primary/80', 'p-2',
                            'border-2', 'border-black', 'bg-primary', 'rounded', 'mt-2', 'font-bold', 'text-sm', 'md:text-base');
                        showMoreBtn.type = 'button';
                        showMoreBtn.onclick = function(evt) {
                            evt.stopPropagation();
                            showAll = true;
                            renderSubjects();
                        };
                        container.appendChild(showMoreBtn);
                    }
                }

                renderSubjects();
            </script>
        </x-slot>
    </x-folder>
</x-auth-layout>
