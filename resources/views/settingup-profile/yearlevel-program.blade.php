<x-auth-layout>
    <x-folder class="h-full">
        <x-slot name="header">
            <div class="md:text-center justify-center">
                @if(Auth::check())
                    Hello, {{ Auth::user()->name }}!
                @else
                    Hello, Guest!   
                @endif
            </div>
        </x-slot>

        <x-slot name="content">
        
                <div class="text-center font-bold text-5xl mt-8">
                    Choose your Year Level and College Program
                </div>
                
                <!-- Image -->
                <div class="flex flex-col pb-44 md:flex-row md:space-x-6 sm:pb-64 lg:pb-20">
                    <div class="w-auto md:w-1/2 flex justify-center mt-6 md:mt-0">
                        <div class="flex flex-col py-14 px-4 justify-center">
                            <img src="{{ asset('/images/profiling/Student.svg') }}" alt="placeholder" class="ml-[20px] max-w-full h-auto mt-8">
                            <p class="text-center font-poppins font-bold text-[22px] mt-2">You're a Student!</p>
                        </div>
                    </div>
                    
                    <!-- Form --> 
                    <div class="w-full md:w-1/2 flex flex-col justify-center p-3">
                        <div class="w-4/5">
                                <form method="POST" action="{{route('department.student.store')}}">
                                    @csrf
                                    <div class="flex flex-col text-left">
                                        <label class="font-bold font-poppins text-2xl mb-2 ">Year Level:</label>
                                        <select name="year_level" class="border-2 font-poppins border-black p-3 rounded shadow-custom-button shadow-black w-full">
                                            <option value="" disabled selected>Year Level...</option>
                                            <option value="1st Year">1st Year</option>
                                            <option value="2nd Year">2nd Year</option>
                                            <option value="3rd Year">3rd Year</option>
                                            <option value="4th Year">4th Year</option>
                                        </select>

                                        <label class="font-bold font-poppins text-2xl mt-8 mb-2">College Department:</label>
                                        <select class="border-2 font-poppins border-black p-3 rounded shadow-custom-button shadow-black w-full" name="college">
                                            <option value=""disabled selected>College Department...</option>
                                            <option value="College Of Computing Studies">College Of Computing Studies</option>
                                            <option value="College of Education">College of Education</option>
                                            <option value="College of Engineering and Architecture">College of Engineering and Architecture</option>
                                            <option value="College of Social Sciences and Philosophy">College of Social Sciences and Philosophy</option>
                                            <option value="College of Business Studies">College of Business Studies</option>
                                            <option value="College of Hospitality and Tourism Management">College of Hospitality and Tourism Management</option>
                                        </select>

                                        <label class="font-bold font-poppins text-2xl mt-8 mb-2">College Program:</label>
                                        <select class="border-2 font-poppins border-black p-3 rounded shadow-custom-button shadow-black w-full" name="department" disabled>
                                            <option value="" disabled selected>College Program...</option>
                                        </select>

                                        <div class="flex flex-col sm:flex-row justify-between sm:justify-end space-y-4 sm:space-y-0 sm:space-x-4 mt-6 w-full">
                                            <x-primary-button onclick="history.back()" type="button" class="bg-primary text-accent2  font-bold w-full max-w-[120px]">
                                                {{ __('Back') }}
                                            </x-primary-button>
                                            <x-primary-button class="bg-accent2 text-primary font-bold w-full max-w-[120px] ml-8">
                                                {{ __('Next') }}
                                            </x-primary-button>
                                        </div>
                                    </form>    
                                </div>
                        </div>
                    </div>
                </div>
                <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const collegeSelect = document.querySelector('select[name="college"]');
                            const departmentSelect = document.querySelector('select[name="department"]');
                            
                            
                            const collegePrograms = {
                                'College Of Computing Studies': [
                                    'Bachelor of Science in Computer Engineering',
                                    'Bachelor of Science in Computer Science',
                                    'Bachelor of Science in Information Systems',
                                    'Bachelor of Science in Information Technology'
                                ],
                                'College of Education': [
                                    'Bachelor of Culture and Arts Education',
                                    'Bachelor of Earyl Childhood Education',
                                    'Bachelor of Elementary Education',
                                    'Bachelor of Secondary Education',
                                    'Bachelor of Secondary Education Major in Filipino',
                                    'Bachelor of Secondary Education Major in General Science',
                                    'Bachelor of Secondary Education Major in Mathematics',
                                    'Bachelor of Secondary Education Major in Social Studies',
                                    'Bachelor of Sciencce in Exercise and Sports Sciences Major in Fitness and Sports Coaching',
                                    'Bachelor of Science in Exercise and Sports Sciences Major in Fitness and Sports Management',
                                    'Bachelor of Physical Education',
                                    'Bachelor of Technical-Vocational Teacher Education Major in Food and Service Management',
                                    'Bachelor of Techonology & Livelihood Education Major in Home Economics',
                                    'Bachelor of Techonology & Livelihood Education Major in Industrial Arts',
                                ],
                                'College of Engineering and Architecture': [
                                    'Bachelor of Science in Civil Engineering',
                                    'Bachelor of Science in Architecture',
                                    'Bachelor of Science in Electrical Engineering',
                                    'Bachelor of Science in Electronics Engineering',
                                    'Bachelor of Science in Mechanical Engineering',
                                    'Bachelor of Science in Computer Engineering',
                                    'Bachelor of Science in Industrial Engineering',
                                ],
                                'College of Social Sciences and Philosophy': [
                                    'Bachelor in Human Services',
                                    'Bachelor of Science in Psychology',
                                    'Bachelor of Arts in Sociology',
                                    'Bachelor of Science in Social Work',
                                ],
                                'College of Business Studies': [
                                    'Bachelor of Public Administration',
                                    'Bachelor of Science in Accountancy',
                                    'Bachelor of Science in Accounting Information System',
                                    'Bachelor of Science in Business Administration Major in Business Economics',
                                    'Bachelor of Science in Business Administration Major in Marketing Management',
                                    'Bachelor of Science in Entrepreneurship',
                                    'Bachelor of Science in Legal Management',
                                    'Bachelor of Science in Logistic and Supply Chain Management',
                                    'Bachelor of Science in Real Estate Management',
                                ],
                                'College of Hospitality and Tourism Management': [
                                    'Bachelor of Science in Hospitality Management',
                                    'Bachelor of Science in Tourism Management',
                                ],
                            };
                            
                            function updateDepartmentOptions() {
                                const selectedCollege = collegeSelect.value;
                                
                                departmentSelect.innerHTML = '<option value="" disabled selected>College Program...</option>';
                                
                                if (!selectedCollege) {
                                    departmentSelect.disabled = true;
                                    return;
                                }
                                
                                departmentSelect.disabled = false;
                                const programs = collegePrograms[selectedCollege] || [];
                                
                                programs.forEach(program => {
                                    const option = document.createElement('option');
                                    option.value = program;
                                    option.textContent = program;
                                    departmentSelect.appendChild(option);
                                });
                            }
                            
                            
                            collegeSelect.addEventListener('change', updateDepartmentOptions);
                            
                            departmentSelect.disabled = true;
                        });
                </script>
        </x-slot>
        
    </x-folder>
</x-auth-layout>