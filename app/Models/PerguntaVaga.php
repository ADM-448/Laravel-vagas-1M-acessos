<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PerguntaVaga extends Model
{
    use HasFactory;

    protected $table = 'perguntas_vaga';

    protected $fillable = [
        'vaga_id',
        'pergunta',
        'tipo_resposta',
        'opcoes',
        'obrigatoria',
        'resposta_eliminatoria',
        'ordem',
    ];

    protected function casts(): array
    {
        return [
            'opcoes' => 'array',
            'obrigatoria' => 'boolean',
        ];
    }

    public function vaga(): BelongsTo
    {
        return $this->belongsTo(Vaga::class);
    }
}
