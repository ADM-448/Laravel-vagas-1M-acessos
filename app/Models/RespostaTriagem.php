<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RespostaTriagem extends Model
{
    use HasFactory;

    protected $table = 'respostas_triagem';

    protected $fillable = [
        'candidatura_id',
        'pergunta_vaga_id',
        'resposta',
        'reprovou_eliminatoria',
    ];

    protected function casts(): array
    {
        return [
            'reprovou_eliminatoria' => 'boolean',
        ];
    }

    public function candidatura(): BelongsTo
    {
        return $this->belongsTo(Candidatura::class);
    }

    public function pergunta(): BelongsTo
    {
        return $this->belongsTo(PerguntaVaga::class, 'pergunta_vaga_id');
    }
}
