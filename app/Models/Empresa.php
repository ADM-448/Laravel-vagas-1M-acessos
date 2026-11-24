<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Empresa extends Model
{
    use HasFactory;

    protected $table = 'empresas';

    protected $fillable = [
        'cnpj',
        'razao_social',
        'nome_fantasia',
        'situacao_cadastral',
        'consulta_receita_at',
        'ramo_atividade',
        'descricao',
        'site',
        'logo_path',
        'telefone',
        'email_contato',
        'cep',
        'logradouro',
        'numero',
        'complemento',
        'bairro',
        'cidade',
        'estado',
        'latitude',
        'longitude',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'consulta_receita_at' => 'datetime',
            'latitude' => 'decimal:7',
            'longitude' => 'decimal:7',
        ];
    }

    public function portais(): BelongsToMany
    {
        return $this->belongsToMany(Portal::class, 'empresa_portal')
            ->withPivot(['status_moderacao', 'moderado_por', 'moderado_em', 'motivo_rejeicao'])
            ->withTimestamps();
    }

    public function vagas(): HasMany
    {
        return $this->hasMany(Vaga::class);
    }

    public function colaboradores(): HasMany
    {
        return $this->hasMany(EmpresaUser::class);
    }

    public function convites(): HasMany
    {
        return $this->hasMany(ConviteEquipe::class);
    }

    public function isAtiva(): bool
    {
        return $this->status === 'ativo' && $this->situacao_cadastral === 'ATIVA';
    }
}
