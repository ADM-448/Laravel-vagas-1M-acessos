<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CelularWhatsapp implements ValidationRule
{
    /**
     * Valida celular/WhatsApp brasileiro:
     * - Formato: (XX) 9XXXX-XXXX
     * - Exatamente 11 dígitos numéricos
     * - 3º dígito obrigatoriamente 9
     * - Não permite repetições falsas (ex: 11999999999, 11111111111)
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $tel = preg_replace('/\D/', '', (string) $value);

        if (empty($tel)) {
            return; // Se for opcional e estiver vazio, passa (se required for usado, required pega)
        }

        // Deve ter exatamente 11 dígitos (DDD + 9 dígitos)
        if (strlen($tel) !== 11) {
            $fail('O número de Celular/WhatsApp deve conter DDD + 9 dígitos. Ex: (13) 98765-4321.');
            return;
        }

        // O terceiro dígito obrigatoriamente tem que ser 9 no Brasil
        if ($tel[2] !== '9') {
            $fail('O número de celular deve iniciar com o dígito 9 após o DDD.');
            return;
        }

        // Bloqueia números sequenciais ou todos repetidos (ex: 11911111111, 11999999999)
        if (preg_match('/^(\d)\1{10}$/', $tel) || preg_match('/^\d{2}9(\d)\1{7}$/', $tel)) {
            $fail('Informe um número de Celular/WhatsApp válido.');
            return;
        }

        // Lista de DDDs válidos no Brasil
        $dddsValidos = [
            11, 12, 13, 14, 15, 16, 17, 18, 19, // SP
            21, 22, 24,                         // RJ
            27, 28,                             // ES
            31, 32, 33, 34, 35, 37, 38,         // MG
            41, 42, 43, 44, 45, 46,             // PR
            47, 48, 49,                         // SC
            51, 53, 54, 55,                     // RS
            61,                                 // DF
            62, 64,                             // GO
            63,                                 // TO
            65, 66,                             // MT
            67,                                 // MS
            68,                                 // AC
            69,                                 // RO
            71, 73, 74, 75, 77,                 // BA
            79,                                 // SE
            81, 87,                             // PE
            82,                                 // AL
            83,                                 // PB
            84,                                 // RN
            85, 88,                             // CE
            86, 89,                             // PI
            91, 93, 94,                         // PA
            92, 97,                             // AM
            95,                                 // RR
            96,                                 // AP
            98, 99                              // MA
        ];

        $ddd = (int) substr($tel, 0, 2);
        if (! in_array($ddd, $dddsValidos)) {
            $fail('O DDD informado (' . $ddd . ') não é válido no Brasil.');
        }
    }
}
