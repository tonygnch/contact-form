<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string','max:50'],
            'email' => ['required', 'email:rfc,dns', 'max:50'],
            'phone' => ['required', 'string', 'max:20', 'regex:/^([\d\s\-\+\(\)]*[\)|\d])$/'],
            'message' => ['required', 'string', 'max:500']
        ];
    }
}
