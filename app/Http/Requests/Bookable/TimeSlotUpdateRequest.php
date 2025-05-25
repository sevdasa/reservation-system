<?php

namespace App\Http\Requests\Bookable;

use Illuminate\Foundation\Http\FormRequest;

class TimeSlotUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'bookable_id' => 'sometimes|required|exists:bookables,id',
            'start_time' => 'sometimes|required|date_format:H:i',
            'end_time' => 'sometimes|required|date_format:H:i',
            'date' => 'sometimes|required|date',
            'is_booked' => 'sometimes|boolean',
        ];
    }
}
