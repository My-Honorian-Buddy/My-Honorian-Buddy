<x-auth-layout>
    <x-folder>
        <x-slot name="header">
            Students Subject
        </x-slot>    
        <x-slot name="content">
            <div class="flex items-center justify-center gap-3 h-full">
                <div>
                    <form method="POST" >
                        @csrf
                        <div id="subjects">
                            <div class="mb-4">
                                <label for="subj_name" class="block text-sm font-medium text-gray-700">Subject Name:</label>
                                <input type="text" id="subj_name" name="subj_name" required>

                                <label for="subj_code" class="block text-sm font-medium text-gray-700">Subject Code:</label>
                                <input type="text" id="subj_code" name="subj_code" required>
                            </div>
                        </div>
                        
                        <div class="flex flex-col space-y-4">
                            <button type="button" id="addBtn" class="bg-pink-500 text-white px-4 py-2 rounded" >Add Subject</button>
                            <button type="submit" id="submitBtn" class="bg-green-500 text-white px-4 py-2 rounded">Submit</button>
                        </div>

                    </form>
                    <h1 class="font-bold">ADDED SUBJECTS</h1>
                    <ul id="subject-list" class="list-disc pl-5">
                      
                    </ul>
                        
                </div>
            </div>

            <script>

                document.getElementById('addBtn').addEventListener('click', addSubject);
                
                let subjects = [];

                function addSubject() {
                    const subjCode = document.getElementById('subj_code').value;
                    const subjName = document.getElementById('subj_name').value;

                    if (subjCode && subjName) {
                        const subject = { subj_name: subjName, subj_code: subjCode };
                        subjects.push(subject);

                        const listItem = document.createElement('li');
                        listItem.classList.add('flex', 'justify-between', 'items-center');
                        listItem.textContent = `${subjCode} - ${subjName}`;

                        const deleteButton = document.createElement('button');
                        deleteButton.textContent = 'x';
                        deleteButton.classList.add('ml-2', 'text-red-500', 'hover:text-red-700');
                        deleteButton.onclick = function() {
                            subjects = subjects.filter((s) => s.subj_code !== subject.subj_code);
                            listItem.remove();
                        };

                        listItem.appendChild(deleteButton);
                        document.getElementById('subject-list').appendChild(listItem);

                        document.getElementById('subj_code').value = '';
                        document.getElementById('subj_name').value = '';
                        
                    }
                }   

                document.getElementById('submitBtn').addEventListener('click', function(event) {
                    event.preventDefault();
                    submitForm();
                });

                console.log('Subjects array', subjects);

                function submitForm() {
                    fetch('{{ route('subjects.store') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ subjects }),
                    }).then (response => {
                        if (response.ok) {
                            console.log('Subjects added successfully');
                            alert('Subjects added successfully');
                            subjects = [];
                            document.getElementById('subject-list').innerHTML = '';
                        } else {
                            console.log('Failed to add subjects');
                            alert('Failed to add subjects');
                        }
                    }).catch (error => {
                        console.error('Error:', error);
                    });
                }
                
            </script>

        </x-slot>
    </x-folder>
</x-auth-layout>