<div class="space-y-4">
    <div class="bg-gray-50 dark:bg-gray-900 p-4 rounded-lg">
        <h3 class="text-lg font-semibold mb-2 text-gray-900 dark:text-white">Ban Request Details</h3>
        <div class="space-y-2">
            <div>
                <span class="font-medium text-gray-700 dark:text-gray-300">Requested At:</span>
                <span class="text-gray-900 dark:text-white">{{ $record->ban_requested_at?->format('M d, Y h:i A') ?? 'N/A' }}</span>
            </div>
            <div>
                <span class="font-medium text-gray-700 dark:text-gray-300">Reason:</span>
                <p class="text-gray-900 dark:text-white mt-1">{{ $record->ban_reason ?? 'No reason provided' }}</p>
            </div>
        </div>
    </div>

    <div class="bg-blue-50 dark:bg-blue-900/20 p-4 rounded-lg border border-blue-200 dark:border-blue-800">
        <h3 class="text-lg font-semibold mb-2 text-blue-900 dark:text-blue-100">Tutor's Response</h3>
        <div class="space-y-2">
            <div>
                <span class="font-medium text-blue-700 dark:text-blue-300">Submitted At:</span>
                <span class="text-blue-900 dark:text-blue-100">{{ $record->tutor_report_submitted_at?->format('M d, Y h:i A') ?? 'N/A' }}</span>
            </div>
            <div>
                <span class="font-medium text-blue-700 dark:text-blue-300">Report:</span>
                <p class="text-blue-900 dark:text-blue-100 mt-1 whitespace-pre-wrap">{{ $record->tutor_report ?? 'No report submitted' }}</p>
            </div>
        </div>
    </div>

    @if($record->tutor_report_images && count($record->tutor_report_images) > 0)
    <div class="bg-gray-50 dark:bg-gray-900 p-4 rounded-lg">
        <h3 class="text-lg font-semibold mb-3 text-gray-900 dark:text-white">Evidence Images</h3>
        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
            @foreach($record->tutor_report_images as $imagePath)
                <div class="relative group">
                    <a href="{{ Storage::url($imagePath) }}" target="_blank" class="block">
                        <img 
                            src="{{ Storage::url($imagePath) }}" 
                            alt="Evidence" 
                            class="w-full h-40 object-cover rounded-lg border border-gray-300 dark:border-gray-600 hover:opacity-90 transition"
                        >
                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 transition rounded-lg flex items-center justify-center">
                            <svg class="w-8 h-8 text-white opacity-0 group-hover:opacity-100 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path>
                            </svg>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
    @else
    <div class="bg-gray-50 dark:bg-gray-900 p-4 rounded-lg">
        <p class="text-gray-500 dark:text-gray-400 italic">No evidence images submitted</p>
    </div>
    @endif

    <div class="bg-yellow-50 dark:bg-yellow-900/20 p-4 rounded-lg border border-yellow-200 dark:border-yellow-800">
        <h3 class="text-lg font-semibold mb-2 text-yellow-900 dark:text-yellow-100">Session Details</h3>
        <div class="grid grid-cols-2 gap-2 text-sm">
            <div>
                <span class="font-medium text-yellow-700 dark:text-yellow-300">Tutor:</span>
                <span class="text-yellow-900 dark:text-yellow-100">{{ $record->tutorUser->name }}</span>
            </div>
            <div>
                <span class="font-medium text-yellow-700 dark:text-yellow-300">Student:</span>
                <span class="text-yellow-900 dark:text-yellow-100">{{ $record->studentUser->name }}</span>
            </div>
            <div>
                <span class="font-medium text-yellow-700 dark:text-yellow-300">Subject:</span>
                <span class="text-yellow-900 dark:text-yellow-100">
                    {{ is_string($record->tutoring_subject) ? implode(', ', json_decode($record->tutoring_subject, true) ?? [$record->tutoring_subject]) : $record->tutoring_subject }}
                </span>
            </div>
            <div>
                <span class="font-medium text-yellow-700 dark:text-yellow-300">Sessions:</span>
                <span class="text-yellow-900 dark:text-yellow-100">{{ $record->num_session }} / {{ $record->total_session }}</span>
            </div>
        </div>
    </div>
</div>
