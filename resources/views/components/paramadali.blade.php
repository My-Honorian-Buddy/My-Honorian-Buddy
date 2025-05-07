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
    
</head>

<body class="font-poppins font-semibold bg-secondary">
    
<div class="flex-1">

    <!-- Sidebar --> 
    
    <div class="flex" x-data="{ isOpen: false }">
    <div class="w-96 min-h-screen p-8 space-y-6 border-r border-black" :class="{ 'w-96 animate__animated animate__fadeInLeft animate__faster': isOpen, 'hidden': !isOpen }">
            {{ $sidebars }}
        </div>
        
        {{-- Main Content --}}
        <div class="{ 'w-full': !isOpen, 'flex-1': isOpen } ">
            <div class="m-8">
                <!-- Burger -->
                <div  class="burger" @click.prevent="isOpen = !isOpen">
                        <div class="tham tham-e-squeeze tham-w-6">
                            <div class="tham-box mb-8">
                                <div class="tham-inner"></div>
                            </div>
                        </div>
                    </div>
                    {{ $maincontent }}
            </div>
        </div>  
    </div>
</div>

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

</body>
</html>               