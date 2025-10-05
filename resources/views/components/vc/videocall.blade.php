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
    <title>Video Call</title>

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    
    <link href="{{ asset('vendor/bladewind/css/bladewind-ui.min.css') }}" rel="stylesheet" />
    <link rel="icon" href="{{ asset('/images/favicon.svg') }}" type="image/x-icon">
    <script src="{{ asset('vendor/bladewind/js/notification.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <script src="{{ asset('vendor/bladewind/js/helpers.js') }}"></script>
</head>
<body>
    <x-nav-bar />
    <div class="absolute mt-4 top-50 right-4 z-50">
        <x-bladewind::button 
                        type="submit" 
                        class=" bg-red-500 hover:bg-red-700 text-white font-bold"
                        size="small"
                        rounded="true"
                        onclick="showModal('confirm-hangup')">
                        Hang Up
        </x-bladewind::button>
                    
        <x-bladewind.modal 
                    name="confirm-hangup"
                    size="small" 
                    title="Confirm Hang Up"
                    footer="false"
                    ok_button_label=""
                    cancel_button_label=""
                    cancel_button_action="hideModal('confirm-hangup')"
                    backdrop_can_close="true">

        <p>Are you sure you want to hang up the call?</p><br>
        <p>A confirmation to add the number of session will be sent to you both.</p>

        <div class="mt-4 flex justify-end space-x-4">
                    <x-bladewind::button
                    type="button"
                    class="bg-primary text-accent2 border-2 border-black hover:bg-red-700 hover:scale-105"
                    size="small"
                    rounded="true"
                    can_submit="false"
                    onclick="hideModal('confirm-hangup')">
                    Cancel
                </x-bladewind::button>
            <form action="{{ route('participant.left') }}" method="GET">
                    @csrf
                    <x-bladewind::button 
                    type="submit"
                    class="bg-accent2 text-primary border-2 border-black hover:bg-secondary hover:scale-105"
                    size="small"
                    rounded="true"
                    can_submit="true">
                    Confirm
                </x-bladewind::button>
            </form> 
        </div>
    </x-bladewind.modal>
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

    <script src='https://8x8.vc/vpaas-magic-cookie-2b61ef21745249ebb86a91088e86a9e0/external_api.js'></script>
    <script>
        
        

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
        
        
        const domain = "8x8.vc";
        const options = {
            roomName: "{{ $roomName }}",
            width: '100%',
            height: '100%',
            parentNode: document.querySelector('#meet'),
            userInfo: {
                displayName: userName
            },
            configOverwrite: {
                disableDeepLinking: true, // Prevents the native app download prompt
                branding: {
                    showPoweredBy: false, // Removes the "Powered by Jitsi" text
                } // Prevents the native app download prompt
            },
            interfaceConfigOverwrite: {

                DEFAULT_LOGO_URL: '/images/favicon.svg',
                TOOLBAR_BUTTONS: ['microphone', 'camera', 'chat', 'settings', 'whiteboard'] ,
                SETTINGS_SECTIONS: [ 'devices', 'language', 'sounds', 'more' ],
            }
        };
        console.log(options);
        window.onload = () => {
        const api = new JitsiMeetExternalAPI(domain, options);

        api.addListener('readyToClose', function () {
            console.log('The conference has ended');

            // Notify the server about the meeting end
            fetch("{{ route('participant.left') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}" // Protect against CSRF attacks
                },
                body: JSON.stringify({
                    user_id: "{{ Auth::user()->id }}", // Authenticated user's ID
                    room_name: "{{ $roomName }}", // Room name or session info
                })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Failed to notify server');
                }
                return response.json();
            })
            .then(data => {
                
            })
            .catch(error => {
                console.error('Error ending meeting end notification:', error);
            });
        });

        api.addListener('participantJoined', function (participant) {
            console.log(`${participant.displayName} joined the meeting`);
            document.getElementById('hangup-button').classList.remove('hidden');
        });

        // Hide the button if the meeting ends
        api.addListener('readyToClose', function () {
            console.log('The meeting has ended');
            document.getElementById('hangup-button').classList.add('hidden');
        });
    }

    </script>
</body>
</html>
