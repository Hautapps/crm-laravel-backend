<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerSearchRequest extends FormRequest
{
    /*public function authorize(): bool
    {
        return true; // allow all requests (adjust if needed)
    }*/

    public function rules(): array
    {
        return [
            'name' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'string', 'email', 'max:255'],
            'createdAt' => ['nullable', 'date'],
            'createdAtMin' => ['nullable', 'date'],
            'createdAtMax' => ['nullable', 'date'],
            'limit' => ['nullable', 'integer', 'min:1', 'max:100'],
            'page' => ['nullable', 'integer', 'min:1'],
            'sortBy' => ['nullable', 'in:name,email,created_at'],
            'order' => ['nullable', 'in:asc,desc'],
            'q' => ['nullable', 'string'],
        ];
    }
}
