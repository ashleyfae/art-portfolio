<?php

namespace App\Http\Requests;

class UpdateArtworkRequest extends StoreArtworkRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user() && auth()->user()->can('update', $this->route('artwork'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $rules = parent::rules();

        $imageRules = $rules['images.*.image'];
        $requiredKey = array_search('required', $imageRules);
        if ($requiredKey !== false) {
            unset($imageRules[$requiredKey]);
        }

        $rules['images.*.image'] = $imageRules;

        return $rules;
    }
}
