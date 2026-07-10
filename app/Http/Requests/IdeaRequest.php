<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\IdeaStatus;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class IdeaRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'status' => ['required', Rule::enum(IdeaStatus::class)],
            'links' => ['nullable', 'array'],
            'links.*' => ['nullable', 'string', 'regex:/^https?:\/\//', 'max:255'],
            'steps' => ['nullable', 'array'],
            'steps.*.description' => ['string', 'max:255'],
            'steps.*.completed' => ['boolean'],
            'image' => ['nullable', 'image', 'max:5120'],

            // Solution for testing form without (enctype="multipart/form-data) issues.
            // Replace image with the following:
            /* 'image' => [
                'nullable',
                function ($value, $fail) { // Validator for Base64 image
                    if (is_string($value) && str_starts_with($value, 'data:image')) {
                        if (strlen($value) > 7000000) {
                            $fail('The image is too large.');
                        }
                    }
                }
            ], */
        ];
    }
}
