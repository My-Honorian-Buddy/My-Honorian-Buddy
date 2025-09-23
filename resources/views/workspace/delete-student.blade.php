<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>My Honorian Buddy</title>
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    <link href="{{ asset('vendor/bladewind/css/bladewind-ui.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="burger.css">
    <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
    />
    <script src="{{ asset('vendor/bladewind/js/helpers.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    
</head>

<body class="font-poppins font-semibold bg-secondary">
    
<div class="flex-1">
    <!-- nav bar -->
    <x-nav-bar />
    
    <!-- Sidebar --> 
    
    <div class="flex" x-data="{ isOpen: false }">
        <div class="w-96 min-h-screen p-8 space-y-6 border-r border-black" :class="{ 'w-96 animate__animated animate__fadeInLeft animate__faster': isOpen, 'hidden': !isOpen }">
                        <ul class="space-y-6">
                            <li>
                                <a href="http://">
                                    <div class="flex items-center justify-between bg-accent2 text-primary text-right font-poppins font-bold w-4/5 rounded-full px-8 py-1 h-11 text-l
                                        border-2 border-black shadow-custom-button hover:bg-[#FFECEC] hover:text-[#8B3A3A] cursor-pointer">
                                        <x-bladewind.icon name="video-camera" class="justify-self-start" />
                                
                                            JOIN A NEW CALL
                                
                                    </div>
                                </a>
                            </li>
                            <li>
                                <div class="flex items-center justify-between bg-accent2 text-primary text-right font-poppins font-bold w-4/5 rounded-full px-8 py-1 h-11 text-l border-2 border-black 
                                shadow-custom-button hover:bg-[#FFECEC] hover:text-[#8B3A3A] cursor-pointer">
                                    <x-bladewind.icon name="plus" class="justify-self-start" />
                                        CREATE A NEW CALL
                                </div>
                            </li>
                            <li>
                                <div class="flex items-center justify-between bg-accent2 text-primary text-right font-poppins font-bold w-4/5 rounded-full px-8 py-1 h-11 text-l border-2 border-black 
                                shadow-custom-button hover:bg-[#FFECEC] hover:text-[#8B3A3A] cursor-pointer">
                                    <x-bladewind.icon name="users" class="justify-self-start" />
                                        VIEW SESSIONS
                                </div>
                            </li>
                        </ul>
        </div>

        <div :class="{ 'w-full': !isOpen, 'flex-1': isOpen } ">
                <section class="m-8">
                    <!-- Burger -->
                    <div class="burger" @click.prevent="isOpen = !isOpen">
                        <div class="tham tham-e-squeeze tham-w-6">
                            <div class="tham-box">
                                <div class="tham-inner"></div>
                            </div> 
                        </div>
                    </div>
                    <div class="text-5xl text-accent2 text-stroke-thick2 stroke-black font-black mb-5 m-8 "> 
                        @if(Auth::check())
                        @php
                            $user = Auth::user();                   
                            $firstName = '';                        
                                                                
                            if ($user -> role === 'Student' && $user->student) {
                                $firstName = $user->Student->fname;
                            }
                            else if ($user -> role === 'Tutor' && $user->tutor) {
                                $firstName = $user -> Tutor -> fname;
                            }
                        @endphp
                        Welcome, {{ $firstName ?: 'User' }}!       
                        @endif
                    </div>
                    <!-- container -->
                    <div class="w-full bg-accent rounded-lg shadow-custom-button shadow-black border-black border-2 "> 
                        <div class="flex items-center w-full border-b-2 border-black py-2">
                            <div class="flex w-full space-x-2 -mt-1 -mb-1 ml-4">
                                <span class="h-6 w-6 bg-accent2 border-2 border-black rounded-full"></span>
                                <span class="h-6 w-6 bg-[#ffb6c1] border-2 border-black rounded-full"></span>
                                <span class="h-6 w-6 bg-[#d3d3d3] border-2 border-black rounded-full"></span>
                            </div>
                            <div class="flex w-full justify-end text-2xl text-[#ffdd57] text-stroke font-black mr-8">DAILY PROGRESS</div>
                        </div>
                
                        <!-- div for grid -->
                        <div class="grid grid-cols-[1fr_3fr]">
                            <!-- left side column -->
                            <div class="flex flex-col space-y-4 border-r-2 border-black bg-accent2 rounded-bl-lg py-4">
                                <div class="font-poppins w-auto  text-lg text-center underline decoration-2 h-[50px] mt-4">
                                    CSIAS 313
                                </div>
                        
                                <div class="font-poppins  w-auto text-lg text-center underline decoration-2 h-[50px]">
                                    CSAC 313
                                </div>
                        
                                <div class="font-poppins  w-auto rounded-bl-lg text-lg text-center underline decoration-2 h-[50px]">
                                    CSAC 313
                                </div>
                            </div>
                            <!-- right side column -->
                            <div class="flex flex-col space-y-4 bg-white rounded-br-lg py-4">
                                <div class="flex items-center h-[50px] w-full">
                                    <x-bladewind.progress-bar percentage="80" color="red" show_percentage_label="true" class="w-full ml-2 mr-2"/>
                                </div>
                                
                                <div class="flex items-center w-full">
                                    <x-bladewind.progress-bar percentage="40" color="pink" show_percentage_label="true" class="w-full ml-2 mr-2"/>
                                </div>
                                
                                <div class="flex items-center w-full">
                                    <x-bladewind.progress-bar percentage="60" color="yellow" show_percentage_label="true" class="w-full ml-2 mr-2"/>
                                </div>
                                
                            </div>
                        </div>
                    </div>           
                </section>
                        <!-- div for grid -->
                        <div class="grid grid-cols-4 gap-8">
                            <!-- left side column -->
                            <div class="col-span-3 space-y-8">
                                <!-- calendar -->
                                <section class="m-8">
                                <!-- container -->
                                    <div class="bg-accent rounded-[20px] pt-2 pb-2 mb-4 shadow-custom-button shadow-black border-black border-2">
                                        <div class="flex bg-white -mt-2 items-center w-full border-b-2 border-black py-2 rounded-t-[20px]">
                                            <div class="flex w-full space-x-2 -mt-1 -mb-1 ml-4">
                                                <span class="h-6 w-6 bg-accent2 border-2 border-black rounded-full"></span>
                                                <span class="h-6 w-6 bg-[#ffb6c1] border-2 border-black rounded-full"></span>
                                                <span class="h-6 w-6 bg-[#d3d3d3] border-2 border-black rounded-full"></span>
                                            </div>
                                            <div class="flex w-full justify-end text-2xl text-accent2 text-stroke font-black mr-8">SCHEDULE</div>
                                        </div>  
                                                <!--Google Calendar JS-->
                                        <!-- calendar content -->
                                        @php
                                            //$nextMonth = Carbon::now()->addMonth();
                                            $today = \Carbon\Carbon::today();  
                                            $daysInMonth = $today->daysInMonth();
                                            $firstDayOfMonth = $today->copy()->startOfMonth()->dayOfWeek;
                                        @endphp

                                            <div class="p4">
                                                <div class="flex justify-evenly items-center">
                                                    <button type="button" id="prev-month" class="text-[#000000] font-bold max-w-[150px] rounded-full mt-2 "> 
                                                        <x-bladewind.icon name="arrow-left"/>
                                                    </button>
                                                    <div id="calendar-month" class="flex justify-center text-3xl text-black font-black my-2">{{ $today->format('F Y') }}</div>
                                                    <button type="button" id="next-month" class="text-[#000000] font-bold max-w-[150px] rounded-full mt-2 "> 
                                                        <x-bladewind.icon name="arrow-right"/>
                                                    </button>
                                                </div>

                                                <div class="grid items-center grid-cols-7 gap 2 h-[500px]"  id="daysContainer">
                                                    <!-- days of the week -->
                                                    <div class="text-center font-bold text-black">Sun</div>
                                                    <div class="text-center font-bold text-black">Mon</div>
                                                    <div class="text-center font-bold text-black">Tue</div>
                                                    <div class="text-center font-bold text-black">Wed</div>
                                                    <div class="text-center font-bold text-black">Thu</div>
                                                    <div class="text-center font-bold text-black">Fri</div>
                                                    <div class="text-center font-bold text-black">Sat</div>

                                                    <!-- emptyy days of the first week -->
                                                    @for ($i = 0; $i < $firstDayOfMonth; $i++)
                                                    <div class=""></div>
                                                    @endfor
                                                
                                                    <!-- days of the month -->
                                                    @for ($day = 1; $day <= $daysInMonth; $day++)
                                                    <div class="block h-full px-0.5 my-8 text-center rounded-full
                                                    @if ($day ==$today ->day) border-2 border-black bg-accent text-yellow-300
                                                    @else hover:bg-accent hover:text-yellow-300
                                                    @endif cursor-pointer" data-day="{{$day}}"  >
                                                    {{ $day }}
                                                    <div class="events-container"></div>
                                                    </div>
                                                @endfor
                                            </div>
                                        </div>    
                                    </div>
                                </section>


                            <!-- upcoming tasks -->
                            <section class="m-8">
                                <!-- container -->
                                <div class="bg-accent2 rounded-[20px] pt-2 pb-2 mb-4 shadow-custom-button shadow-black border-black border-2">
                                    <div class="flex bg-white -mt-2 items-center w-full border-b-2 border-black py-2 rounded-t-[20px]">
                                        <div class="flex w-full space-x-2 -mt-1 -mb-1 ml-4">
                                            <span class="h-6 w-6 bg-accent2 border-2 border-black rounded-full"></span>
                                            <span class="h-6 w-6 bg-[#ffb6c1] border-2 border-black rounded-full"></span>
                                            <span class="h-6 w-6 bg-[#d3d3d3] border-2 border-black rounded-full"></span>
                                        </div>
                                        <div class="flex w-full justify-end text-2xl text-accent text-stroke font-black mr-8">UPCOMING TASK</div>
                                    </div> 
                                    <!-- upcoming tasks, checkboxes -->
                                    <div class="bg-accent2 w-full p-2 space-y-3 rounded-[20px]">
                                        <form id="addTaskForm" class="flex flex-col space-y-4"method="POST" action="{{ route('tasks.store') }}">
                                            @csrf
                                            <input type="text" name="title" placeholder="To Do Task" class="py-3 px-4 bg-gray-100 rounded-xl">
                                                
                                            <button type="submit" class="w-28 py-4 px-8 bg-green-500 text-white rounded-xl ">Add</button>
                                        </form>

                                        <div id="taskList" class="space-y-3">
                                            @foreach ($todolists as $task)
                                                <div id="task-{{ $task->id }}" class="flex items-center justify-between">
                                                    <!-- <form method="POST" action="{{ route('tasks.update', $task) }}">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input  type="checkbox"  
                                                                onchange="this.form.submit()" 
                                                                class="peer mr-4" {{ $task->is_completed ? 'checked' : '' }}>
                                                        <label class="{{ $task->is_completed ? 'line-through text-red-900 ' : '' }}" >   {{ $task->title }}  </label> -->

                                                        <input type="checkbox" 
                                                            onchange="toggleTaskStatus({{ $task->id }}, this.checked)"
                                                            class="peer mr-4" 
                                                            {{ $task->is_completed ? 'checked' : '' }}>

                                                        <label class="{{ $task->is_completed ? 'line-through text-red-600' : '' }}">
                                                            {{ $task->title }}
                                                        </label>
                                                    <!-- </form>
                                                    <form method="POST" action="{{ route('tasks.delete', $task) }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        @if($task->is_completed) 
                                                            <button class="text-red-800">Delete</button>
                                                        @endif
                                                    </form>  -->
                                                     
                                                        <button onclick="deleteTask({{ $task->id }})" class="text-red-800">Delete</button>
                                                    
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    <hr class="border-1 border-black">

                                    <div class="mt-2">
                                        <div class="py-4 flex items-center px-3">
                                        
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                    
                            <!-- right side column -->
                            <div class="col-span-1 space-y-8">
                                
                                <!-- go to my profile -->
                                <section class="m-4 mt-8 max-w-xs">
                                    <!-- container -->
                                    <div class="bg-white rounded-[20px] pb-2 mb-4 shadow-custom-button shadow-black border-black border-2">
                                        <div class="border-black p-4"></div>
                                        <!-- content -->
                                        <div class="grid grid-cols-2 items-center px-4">
                                            <!-- profile image -->
                                            <div class="flex justify-center">
                                                <img src="{{ $user->profile_pic }}" alt="Profile" class="w-[150px] h-[150px] border-4 border-black rounded-lg">
                                            </div>    
                                            <!-- profile infos -->
                                            @php
                                                $user = Auth::user();                   
                                                $firstName = '';                        
                                                                                    
                                                if ($user -> role === 'Student' && $user->student) {
                                                    $user = $user->Student;
                                                }
                                                else if ($user -> role === 'Tutor' && $user->tutor) {
                                                    $user = $user -> Tutor;
                                                }
                                            @endphp
                                            <div>
                                                <p class="font-bold ml-5 text-primary text-[16px]">Firstname</p>
                                                <p class="font-bold ml-5 text-[18px] -mt-1">{{$user->fname}}</p>
                                                <p class="font-bold ml-5 text-primary text-[16px]">Lastname</p>
                                                <p class="font-bold ml-5 text-[18px] -mt-1">{{$user->lname}}</p>
                                                <p class="font-bold ml-5 text-primary text-[16px]">Role</p>
                                                @php
                                                    $user = Auth::user();
                                                @endphp
                                                <p class="font-bold ml-5 text-[18px] -mt-1">{{$user->role}}</p>
                                            </div>
                                        </div>
                                        <!-- go to my profile button -->
                                        <div class="flex justify-center mb-5 mt-4">
                                            <a href="#">
                                                <button class="bg-accent2 text-primary text-center font-poppins font-bold rounded-full px-8 py-1 h-11 text-l border-2 border-black shadow-custom-button hover:bg-[#FFECEC] hover:text-[#8B3A3A] flex items-center space-x-2">
                                                    <img src="https://picsum.photos/400" class="w-7 h-7">
                                                    <span>GO TO MY PROFILE</span>
                                                </button>
                                            </a>
                                        </div>                             
                                    </div>
                                </section>
                                
                                <!-- your buddy -->
                                <section class="m-4 mt-8 max-w-xs">
                                    <!-- container -->
                                    <div class="bg-accent rounded-[20px] pb-2 mb-4 shadow-custom-button shadow-black border-black border-2">
                                        <div class="bg-accent2 rounded-t-[20px] text-2xl text-accent text-stroke font-black p-3 border-b-2 border-black">
                                            YOUR BUDDY
                                        </div>
                                        <div class="border-black p-4"></div>
                                        <!-- content -->
                                        <div class="grid grid-cols-2 items-center px-4">
                                            <!-- profile image -->
                                            <div class="flex justify-center">
                                                <img src="https://picsum.photos/400" alt="Profile" class="w-[150px] h-[150px] border-4 border-black rounded-lg">
                                            </div>    
                                            <!-- profile infos -->
                                            <div>
                                                <p class="font-bold ml-5 text-primary text-[16px]">Firstname</p>
                                                <p class="font-bold ml-5 text-[18px] -mt-1">MARIA FIONA</p>
                                                <p class="font-bold ml-5 text-primary text-[16px]">Lastname</p>
                                                <p class="font-bold ml-5 text-[18px] -mt-1">DE LEON</p>
                                                <a href="#">
                                                    <button class="bg-accent2 text-primary text-center font-poppins font-bold rounded-full px-5 py-3 ml-2 h-10 text-[12px] border-2 border-black shadow-custom-button hover:bg-[#FFECEC] hover:text-[#8B3A3A] flex items-center space-x-2">
                                                        <span>VISIT PROFILE</span>
                                                    </button>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="border-black p-4"></div>
                                    </div>
                                </section>       
                                
                                
                                <!-- streak -->
                                <section class="m-4 max-w-xs">
                                    <!-- container -->
                                    <div class="bg-accent2 rounded-[20px] pt-2 pb-10 mb-4 shadow-custom-button shadow-black border-black border-2">
                                        <!-- streak content -->
                                        <div class="flex justify-center items-center p4">
                                            <!-- left side column -->
                                            <div>
                                                <p class="text-xl font-poppins font-bold text-black mr-6">You have<br> studied for:</p>
                                                <p class="text-3xl text-accent text-stroke-thick2 font-black">3 days </p>
                                            </div>
                                            
                                            <!-- right side column -->
                                            <div class=" relative w-24 h-24">
                                                <!-- progress bar na circle -->
                                                <div class="absolute inset-0 w-full h-full">
                                                    <x-bladewind.progress-circle 
                                                    percentage="75"
                                                    color="red"
                                                    size="medium"
                                                    text_size="0"
                                                    align="40"
                                                    valign="0"
                                                    circle_width="15"
                                                    show_label="false"
                                                    animate="false"
                                                    shade="dark"
                                                    class="w-full h-full rounded-full"
                                                    />
                                                </div>  
                                            </div>
                                        </div>    
                                    </div> 
                                </section>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>  
    </div>
</div>



<!-- For the Calendar -->
<script>
    document.addEventListener('DOMContentLoaded', () => {
                let currentDate = new Date();
                
                function createCalendar(date) {
                    const monthDays = document.querySelector('.grid-cols-7');
                    const month = date.getMonth();
                    const year = date.getFullYear();
                    const firstDay = new Date(year, month, 1).getDay();

                    const daysInMonth = new Date(year, month + 1, 0).getDate();

                    document.getElementById("calendar-month").innerText = 
                       new Intl.DateTimeFormat('en', { month: 'long', year: 'numeric' }).format(date);
                    
                    monthDays.innerHTML = '';
                    
                    const daysOfWeek = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
                    daysOfWeek.forEach(day => {
                        const dayElement = document.createElement('div');
                        dayElement.classList.add('text-center', 'font-bold', 'text-black');
                        dayElement.innerText = day;
                        monthDays.appendChild(dayElement);
                    });

                    // This creates a new div element for each day before the first day of the month
                    for (let i = 0; i < firstDay; i++) {
                        const blank= document.createElement('div');
                        monthDays.appendChild(blank);
                    }

                    for (let day = 1; day <= daysInMonth; day++) {
                        // This creates a new div element for each day in the month
                        const dayElement = document.createElement('div');
                        dayElement.classList.add('text-center', "px-0.5", "m-2", "rounded-full");
                        dayElement.innerText = day;

                        if (
                            day === new Date().getDate() &&
                            month === new Date().getMonth() &&
                            year === new Date().getFullYear()
                        ) {
                            dayElement.classList.add("border-2", "border-black", "bg-primary", "text-yellow-300", "cursor-pointer");
                        }else {
                            dayElement.classList.add("hover:bg-primary", "hover:text-yellow-300", "cursor-pointer");
                        }
                        
                        monthDays.appendChild(dayElement);
                    }
                }

                document.getElementById('prev-month').addEventListener('click', () => {
                    currentDate.setMonth(currentDate.getMonth() - 1);
                    createCalendar(currentDate);
                });

                document.getElementById('next-month').addEventListener('click', () => {
                    currentDate.setMonth(currentDate.getMonth() + 1);
                    createCalendar(currentDate);
                });

                createCalendar(currentDate);
            });
                </script>
                
    <script>  
    
    // Burger
    const tham = document.querySelector(".tham");
        
        tham.addEventListener('tham-active', () => {
        tham.classList.toggle('click');
        tham.style.setProperty('--animate-duration', '0.5s');
        });
    </script>

<script>
    
    $('#addTaskForm').on('submit', function(event) {
        event.preventDefault(); 

        $.ajax({
            url: '{{ route('tasks.store') }}',
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                console.log("Task added successfully!");
                
                $('#taskList').append(`
                    <div id="task-${response.task.id}" class="flex items-center justify-between">
                        <input type="checkbox" onchange="toggleTaskStatus(${response.task.id}, this.checked)"
                               class="peer mr-4">
                        <label>${response.task.title}</label>
                        <button onclick="deleteTask(${response.task.id})" class="text-red-800">Delete</button>
                    </div>
                `);

               
                $('#addTaskForm')[0].reset();
            },
            error: function(xhr) {
                console.error("Error adding task:", xhr.responseText);
            }
        });
    });

    
    function toggleTaskStatus(taskId, isChecked) {
        $.ajax({
            url: `/workspace/tasks/${taskId}`,
            method: 'PATCH',
            data: {
                _token: '{{ csrf_token() }}',
                is_completed: isChecked
            },
            success: function(response) {
                console.log("Task status updated successfully!");
                const taskLabel = $(`#task-${taskId} label`);
                if (isChecked) {
                    taskLabel.addClass('line-through text-red-600');
                } else {
                    taskLabel.removeClass('line-through');
                }
            },
            error: function(xhr) {
                console.error("Error updating task status:", xhr.responseText);
            }
        });
    }

   
    function deleteTask(taskId) {
        if (!confirm("Are you sure you want to delete this task?")) return;

        $.ajax({
            url: `/workspace/tasks/${taskId}`,
            method: 'DELETE',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                console.log("Task deleted successfully!");
                $(`#task-${taskId}`).remove();
            },
            error: function(xhr) {
                console.error("Error deleting task:", xhr.responseText);
            }
        });
    }
</script>
    
    
</body>
</html>