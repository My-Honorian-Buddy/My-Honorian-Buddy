<section class="mb-8 h-full">
    <!-- container -->
    <div class="bg-accent3 rounded-[20px] h-full pt-2 pb-2 overflow-hidden mb-4 shadow-custom-button shadow-black border-black border-2">
        <div class="flex bg-primary -mt-2 items-center w-full border-b-2 border-black py-2">
            <div class="flex w-full space-x-2 -mt-1 -mb-1 ml-4">
                <span class="h-6 w-6 bg-accent2 border-2 border-black rounded-full"></span>
                <span class="h-6 w-6 bg-secondary border-2 border-black rounded-full"></span>
                <span class="h-6 w-6 bg-accent3 border-2 border-black rounded-full"></span>
            </div>
            <div class="flex w-full justify-end text-2xl text-accent2 text-stroke font-black mr-8">SCHEDULE</div>
        </div>  
               

            <div class="p-4 pb-16">
                <div class="flex justify-evenly items-center w-full">
                    <button type="button" id="prev-month" class="text-[#000000] font-bold max-w-[150px] rounded-full  "> 
                        <x-bladewind.icon name="arrow-left"/>
                    </button>
                    <div id="calendar-month" class="flex justify-center w-[500px] text-3xl text-black font-black my-2"></div>
                    <button type="button" id="next-month" class="text-[#000000] font-bold max-w-[150px] rounded-full  "> 
                        <x-bladewind.icon name="arrow-right"/>
                    </button>
                </div>

                <div class="grid items-center grid-cols-7 gap 2 h-[500px] justify-items-center"  id="daysContainer">
                    <!-- days of the week -->
                    <div class="text-center font-bold text-black">Sun</div>
                    <div class="text-center font-bold text-black">Mon</div>
                    <div class="text-center font-bold text-black">Tue</div>
                    <div class="text-center font-bold text-black">Wed</div>
                    <div class="text-center font-bold text-black">Thu</div>
                    <div class="text-center font-bold text-black">Fri</div>
                    <div class="text-center font-bold text-black">Sat</div>
                </div>
            </div>
            

    </div>
</section>

{{-- script for calendar --}}
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
                        dayElement.classList.add('text-center', 'font-black', 'text-black', 'text-2xl', 'h-[40px]');
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
                        dayElement.classList.add('justify-center','text-primary','font-bold',"text-xl","flex", "items-center", "px-0.5", "m-2", "rounded-full");
                        dayElement.innerText = day;
                        
                        if (
                            day === new Date().getDate() &&
                            month === new Date().getMonth() &&
                            year === new Date().getFullYear()
                        ) {
                            dayElement.classList.add("border-2", "border-black", "bg-primary", "text-yellow-400", "cursor-pointer", "h-[75px]", "w-[75px]");
                        }else {
                            dayElement.classList.add("transition","ease-in-out","hover:bg-primary", "hover:text-accent2", "cursor-pointer", "h-[75px]", "w-[75px]");
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