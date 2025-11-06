<style>
    /* Force modal above everything including navbar */
    .bw-modal-backdrop[data-name="set-appointment"] {
        z-index: 999999 !important;
    }
    .bw-modal[data-name="set-appointment"] {
        z-index: 1000000 !important;
        max-height: 85vh !important;
        overflow-y: auto !important;
    }
    /* Make the modal scrollable */
    .bw-modal[data-name="set-appointment"] .modal-body {
        max-height: 70vh !important;
        overflow-y: auto !important;
    }
</style>

<div class="w-full mt-4 flex justify-center items-center">

        <button class="w-full bg-primary/5 text-primary text-center font-poppins font-bold rounded-sm px-3 py-1 h-11 text-l border-2 border-black hover:shadow-custom-button
                    transition-all duration-600 ease-in-out hover:bg-primary hover:text-accent flex items-center space-x-2 mb-4" 
                    id="set-appointment-btn"
                    type="button"
                    >
                    
            <span class="w-full text-center py-4">SET APPOINTMENT</span>
        </button>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Attach click event to the button or wrapper
        const appointmentBtn = document.getElementById('set-appointment-btn');
        
        if (appointmentBtn) {
            appointmentBtn.addEventListener('click', function () {
                const wrapper = document.getElementById('set-appointment-wrapper');
                if (wrapper) {
                    const tutorId = wrapper.getAttribute('data-tutor-id');
                    if (tutorId) {
                        const baseUrl = "{{ route('appointment.page', ['tutorId' => 'TUTOR_ID_PLACEHOLDER']) }}".replace('TUTOR_ID_PLACEHOLDER', tutorId);
                        window.location.href = baseUrl;
                    }
                }
            });
        }
    });
</script>