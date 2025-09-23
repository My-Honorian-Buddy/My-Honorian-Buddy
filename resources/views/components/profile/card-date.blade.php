@php
    $user = Auth::user();
@endphp

<div class="flex mt-8 mb-8">
    <div class="w-full bg-accent3 rounded-[20px] shadow-custom-button shadow-black border-black border-2">
        <div class="relative rounded-[20px] px-6">
            
            <!-- Card Tittle-->
            <div class="flex flex-col mt-8 text-left">
                <span class="font-bold text-4xl m-5 leading-relaxed">Date Availability</span> 
            </div>

            <!-- Card Content-->
            @if ($user->schedule && $user->schedule->days_week)
                @php
                    $days = is_string($user->schedule->days_week) 
                    ? json_decode($user->schedule->days_week, true) 
                    : $user->schedule->days_week;
                @endphp

                @if(is_array($days))
                    <div class="flex flex-row justify-center gap-4 mt-8 mb-8">
                        @foreach($days as $day)
                        <span class="border-2 border-black bg-primary p-2 rounded-full text-white py-8 px-8">{{$day}}</span>
                        @endforeach
                    </div>
    
                @else
                    <div class="bg-gray-200 my-1 py-1 px-4 rounded-2xl border-2 border-black shadow-custom-button text-primary text-[20px] text-center font-bold">
                        <p class="font-bold text-[18px]">No schedule available</p>
                    </div>
                @endif
            @endif

            <div class="flex flex-row justify-center gap-4 mt-8 mb-8">
                <span class="font-bold text-2xl">{{\Carbon\Carbon::parse($user->schedule->start_time)->format('h:i A')}} - {{\Carbon\Carbon::parse($user->schedule->end_time)->format('h:i A')}}</span>
            </div>

            <!-- Card Footer -->
        </div>
    </div>
</div>