<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Candidato extends Model
{
    use HasFactory;

    protected $table = 'candidatos';

    protected $fillable = [
        'user_id',
        'data_nascimento',
        'genero',
        'pcd',
        'pcd_detalhes',
        'resumo_profissional',
        'pretensao_salarial',
        'cep',
        'logradouro',
        'numero',
        'bairro',
        'cidade',
        'estado',
        'latitude',
        'longitude',
        'curriculo_pdf_path',
        'linkedin_url',
        'portfolio_url',
        'disponibilidade',
        'visivel_banco_talentos',
    ];

    protected function casts(): array
    {
        return [
            'data_nascimento' => 'date',
            'pcd' => 'boolean',
            'visivel_banco_talentos' => 'boolean',
            'latitude' => 'decimal:7',
            'longitude' => 'decimal:7',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function experiencias(): HasMany
    {
        return $this->hasMany(ExperienciaProfissional::class)->orderByDesc('data_inicio');
    }

    public function formacoes(): HasMany
    {
        return $this->hasMany(FormacaoAcademica::class)->orderByDesc('data_inicio');
    }

    public function cursos(): HasMany
    {
        return $this->hasMany(CursoHabilidade::class);
    }

    public function candidaturas(): HasMany
    {
        return $this->hasMany(Candidatura::class);
    }
}
