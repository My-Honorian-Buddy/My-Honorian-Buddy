@php
use App\Models\bookedSession;
use App\Models\Review;
use App\Models\Student;
use App\Models\Tutor;
use App\Models\notifSession;

$all = notifSession::where('user_id', Auth::id())->get();

$test = bookedSession::where('student_id', Auth::id())->orWhere('tutor_id', Auth::id())->first();
$user = Auth::user();

@endphp
<div class="grid xl:grid-cols-[1fr_2fr] bg-secondary border-b border-black">
    <div class="flex justify-center items-center w-3/5 lg:w-3/5 md:w-3/5 sm:w-3/5 sm:shrink-0 text-center ">
        <a href="{{ route('landing-page') }}">
            <img src="{{ asset('images/logo.svg') }}" alt="logo" class="mx-auto w-2/3">
        </a>
    </div>

    <div class="p-8">
        <header class="md:flex md:justify-between md:items-center md:mb-5">
            
            <div class="flex justify-center md:items-center font-black bg-accent2 md:h-[75px] md:space-x-2 p-3 rounded-full border-2 border-black shadow-custom-button">
                <nav class="md:space-x-9 sm:space-x-14 md:items-center text-primary text-xl sm:text-primary md:text-primary font-bold mr-8 ml-8">  
                    <a href="{{ route('workspace.start') }}" class="transition ease-in-out hover:underline">WORKSPACE</a>

                    @if ($user -> role === 'Student')
                        <a href="{{ route('match.explore') }}" class="transition ease-in-out hover:underline">EXPLORE</a>
                    @else
                        <a href="{{ route('tutor.search') }}" class="transition ease-in-out hover:underline">EXPLORE</a>
                    @endif
                    
                    <a href="{{ route('about') }}" class="transition ease-in-out hover:underline">ABOUT US</a>
                </nav>
            </div>

            <div class="flex justify-center h-[75px] bg-accent2 space-x-4 px-4 py-3  rounded-full border-2 border-black shadow-custom-button">

                <div class="p-1 rounded-full text-xl z-40"> 
                <!--for notifications  -->
                    <x-bladewind.dropmenunotif 
                    class="w-[600px]"
                    >

                    @php
                        $hasNotification = Auth::user()->hasNotification;
                    @endphp
                    
                        <x-slot name="trigger">
                            <x-bladewind.bell
                                id="bell" 
                                size="big" 
                                color="purple" 
                                class="!h-8 !w-8 md:!h-10 md:!w-10 hover:text-white text-black" 
                                show_dot="{{ $hasNotification ? 'true' : 'false' }}" 
                                animate_dot="{{ $hasNotification ? 'true' : 'false' }}"
                            />
                        </x-slot>      
                    

                    <div class= "flex justify-between">
                        <x-bladewind.dropmenunotif-item header="true" class="flex justify-between items-center">                        
                            <div>
                                Notification
                            </div>
                            
                            
                        </x-bladewind.dropmenunotif-item>
                    </div>
                    <div class="flex flex-col justify-between items-end text-base px-4 py-2">
                            <button id="edit-button" class="bg-secondary rounded-lg text-primary border-2 border-black px-3 
                                py-1 hover:bg-primary transition ease-in-out hover:text-secondary">
                                Edit
                            </button>
                            <div id="bulk-actions" class="hidden pt-2 space-x-2">
                                <button id="mark-all-read" class="bg-accent2 text-primary border-2 border-black px-3 py-1 
                                rounded-md transition active:scale-95 hover:scale-[1.1]" onclick="markAllAsRead()">
                                    Mark All as Read
                                </button>
                                <button id="delete-all" class="bg-primary text-accent2 border-2 border-black px-3 py-1 rounded-md hover:bg-red-900
                                transition active:scale-95 hover:scale-[1.1]" onclick="deleteAllNotifications()">
                                    Delete All
                                </button>
                            </div>
                        </div>
                        
                        <ul class="bladewind-dropmenunotif overflow-auto max-h-96" style="scrollbar-width: none;" onclick="markAsRead()">
                            {{-- Notifications will be dynamically inserted here by the script --}}
                        </ul>                     
                    
                    </x-bladewind.dropmenunotif>
                </div>

                <a href="{{ route(config('chatify.routes.prefix')) }}">
                    <div class="p-1 rounded-full text-xl">
                        <x-bladewind.icon  name="chat-bubble-left" class="!h-8 !w-8 md:!h-10 md:!w-10 transition ease-in-out hover:text-white" />
                    </div>
                </a>
                
                    <div class="p-1 rounded-full text-xl"> 
                        
                        <x-bladewind.dropmenu trigger="user-circle-icon"
                        trigger_css="!h-8 !w-8 md:!h-10 md:!w-10 hover:text-white text-black">
                            
                            <form method="GET" action="{{ route('tutor.profile') }}">
                            @csrf
                            <x-bladewind.dropmenu-item padded="true" :href="route('logout')"
                                onclick="event.preventDefault();
                                this.closest('form').submit();" >
                                Profile
                            </x-bladewind.dropmenu-item>
                            </form>

                            <form method="GET" action="{{ route('contact') }}">
                                @csrf
                                <x-bladewind.dropmenu-item padded="true" :href="route('contact-us')"
                                    onclick="event.preventDefault();
                                    this.closest('form').submit();" >
                                    Contact Us
                                </x-bladewind.dropmenu-item>
                            </form>

                            <form method="POST" action="{{ route('role.switch') }}">
                                @csrf
                                <input type="hidden" name="mode" value="{{ strtolower($user->role === 'Student' ? 'tutor' : 'student')}}">
                                <x-bladewind.dropmenu-item padded="true" :href="route('logout')"
                                    onclick="event.preventDefault();
                                    this.closest('form').submit();" >
                                    Switch to 
                                    @if ($user -> role === 'Student')
                                        Tutor
                                    @else
                                        Student
                                    @endif
                                    
                                </x-bladewind.dropmenu-item>
                            </form>

                            <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-bladewind.dropmenu-item padded="true" :href="route('logout')"
                                onclick="event.preventDefault();
                                this.closest('form').submit();" >
                                Log Out
                            </x-bladewind.dropmenu-item>
                            </form>
                        </x-bladewind.dropmenu>
                    </div>
            </div>
        </header>
    </div>
