<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ConversaChat extends Model
{
    use HasFactory;

    protected $table = 'conversas_chat';

    protected $fillable = [
        'vaga_id',
        'candidatura_id',
        'empresa_id',
        'candidato_id',
        'ultima_mensagem_em',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'ultima_mensagem_em' => 'datetime',
        ];
    }

    public function vaga(): BelongsTo
    {
        return $this->belongsTo(Vaga::class);
    }

    public function candidatura(): BelongsTo
    {
        return $this->belongsTo(Candidatura::class);
    }

    public function empresa(): BelongsTo
    {
        return $this->belongsTo(Empresa::class);
    }

    public function candidato(): BelongsTo
    {
        return $this->belongsTo(Candidato::class);
    }

    public function mensagens(): HasMany
    {
        return $this->hasMany(MensagemChat::class, 'conversa_id')->orderBy('created_at');
    }
}
