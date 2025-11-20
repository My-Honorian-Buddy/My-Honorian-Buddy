<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.css' rel='stylesheet' />

    <style>
        .fc-button {
            background-color: #550000 !important;
            border-color: #550000 !important;
            color: #FDFBFB !important;
            font-weight: bold !important;
        }

        .fc-button:hover {
            background-color: rgb(85 0 0 / 0.8) !important;
            border-color: black !important;
            color: #FDFBFB !important;
            font-weight: bold !important;
        }

        .fc-col-header-cell {
            background-color: #FDFBFB !important;
            color: #550000 !important;
            font-weight: bold !important;
            border-color: black !important;
            border-width: 1px !important;
        }

        .fc-day-today {
            background-color: #550000 !important;
            color: #FDFBFB !important;
        }

        .fc-day-today:hover {
            background-color: #55000010 !important;
            color: #550000 !important;
            border: 2px solid #550000 !important;
            transition: all 0.2s ease-in-out;
        }

        .fc-daygrid-day.fc-day-today.has-events {
            background-color: #55000010 !important;
            border: 2px solid #550000 !important;
        }

        .fc-daygrid-day.has-events {
            background-color: #55000010 !important;
            border: 2px solid #550000 !important;
        }

        .fc-daygrid-event {
            border-radius: 2px !important;
            padding: 2px 4px !important;
            margin: 1px 2px !important;
            
        }

        .fc-toolbar-title {
            color: #550000 !important;
            font-weight: bold !important;
            font-size: 2rem !important;
        }

        /* Modal Styles */
        .event-modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(4px);
            animation: fadeIn 0.3s ease;
        }

        .event-modal-content {
            position: relative;
            background-color: #FDFBFB;
            margin: 8% auto;
            padding: 0;
            border: 2px solid #1A1A1A;
            border-radius: 6px;
            width: 95%;
            max-width: 700px;
            max-height: 80vh;
            display: flex;
            flex-direction: column;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
            animation: slideDown 0.3s ease;
            overflow: hidden;
        }

        .modal-header {
            background-color: #FDFBFB;
            color: #1A1A1A;
            font-family: 'Dela Gothic One', sans-serif !important;
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-shrink: 0;
        }

        .modal-header h2 {
            margin: 0;
            font-size: 1.5rem;
            font-weight: bold;
        }

        .modal-body {
            padding: 25px 30px;
            color: #1A1A1A;
            overflow-y: auto;
            flex: 1;
            max-height: calc(80vh - 160px);
        }

        .modal-footer {
            padding: 15px 25px;
            text-align: right;
            flex-shrink: 0;
            background-color: #FDFBFB;
            border-radius: 0 0 9px 9px;
        }

        .close-btn {
            color: #1A1A1A;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
            background: none;
            border: none;
            padding: 0;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            transition: all 0.2s;
        }

        .close-btn:hover {
            background-color: #550000;
            color: #FDFBFB;
        }

        .session-badge {
            display: inline-block;
            background-color: #10b981;
            color: #FDFBFB;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: bold;
            margin-bottom: 15px;
        }

        .manual-badge {
            display: inline-block;
            background-color: #FDFBFB;
            color: #550000;
            padding: 4px 12px;
            border-radius: 20px;
            border-color: #550000;
            font-size: 0.85rem;
            font-weight: bold;
            margin-bottom: 15px;
        }

        .info-row {
            margin-bottom: 12px;
            display: flex;
            align-items: flex-start;
        }

        .info-icon {
            margin-right: 10px;
            font-size: 1.2rem;
        }

        .info-label {
            font-weight: bold;
            margin-right: 8px;
        }

        .warning-box {
            background-color: #FEF3C7;
            border-left: 4px solid #F59E0B;
            padding: 12px;
            margin-top: 15px;
            border-radius: 4px;
            font-size: 0.9rem;
        }

        .fc-event-main {
            color: #550000 !important;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes slideDown {
            from {
                transform: translateY(-50px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            font-weight: bold;
            margin-bottom: 8px;
            color: #1A1A1A;
        }

        .form-input {
            width: 100%;
            padding: 10px 12px;
            border: 2px solid #1A1A1A;
            border-radius: 2px;
            font-size: 1rem;
            background-color: #FDFBFB;
            color: #1A1A1A;
            transition: all 0.2s;
        }

        .form-input:focus {
            outline: none;
            border-color: #550000;
            box-shadow: 0 0 0 3px rgba(255, 217, 92, 0.3);
        }

        .btn {
            padding: 10px 20px;
            border: 2px solid #1A1A1A;
            border-radius: 2px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.2s;
            font-size: 1rem;
        }

        .btn-primary {
            background-color: #550000;
            color: #FDFBFB;
        }

        .btn-primary:hover {
            background-color: #6E0000;
            color: #FDFBFB;
        }

        .btn-secondary {
            background-color: #FDFBFB;
            color: #550000;
        }

        .btn-secondary:hover {
            background-color: #55000005;
        }

        .fc-view-harness {
            border-width: 1px !important;
            border-color: black !important;
            border-radius: 8px !important;
            overflow: hidden !important;
        }

        .fc-daygrid-day {
            border-width: 1px !important;
            border-color: black !important;
        }

        .fc-daygrid-day-number {
            font-weight: bold !important;
            font-size: 20px !important;
        }
        .fc-toolbar-title {
            color: #1A1A1A !important;
            font-family: 'Dela Gothic One', sans-serif !important;
        }

        /* Fix calendar container */
        #calendar {
            width: 100%;
            height: auto;
            clear: both;
        }

        .fc {
            width: 100% !important;
        }

        .fc-view-harness-active {
            height: auto !important;
        }

        /* Disable past dates */
        .fc-day-past {
            background-color: #f5f5f5 !important;
            opacity: 0.5;
            cursor: not-allowed !important;
        }

        .fc-day-past .fc-daygrid-day-number {
            color: #999 !important;
        }

        /* Enhanced event hover effect */
        .fc-event:hover {
            opacity: 0.9;
            transform: scale(1.02);
            transition: all 0.2s ease;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
        }

        .fc-daygrid-event:hover {
            z-index: 100;
        }

        /* Custom tooltip */
        .custom-tooltip {
            position: fixed;
            background-color: #FDFBFB;
            color: #1A1A1A;
            padding: 12px 16px;
            border-radius: 6px;
            border: 2px solid #550000;
            font-size: 0.875rem;
            z-index: 99999 !important;
            pointer-events: none;
            box-shadow: 0 4px 12px rgba(85, 0, 0, 0.3);
            opacity: 0;
            transition: opacity 0.2s ease;
            max-width: 300px;
            line-height: 1.5;
            display: none;
        }

        .custom-tooltip.show {
            opacity: 1;
            display: block !important;
        }

        .custom-tooltip strong {
            display: block;
            margin-bottom: 6px;
            font-size: 1rem;
            color: #550000;
        }

        .custom-tooltip .tooltip-type {
            display: inline-block;
            margin-bottom: 4px;
            font-weight: 600;
        }

        .custom-tooltip .tooltip-time {
            color: #666666;
            font-size: 0.8rem;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .fc-toolbar-title {
                font-size: 1.25rem !important;
            }

            .fc-daygrid-day-number {
                font-size: 14px !important;
            }

            .fc-button {
                font-size: 0.75rem !important;
                padding: 4px 8px !important;
            }

            .fc-button-group {
                flex-wrap: wrap;
            }

            .fc-toolbar {
                flex-direction: column;
                gap: 10px;
            }

            .event-modal-content {
                width: 95%;
                max-width: 90vw;
                margin: 20% auto;
                max-height: 90vh;
                padding: 0;
            }

            .modal-header {
                padding: 15px;
            }

            .modal-header h2 {
                font-size: 1.25rem;
            }

            .modal-body {
                padding: 15px 20px;
                max-height: calc(90vh - 140px);
            }

            .modal-footer {
                padding: 12px 15px;
            }

            .close-btn {0
                width: 28px;
                height: 28px;
                font-size: 24px;
            }

            .info-row {
                margin-bottom: 10px;
                font-size: 0.9rem;
            }

            .session-badge,
            .manual-badge {
                font-size: 0.75rem;
                padding: 3px 10px;
            }

            .warning-box {
                font-size: 0.85rem;
                padding: 10px;
            }

            .btn {
                padding: 8px 16px;
                font-size: 0.9rem;
            }

            .form-input {
                font-size: 0.95rem;
                padding: 8px 10px;
            }

            .form-label {
                font-size: 0.95rem;
            }
        }

        @media (max-width: 480px) {
            .fc-toolbar {
                flex-direction: column;
            }

            .fc-toolbar-title {
                font-size: 1rem !important;
            }

            .fc-daygrid-day-number {
                font-size: 11px !important;
            }

            .fc-button {
                font-size: 0.65rem !important;
                padding: 3px 6px !important;
            }

            .fc-col-header-cell {
                padding: 4px 2px !important;
                font-size: 0.75rem;
            }

            .event-modal-content {
                margin: 40% auto;
            }

            .modal-header h2 {
                font-size: 1rem;
            }

            .modal-body {
                padding: 12px 15px;
            }

            .info-icon {
                font-size: 1rem;
                margin-right: 8px;
            }

            .info-row {
                font-size: 0.85rem;
                margin-bottom: 8px;
            }

            .btn {
                padding: 6px 12px;
                font-size: 0.85rem;
                width: 100%;
                margin-bottom: 8px;
            }

            .modal-footer {
                display: flex;
                flex-direction: column;
                gap: 8px;
            }

            .form-input {
                font-size: 0.9rem;
                padding: 8px;
            }

            .session-badge,
            .manual-badge {
                font-size: 0.7rem;
                padding: 2px 8px;
            }

            .warning-box {
                font-size: 0.8rem;
                padding: 8px;
            }
        }

        @media (max-width: 1024px) and (min-width: 769px) {
            .fc-toolbar {
                flex-wrap: wrap;
            }

            .fc-toolbar-title {
                font-size: 1.5rem !important;
            }

            .event-modal-content {
                max-width: 85vw;
            }
        }
    </style>

</head>

<body>
    <section class="mb-8 h-full">
        <div class="bg-accent rounded-md h-full pt-2 overflow-hidden border-charcoal border-2">
            <div class="flex -mt-2 items-center w-full py-2">
                <div
                    class="font-dela tracking-wide uppercase flex w-full justify-start text-xl text-charcoal font-bold ml-8 max-md:ml-4 max-md:text-lg">
                    Calendar
                </div>
            </div>
            <span class="flex mx-4 items-center">
                <span class="h-px flex-1 bg-charcoal"></span>
            </span>

            <div class="p-4 pb-16 max-md:p-2 max-md:pb-8">
                <div id="calendar"></div>
            </div>
        </div>
    </section>

    <!-- Event Details Modal -->
    <div id="eventModal" class="event-modal overflow-y-hidden">
        <div class="event-modal-content">
            <div class="modal-header">
                <h2 id="modalTitle">Event Details</h2>
                <button class="close-btn" onclick="closeEventModal()">&times;</button>
            </div>
            <span class="flex mx-4 items-center">
                <span class="h-px flex-1 bg-charcoal"></span>
            </span>
            <div class="modal-body" id="modalBody">
            </div>
            <span class="flex mx-4 items-center">
                <span class="h-px flex-1 bg-charcoal"></span>
            </span>
            <div class="modal-footer" id="modalFooter">
                <button onclick="closeEventModal()"
                    style="background-color: #550000; 
                    color: #FDFCFC; 
                    padding: 10px 20px; 
                    border: 2px solid black; 
                    border-radius: 8px; 
                    font-weight: bold; 
                    cursor: pointer;">
                    Close
                </button>
            </div>
        </div>
    </div>

    <!-- Add Event Modal -->
    <div id="addEventModal" class="event-modal">
        <div class="event-modal-content">
            <div class="modal-header">
                <h2>Add New Event</h2>
                <button class="close-btn" onclick="closeAddEventModal()">&times;</button>
            </div>
            <span class="flex mx-4 items-center">
                <span class="h-px flex-1 bg-charcoal"></span>
            </span>
            <div class="modal-body">
                <form id="addEventForm" onsubmit="submitNewEvent(event)">
                    <div class="form-group">
                        <input type="text" id="eventTitle" class="form-input" placeholder="Enter event title"
                            required>
                    </div>
                    <div class="form-group">
                        <input type="datetime-local" id="eventStart" class="form-input" required>
                    </div>
                    <div class="form-group">
                        <input type="datetime-local" id="eventEnd" class="form-input" required>
                    </div>
                </form>
            </div>
            <span class="flex mx-4 items-center">
                <span class="h-px flex-1 bg-charcoal"></span>
            </span>
            <div class="modal-footer">
                <button type="button" onclick="closeAddEventModal()" class="btn btn-secondary"
                    style="margin-right: 10px;">
                    Cancel
                </button>
                <button type="submit" form="addEventForm" class="btn btn-primary">
                    Add Event
                </button>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteConfirmModal" class="event-modal">
        <div class="event-modal-content" style="max-width: 450px;">
            <div class="modal-header">
                <h2>Confirm Delete</h2>
                <button class="close-btn" onclick="closeDeleteConfirmModal()">&times;</button>
            </div>
            <span class="flex mx-4 items-center">
                <span class="h-px flex-1 bg-charcoal"></span>
            </span>
            <div class="modal-body">
                <p style="font-size: 1.1rem; color: #1A1A1A; margin: 0;">
                    Are you sure you want to delete this event?
                </p>
            </div>
            <span class="flex mx-4 items-center">
                <span class="h-px flex-1 bg-charcoal"></span>
            </span>
            <div class="modal-footer">
                <button type="button" onclick="closeDeleteConfirmModal()" class="btn btn-secondary"
                    style="margin-right: 10px;">
                    Cancel
                </button>
                <button type="button" onclick="confirmDeleteEvent()" 
                    style="background-color: #dc2626; color: white; padding: 10px 20px; border: 2px solid black; border-radius: 2px; font-weight: bold; cursor: pointer;">
                    Delete Event
                </button>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.js'></script>
    <script>
        function openEventModal(eventInfo) {
            const modal = document.getElementById('eventModal');
            const modalTitle = document.getElementById('modalTitle');
            const modalBody = document.getElementById('modalBody');
            const modalFooter = document.getElementById('modalFooter');

            const event = eventInfo.event;
            const isBookedSession = event.extendedProps.eventType === 'booked_session';

            // Set title
            modalTitle.textContent = event.title;

            // Build modal content
            let content = '';

            if (isBookedSession) {
                content += `<span class="session-badge">📚 Booked Tutoring Session</span>`;

                const description = event.extendedProps.description || '';
                const lines = description.split('\n');

                content += '<div style="margin-top: 15px;">';
                lines.forEach(line => {
                    if (line.trim()) {
                        if (line.includes('Session')) {
                            content +=
                                `<div class="info-row"><span class="info-icon">🎯</span><span>${line}</span></div>`;
                        } else if (line.includes('Subject')) {
                            content +=
                                `<div class="info-row"><span class="info-icon">📖</span><span>${line}</span></div>`;
                        } else if (line.includes('Tutor')) {
                            content +=
                                `<div class="info-row"><span class="info-icon">👨‍🏫</span><span>${line}</span></div>`;
                        } else if (line.includes('Date')) {
                            content +=
                                `<div class="info-row"><span class="info-icon">📅</span><span>${line}</span></div>`;
                        } else if (line.includes('Time')) {
                            content +=
                                `<div class="info-row"><span class="info-icon">🕐</span><span>${line}</span></div>`;
                        } else {
                            content += `<div class="info-row"><span>${line}</span></div>`;
                        }
                    }
                });
                content += '</div>';

                content += `
                <div class="warning-box">
                    <strong>⚠️ Important:</strong> Booked session events cannot be deleted or modified manually.
                    To cancel this session, please use the <strong>"Drop Session"</strong> feature in your workspace.
                </div>
            `;

                modalFooter.innerHTML = `
                <button onclick="closeEventModal()" 
                    style="background-color: #000000; color: #FFD95C; padding: 10px 20px; border: 2px solid black; border-radius: 8px; font-weight: bold; cursor: pointer; transition: all 0.2s;">
                    Close
                </button>
            `;
            } else {
                content += `<span class="manual-badge">✏️ Manual Event</span>`;

                const startDate = new Date(event.start);
                const endDate = event.end ? new Date(event.end) : startDate;

                content += '<div style="margin-top: 15px;">';
                content +=
                    `<div class="info-row"><span class="info-icon">📅</span><span><span class="info-label">Start:</span>${startDate.toLocaleString()}</span></div>`;
                content +=
                    `<div class="info-row"><span class="info-icon">🏁</span><span><span class="info-label">End:</span>${endDate.toLocaleString()}</span></div>`;
                content += '</div>';

                modalFooter.innerHTML = `
                
                <button onclick="closeEventModal()" 
                    style="background-color: #55000005; color: #550000; padding: 10px 20px; border: 2px solid #550000; border-radius: 2px; font-weight: bold; cursor: pointer; transition: all 0.2s;">
                    Close
                </button>
                <button onclick="deleteEventFromModal(${event.id})" 
                    style="background-color: #dc2626; color: white; padding: 10px 20px; border: 2px solid black; border-radius: 2px; font-weight: bold; cursor: pointer; margin-right: 10px; transition: all 0.2s;">
                    Delete Event
                </button>
            `;
            }

            modalBody.innerHTML = content;
            modal.style.display = 'block';
        }

        function closeEventModal() {
            document.getElementById('eventModal').style.display = 'none';
        }

        let eventToDelete = null;

        function deleteEventFromModal(eventId) {
            eventToDelete = eventId;
            document.getElementById('deleteConfirmModal').style.display = 'block';
        }

        function closeDeleteConfirmModal() {
            document.getElementById('deleteConfirmModal').style.display = 'none';
            eventToDelete = null;
        }

        function confirmDeleteEvent() {
            if (eventToDelete) {
                $.ajax({
                    url: "/calendar/action",
                    type: "POST",
                    data: {
                        id: eventToDelete,
                        type: 'delete',
                        _token: '{{ csrf_token() }}'
                    },
                    success: function() {
                        closeDeleteConfirmModal();
                        closeEventModal();
                        location.reload();
                    },
                    error: function(xhr) {
                        closeDeleteConfirmModal();
                        alert("Error deleting event: " + xhr.responseText);
                    }
                });
            }
        }

        window.onclick = function(event) {
            const modal = document.getElementById('eventModal');
            const addModal = document.getElementById('addEventModal');
            const deleteModal = document.getElementById('deleteConfirmModal');
            if (event.target == modal) {
                closeEventModal();
            }
            if (event.target == addModal) {
                closeAddEventModal();
            }
            if (event.target == deleteModal) {
                closeDeleteConfirmModal();
            }
        }

        let selectedDateInfo = null;

        function openAddEventModal(info) {
            selectedDateInfo = info;
            const modal = document.getElementById('addEventModal');
            const startInput = document.getElementById('eventStart');
            const endInput = document.getElementById('eventEnd');

            const startDate = new Date(info.start);
            const endDate = new Date(info.end || info.start);

            startInput.value = startDate.toISOString().slice(0, 16);
            endInput.value = endDate.toISOString().slice(0, 16);

            document.getElementById('eventTitle').value = '';
            modal.style.display = 'block';
        }

        function closeAddEventModal() {
            document.getElementById('addEventModal').style.display = 'none';
            selectedDateInfo = null;
        }

        function submitNewEvent(event) {
            event.preventDefault(); // Prevent default form submission
            
            const title = document.getElementById('eventTitle').value.trim();
            const start = document.getElementById('eventStart').value;
            const end = document.getElementById('eventEnd').value;

            // Form validation will be handled by HTML5 required attribute
            $.ajax({
                url: "/calendar/action",
                type: "POST",
                data: {
                    title: title,
                    start: start,
                    end: end,
                    type: 'add',
                    _token: '{{ csrf_token() }}'
                },
                success: function() {
                    closeAddEventModal();
                    location.reload();
                },
                error: function(xhr) {
                    alert("Error adding event: " + xhr.responseText);
                }
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');

            // Determine responsive height and view
            function getCalendarConfig() {
                const width = window.innerWidth;
                let height, initialView, headerToolbar;

                if (width <= 480) {
                    // Mobile
                    height = 'auto';
                    initialView = 'dayGridMonth';
                    headerToolbar = {
                        left: 'prev,next',
                        center: 'title',
                        right: ''
                    };
                } else if (width <= 768) {
                    // Tablet
                    height = 500;
                    initialView = 'dayGridMonth';
                    headerToolbar = {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth,timeGridWeek'
                    };
                } else {
                    // Desktop
                    height = 600;
                    initialView = 'dayGridMonth';
                    headerToolbar = {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth,timeGridWeek,timeGridDay'
                    };
                }

                return { height, initialView, headerToolbar };
            }

            const config = getCalendarConfig();

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: config.initialView,
                height: config.height,
                contentHeight: 'auto',
                selectable: true,
                editable: true,
                headerToolbar: config.headerToolbar,
                events: '/calendar/event',
                displayEventTime: true,
                validRange: {
                    start: new Date().toISOString().split('T')[0] // Only allow current date and future
                },
                selectAllow: function(selectInfo) {
                    // Prevent selection of past dates
                    const today = new Date();
                    today.setHours(0, 0, 0, 0);
                    return selectInfo.start >= today;
                },

                eventDidMount: function(info) {
                    // Create custom tooltip
                    const eventType = info.event.extendedProps.eventType === 'booked_session' ? '📚 Tutoring Session' : '✏️ Personal Event';
                    const startTime = info.event.start.toLocaleString('en-US', { 
                        month: 'short', 
                        day: 'numeric', 
                        year: 'numeric',
                        hour: '2-digit', 
                        minute: '2-digit' 
                    });
                    
                    // Create tooltip element
                    const tooltip = document.createElement('div');
                    tooltip.className = 'custom-tooltip';
                    tooltip.style.position = 'fixed';
                    tooltip.style.zIndex = '99999';
                    tooltip.innerHTML = `
                        <strong>${info.event.title}</strong>
                        <div class="tooltip-type">${eventType}</div>
                        <div class="tooltip-time">${startTime}</div>
                    `;
                    document.body.appendChild(tooltip);

                    // Show/hide tooltip on hover
                    info.el.addEventListener('mouseenter', function(e) {
                        const rect = info.el.getBoundingClientRect();
                        
                        // Calculate tooltip position
                        tooltip.style.display = 'block';
                        tooltip.style.left = (rect.left + rect.width / 2) + 'px';
                        tooltip.style.top = (rect.top - 10) + 'px';
                        tooltip.style.transform = 'translate(-50%, -100%)';
                        
                        // Show tooltip immediately
                        requestAnimationFrame(() => {
                            tooltip.classList.add('show');
                        });
                    });

                    info.el.addEventListener('mouseleave', function() {
                        tooltip.classList.remove('show');
                        setTimeout(() => {
                            tooltip.style.display = 'none';
                        }, 200);
                    });

                    // Store tooltip reference for cleanup
                    info.el._tooltip = tooltip;

                    if (info.event.extendedProps.eventType === 'booked_session') {
                        info.el.style.cursor = 'pointer';
                        info.el.style.fontWeight = 'bold';
                    } else {
                        info.el.style.cursor = 'pointer';
                    }

                    const dayCell = info.el.closest('.fc-daygrid-day');
                    if (dayCell) {
                        dayCell.classList.add('has-events');
                    }
                },

                eventWillUnmount: function(info) {
                    // Clean up tooltip when event is removed
                    if (info.el._tooltip && info.el._tooltip.parentNode) {
                        info.el._tooltip.remove();
                    }
                },

                select: function(info) {
                    // Double-check that we're not selecting a past date
                    const today = new Date();
                    today.setHours(0, 0, 0, 0);
                    if (info.start < today) {
                        alert('Cannot create events in the past!');
                        return;
                    }
                    openAddEventModal(info);
                },

                eventDrop: function(info) {
                    if (info.event.extendedProps.eventType === 'booked_session') {
                        alert(
                            "Booked session events cannot be moved. Please contact your tutor/student to reschedule."
                        );
                        info.revert();
                        return;
                    }

                    $.ajax({
                        url: "/calendar/action",
                        type: "POST",
                        data: {
                            id: info.event.id,
                            title: info.event.title,
                            start: info.event.start.toISOString(),
                            end: info.event.end ? info.event.end.toISOString() : info.event
                                .start.toISOString(),
                            type: 'update',
                            _token: '{{ csrf_token() }}'
                        },
                        success: function() {
                            alert("Event updated!");
                        },
                        error: function(xhr) {
                            alert("Error updating event: " + xhr.responseText);
                            info.revert();
                        }
                    });
                },

                eventResize: function(info) {
                    if (info.event.extendedProps.eventType === 'booked_session') {
                        alert("Booked session events cannot be resized.");
                        info.revert();
                        return;
                    }

                    $.ajax({
                        url: "/calendar/action",
                        type: "POST",
                        data: {
                            id: info.event.id,
                            title: info.event.title,
                            start: info.event.start.toISOString(),
                            end: info.event.end.toISOString(),
                            type: 'update',
                            _token: '{{ csrf_token() }}'
                        },
                        success: function() {
                            alert("Event resized!");
                        },
                        error: function(xhr) {
                            alert("Error resizing event: " + xhr.responseText);
                            info.revert();
                        }
                    });
                },

                eventClick: function(info) {
                    openEventModal(info);
                }
            });

            calendar.render();
        });

        // Handle window resize for responsive updates
        let resizeTimeout;
        let lastWidth = window.innerWidth;
        
        window.addEventListener('resize', function() {
            clearTimeout(resizeTimeout);
            resizeTimeout = setTimeout(function() {
                const currentWidth = window.innerWidth;
                if (Math.abs(currentWidth - lastWidth) > 50) {
                    lastWidth = currentWidth;
                    location.reload();
                }
            }, 500);
        });
    </script>

</body>

</html>
