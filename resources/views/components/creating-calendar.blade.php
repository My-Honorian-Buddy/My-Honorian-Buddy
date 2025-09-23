<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.css' rel='stylesheet' />
</head>
<body>
    <section class="mb-8 h-full">
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
                <div id="calendar"></div>
            </div>
        </div>
    </section>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.js'></script>
    
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');

        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            height: 600,
            selectable: true,
            editable: true,
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            events: '/cecill',
            displayEventTime: false,

            // Adding of ur event
            select: function(info) {
                var title = prompt('Enter Event Title:');
                if (title) {
                    $.ajax({
                        url: "/cecill/action",
                        type: "POST",
                        data: {
                            title: title,
                            start: info.startStr,
                            end: info.endStr,
                            type: 'add',
                            _token: '{{ csrf_token() }}'
                        },
                        success: function() {
                            calendar.refetchEvents();
                            alert("Event added!");
                        }
                    });
                }
                calendar.unselect();
            },

            // Update (drag/drop or resize)
            eventDrop: function(info) {
                $.ajax({
                    url: "/cecill/action",
                    type: "POST",
                    data: {
                        id: info.event.id,
                        title: info.event.title,
                        start: info.event.start.toISOString(),
                        end: info.event.end ? info.event.end.toISOString() : info.event.start.toISOString(),
                        type: 'update',
                        _token: '{{ csrf_token() }}'
                    },
                    success: function() {
                        alert("Event updated!");
                    }
                });
            },
            eventResize: function(info) {
                $.ajax({
                    url: "/cecill/action",
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
                    }
                });
            },

            // Delete
            eventClick: function(info) {
                if (confirm("Do you really want to delete this event?")) {
                    $.ajax({
                        url: "/cecill/action",
                        type: "POST",
                        data: {
                            id: info.event.id,
                            type: 'delete',
                            _token: '{{ csrf_token() }}'
                        },
                        success: function() {
                            calendar.refetchEvents();
                            alert("Event deleted!");
                        }
                    });
                }
            }
        });

        calendar.render();
    });
</script>


</body>
</html>
