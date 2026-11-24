<?php

namespace App\Http\Middleware;

use App\Models\Portal;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

class IdentifyPortal
{
    /**
     * Identifica o portal da prefeitura correspondente ao domínio/host acessado
     * com cache em Redis de alta performance para suportar 1M de acessos.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $host = $request->getHost();

        // 1. Permite simulação/override em desenvolvimento via header ou query string
        $portalSlug = $request->header('X-Portal-Slug') ?? $request->query('portal');

        if ($portalSlug) {
            $portal = Portal::where('slug', $portalSlug)->first();
        } else {
            // 2. Busca pelo domínio cadastrado ou subdomínio (com cache)
            $portal = Portal::findByHost($host);
        }

        // 3. Se for o domínio central de identidade ou fallback local
        if (! $portal) {
            // Pode ser o primeiro portal padrão ou o contexto central
            $portal = Portal::first();
        }

        if ($portal) {
            // Verifica se a licença da prefeitura está ativa
            if (! $portal->isAtivo()) {
                return response()->view('errors.portal-bloqueado', ['portal' => $portal], 403);
            }

            // Injeta o portal no container e nas views
            app()->instance('portal', $portal);
            View::share('portalAtual', $portal);
        }

        return $next($request);
    }
}
