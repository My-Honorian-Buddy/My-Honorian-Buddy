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
<header class="sticky top-0 z-50 bg-accent shadow-md backdrop-blur border-b-2 border-black relative">
    <div class="w-full">
        <div class="grid xl:grid-cols-[1fr_2fr] bg-accent">
            <div class="flex justify-center items-center w-2/5 lg:w-3/5 md:w-3/5 sm:w-3/5 sm:shrink-0 text-center ">
                <a href="{{ route('landing-page') }}">
                    <img src="{{ asset('images/logo.svg') }}" alt="logo" class="mx-auto w-2/3">
                </a>
            </div>

            <div class="p-6">
                <header class="md:flex md:justify-between md:items-center">
                    <div class="flex justify-center md:items-center font-black md:h-[75px] md:space-x-2 p-3">
                        <nav
                            class="font-dela md:space-x-9 sm:space-x-14 md:items-center text-charcoal text-base mr-8 ml-8">
                            <a href="{{ route('workspace.start') }}"
                                class="transition ease-in-out hover:text-primary hover:underline">WORKSPACE</a>

                            @if ($user->role === 'Student')
                                <a href="{{ route('match.explore') }}"
                                    class="transition ease-in-out hover:text-primary hover:underline">EXPLORE</a>
                            @else
                                <a href="{{ route('tutor.search') }}"
                                    class="transition ease-in-out hover:text-primary hover:underline">EXPLORE</a>
                            @endif

                            <a href="{{ route('about') }}"
                                class="transition ease-in-out hover:text-primary hover:underline">ABOUT US</a>
                        </nav>
                    </div>

                    <div class="flex justify-center items-center h-[75px] space-x-4 px-4 py-3">

                        <!--for notifications  -->
                        <x-bladewind.dropmenunotif class="w-[600px] z-40">

                            @php
                                $hasNotification = Auth::user()->hasNotification;
                                $unreadCount = \App\Models\notifSession::where('to', Auth::id())
                                    ->whereNull('read_at')
                                    ->count();
                            @endphp

                            <x-slot name="trigger">
                                <div class="relative">
                                    <x-bladewind.bell id="bell" size="small" color="red"
                                        class="p-3 h-10 w-10 md:!h-12 md:!w-12 text-white bg-primary transition ease-in-out hover:bg-hover border-2 border-charcoal rounded-full flex items-center justify-center cursor-pointer"
                                        show_dot="false"
                                        animate_dot="false" />
                                    
                                    <!-- Red notification badge with counter -->
                                    @if($hasNotification)
                                    <span id="notification-badge" 
                                        class="absolute -top-1 -right-1 bg-red-600 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center border-2 border-white">
                                        {{ $unreadCount > 9 ? '9+' : $unreadCount }}
                                    </span>
                                    @endif
                                </div>
                            </x-slot>


                            <div class= "flex justify-between">
                                <x-bladewind.dropmenunotif-item header="true"
                                    class="flex justify-between items-center">
                                    <div class="text-accent">
                                        Notification
                                    </div>


                                </x-bladewind.dropmenunotif-item>
                            </div>
                            <div class="flex flex-col justify-between items-end text-base px-4 py-2">
                                <button id="edit-button"
                                    class="bg-accent rounded-sm text-primary border border-primary px-3 
                            py-1 hover:bg-primary transition ease-in-out hover:text-accent">
                                    Edit
                                </button>
                                <div id="bulk-actions" class="hidden pt-2 space-x-2">
                                    <button id="mark-all-read"
                                        class="bg-accent text-primary border border-charcoal px-3 py-1 
                            rounded-sm transition hover:bg-primary hover:text-accent"
                                        onclick="markAllAsRead()">
                                        Mark All as Read
                                    </button>
                                    <button id="delete-all"
                                        class="bg-primary text-accent border border-black px-3 py-1 rounded-sm 
                                        hover:bg-red-700 transition"
                                        onclick="deleteAllNotifications()">
                                        Delete All
                                    </button>
                                </div>
                            </div>

                            <ul class="bladewind-dropmenunotif overflow-auto max-h-96" style="scrollbar-width: none;"
                                onclick="markAsRead()">
                                {{-- Notifications will be dynamically inserted here by the script --}}
                            </ul>

                        </x-bladewind.dropmenunotif>

                        <a href="{{ route(config('chatify.routes.prefix')) }}" class="text-center">
                            <div
                                class="p-3 h-10 w-10 md:!h-12 md:!w-12 text-accent bg-primary transition ease-in-out hover:bg-hover border-2 border-charcoal rounded-full flex items-center justify-center">
                                <x-bladewind.icon name="chat-bubble-left" class="!h-6 !w-6 md:!h-7 md:!w-7" />
                            </div>
                        </a>

                        <div class="p-1 rounded-full text-xl">

                            <x-bladewind.dropmenu trigger="user-icon"
                                trigger_css="p-3 !h-10 !w-10 md:!h-12 md:!w-12 hover:bg-hover bg-primary !text-accent border-2 border-charcoal rounded-full transition ease-in-out">

                                <form method="GET" action="{{ route('tutor.profile') }}">
                                    @csrf
                                    <x-bladewind.dropmenu-item padded="true" :href="route('logout')"
                                        onclick="event.preventDefault();
                                this.closest('form').submit();">
                                        Profile
                                    </x-bladewind.dropmenu-item>
                                </form>

                                <form method="GET" action="{{ route('contact') }}">
                                    @csrf
                                    <x-bladewind.dropmenu-item padded="true" :href="route('contact-us')"
                                        onclick="event.preventDefault();
                                    this.closest('form').submit();">
                                        Contact Us
                                    </x-bladewind.dropmenu-item>
                                </form>

                                <form method="POST" action="{{ route('role.switch') }}">
                                    @csrf
                                    <input type="hidden" name="mode"
                                        value="{{ strtolower($user->role === 'Student' ? 'tutor' : 'student') }}">
                                    <x-bladewind.dropmenu-item padded="true" :href="route('logout')"
                                        onclick="event.preventDefault();
                                    this.closest('form').submit();">
                                        Switch to
                                        @if ($user->role === 'Student')
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
                                this.closest('form').submit();">
                                        Log Out
                                    </x-bladewind.dropmenu-item>
                                </form>
                            </x-bladewind.dropmenu>
                        </div>
                    </div>
                </header>
            </div>
        </div>
        <div class="absolute inset-x-0 bottom-0 h-1 bg-black/5">
            <div id="scroll-progress" class="h-full bg-primary w-0"></div>
        </div>
    </div>
