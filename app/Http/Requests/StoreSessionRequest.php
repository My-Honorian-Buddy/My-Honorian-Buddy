<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSessionRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Adjust based on your authorization logic
    }

    public function rules()
    {
        return [
            'student_id' => 'required|exists:students,id',
            'tutor_id' => 'required|exists:tutors,id',
            'tutoring_subject' => 'required|string|max:255',
            'schedule_time' => 'required|date',
            'total_sessions' => 'required|integer|min:1',
        ];
    }
}
