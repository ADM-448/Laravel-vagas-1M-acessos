<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Temporariamente Indisponível</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center justify-content-center min-vh-100">
    <div class="text-center p-4">
        <h1 class="display-4 fw-bold text-dark">Portal Temporariamente Indisponível</h1>
        <p class="lead text-muted">A licença do portal {{ $portal->nome ?? '' }} encontra-se suspensa ou em manutenção.</p>
        <p class="text-secondary small">Entre em contato com o suporte ou com a gestão municipal para regularização.</p>
    </div>
</body>
</html>
