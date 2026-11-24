@extends('layouts.app')

@section('content')
<div class="container py-2">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-dark mb-0">Equipe de Recrutamento (Sub-RHs)</h3>
            <p class="text-muted small mb-0">Gerencie recrutadores, analistas e entrevistadores com níveis de permissão (RBAC).</p>
        </div>
        <a href="{{ route('empresa.dashboard') }}" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left me-1"></i> Painel Geral
        </a>
    </div>

    <div class="row g-4">
        <!-- FORMULÁRIO DE CONVITE -->
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                <h5 class="fw-bold text-dark mb-3"><i class="bi bi-person-plus-fill text-success me-1"></i> Convidar Novo Colaborador</h5>

                <form method="POST" action="{{ route('empresa.equipe.convidar') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="email" class="form-label small fw-semibold text-secondary">E-mail do Colaborador *</label>
                        <input type="email" name="email" id="email" class="form-control" required placeholder="recrutador@empresa.com.br">
                    </div>

                    <div class="mb-4">
                        <label for="role" class="form-label small fw-semibold text-secondary">Nível de Permissão (Papel RBAC) *</label>
                        <select name="role" id="role" class="form-select" required>
                            <option value="recrutador">Recrutador (Visualiza candidatos e move no pipeline)</option>
                            <option value="gestor_vagas">Gestor de Vagas (Publica e edita vagas + candidatos)</option>
                            <option value="entrevistador">Entrevistador (Apenas avalia entrevistas)</option>
                            <option value="admin">Administrador (Controle total da empresa e equipe)</option>
                        </select>
                        <div class="form-text small">O colaborador receberá um convite por e-mail com validade de 7 dias.</div>
                    </div>

                    <button type="submit" class="btn btn-success w-100 py-2 fw-semibold">
                        <i class="bi bi-send-fill me-1"></i> Enviar Convite
                    </button>
                </form>
            </div>
        </div>

        <!-- LISTA DE MEMBROS E CONVITES PENDENTES -->
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
                <h5 class="fw-bold text-dark mb-3"><i class="bi bi-people-fill text-primary me-1"></i> Colaboradores Ativos</h5>

                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Nome / E-mail</th>
                                <th>Papel</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($membros as $membro)
                                <tr>
                                    <td>
                                        <div class="fw-bold text-dark">{{ $membro->user->name }}</div>
                                        <small class="text-muted">{{ $membro->user->email }}</small>
                                    </td>
                                    <td>
                                        <span class="badge bg-primary-subtle text-primary">{{ strtoupper($membro->role) }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-success-subtle text-success">Ativo</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            @if($convites->isNotEmpty())
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                    <h6 class="fw-bold text-dark mb-3"><i class="bi bi-clock-history text-warning me-1"></i> Convites Enviados Pendentes</h6>
                    <ul class="list-group list-group-flush">
                        @foreach($convites as $convite)
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <div>
                                    <strong>{{ $convite->email }}</strong> &bull;
                                    <span class="badge bg-secondary-subtle text-secondary">{{ strtoupper($convite->role) }}</span>
                                </div>
                                <small class="text-muted">Expira em {{ $convite->expira_em->format('d/m/Y') }}</small>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
