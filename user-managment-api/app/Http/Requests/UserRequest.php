<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
        $user = $this->route('user'); // Assuming you have a user ID in the route parameter
        return [
            'name' => 'string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($user),
            ],
            'password' => ['string', 'min:8', 'confirmed'],
        ];
    }
}
