<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ConviteEquipe extends Model
{
    use HasFactory;

    protected $table = 'convites_equipe';

    protected $fillable = [
        'empresa_id',
        'portal_id',
        'convidado_por',
        'email',
        'role',
        'token',
        'expira_em',
        'aceito_em',
    ];

    protected function casts(): array
    {
        return [
            'expira_em' => 'datetime',
            'aceito_em' => 'datetime',
        ];
    }

    public function empresa(): BelongsTo
    {
        return $this->belongsTo(Empresa::class);
    }

    public function portal(): BelongsTo
    {
        return $this->belongsTo(Portal::class);
    }

    public function quemConvidou(): BelongsTo
    {
        return $this->belongsTo(User::class, 'convidado_por');
    }

    public function isValido(): bool
    {
        return is_null($this->aceito_em) && $this->expira_em->isFuture();
    }
}
