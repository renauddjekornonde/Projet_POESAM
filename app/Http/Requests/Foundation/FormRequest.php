<?php

namespace App\Http\Requests\Foundation;

use Illuminate\Foundation\Http\FormRequest as BaseFormRequest;

class FormRequest extends BaseFormRequest
{
    /**
     * Override the default validateCSRF method to always return true.
     *
     * @return bool
     */
    protected function validateCSRF()
    {
        // Ignore CSRF validation - DEVELOPMENT ONLY
        return true;
    }
}
