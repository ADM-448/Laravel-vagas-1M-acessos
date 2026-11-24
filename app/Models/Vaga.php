<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Redis;

class Vaga extends Model
{
    use HasFactory;

    protected $table = 'vagas';

    protected $fillable = [
        'portal_id',
        'empresa_id',
        'recrutador_id',
        'titulo',
        'slug',
        'descricao',
        'requisitos',
        'beneficios',
        'experiencia',
        'escolaridade_minima',
        'faixa_salarial_min',
        'faixa_salarial_max',
        'salario_a_combinar',
        'tipo_contrato',
        'modalidade',
        'pcd',
        'cep',
        'bairro',
        'cidade',
        'estado',
        'latitude',
        'longitude',
        'confidencial',
        'status',
        'destaque',
        'visualizacoes_count',
        'candidaturas_count',
        'publicada_em',
        'encerra_em',
    ];

    protected function casts(): array
    {
        return [
            'salario_a_combinar' => 'boolean',
            'confidencial' => 'boolean',
            'destaque' => 'boolean',
            'latitude' => 'decimal:7',
            'longitude' => 'decimal:7',
            'publicada_em' => 'datetime',
            'encerra_em' => 'datetime',
        ];
    }

    public function portal(): BelongsTo
    {
        return $this->belongsTo(Portal::class);
    }

    public function empresa(): BelongsTo
    {
        return $this->belongsTo(Empresa::class);
    }

    public function recrutador(): BelongsTo
    {
        return $this->belongsTo(User::class, 'recrutador_id');
    }

    public function perguntas(): HasMany
    {
        return $this->hasMany(PerguntaVaga::class)->orderBy('ordem');
    }

    public function candidaturas(): HasMany
    {
        return $this->hasMany(Candidatura::class);
    }

    // Scopes de Alta Performance
    public function scopePublicadas(Builder $query): Builder
    {
        return $query->where('status', 'publicada');
    }

    public function scopeDoPortal(Builder $query, int $portalId): Builder
    {
        return $query->where('portal_id', $portalId);
    }

    public function scopeModalidade(Builder $query, ?string $modalidade): Builder
    {
        if ($modalidade) {
            return $query->where('modalidade', $modalidade);
        }
        return $query;
    }

    /**
     * Incrementa visualizações em lote via Redis para suportar 1M de acessos sem travar o banco
     */
    public function registrarVisualizacaoAssincrona(): void
    {
        try {
            Redis::incr("vaga:views:{$this->id}");
        } catch (\Throwable) {
            // Fallback gracioso caso Redis esteja temporariamente fora
            $this->incrementQuietly('visualizacoes_count');
        }
    }
}
