<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class DifferentCategoryIdRule implements ValidationRule
{
    private object $category;

    public function __construct(object $category)
    {
        $this->category = $category;
    }

    /**
     * Run the validation rule.
     *
     * @param string $attribute
     * @param mixed $value
     * @param Closure $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($this->category->id === (int)$value) {
            $fail("The {$attribute} must be different from the current category ID.");
        }
    }
}
