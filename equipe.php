<?php
session_start();
if (!isset($_SESSION['nome'])) {
    header("Location: index.php");
    exit;
}

$nomeUsuario = $_SESSION['nome'];
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Equipe</title>
    <link rel="shortcut icon" href="../img/favicon.ico" type="image/x-icon">
    <link rel="icon" type="png" href="../img/logo-oficial.png">
    <link rel="stylesheet" href="../style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.css">
    <style>
        main {
            margin-left: calc(200px + 5vw);
            padding: 2rem;
        }

        .titulo-e-select {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            margin-bottom: 1.5rem;
        }

        .select-container {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .select-container select {
            width: 180px;
        }

        .card-icon {
            font-size: 5rem;
            color: #6c757d;
            margin-top: 1rem;
        }

        .card-text {
            margin-top: 0.5rem;
        }

        .card-message {
            margin-top: 0.5rem;
            color: #0d6efd;
            cursor: pointer;
            font-size: 1.2rem;
            transition: color 0.2s;
            display: inline-block;
        }

        .card-message:hover {
            color: #0a58ca;
        }

        /* Card do usuário logado em destaque */
        .card-user {
            border: 2px solid #0d6efd;
        }

        /* Select dentro do card */
        .card-user select {
            margin-top: 0.5rem;
        }
    </style>
</head>

<body>
    <?php
    $selected = 'equipe';
    include_once '../estruturas/sidebar/sidebar.php';
    ?>

    <main>
        <div class="titulo-e-select">
            <h2 class="fw-semibold mb-2 mb-md-0 mt-3">Aqui está a sua equipe</h2>
            <div class="select-container mt-3">
                <span>Filtros:</span>
                <select class="form-select form-select-sm">
                    <option value="">Todos</option>
                    <option value="">Conversas Recentes</option>
                    <option value="">On-line</option>
                    <option value="">Ordem Alfabética</option>
                </select>
            </div>
        </div>

        <!-- Cards da equipe -->
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">

            <!-- Card do usuário logado -->
            <div class="col">
                <div class="card h-100 text-center card-user">
                    <i class="bi bi-person-circle card-icon"></i>
                    <div class="card-body">
                        <p class="card-text"><strong>@<?= htmlspecialchars($nomeUsuario) ?></strong></p>
                        
                        <!-- Select dentro do card do usuário -->
                        <div class="mt-2">
                            <select class="form-select form-select-sm">
                                <option value="">On-line</option>
                                <option value="">Ausente</option>
                                <option value="">Não Pertube</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Outros membros -->
            <?php for ($i = 1; $i <= 15; $i++): ?>
                <div class="col">
                    <div class="card h-100 text-center">
                        <i class="bi bi-person-circle card-icon"></i>
                        <div class="card-body">
                            <p class="card-text"><strong>Membro <?= $i ?></strong></p>
                            <a href="mensagens.php>" class="card-message" title="Enviar mensagem">
                                <i class="bi bi-chat-dots"></i>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endfor; ?>

        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
