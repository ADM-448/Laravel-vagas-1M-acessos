<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Candidatura extends Model
{
    use HasFactory;

    protected $table = 'candidaturas';

    protected $fillable = [
        'vaga_id',
        'candidato_id',
        'etapa_pipeline',
        'score_compatibilidade',
        'feedback_recrutador',
        'motivo_reprovacao',
        'visualizado_em',
    ];

    protected function casts(): array
    {
        return [
            'visualizado_em' => 'datetime',
        ];
    }

    public function vaga(): BelongsTo
    {
        return $this->belongsTo(Vaga::class);
    }

    public function candidato(): BelongsTo
    {
        return $this->belongsTo(Candidato::class);
    }

    public function respostas(): HasMany
    {
        return $this->hasMany(RespostaTriagem::class);
    }
}
