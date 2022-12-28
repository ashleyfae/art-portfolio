<?php

namespace App\Http\Requests;

use App\Models\Artwork;
use App\Rules\CategoryIdOrNameRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreArtworkRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user() && auth()->user()->can('create', Artwork::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'images.*.image' => ['required', 'image', 'max:10000'],
            'images.*.title' => ['nullable', 'string', 'max:255'],
            'images.*.description' => ['nullable', 'string', 'max:10000'],
            'images.*.alt_text' => ['nullable', 'string', 'max:1000'],
            'images.*.primary' => ['nullable', 'boolean'],
            'images.*.id' => ['nullable', 'exists:images,id'],
            'is_featured' => ['nullable', 'boolean'],
            'published_at' => ['required', 'date'],
            'categories' => ['nullable', 'array'],
            'categories.*' => [new CategoryIdOrNameRule()],
        ];
    }
}
