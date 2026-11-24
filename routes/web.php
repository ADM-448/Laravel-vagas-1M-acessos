<?php

use App\Http\Controllers\CandidatoController;
use App\Http\Controllers\EmpresaController;
use App\Models\Portal;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Módulo 0: Página Inicial (Hub Central da Plataforma)
Route::get('/', function () {
    $portais = Portal::where('status_licenca', 'ativa')
        ->orderBy('cidade')
        ->get();

    return view('welcome', [
        'portais' => $portais,
    ]);
})->name('home');

// Módulo 1: Portal do Candidato (Público)
Route::get('/candidato/cadastro', [CandidatoController::class, 'create'])->name('candidato.cadastro');
Route::post('/candidato/cadastro', [CandidatoController::class, 'store'])->name('candidato.cadastro.post');
Route::get('/candidato/login', [CandidatoController::class, 'showLogin'])->name('candidato.login');
Route::post('/candidato/login', [CandidatoController::class, 'login'])->name('candidato.login.post');

// Módulo 2: Portal da Empresa (Público)
Route::get('/empresa/cadastro', [EmpresaController::class, 'create'])->name('empresa.cadastro');
Route::post('/empresa/cadastro', [EmpresaController::class, 'store'])->name('empresa.cadastro.post');
Route::get('/empresa/consultar-cnpj/{cnpj}', [EmpresaController::class, 'consultarCnpj'])->name('empresa.consultar.cnpj');
Route::get('/empresa/login', [EmpresaController::class, 'login'])->name('empresa.login');
Route::post('/empresa/login', [EmpresaController::class, 'authenticate'])->name('empresa.login.post');

// Rotas de Verificação de E-mail (MustVerifyEmail)
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (\Illuminate\Foundation\Auth\EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect()->route('candidato.curriculo')->with('success', 'E-mail confirmado com sucesso!');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (\Illuminate\Http\Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('success', 'Link de verificação reenviado!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

// Logout Global
Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect()->route('home')->with('success', 'Você saiu da sua conta.');
})->name('logout');

// Rotas Autenticadas
Route::middleware(['auth'])->group(function () {
    // Módulo 1: Candidato (Área Restrita)
    Route::get('/candidato/meu-curriculo', [CandidatoController::class, 'curriculo'])->name('candidato.curriculo');
    Route::put('/candidato/dados', [CandidatoController::class, 'updateDados'])->name('candidato.dados.update');
    
    // Experiências Profissionais
    Route::post('/candidato/experiencias', [CandidatoController::class, 'addExperiencia'])->name('candidato.experiencia.add');
    Route::delete('/candidato/experiencias/{id}', [CandidatoController::class, 'deleteExperiencia'])->name('candidato.experiencia.delete');

    // Formações Acadêmicas
    Route::post('/candidato/formacoes', [CandidatoController::class, 'addFormacao'])->name('candidato.formacao.add');
    Route::delete('/candidato/formacoes/{id}', [CandidatoController::class, 'deleteFormacao'])->name('candidato.formacao.delete');

    // Cursos e Certificações
    Route::post('/candidato/cursos', [CandidatoController::class, 'addCurso'])->name('candidato.curso.add');
    Route::delete('/candidato/cursos/{id}', [CandidatoController::class, 'deleteCurso'])->name('candidato.curso.delete');

    // Minhas Candidaturas
    Route::get('/candidato/minhas-candidaturas', [CandidatoController::class, 'candidaturas'])->name('candidato.candidaturas');

    // Módulo 2: Empresa (Área Restrita)
    Route::get('/empresa/dashboard', [EmpresaController::class, 'dashboard'])->name('empresa.dashboard');
    Route::get('/empresa/vagas', [EmpresaController::class, 'vagas'])->name('empresa.vagas');
    Route::get('/empresa/vagas/nova', [EmpresaController::class, 'novaVaga'])->name('empresa.vagas.create');
    Route::post('/empresa/vagas', [EmpresaController::class, 'salvarVaga'])->name('empresa.vagas.store');
    Route::get('/empresa/vagas/{vaga}/candidatos', [EmpresaController::class, 'vagaCandidatos'])->name('empresa.vagas.candidatos');
    Route::post('/empresa/candidaturas/{candidatura}/etapa', [EmpresaController::class, 'atualizarEtapaCandidatura'])->name('empresa.candidaturas.etapa');
    Route::get('/empresa/equipe', [EmpresaController::class, 'equipe'])->name('empresa.equipe');
    Route::post('/empresa/equipe/convidar', [EmpresaController::class, 'convidarMembro'])->name('empresa.equipe.convidar');
});

