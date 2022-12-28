<?php

namespace App\Rules;

use App\Models\Category;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CategoryIdOrNameRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return is_numeric($value) ? $this->isValidCategoryId($value) : $this->isValidCategoryName($value);
    }

    protected function isValidCategoryId(mixed $value): bool
    {
        try {
            /** @var Category $category */
            $category = Category::findOrFail($value);

            return $category->exists();
        } catch(ModelNotFoundException $e) {
            return false;
        }
    }

    protected function isValidCategoryName(mixed $value): bool
    {
        return is_string($value) && strlen($value) <= 500;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Must be a valid category ID or name.';
    }
}
