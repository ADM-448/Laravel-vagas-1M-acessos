<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class EmpresaPortal extends Pivot
{
    protected $table = 'empresa_portal';

    protected $fillable = [
        'empresa_id',
        'portal_id',
        'status_moderacao',
        'moderado_por',
        'moderado_em',
        'motivo_rejeicao',
    ];

    protected function casts(): array
    {
        return [
            'moderado_em' => 'datetime',
        ];
    }
}
