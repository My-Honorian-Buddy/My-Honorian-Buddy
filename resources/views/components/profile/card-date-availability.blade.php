@php
    $user = Auth::user();
@endphp

<div class="flex mt-8 mb-8">
    <div class="w-full bg-accent rounded-md border-charcoal border-4">
        <div class="relative rounded-[20px] px-8">

            <!-- Card Tittle-->
            <div class="flex flex-col mt-8 text-left">
                <span class="font-dela font-bold text-4xl m-5 mb-0 leading-relaxed">Date Availability</span>
            </div>
            <span class="font-bold font-sm text-primary m-5 leading-relaxed">Update Date and Time availability</span>

            <!-- Card Content-->
            @if ($user->schedule && $user->schedule->days_week)
                @php
                    $days = is_string($user->schedule->days_week)
                        ? json_decode($user->schedule->days_week, true)
                        : $user->schedule->days_week;
                @endphp

                @if (is_array($days))
                    <div style="display: flex; flex-direction: row; justify-content: center; gap: 1rem; margin-top: 2rem; margin-bottom: 2rem; flex-wrap: wrap; @media (max-width: 768px) { gap: 0.25rem; margin-top: 0.75rem; margin-bottom: 0.75rem; }">
                        @foreach ($days as $day)
                            <span style="border: 2px solid black; background-color: #550000; padding: 0.5rem; border-radius: 9999px; color: white; padding:0.5rem 1rem; font-size: 1rem; @media (max-width: 768px) { border: 1px solid black; padding: 0.75rem 1rem; font-size: 0.875rem; }">{{ $day }}</span>
                        @endforeach
                    </div>
                @else
                    <div style="background-color: #e5e7eb; margin: 0.25rem 0; padding: 0.25rem 1rem; border-radius: 1rem; border: 2px solid black; box-shadow: 5px 5px 1px rgba(0, 0, 0, 1); color: #550000; font-size: 1.25rem; text-align: center; font-weight: bold; @media (max-width: 768px) { border: 1px solid black; padding: 0.5rem 0.5rem; font-size: 0.875rem; }">
                        <p style="font-weight: bold; @media (max-width: 768px) { font-size: 0.875rem; }">No schedule available</p>
                    </div>
                @endif
            @endif


            <div class="flex flex-row justify-center gap-4 mt-8 mb-8">
                <span
                    class="font-bold text-2xl">{{ \Carbon\Carbon::parse($user->schedule->start_time)->format('h:i A') }}
                    - {{ \Carbon\Carbon::parse($user->schedule->end_time)->format('h:i A') }}</span>
            </div>

            <!-- Schedule Edit Button-->
            <div class="w-auto mt-6 m-8 flex justify-end">
                <a href="{{ route('user.schedule.edit') }}"
                    class="sm:w-auto bg-accent px-6 sm:px-8 md:px-10 py-2 sm:py-2.5 md:py-1 h-auto sm:h-10 md:h-11 border-2 border-black
                                active:scale-95 transition-all duration-800 ease-in-out flex items-center justify-center rounded-sm font-bold text-sm
                                hover:bg-primary w-auto hover:text-accent tracking-widest uppercase hover:shadow-custom-button">
                    Edit
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        @if (session('success'))
            showNotification('{{ session('success') }}', 'Schedule updated successfully!', 'success');
        @endif

        @if (session('error'))
            showNotification('{{ session('error') }}', 'Error', 'error');
        @endif
    });
</script>
