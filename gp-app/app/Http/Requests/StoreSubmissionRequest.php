<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreSubmissionRequest extends FormRequest
{
    /**
     * Authentication is handled by the webhook.token middleware.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Only name and email are required: the theme already enforces those two,
     * and everything else differs between the trial and contact forms. Fields
     * are kept permissive so a valid enquiry is never rejected over formatting.
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:255'],
            'website' => ['nullable', 'string', 'max:255'],
            'company' => ['nullable', 'string', 'max:255'],
            'service' => ['nullable', 'string', 'max:255'],
            'message' => ['nullable', 'string'],
            'file_link' => ['nullable', 'string'],
            'form' => ['nullable', 'string', 'max:255'],
            'source' => ['nullable', 'string', 'max:50'],
            'wp_entry_id' => ['nullable', 'integer'],
            'submitted_at' => ['nullable', 'string', 'max:100'],
            'attachment_url' => ['nullable', 'string'],
            'attachments' => ['nullable', 'array'],
        ];
    }

    /**
     * Always answer the webhook in JSON, even when the caller did not send an
     * Accept header.
     */
    protected function failedValidation(Validator $validator): never
    {
        throw new HttpResponseException(response()->json([
            'ok' => false,
            'error' => 'Validation failed.',
            'errors' => $validator->errors()->toArray(),
        ], 422));
    }
}
