<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'cpf',
        'telefone',
        'tipo_usuario',
        'status',
        'avatar_path',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relacionamento com perfil de candidato (se for tipo 'candidato')
    public function candidato(): HasOne
    {
        return $this->hasOne(Candidato::class);
    }

    // Relacionamento com empresas e portais onde o usuário atua no RH
    public function vinculosRh(): HasMany
    {
        return $this->hasMany(EmpresaUser::class);
    }

    public function tokensSSO(): HasMany
    {
        return $this->hasMany(TokenSSO::class);
    }

    // Helpers de verificação de permissão e tipo
    public function isCandidato(): bool
    {
        return $this->tipo_usuario === 'candidato';
    }

    public function isEmpresa(): bool
    {
        return in_array($this->tipo_usuario, ['empresa', 'empresa_rh']);
    }

    public function isEmpresaRh(): bool
    {
        return in_array($this->tipo_usuario, ['empresa', 'empresa_rh']);
    }

    public function isPrefeituraAdmin(): bool
    {
        return in_array($this->tipo_usuario, ['prefeitura', 'prefeitura_admin']);
    }
    }

    public function isSuperAdmin(): bool
    {
        return $this->tipo_usuario === 'super_admin';
    }
}
