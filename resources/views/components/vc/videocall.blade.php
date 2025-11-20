@php
    use App\Models\Tutor;
    use App\Models\Student;
    use App\Models\bookedSession;

    $allTutors = Tutor::all();
    $allStudents = Student::all();
    $bookedSession = bookedSession::all();
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @auth
    <meta name="user-id" content="{{ Auth::id() }}">
    @endauth

    <title>My Honorian Buddy</title>
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    <link rel="icon" href="{{ asset('/images/favicon.svg') }}" type="image/x-icon">

    <link href="{{ asset('vendor/bladewind/css/bladewind-ui.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="burger.css">
    <link href="{{ asset('vendor/bladewind/css/animate.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <script src="{{ asset('vendor/bladewind/js/helpers.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.css' rel='stylesheet' />
</head>
<body>
    <x-nav-bar />
    <div class="absolute mt-4 top-50 right-4 z-50">
        <x-bladewind::button 
                        type="submit" 
                        class=" bg-red-500 hover:bg-red-700 text-white font-bold"
                        size="small"
                        rounded="false"
                        onclick="showModal('confirm-hangup')">
                        Hang Up
        </x-bladewind::button>
                    
        <x-bladewind.modal-explore 
                    name="confirm-hangup"
                    size="medium" 
                    title="Confirm Hang Up"
                    footer="false"
                    show_action_buttons="false"
                    cancel_button_action="hideModal('confirm-hangup')"
                    backdrop_can_close="true">

        <p>Are you sure you want to hang up the call?</p><br>
        <p>A confirmation to add the number of session will be sent to you both.</p>

        <div class="mt-4 flex justify-end space-x-4 pb-2">
                    <x-bladewind::button
                    type="button"
                    class="bg-accent text-primary border border-primary hover:bg-primary/5"
                    size="small"
                    rounded="false"
                    can_submit="false"
                    onclick="hideModal('confirm-hangup')">
                    Cancel
                </x-bladewind::button>
            <x-bladewind::button 
                    type="button"
                    class="bg-primary text-accent border border-primary hover:bg-primary/80"
                    size="small"
                    rounded="false"
                    can_submit="false"
                    onclick="confirmHangup()">
                    Confirm
                </x-bladewind::button>
        </div>
    </x-bladewind.modal-explore>
    </div>
    
    <div id="meet" class="flex justify-center items-center w-full">

    </div>

    <style>
        html, body {
            margin: 0;
            padding: 0;
            height: 100%;
            overflow: hidden;
        }

        #meet {
            width: 100%;
            height: calc(95vh - 100px);
        }
    </style>

    <script src='https://meet.jit.si/external_api.js'></script>
    <script>
        // Variables to track call duration
        // Set start time immediately when page loads (backup if Jitsi event doesn't fire)
        let callStartTime = new Date();
        let callEndTime = null;
        let totalDurationMinutes = 0;
        let jitsiApi = null; // Global reference to Jitsi API
        
        console.log('⏱️ Initial callStartTime set to:', callStartTime.toISOString());

        const allTutors = @json($allTutors);
        const allStudents = @json($allStudents);
        const bookedSession = @json($bookedSession);
        
        let userName = null;
        const role = "{{ Auth::user()->role }}";

        if (role === 'Tutor') {
            allTutors.forEach((tutor) => {
                if (tutor.user_id === {{ Auth::user()->id }}) {
                    userName = tutor.fname + ' ' + tutor.lname;
                }
            });
        } else if (role === 'Student') {
            allStudents.forEach((student) => {
                if (student.user_id === {{ Auth::user()->id }}) {
                    userName = student.fname + ' ' + student.lname;
                }
            });
        }
        
        // Function to handle manual hangup from the modal
        window.confirmHangup = function() {
            console.log('🔴 Manual hangup triggered');
            
            // Hide the modal
            if (typeof hideModal === 'function') {
                hideModal('confirm-hangup');
            }
            
            if (jitsiApi) {
                
                if (callStartTime) {
                    callEndTime = new Date();
                    const durationMs = callEndTime - callStartTime;
                    totalDurationMinutes = Math.round(durationMs / (1000 * 60));
                    
                    console.log('⏱️ Manual Hangup - Duration Calculation:', {
                        startTime: callStartTime.toISOString(),
                        endTime: callEndTime.toISOString(),
                        durationMs: durationMs,
                        durationMinutes: totalDurationMinutes
                    });
                } else {
                    console.error('❌ callStartTime is null at manual hangup!');
                    totalDurationMinutes = 1; // Fallback to 1 minute
                }
                
                jitsiApi.dispose();
                
                fetch("{{ route('participant.left') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        user_id: "{{ Auth::user()->id }}",
                        room_name: "{{ $roomName }}",
                        duration: totalDurationMinutes,
                        start_time: callStartTime ? callStartTime.toISOString() : null,
                        end_time: callEndTime ? callEndTime.toISOString() : null
                    })
                })
                .then(response => response.json())
                .then(data => {
                    console.log('✅ Server notified successfully:', data);
                    window.location.href = "{{ route('workspace.start') }}";
                })
                .catch(error => {
                    console.error('❌ Error:', error);
                    window.location.href = "{{ route('workspace.start') }}";
                });
                
            } else {
                console.error('❌ Jitsi API not initialized yet');
                alert('Call ended. Redirecting...');
                window.location.href = "{{ route('workspace.start') }}";
            }
        }
        
        const domain = "meet.jit.si";
        const options = {
            roomName: "{{ $roomName }}",
            width: '100%',
            height: '100%',
            parentNode: document.querySelector('#meet'),
            userInfo: {
                displayName: userName
            },
            configOverwrite: {
                disableDeepLinking: true,
                branding: {
                    showPoweredBy: false,
                }
            },
            interfaceConfigOverwrite: {

                DEFAULT_LOGO_URL: '/images/favicon.svg',
                TOOLBAR_BUTTONS: ['microphone', 'camera', 'chat', 'settings', 'whiteboard'] ,
                SETTINGS_SECTIONS: [ 'devices', 'language', 'sounds', 'more' ],
            }
        };
        console.log(options);
        window.onload = () => {
        jitsiApi = new JitsiMeetExternalAPI(domain, options);

        
        jitsiApi.addListener('videoConferenceJoined', function (event) {
            console.log('🎥 Video conference joined by user:', event);
            
            // Update start time when actually joined (more accurate)
            callStartTime = new Date();
            console.log('⏱️ Call started at (updated):', callStartTime.toISOString());
        });

        jitsiApi.addListener('readyToClose', function () {
            console.log('🔴 The conference has ended');
            
            callEndTime = new Date();
            console.log('⏱️ Call ended at:', callEndTime.toISOString());
            
            if (callStartTime && callEndTime) {
                const durationMs = callEndTime - callStartTime;
                totalDurationMinutes = Math.round(durationMs / (1000 * 60)); 
                
                console.log('⏱️ Duration Calculation:', {
                    startTime: callStartTime.toISOString(),
                    endTime: callEndTime.toISOString(),
                    durationMs: durationMs,
                    durationMinutes: totalDurationMinutes,
                    hours: Math.floor(totalDurationMinutes / 60),
                    minutes: totalDurationMinutes % 60
                });
            } else {
                console.error('❌ Missing time data:', {
                    callStartTime: callStartTime,
                    callEndTime: callEndTime
                });
                // If start time is somehow null, use minimal duration
                totalDurationMinutes = 1; // At least 1 minute
            }

            // Notify the server about the meeting end with duration
            fetch("{{ route('participant.left') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}" 
                },
                body: JSON.stringify({
                    user_id: "{{ Auth::user()->id }}", 
                    room_name: "{{ $roomName }}", 
                    duration: totalDurationMinutes, 
                    start_time: callStartTime ? callStartTime.toISOString() : null,
                    end_time: callEndTime ? callEndTime.toISOString() : null
                })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Failed to notify server');
                }
                return response.json();
            })
            .then(data => {
                console.log('✅ Server notified successfully:', data);
                
                setTimeout(() => {
                    window.location.href = "{{ route('workspace.start') }}";
                }, 500);
            })
            .catch(error => {
                console.error('❌ Error sending meeting end notification:', error);
                
                setTimeout(() => {
                    window.location.href = "{{ route('workspace.start') }}";
                }, 1000);
            });
        });

        jitsiApi.addListener('participantJoined', function (participant) {
            console.log(`${participant.displayName} joined the meeting`);
        });
    }

    </script>
</body>
</html>
