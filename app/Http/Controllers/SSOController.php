<?php

namespace App\Http\Controllers;

use App\Models\Portal;
use App\Models\TokenSSO;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class SSOController extends Controller
{
    /**
     * Exibe a tela de login unificada (IntalenTi ID)
     * Pode receber ?portal=santos para estilizar com o brasão da cidade
     */
    public function showLogin(Request $request): View|RedirectResponse
    {
        $portalSlug = $request->query('portal');
        $portal = $portalSlug ? Portal::where('slug', $portalSlug)->first() : (app()->bound('portal') ? app('portal') : null);
        $returnTo = $request->query('return_to', '/vagas');

        // Se o usuário já está logado na central, faz o handshake instantâneo
        if (Auth::check()) {
            return $this->gerarHandshake(Auth::user(), $portal, $returnTo);
        }

        return view('auth.sso-login', [
            'portal' => $portal,
            'returnTo' => $returnTo,
        ]);
    }

    /**
     * Processa a autenticação unificada
     */
    public function authenticate(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $portalSlug = $request->input('portal');
        $portal = $portalSlug ? Portal::where('slug', $portalSlug)->first() : null;
        $returnTo = $request->input('return_to', '/vagas');

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()->withErrors([
                'email' => 'As credenciais informadas não coincidem com nossos registros.',
            ])->onlyInput('email');
        }

        $request->session()->regenerate();
        $user = Auth::user();

        return $this->gerarHandshake($user, $portal, $returnTo);
    }

    /**
     * Endpoint no portal da prefeitura que consome o Token de SSO e inicia a sessão local
     */
    public function consumeCallback(Request $request): RedirectResponse
    {
        $token = $request->query('token');

        if (! $token) {
            return redirect('/login')->withErrors(['error' => 'Token de autenticação não fornecido.']);
        }

        $user = TokenSSO::consumir($token);

        if (! $user) {
            return redirect('/login')->withErrors(['error' => 'Token expirado ou inválido. Faça login novamente.']);
        }

        Auth::login($user, true);
        $request->session()->regenerate();

        $targetUrl = $request->query('return_to', '/vagas');
        return redirect()->intended($targetUrl);
    }

    /**
     * Desconecta o usuário
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/vagas');
    }

    /**
     * Gera o token temporário e redireciona para o callback do portal
     */
    private function gerarHandshake(User $user, ?Portal $portal, string $returnTo): RedirectResponse
    {
        $ssoToken = TokenSSO::gerarPara($user, $portal, $returnTo);

        // Se o portal tiver domínio principal configurado (ex: vagas.santos.sp.gov.br)
        if ($portal && $portal->dominio_principal && $portal->dominio_principal !== request()->getHost()) {
            $scheme = request()->getScheme();
            $urlDestino = "{$scheme}://{$portal->dominio_principal}/sso/callback?token={$ssoToken->token}&return_to=" . urlencode($returnTo);
            return redirect()->away($urlDestino);
        }

        // Em ambiente local de desenvolvimento ou mesmo domínio
        return redirect()->route('sso.callback', [
            'token' => $ssoToken->token,
            'return_to' => $returnTo,
        ]);
    }
}
