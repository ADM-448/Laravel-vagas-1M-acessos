<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmpresaUser extends Model
{
    use HasFactory;

    protected $table = 'empresa_user';

    protected $fillable = [
        'user_id',
        'empresa_id',
        'portal_id',
        'role',
        'status',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function empresa(): BelongsTo
    {
        return $this->belongsTo(Empresa::class);
    }

    public function portal(): BelongsTo
    {
        return $this->belongsTo(Portal::class);
    }

    // Permissões RBAC
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function canManageVagas(): bool
    {
        return in_array($this->role, ['admin', 'gestor_vagas']);
    }

    public function canInteractCandidates(): bool
    {
        return in_array($this->role, ['admin', 'gestor_vagas', 'recrutador']);
    }
}
