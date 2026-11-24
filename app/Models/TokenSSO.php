<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class TokenSSO extends Model
{
    use HasFactory;

    protected $table = 'tokens_sso';

    protected $fillable = [
        'user_id',
        'portal_id',
        'token',
        'target_url',
        'expira_em',
        'utilizado',
    ];

    protected function casts(): array
    {
        return [
            'expira_em' => 'datetime',
            'utilizado' => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function portal(): BelongsTo
    {
        return $this->belongsTo(Portal::class);
    }

    /**
     * Gera um token de uso único com expiração de 60 segundos
     */
    public static function gerarPara(User $user, ?Portal $portal = null, ?string $targetUrl = null): self
    {
        return self::create([
            'user_id' => $user->id,
            'portal_id' => $portal?->id,
            'token' => Str::random(64),
            'target_url' => $targetUrl,
            'expira_em' => now()->addSeconds(60),
            'utilizado' => false,
        ]);
    }

    /**
     * Valida e consome o token atomicamente
     */
    public static function consumir(string $token): ?User
    {
        $registro = self::where('token', $token)
            ->where('utilizado', false)
            ->where('expira_em', '>', now())
            ->first();

        if (! $registro) {
            return null;
        }

        $registro->update(['utilizado' => true]);

        return $registro->user;
    }
}
