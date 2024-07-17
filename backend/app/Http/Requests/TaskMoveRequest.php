<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskMoveRequest extends FormRequest
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
            'id' => 'required',
            'new_order' => 'required',
            'old_order' => 'required',
            'from_status' => 'required',
            'to_status' => 'required',
        ];
    }
}
