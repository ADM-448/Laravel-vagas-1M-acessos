<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Cache;

class Portal extends Model
{
    use HasFactory;

    protected $table = 'portais';

    protected $fillable = [
        'nome',
        'slug',
        'dominio_principal',
        'subdominio',
        'cidade',
        'estado',
        'ibge_code',
        'logo_url',
        'brasao_url',
        'cor_primaria',
        'cor_secundaria',
        'status_licenca',
        'licenca_expira_em',
        'exige_aprovacao_empresa',
        'configuracoes',
    ];

    protected function casts(): array
    {
        return [
            'licenca_expira_em' => 'date',
            'exige_aprovacao_empresa' => 'boolean',
            'configuracoes' => 'array',
        ];
    }

    public function vagas(): HasMany
    {
        return $this->hasMany(Vaga::class, 'portal_id');
    }

    public function empresas(): BelongsToMany
    {
        return $this->belongsToMany(Empresa::class, 'empresa_portal')
            ->withPivot(['status_moderacao', 'moderado_por', 'moderado_em', 'motivo_rejeicao'])
            ->withTimestamps();
    }

    public function equipe(): HasMany
    {
        return $this->hasMany(EmpresaUser::class, 'portal_id');
    }

    public function isAtivo(): bool
    {
        return $this->status_licenca === 'ativa' || $this->status_licenca === 'degustacao';
    }

    /**
     * Busca o portal pelo Host da requisição com cache Redis de 24h
     */
    public static function findByHost(string $host): ?self
    {
        $cleanHost = strtolower(trim($host));

        return Cache::remember("portal:host:{$cleanHost}", 86400, function () use ($cleanHost) {
            return self::where('dominio_principal', $cleanHost)
                ->orWhere('subdominio', explode('.', $cleanHost)[0])
                ->first();
        });
    }
}