</div>
@livewireScripts


<script>
    

    const editButton = document.getElementById('edit-button');
    const bulkActions = document.getElementById('bulk-actions');
    const bell = document.getElementById("bell");

    bell.addEventListener('click', () => {
        bell.setAttribute("show_dot", "false");
        bell.setAttribute("animate_dot", "false");
    });
    
    
    editButton.addEventListener('click', () => {
        const actions = document.querySelectorAll('.notification-actions');
        bulkActions.classList.toggle('hidden');
        actions.forEach(action => action.classList.toggle('hidden'));
    });

    

    //haiiiii

    
    // Function to load notifications
    function loadNotifications() {
        const notifContainer = document.querySelector('.bladewind-dropmenunotif'); // Adjust selector if necessary


        // Clear previous notifications
        notifContainer.innerHTML = `
            <li class=" px-4 py-2 text-gray-500">Loading notifications...</li>
        `;

        // Fetch notifications from the server
        fetch('{{ route('user.notifications') }}')
            .then(response => response.json())
            .then(data => {
                const { notifications, hasUnreadNotification } = data;
                const bell = document.getElementById("bell");

                notifContainer.innerHTML = ''; // Clear loading message
            
                
                if (notifications.length === 0) {
                    console.log("No new notifications.");
                    notifContainer.innerHTML = `
                        <li class=" px-4 py-2 text-gray-500">No new notifications.</li>
                    `;
                } else {
                    console.log("Loaded notifications:", notifications);
                    notifications.forEach(notification => {
                        const info = JSON.parse(notification.notif_info);
                        const bgClass = notification['read_at'] === null ? 'bg-[#FFFCEF]' : 'bg-secondary';
                        const fontClass = notification['read_at'] === null ? 'font-black' : 'font-semibold';
                        const dateColor = notification['read_at'] === null ? 'text-primary' : 'text-gray-400';
                        const hoverClass = 'hover:bg-accent3';

                        console.log(notification['read_at'] === null)
                        bell.setAttribute("show_dot", "true");
                        bell.setAttribute("animate_dot", "true");
                        
                        // Check if NotifType is "Tutor Request"
                        if (info['NotifType'] === "Tutor Request") {
                            notifContainer.innerHTML += `
                                <li class="${bgClass} ${hoverClass} text-base px-4 py-2 border-b border-black transition-colors duration-200 cursor-pointer">
                                    <div class="flex justify-between" onclick="markRead(${notification.id})">
                                        <div class="${fontClass}">
                                            <p>${info['NotifType'] || 'Notification'}</p>
                                            <p class="text-sm text-gray-500">from ${info['studentName'] || ''}</p>
                                            <p class="text-sm text-gray-500">Sub: ${info['subjects'] || ''}</p>
                                            <p class="text-sm text-gray-500">Date & Time: ${info['appointment_day'] + ' | ' + info['appointment_date'] + ' | ' + info['appointment_time'] || ''}</p>
                                            <p class="text-sm text-gray-500">Total Session: ${info['total_session'] || ''}</p>
                                            <p class="text-sm text-gray-500">Note: ${info['unique_message'] || ''}</p>
                                            <p class="${dateColor} text-xs mt-1">${new Date(notification.created_at).toLocaleString()}</p>
                                        </div>
                                        <div class="hidden notification-actions self-center space-x-2">
                                            <button 
                                                class="bg-accent2 text-primary px-3 py-1 rounded-md border-2 border-black transition active:scale-95 hover:scale-[1.1]"
                                                onclick="markAsRead(${notification.id})">
                                                ✔
                                            </button>
                                            <button 
                                                class="bg-primary text-accent2 hover:bg-red-900 px-3 py-1 rounded-md border-2 border-black transition active:scale-95 hover:scale-[1.1]"
                                                onclick="deleteNotification(${notification.id})">
                                                ✖
                                            </button>
                                        </div>
                                    </div> 
                                    
                                    <div class="flex space-x-2 mt-2">
                                        <!-- Accept Form -->
                                        <form action="/notifications/tutor-request/${notification.id}" method="POST" class="inline-block">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <input type="hidden" name="action" value="accept">
                                            <input type="hidden" id="previous_url" value="{{ url()->previous() }}">
                                            <button 
                                                type="submit" 
                                                class="bg-accent2 text-primary px-3 py-1 rounded-md border-2 border-black transition active:scale-95 hover:scale-[1.1]">
                                                Accept
                                            </button>
                                        </form>

                                        <!-- Reject Form -->
                                        <form action="/notifications/tutor-request/${notification.id}" method="POST" class="inline-block">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <input type="hidden" name="action" value="reject">
                                            <input type="hidden" id="previous_url" value="{{ url()->previous() }}">
                                            <button 
                                                type="submit" 
                                                class="bg-primary text-accent2 hover:bg-red-900 px-3 py-1 rounded-md border-2 border-black transition active:scale-95 hover:scale-[1.1]">
                                                Reject
                                            </button>
                                        </form>
                                    </div>
                                    
                                </li>
                            `;
                        } else if (info['NotifType'] === "Tutor Request Accepted" || info['NotifType'] === "Tutor Request Rejected") {
                            notifContainer.innerHTML += `
                                <li class="${bgClass} ${hoverClass} text-base px-4 py-2 border-b  border-black transition-colors duration-200 cursor-pointer" 
                                onclick="markRead(${notification.id})">
                                <div class="flex justify-between">
                                    <div class="${fontClass}">
                                        <p>${info['NotifType'] || 'Notification'}</p>
                                        <p class="text-sm text-gray-500">Your request to ${info['tutor_name'] || ''}</p>
                                        <p class="text-sm text-gray-500">for ${info['subjects'] || ''}</p>
                                        <p class="text-sm text-gray-500">for a total of ${info['total_session'] || ''} sessions</p>
                                        <p class="${dateColor} text-xs mt-1">${new Date(notification.created_at).toLocaleString()}</p>
                                    </div>    
                                    <div class="hidden notification-actions self-center space-x-2">
                                        <button 
                                            class="bg-accent2 text-primary px-3 py-1 rounded-md border-2 border-black transition active:scale-95 hover:scale-[1.1]"
                                            onclick="markAsRead(${notification.id})">
                                            ✔
                                        </button>
                                        <button 
                                            class="bg-primary text-accent2 hover:bg-red-900 px-3 py-1 rounded-md border-2 border-black transition active:scale-95 hover:scale-[1.1]"
                                            onclick="deleteNotification(${notification.id})">
                                            ✖
                                        </button>
                                    </div>
                                </div>
                                </li>
                            `;
                        } else if(info['NotifType'] === "AddNumSession") {
                            notifContainer.innerHTML += `
                                <li class="${bgClass} ${hoverClass} text-base px-4 py-2 border-b border-black transition-colors duration-200 cursor-pointer"
                                onclick="markRead(${notification.id})">
                                    <div class="flex justify-between">
                                        <div class="${fontClass}">
                                            <p>Session Confirmation</p>
                                            <p class="text-sm text-gray-500">Do you agree to confirm this session?</p>
                                            <p class="text-sm text-gray-500">Session: ${info['num_session'] + 1} of ${info['total_session']}</p>
                                            <p class="${dateColor} text-xs mt-1">${new Date(notification.created_at).toLocaleString()}</p>
                                        </div>
                                        <div class="hidden notification-actions self-center space-x-2">
                                            <button 
                                                class="bg-accent2 text-primary px-3 py-1 rounded-md border-2 border-black transition active:scale-95 hover:scale-[1.1]"
                                                onclick="markAsRead(${notification.id})">
                                                ✔
                                            </button>
                                            <button 
                                                class="bg-primary text-accent2 hover:bg-red-900 px-3 py-1 rounded-md border-2 border-black transition active:scale-95 hover:scale-[1.1]"
                                                onclick="deleteNotification(${notification.id})">
                                                ✖
                                            </button>
                                        </div>
                                    </div>
                                        <div class="flex space-x-2 mt-2">
                                            <button 
                                                class="bg-accent2 text-primary px-3 py-1 rounded-md border-2 border-black transition active:scale-95 hover:scale-[1.1]"  
                                                onclick="handleConfirmation(${notification.id}, true)">
                                                Agree
                                            </button>
                                            <button 
                                                class="bg-primary text-accent2 hover:bg-red-900 px-3 py-1 rounded-md border-2 border-black transition active:scale-95 hover:scale-[1.1]"
                                                onclick="handleConfirmation(${notification.id}, false)">
                                                Reject
                                            </button>
                                        </div>
                                </li>
                            `; 
                        }else if(info['NotifType'] === "SessionDisagreed") {
                            notifContainer.innerHTML += `
                                <li class="${bgClass} ${hoverClass} text-base px-4 py-2 border-b border-black transition-colors duration-200 cursor-pointer"
                                onclick="markRead(${notification.id})">
                                    <div class="flex justify-between">
                                        <div class="${fontClass}">
                                            <p>Session Disagreed</p>
                                            <p class="text-sm text-gray-500">${info['message'] || ''}</p>
                                            <p class="${dateColor} text-xs mt-1">${new Date(notification.created_at).toLocaleString()}</p>
                                        </div>
                                        <div class="hidden notification-actions self-center space-x-2">
                                            <button 
                                                class="bg-accent2 text-primary px-3 py-1 rounded-md border-2 border-black transition active:scale-95 hover:scale-[1.1]"
                                                onclick="markAsRead(${notification.id})">
                                                ✔
                                            </button>
                                            <button 
                                                class="bg-primary text-accent2 hover:bg-red-900 px-3 py-1 rounded-md border-2 border-black transition active:scale-95 hover:scale-[1.1]"
                                                onclick="deleteNotification(${notification.id})">
                                                ✖
                                            </button>
                                        </div>
                                    </div>
                                </li>
                            `;
                        }else if(info['NotifType'] === "SessionUpdated") {
                            notifContainer.innerHTML += `
                                <li class="${bgClass} ${hoverClass} text-base px-4 py-2 border-b border-black transition-colors duration-200 cursor-pointer"
                                onclick="markRead(${notification.id})">
                                    <div class="flex justify-between">
                                        <div class="${fontClass}">
                                            <p>Session updated</p>
                                            <p class="text-sm text-gray-500">${info['message'] || ''}</p>
                                            <p class="${dateColor} text-xs mt-1">${new Date(notification.created_at).toLocaleString()}</p>
                                            <p class="text-sm text-gray-500">Session: ${info['num_session']} of ${info['total_session']}</p>
                                        </div>
                                        <div class="hidden notification-actions self-center space-x-2">
                                            <button 
                                                class="bg-accent2 text-primary px-3 py-1 rounded-md border-2 border-black transition active:scale-95 hover:scale-[1.1]"
                                                onclick="markAsRead(${notification.id})">
                                                ✔
                                            </button>
                                            <button 
                                                class="bg-primary text-accent2 hover:bg-red-900 px-3 py-1 rounded-md border-2 border-black transition active:scale-95 hover:scale-[1.1]"
                                                onclick="deleteNotification(${notification.id})">
                                                ✖
                                            </button>
                                        </div>
                                    </div>
                                </li>
                            `;
                        }else if(info['NotifType'] === "SessionDidNotUpdate") {
                            notifContainer.innerHTML += `
                                <li class="${bgClass} ${hoverClass} text-base px-4 py-2 border-b border-black transition-colors duration-200 cursor-pointer"
                                onclick="markRead(${notification.id})">
                                    <div class="flex justify-between">
                                        <div class="${fontClass}">
                                            <p class="font-semibold">COR Verification Required</p>
                                            <p class="text-sm text-gray-500">${info['message']} ${info['schoolYear']}</p>
                                            <p class="${dateColor} text-xs mt-1">${new Date(notification.created_at).toLocaleString()}</p>
                                        </div>
                                        <div class="self-center">
                                            <a href="/cor-verification-${info['schoolYear']}" 
                                            class="bg-accent2 text-primary px-3 py-1 rounded-md border-2 border-black transition active:scale-95 hover:scale-[1.1]">
                                                Please Verify
                                            </a>
                                        </div>
                                        <div class="hidden notification-actions self-center space-x-2">
                                            <button 
                                                class="bg-accent2 text-primary px-3 py-1 rounded-md border-2 border-black transition active:scale-95 hover:scale-[1.1]"
                                                onclick="markAsRead(${notification.id})">
                                                ✔
                                            </button>
                                            <button 
                                                class="bg-primary text-accent2 hover:bg-red-900 px-3 py-1 rounded-md border-2 border-black transition active:scale-95 hover:scale-[1.1]"
                                                onclick="deleteNotification(${notification.id})">
                                                ✖
                                            </button>
                                        </div>
                                    </div>
                                </li>
                            `;
                        }else if(info['NotifType'] === "DropSession") {
                            notifContainer.innerHTML += `
                                <li class="${bgClass} ${hoverClass} text-base px-4 py-2 border-b border-black transition-colors duration-200 cursor-pointer"
                                onclick="markRead(${notification.id})">
                                    <div class="flex justify-between">
                                        <div class="${fontClass}">
                                            <p>Session Drop Request</p>
                                            <p class="text-sm text-gray-500">${info['studentName']} requested to drop your tutoring session</p>
                                            <p class="${dateColor} text-xs mt-1">${new Date(notification.created_at).toLocaleString()}</p>
                                        </div>
                                        <div class="flex space-x-2">
                                            <div class="hidden notification-actions self-center space-x-2">
                                                <button 
                                                    class="bg-accent2 text-primary px-3 py-1 rounded-md border-2 border-black transition active:scale-95 hover:scale-[1.1]"
                                                    onclick="markAsRead(${notification.id})">
                                                    ✔
                                                </button>
                                                <button 
                                                    class="bg-primary text-accent2 hover:bg-red-900 px-3 py-1 rounded-md border-2 border-black transition active:scale-95 hover:scale-[1.1]"
                                                    onclick="deleteNotification(${notification.id})">
                                                    ✖
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex space-x-2 mt-2">
                                        <form action="{{ route('drop.session') }}" method="post">
                                            @csrf
                                            <input type="hidden" name="session_id" value="${info['booked_session_id']}">
                                            <input type="hidden" name="notification_id" value="${notification.id}">
                                            <input type="hidden" name="accept" value="true">
                                            <button 
                                                type="submit"
                                                class="bg-accent2 text-primary px-3 py-1 rounded-md border-2 border-black transition active:scale-95 hover:scale-[1.1]">
                                                Accept
                                            </button>
                                        </form>
                                        <form action="{{ route('drop.session') }}" method="post">
                                            @csrf
                                            <input type="hidden" name="session_id" value="${info['booked_session_id']}">
                                            <input type="hidden" name="notification_id" value="${notification.id}">
                                            <input type="hidden" name="accept" value="false">
                                            <button 
                                                class="bg-primary text-accent2 hover:bg-red-900 px-3 py-1 rounded-md border-2 border-black transition active:scale-95 hover:scale-[1.1]"
                                                onclick="handleConfirmRequest(${notification.id} ,${info['booked_session_id']} , false)">
                                                Reject
                                            </button>
                                        </form>
                                    </div>
                                </li>
                            `;
                        }else if(info['NotifType'] === "SessionSuccessfullyDropped") {
                            notifContainer.innerHTML += `
                                <li class="${bgClass} ${hoverClass} text-base px-4 py-2 border-b border-black transition-colors duration-200 cursor-pointer"
                                onclick="markRead(${notification.id})">
                                    <div class="flex justify-between">
                                        <div class="${fontClass}">
                                            <p>Session Successfully Dropped</p>
                                            <p class="text-sm text-gray-500">${info['message'] || ''}</p>
                                            <p class="text-xs text-gray-500">for session #${info['tutorName']}</p>
                                            <p class="${dateColor} text-xs mt-1">${new Date(notification.created_at).toLocaleString()}</p>
                                        </div>
                                        <div class="flex space-x-2">
                                            <div class="hidden notification-actions self-center space-x-2">
                                                <button 
                                                    class="bg-accent2 text-primary px-3 py-1 rounded-md border-2 border-black transition active:scale-95 hover:scale-[1.1]"
                                                    onclick="markAsRead(${notification.id})">
                                                    ✔
                                                </button>
                                                <button 
                                                    class="bg-primary text-accent2 hover:bg-red-900 px-3 py-1 rounded-md border-2 border-black transition active:scale-95 hover:scale-[1.1]"
                                                    onclick="deleteNotification(${notification.id})">
                                                    ✖
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            `;
                        } else if(info['NotifType'] === "SessionDropRequestDenied") {
                            notifContainer.innerHTML += `
                                <li class="${bgClass} ${hoverClass} text-base px-4 py-2 border-b border-black transition-colors duration-200 cursor-pointer"
                                onclick="markRead(${notification.id})">
                                    <div class="flex justify-between">
                                        <div class="${fontClass}">
                                            <p>Request Denied</p>
                                            <p class="text-sm text-gray-500">${info['message'] || ''}</p>
                                            <p class="text-sm text-gray-500">Reach out to ${info['tutorName']} for more details</p>
                                            <p class="text-xs text-gray-500">for tutoring session #${info['booked_session_id']}</p>
                                            <p class="${dateColor} text-xs mt-1">${new Date(notification.created_at).toLocaleString()}</p>
                                        </div>
                                        <div class="flex space-x-2">
                                            <div class="hidden notification-actions self-center space-x-2">
                                                <button 
                                                    class="bg-accent2 text-primary px-3 py-1 rounded-md border-2 border-black transition active:scale-95 hover:scale-[1.1]"
                                                    onclick="markAsRead(${notification.id})">
                                                    ✔
                                                </button>
                                                <button 
                                                    class="bg-primary text-accent2 hover:bg-red-900 px-3 py-1 rounded-md border-2 border-black transition active:scale-95 hover:scale-[1.1]"
                                                    onclick="deleteNotification(${notification.id})">
                                                    ✖
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            `;
                        } else if(info['NotifType'] === "PointsUpdated") {
                                notifContainer.innerHTML += `
                                <li class="${bgClass} ${hoverClass} text-base px-4 py-2 border-b border-black transition-colors duration-200 cursor-pointer"
                                onclick="markRead(${notification.id})">
                                    <div class="flex justify-between">
                                        <div class="${fontClass}">
                                            <p>Session updated</p>
                                            <p class="text-sm text-gray-500">${info['message'] || ''}</p>
                                            <p class="${dateColor} text-xs mt-1">${new Date(notification.created_at).toLocaleString()}</p>
                                            <p class="text-sm text-gray-500">Session: ${info['num_session']} of ${info['total_session']}</p>
                                        </div>
                                        <div class="hidden notification-actions self-center space-x-2">
                                            <button 
                                                class="bg-accent2 text-primary px-3 py-1 rounded-md border-2 border-black transition active:scale-95 hover:scale-[1.1]"
                                                onclick="markAsRead(${notification.id})">
                                                ✔
                                            </button>
                                            <button 
                                                class="bg-primary text-accent2 hover:bg-red-900 px-3 py-1 rounded-md border-2 border-black transition active:scale-95 hover:scale-[1.1]"
                                                onclick="deleteNotification(${notification.id})">
                                                ✖
                                            </button>
                                        </div>
                                    </div>
                                </li>
                            `;
                        } else if (info['NotifType'] === "CorVerification") {
                                notifContainer.innerHTML += `
                                <li class="${bgClass} ${hoverClass} text-base px-4 py-2 border-b border-black transition-colors duration-200 cursor-pointer"
                                onclick="markRead(${notification.id})">
                                    <div class="flex justify-between">
                                        <div class="${fontClass}">
                                            <p>Cor Verification</p>
                                            <p class="text-sm text-gray-500">${info['message'] || ''}</p>
                                            <p class="${dateColor} text-xs mt-1">${new Date(notification.created_at).toLocaleString()}</p>
                                        </div>
                                        <div class="self-center">
                                            <a href="{{ route('cor.view') }}" 
                                            class="bg-accent2 text-primary px-3 py-1 rounded-md border-2 border-black transition active:scale-95 hover:scale-[1.1]">
                                                Please Verify
                                            </a>
                                        </div>
                                        <div class="hidden notification-actions self-center space-x-2">
                                            <button 
                                                class="bg-accent2 text-primary px-3 py-1 rounded-md border-2 border-black transition active:scale-95 hover:scale-[1.1]"
                                                onclick="markAsRead(${notification.id})">
                                                ✔
                                            </button>
                                            <button 
                                                class="bg-primary text-accent2 hover:bg-red-900 px-3 py-1 rounded-md border-2 border-black transition active:scale-95 hover:scale-[1.1]"
                                                onclick="deleteNotification(${notification.id})">
                                                ✖
                                            </button>
                                        </div>
                                    </div>
                                </li>
                            `;
                        }
                    });
                }
            })
            .catch(error => {
                console.error("Error loading notifications:", error);
                notifContainer.innerHTML = `
                    <li class="px-4 py-2 text-red-500">Failed to load notifications.</li>
                `;
            });
    }
    
    function markRead(notificationId) {
        fetch(`/notifications/${notificationId}/read`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                console.log("Notification marked as read:", notificationId);

                loadNotifications();
            }
            console.log(data.message);

        })
        .catch(error => {
            console.error("Error marking notification as read:", error);
        });
    }

    function markAsRead(notificationId) {
        fetch(`/notifications/${notificationId}/read`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                console.log("Notification marked as read:", notificationId);

                loadNotifications();
                const actions = document.querySelectorAll('.notification-actions');
                bulkActions.classList.toggle('hidden');
                actions.forEach(action => action.classList.toggle('hidden'));
            }
            console.log(data.message);

        })
        .catch(error => {
            console.error("Error marking notification as read:", error);
        });
    }

    function deleteNotification(notificationId) {
        fetch(`/notifications/${notificationId}/delete`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                console.log("Notification deleted:", notificationId);
                loadNotifications();
                const actions = document.querySelectorAll('.notification-actions');
                bulkActions.classList.toggle('hidden');
                actions.forEach(action => action.classList.toggle('hidden'));
            }
            console.log(data.message);
        })
        console.log(response.json());
    }

    function markAllAsRead() {
        fetch('/notifications/mark-all-as-read', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            console.log(data.message);
            loadNotifications();
            const actions = document.querySelectorAll('.notification-actions');
            bulkActions.classList.toggle('hidden');
            actions.forEach(action => action.classList.toggle('hidden'));
        })
        .catch(error => {
            console.error("Error marking all notifications as read:", error);
        });
    }

    function deleteAllNotifications() {
        fetch('/notifications/delete-all', {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            console.log(data.message);
            loadNotifications();
            const actions = document.querySelectorAll('.notification-actions');
            bulkActions.classList.toggle('hidden');
            actions.forEach(action => action.classList.toggle('hidden'));
        })
        .catch(error => {
            console.error("Error deleting all notifications:", error);
        });
    }


    // Function to handle Tutor Request actions
    function handleTutorRequest(notificationId, action) {
        // Validate the action
        if (action !== 'accept' && action !== 'reject') {
            console.error('Invalid action provided:', action);
            return;
        }

        fetch(`/notifications/tutor-request/${notificationId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
            body: JSON.stringify({ action }),
        })
            .then((response) => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
            })
            .then((data) => {
                if (data.success) {
                    console.log(`Tutor request ${action}ed successfully:`, data);
                    showNotification(`Tutor request ${action}ed successfully.`); // Notify the user
                    loadNotifications(); // Refresh the notification list
                } else {
                    console.error(`Failed to process tutor request: ${data.message}`);
                    showNotification(`Failed to ${action} the tutor request. Please try again.`);
                }
            })
            .catch((error) => {
                console.error(`Error handling tutor request:`, error);
                alert('An error occurred while processing the tutor request. Please try again.');
            });
    }

    function handleConfirmation(notificationId, agree) {
        fetch(`/notifications/session-confirm/${notificationId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            },
            body: JSON.stringify({ agree: agree }),
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification(data.message);
                loadNotifications();
            } else {
                showNotification('Session Update Failed', data.message, 'error');
                loadNotifications();
            }
            loadNotifications();
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }


    // Load notifications when the page loads
    document.addEventListener('DOMContentLoaded', loadNotifications, );
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>

    document.addEventListener('DOMContentLoaded', function () {
        @if (session('success'))
            showNotification("{{ session('success') }}");
        @endif

        @if (session('cannotAccept'))
            showNotification('{{ session('cannotAccept')}}', 'Please complete your current tutoring session before accepting a tutor request.', 'error');
        @endif

        @if (session('cannotReject'))
            showNotification('{{ session('cannotReject')}}', 'Please complete your current tutoring session before rejecting a tutor request.', 'error');
        @endif
    });

</script>