</header>

@livewireScripts


<script>
 
    const editButton = document.getElementById('edit-button');
    const bulkActions = document.getElementById('bulk-actions');
    const bell = document.getElementById("bell");

    // Function to update notification badge
    function updateNotificationBadge(count) {
        let badge = document.getElementById('notification-badge');
        
        if (count > 0) {
            if (!badge) {
                // Create badge if it doesn't exist
                const bellContainer = bell.closest('.relative');
                badge = document.createElement('span');
                badge.id = 'notification-badge';
                badge.className = 'absolute -top-1 -right-1 bg-red-600 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center border-2 border-white';
                bellContainer.appendChild(badge);
            }
            badge.textContent = count > 9 ? '9+' : count;
            badge.classList.remove('hidden');
        } else {
            if (badge) {
                badge.classList.add('hidden');
            }
        }
    }

    bell.addEventListener('click', () => {
        // Don't modify show_dot or animate_dot anymore since we're using badge
        // bell.setAttribute("show_dot", "false");
        // bell.setAttribute("animate_dot", "false");
    });


    editButton.addEventListener('click', () => {
        const actions = document.querySelectorAll('.notification-actions');
        bulkActions.classList.toggle('hidden');
        actions.forEach(action => action.classList.toggle('hidden'));
    });


    // Make loadNotifications globally accessible for echo.js
    function loadNotifications() {
        console.log('[loadNotifications] Starting to load notifications...');
        const notifContainer = document.querySelector('.bladewind-dropmenunotif');
        
        if (!notifContainer) {
            console.error('[loadNotifications] Notification container not found!');
            return;
        }

        console.log('[loadNotifications] Container found:', notifContainer);

        notifContainer.innerHTML = `
            <li class="px-4 py-2 text-gray-500">Loading notifications...</li>
        `;

        const url = '{{ route('user.notifications') }}';
        console.log('[loadNotifications] Fetching from URL:', url);
        
        fetch(url)
            .then(response => {
                console.log('[loadNotifications] Response status:', response.status);
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                console.log('[loadNotifications] Data received:', data);
                const {
                    notifications,
                    hasUnreadNotification
                } = data;
                const bell = document.getElementById("bell");

                notifContainer.innerHTML = '';

                console.log('[loadNotifications] Number of notifications:', notifications.length);

                // Count unread notifications
                const unreadCount = notifications.filter(n => n.read_at === null).length;
                console.log('[loadNotifications] Unread count:', unreadCount);
                
                // Update the notification badge with count
                updateNotificationBadge(unreadCount);

                if (notifications.length === 0) {
                    console.log("[loadNotifications] No new notifications.");
                    notifContainer.innerHTML = `
                        <li class="px-4 py-2 text-gray-500">No new notifications.</li>
                    `;
                } else {
                    console.log("[loadNotifications] Processing", notifications.length, "notifications:", notifications);
                    notifications.forEach(notification => {
                        const info = JSON.parse(notification.notif_info);
                        const bgClass = notification['read_at'] === null ? 'bg-[#FFFCEF]' : 'bg-secondary';
                        const fontClass = notification['read_at'] === null ? 'font-black' : 'font-semibold';
                        const dateColor = notification['read_at'] === null ? 'text-primary' :
                            'text-gray-400';
                        const hoverClass = 'hover:bg-accent3';

                        console.log(notification['read_at'] === null)
                        // Remove these lines since we're using badge now
                        // bell.setAttribute("show_dot", "true");
                        // bell.setAttribute("animate_dot", "true");

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
                        } else if (info['NotifType'] === "Tutor Request Accepted" || info['NotifType'] ===
                            "Tutor Request Rejected") {
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
                        } else if (info['NotifType'] === "AddNumSession") {
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
                                                id="agree-btn-${notification.id}"
                                                class="bg-accent2 text-primary px-3 py-1 rounded-md border-2 border-black transition active:scale-95 hover:scale-[1.1]"  
                                                onclick="this.disabled=true; document.getElementById('reject-btn-${notification.id}').disabled=true; handleConfirmation(${notification.id}, true)">
                                                Agree
                                            </button>
                                            <button 
                                                id="reject-btn-${notification.id}"
                                                class="bg-primary text-accent2 hover:bg-red-900 px-3 py-1 rounded-md border-2 border-black transition active:scale-95 hover:scale-[1.1]"
                                                onclick="this.disabled=true; document.getElementById('agree-btn-${notification.id}').disabled=true; handleConfirmation(${notification.id}, false)">
                                                Reject
                                            </button>
                                        </div>
                                </li>
                            `;
                        } else if (info['NotifType'] === "SessionDisagreed") {
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
                        } else if (info['NotifType'] === "SessionUpdated") {
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
                        } else if (info['NotifType'] === "SessionDidNotUpdate") {
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
                        } else if (info['NotifType'] === "SessionDropRequested") {
                            const requesterRole = info['requester_role'] || 'Student';
                            const requesterName = info['requester_name'] || 'Someone';
                            
                            notifContainer.innerHTML += `
                                <li class="${bgClass} ${hoverClass} text-base px-4 py-2 border-b border-black transition-colors duration-200 cursor-pointer"
                                onclick="markRead(${notification.id})">
                                    <div class="flex justify-between">
                                        <div class="${fontClass}">
                                            <p class="font-semibold">📩 Session Drop Request</p>
                                            <p class="text-sm text-gray-500">${requesterName} (${requesterRole}) requested to drop the tutoring session</p>
                                            <p class="${dateColor} text-xs mt-1">${new Date(notification.created_at).toLocaleString()}</p>
                                        </div>
                                    </div>
                                    <div class="flex space-x-2 mt-3">
                                        <form action="{{ route('drop.session') }}" method="post" class="inline">
                                            @csrf
                                            <input type="hidden" name="session_id" value="${info['booked_session_id']}">
                                            <input type="hidden" name="notification_id" value="${notification.id}">
                                            <input type="hidden" name="accept" value="true">
                                            <button 
                                                type="submit"
                                                class="bg-green-600 text-white px-4 py-2 rounded-md border-2 border-black transition active:scale-95 hover:bg-green-700 hover:scale-[1.05]">
                                                ✓ Accept & Drop Session
                                            </button>
                                        </form>
                                        <form action="{{ route('drop.session') }}" method="post" class="inline">
                                            @csrf
                                            <input type="hidden" name="session_id" value="${info['booked_session_id']}">
                                            <input type="hidden" name="notification_id" value="${notification.id}">
                                            <input type="hidden" name="accept" value="false">
                                            <button 
                                                type="submit"
                                                class="bg-red-600 text-white px-4 py-2 rounded-md border-2 border-black transition active:scale-95 hover:bg-red-700 hover:scale-[1.05]">
                                                ✗ Deny Request
                                            </button>
                                        </form>
                                    </div>
                                </li>
                            `;
                        } else if (info['NotifType'] === "SessionDropped") {
                            const droppedBy = info['dropped_by'] || 'the other party';
                            
                            notifContainer.innerHTML += `
                                <li class="${bgClass} ${hoverClass} text-base px-4 py-2 border-b border-black transition-colors duration-200 cursor-pointer"
                                onclick="markRead(${notification.id})">
                                    <div class="flex justify-between">
                                        <div class="${fontClass}">
                                            <p class="font-semibold">✅ Session Dropped</p>
                                            <p class="text-sm text-gray-500">The tutoring session has been dropped by ${droppedBy}</p>
                                            <p class="${dateColor} text-xs mt-1">${new Date(notification.created_at).toLocaleString()}</p>
                                        </div>
                                        <div class="flex space-x-2">
                                            <div class="notification-actions self-center space-x-2">
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
                        } else if (info['NotifType'] === "SessionDropRequestDenied") {
                            const deniedBy = info['denied_by'] || 'the other party';
                            
                            notifContainer.innerHTML += `
                                <li class="${bgClass} ${hoverClass} text-base px-4 py-2 border-b border-black transition-colors duration-200 cursor-pointer"
                                onclick="markRead(${notification.id})">
                                    <div class="flex justify-between">
                                        <div class="${fontClass}">
                                            <p class="font-semibold">❌ Drop Request Denied</p>
                                            <p class="text-sm text-gray-500">Your request to drop the session was denied by ${deniedBy}</p>
                                            <p class="text-xs text-gray-500">The tutoring session continues as scheduled</p>
                                            <p class="${dateColor} text-xs mt-1">${new Date(notification.created_at).toLocaleString()}</p>
                                        </div>
                                        <div class="flex space-x-2">
                                            <div class="notification-actions self-center space-x-2">
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
                        } else if (info['NotifType'] === "SessionCompletionRequest") {
                            notifContainer.innerHTML += `
                                <li class="${bgClass} ${hoverClass} text-base px-4 py-2 border-b border-black transition-colors duration-200 cursor-pointer"
                                onclick="markRead(${notification.id})">
                                    <div class="flex justify-between">
                                        <div class="${fontClass}">
                                            <p class="font-semibold">✅ Session Completion Request</p>
                                            <p class="text-sm text-gray-500">${info['message'] || 'Your tutor has marked this session as complete.'}</p>
                                            <p class="text-sm text-gray-500">Session: ${info['num_session']} of ${info['total_session']}</p>
                                            <p class="${dateColor} text-xs mt-1">${new Date(notification.created_at).toLocaleString()}</p>
                                        </div>
                                    </div>
                                    <div class="flex space-x-2 mt-2">
                                        <button 
                                            id="completion-agree-btn-${notification.id}"
                                            class="bg-green-600 text-white px-3 py-1 rounded-md border-2 border-black transition active:scale-95 hover:scale-[1.1]"  
                                            onclick="this.disabled=true; document.getElementById('completion-disagree-btn-${notification.id}').disabled=true; handleSessionCompletionResponse(${notification.id}, true)">
                                            Agree
                                        </button>
                                        <button 
                                            id="completion-disagree-btn-${notification.id}"
                                            class="bg-red-600 text-white hover:bg-red-700 px-3 py-1 rounded-md border-2 border-black transition active:scale-95 hover:scale-[1.1]"
                                            onclick="this.disabled=true; document.getElementById('completion-agree-btn-${notification.id}').disabled=true; handleSessionCompletionResponse(${notification.id}, false)">
                                            Disagree
                                        </button>
                                    </div>
                                </li>
                            `;
                        } else if (info['NotifType'] === "SessionCompletionDenied") {
                            notifContainer.innerHTML += `
                                <li class="${bgClass} ${hoverClass} text-base px-4 py-2 border-b border-black transition-colors duration-200 cursor-pointer"
                                onclick="markRead(${notification.id})">
                                    <div class="flex justify-between">
                                        <div class="${fontClass}">
                                            <p class="font-semibold">❌ Completion Request Denied</p>
                                            <p class="text-sm text-gray-500">${info['message'] || 'The student has disagreed with the session completion.'}</p>
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
                        } else if (info['NotifType'] === "BanRequest") {
                            notifContainer.innerHTML += `
                                <li class="${bgClass} ${hoverClass} text-base px-4 py-2 border-b border-black transition-colors duration-200 cursor-pointer"
                                onclick="markRead(${notification.id})">
                                    <div class="flex justify-between">
                                        <div class="${fontClass}">
                                            <p class="font-semibold">⚠️ Session Ban Request</p>
                                            <p class="text-sm text-gray-500">${info['message'] || 'Admin has requested to ban your session.'}</p>
                                            <p class="text-sm text-red-600 font-medium mt-1">Reason: ${info['ban_reason'] || 'No reason provided'}</p>
                                            <p class="${dateColor} text-xs mt-1">${new Date(notification.created_at).toLocaleString()}</p>
                                        </div>
                                    </div>
                                    <div class="flex space-x-2 mt-2">
                                        <button 
                                            class="bg-yellow-600 text-white px-3 py-1 rounded-md border-2 border-black transition active:scale-95 hover:scale-[1.1]"
                                            onclick="openReportModal(${info['session_id']}, ${notification.id})">
                                            Submit Report
                                        </button>
                                    </div>
                                </li>
                            `;
                        } else if (info['NotifType'] === "PointsUpdated") {
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
                console.error("[loadNotifications] ERROR:", error);
                console.error("[loadNotifications] Error details:", error.message, error.stack);
                notifContainer.innerHTML = `
                    <li class="px-4 py-2 text-red-500">Failed to load notifications. Error: ${error.message}</li>
                `;
            });
    }
    
    // Make loadNotifications globally accessible for echo.js
    window.fetchUserNotifications = loadNotifications;

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
            .catch(error => {
                console.error("Error deleting notification:", error);
            });
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
                body: JSON.stringify({
                    action
                }),
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
        console.log('🔔 handleConfirmation called', {notificationId, agree});
        
        fetch(`/notifications/session-confirm/${notificationId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
                body: JSON.stringify({
                    agree: agree
                }),
            })
            .then(response => {
                console.log('Response status:', response.status);
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                console.log('✅ Session confirmation response:', data);
                
                if (data.success) {
                    console.log('✅ Success:', data.message);
                    loadNotifications();
                    
                    // If session is completed, reload the page
                    if (data.reload === true) {
                        console.log('🔄 Session completed! Reloading page in 2 seconds...');
                        setTimeout(() => {
                            window.location.reload();
                        }, 2000);
                    }
                } else {
                    console.error('❌ Error:', data.message);
                    loadNotifications();
                }
            })
            .catch(error => {
                console.error('❌ Fetch error:', error);
            });
    }

    function handleSessionCompletionResponse(notificationId, agree) {
        console.log('🔔 handleSessionCompletionResponse called', {notificationId, agree});
        
        fetch(`/notifications/session-completion-confirm/${notificationId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
                body: JSON.stringify({
                    agree: agree
                }),
            })
            .then(response => {
                console.log('Response status:', response.status);
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                console.log('✅ Session completion response:', data);
                
                if (data.success) {
                    console.log('✅ Success:', data.message);
                    loadNotifications();
                    
                    // If session is completed, reload the page
                    if (data.reload === true) {
                        console.log('🔄 Session completed! Reloading page in 2 seconds...');
                        setTimeout(() => {
                            window.location.reload();
                        }, 2000);
                    }
                } else {
                    console.error('❌ Error:', data.message);
                    loadNotifications();
                }
            })
            .catch(error => {
                console.error('❌ Fetch error:', error);
            });
    }

    function openReportModal(sessionId, notificationId) {
        // Create modal HTML
        const modalHtml = `
            <div id="reportModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                <div class="bg-white dark:bg-gray-800 rounded-lg p-6 max-w-2xl w-full mx-4 max-h-[90vh] overflow-y-auto">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Submit Report</h2>
                        <button onclick="closeReportModal()" class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    
                    <form id="reportForm" onsubmit="submitReport(event, ${sessionId}, ${notificationId})" enctype="multipart/form-data">
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Explain why this session should not be banned:
                            </label>
                            <textarea 
                                id="reportText" 
                                name="report_text" 
                                rows="6" 
                                required
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white"
                                placeholder="Provide details about why this ban request is not valid..."
                            ></textarea>
                        </div>
                        
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Upload Evidence (Images):
                            </label>
                            <input 
                                type="file" 
                                id="reportImages" 
                                name="images[]" 
                                accept="image/*" 
                                multiple
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white"
                            >
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">You can upload multiple images as evidence</p>
                        </div>
                        
                        <div id="imagePreview" class="mb-4 grid grid-cols-3 gap-2"></div>
                        
                        <div class="flex justify-end space-x-2">
                            <button 
                                type="button" 
                                onclick="closeReportModal()"
                                class="px-4 py-2 bg-gray-300 dark:bg-gray-600 text-gray-800 dark:text-white rounded-md hover:bg-gray-400 dark:hover:bg-gray-500 transition"
                            >
                                Cancel
                            </button>
                            <button 
                                type="submit"
                                class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition"
                            >
                                Submit Report
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        `;
        
        // Add modal to body
        document.body.insertAdjacentHTML('beforeend', modalHtml);
        
        // Add image preview functionality
        document.getElementById('reportImages').addEventListener('change', function(e) {
            const preview = document.getElementById('imagePreview');
            preview.innerHTML = '';
            
            Array.from(e.target.files).forEach(file => {
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        preview.innerHTML += `
                            <div class="relative">
                                <img src="${e.target.result}" class="w-full h-24 object-cover rounded">
                            </div>
                        `;
                    };
                    reader.readAsDataURL(file);
                }
            });
        });
    }

    function closeReportModal() {
        const modal = document.getElementById('reportModal');
        if (modal) {
            modal.remove();
        }
    }

    function submitReport(event, sessionId, notificationId) {
        event.preventDefault();
        
        const formData = new FormData();
        formData.append('session_id', sessionId);
        formData.append('report_text', document.getElementById('reportText').value);
        
        const images = document.getElementById('reportImages').files;
        for (let i = 0; i < images.length; i++) {
            formData.append('images[]', images[i]);
        }
        
        fetch('/tutor/submit-ban-report', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                closeReportModal();
                loadNotifications();
                alert('Report submitted successfully!');
            } else {
                alert('Error submitting report: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error submitting report. Please try again.');
        });
    }


    document.addEventListener('DOMContentLoaded', loadNotifications, );
    
    
    setTimeout(() => {
        const currentUserId = document.querySelector('meta[name="user-id"]')?.content;
        
        if (currentUserId && typeof window.Echo !== 'undefined') {
            console.log('[Notification System] Setting up listener for user.' + currentUserId);
            
            window.Echo.private(`user.${currentUserId}`)
                .listen('NewNotification', (e) => {
                    console.log('[Notification System] New notification received, reloading notifications list');
                    loadNotifications();
                    
                    
                    const bell = document.getElementById("bell");
                    if (bell) {
                        bell.setAttribute("show_dot", "true");
                        bell.setAttribute("animate_dot", "true");
                    }
                })
                .error((error) => {
                    console.error('[Notification System] Error on user channel:', error);
                });
        } else {
            console.warn('[Notification System] Echo not available or no user ID found');
        }
    }, 500);
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        @if (session('success'))
            showNotification("{{ session('success') }}");
        @endif

        @if (session('cannotAccept'))
            showNotification('{{ session('cannotAccept') }}',
                'Please complete your current tutoring session before accepting a tutor request.', 'error');
        @endif

        @if (session('cannotReject'))
            showNotification('{{ session('cannotReject') }}',
                'Please complete your current tutoring session before rejecting a tutor request.', 'error');
        @endif
    });
</script>
