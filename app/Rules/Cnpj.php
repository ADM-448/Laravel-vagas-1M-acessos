<?php

namespace App\Rules;

use App\Services\EmpresaValidationService;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class Cnpj implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! EmpresaValidationService::validarDigitosCnpj((string) $value)) {
            $fail('O CNPJ informado é inválido.');
        }
    }
}
