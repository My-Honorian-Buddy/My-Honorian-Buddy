@php
    $user = Auth::user();
@endphp

<div class="flex" style="margin-top: 2rem; margin-bottom: 2rem; @media (max-width: 768px) { margin-top: 0.5rem; margin-bottom: 0.5rem; }">
    <div class="w-full bg-accent rounded-md shadow-black" style="border: 4px solid #1A1A1A; @media (max-width: 768px) { border: 2px solid #1A1A1A; }">
        <div class="relative rounded-[20px]" style="padding: 2rem; @media (max-width: 768px) { padding: 0.75rem; }">

            <!-- Card Tittle-->
            <div style="display: flex; flex-direction: column; text-align: left; @media (max-width: 768px) { margin-top: 0.75rem; }">
                <span style="font-family: 'Dela Gothic One'; font-weight: bold; font-size: 2.25rem; margin: 1.25rem; line-height: 1.5; @media (max-width: 768px) { font-size: 1.5rem; margin: 0.25rem; }">
                    Date Availability
                </span>
            </div>
            <span style="display: flex; margin: 1rem; margin-bottom: 1rem; align-items: center; @media (max-width: 768px) { margin: 0.25rem; margin-bottom: 0.25rem; }">
                <span style="height: 1px; flex: 1; background-color: #1A1A1A;"></span>
            </span>

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

            <div style="display: flex; flex-direction: row; justify-content: center; gap: 1rem; margin-top: 2rem; margin-bottom: 2rem; @media (max-width: 768px) { flex-direction: column; gap: 0.25rem; margin-top: 0.75rem; margin-bottom: 0.75rem; }">
                <span style="font-weight: bold; font-size: 1.5rem; @media (max-width: 768px) { font-size: 1.125rem; text-align: center; }">{{ \Carbon\Carbon::parse($user->schedule->start_time)->format('h:i A') }}
                    - {{ \Carbon\Carbon::parse($user->schedule->end_time)->format('h:i A') }}</span>
            </div>
        </div>
    </div>
</div>
