<?php
session_start();
if (!isset($_SESSION['nome'])) {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minha Loja</title>
    <link rel="shortcut icon" href="../img/favicon.ico" type="image/x-icon">
    <link rel="icon" type="png" href="../img/logo-oficial.png">
    <link rel="stylesheet" href="../style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <style>
        main {
            margin-left: calc(200px + 5vw);
            padding: 2rem;
        }

        #foto-edit-icon {
            width: 35px;
            height: 35px;
            cursor: pointer;
            position: absolute;
            top: 50%;
            right: -15px;
            transform: translateY(-50%);
        }

        #sobre-input:read-only {
            background-color: #f8f9fa;
            cursor: default;
        }

        #sobre-input.border-primary {
            border-width: 2px;
        }

        .titulo-e-botao {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: nowrap;
            margin-bottom: 1.5rem;
        }

        .botoes-acoes {
            display: flex;
            gap: 0.5rem;
        }

        /* Garantir que os botões fiquem iguais ao do config */
        .botoes-acoes .btn {
            height: 38px;
            /* ajuste para igualar */
            padding: 0 1rem;
            font-size: 0.875rem;
        }

        /* Carrossel menor */
        .carousel-inner img {
            height: 200px;
            object-fit: cover;
            border-radius: 12px;
        }
    </style>
</head>

<body>
    <?php
    $selected = 'loja';
    include_once '../estruturas/sidebar/sidebar.php';
    ?>

    <main>

        <div class="titulo-e-botao">
            <h2 class="fw-semibold mb-2 mb-md-0 mt-3">Minha Loja</h2>
            <div class="botoes-acoes">
                <button class="btn btn-dark d-flex align-items-center gap-1" id="edit-btn">
                    <i class="bi bi-pencil-fill"></i>
                    <span>Editar</span>
                </button>
                <button class="btn btn-success d-flex align-items-center gap-1 d-none" id="save-btn">
                    <i class="bi bi-check-lg"></i>
                    <span>Salvar</span>
                </button>
                <button class="btn btn-danger d-flex align-items-center gap-1 d-none" id="cancel-btn">
                    <i class="bi bi-x-lg"></i>
                    <span>Cancelar</span>
                </button>
            </div>
        </div>

        <!-- Linha do perfil -->
        <div class="d-flex align-items-center gap-3 mt-3 position-relative flex-wrap">
            <div class="position-relative">
                <img src="../img/logo-fahren-bg.jpg" id="perfil-foto" class="rounded-circle"
                    style="width: 120px; height: 120px; object-fit: cover;">
                <input type="file" id="file" accept="image/*" class="d-none">
                <label for="file" id="foto-edit-icon"
                    class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center d-none">
                    <i class="bi bi-pencil-fill"></i>
                </label>
            </div>
            <div>
                <h3 class="fw-bold mb-1">@loja_fahren</h3>
                <div class="d-flex gap-4 text-muted small">
                    <span><strong>Data da criação:</strong> <span class="fw-medium">14/09/2025</span></span>
                    <span><strong>Seguidores:</strong> <span class="fw-medium">12</span></span>
                </div>
            </div>
        </div>

        <!-- Sobre a loja -->
        <div class="mt-4">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <div class="text-muted small">Diga algo sobre a sua Loja:</div>
                <div class="text-muted small">
                    <span id="char-count" class="text-muted">0</span>/250 caracteres
                </div>
            </div>
            <div class="row g-2 align-items-center">
                <div class="col">
                    <input type="text" id="sobre-input" readonly class="form-control shadow-sm"
                        placeholder="Escreva algo sobre você..." maxlength="250">
                </div>
            </div>
        </div>
        <hr class="my-4">

        <div class="mb- d-flex flex-wrap gap-2">
            <input type="radio" class="btn-check" name="telas" id="tela-1" autocomplete="off" checked>
            <label class="btn btn-outline-dark w-auto rounded-pill px-3 shadow-sm" for="tela-1">Lojas</label>
            <input type="radio" class="btn-check" name="telas" id="tela-2" autocomplete="off">
            <label class="btn btn-outline-dark w-auto rounded-pill px-3 shadow-sm" for="tela-2">Endereço</label>
            <input type="radio" class="btn-check" name="telas" id="tela-3" autocomplete="off">
            <label class="btn btn-outline-dark w-auto rounded-pill px-3 shadow-sm" for="tela-3">Funcionamento</label>
            <input type="radio" class="btn-check" name="telas" id="tela-4" autocomplete="off">
            <label class="btn btn-outline-dark w-auto rounded-pill px-3 shadow-sm" for="tela-4">Formas de
                pagamento</label>
        </div>

        <div class="mt-3">
            <h5 class="fw-semibold mb-3">Anúncios recentes das lojas que @<?= $_SESSION['nome'] ?> participa</h5>
            <div id="miniCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="../img/banner/carousel-4.png" class="d-block w-100" alt="Produto 1">
                    </div>
                    <div class="carousel-item">
                        <img src="../img/banner/carousel-5.png" class="d-block w-100" alt="Produto 2">
                    </div>
                    <div class="carousel-item">
                        <img src="../img/banner/carousel-6.png" class="d-block w-100" alt="Produto 3">
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#miniCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#miniCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon"></span>
                </button>
            </div>
        </div>
        <hr class="my-4">
    </main>

    <?php include '../estruturas/alert/alert.php' ?>
    <main class="container-fluid d-flex vh-100 p-0 mt-4">
        <?php $selected = 'loja';
        include_once '../estruturas/sidebar/sidebar.php' ?>
        <div class="col d-flex" style="margin-left: calc(200px + 5vw);">
            <div class="container p-5 d-flex justify-content-center align-items-center flex-grow-1">
                <div class="card p-3 w-100">
                    <div class="card-body">
                        <div class="mb-5">
                            <label for="exampleFormControlInput1" class="form-label">Suas lojas</label>
                            <input type="text" class="form-control" id="exampleFormControlInput1"
                                placeholder="Procure as lojas que você está participando">
                        </div>
                        <ul class="list-group list-group-flush flex-grow-1 overflow-y-auto">
                            <?php
                            $quantidade = 10;
                            for ($i = 1; $i <= $quantidade; $i++): ?>
                                <li class="list-group-item d-flex align-items-center gap-3">
                                    <div class="col-auto flex-shrink-0">
                                        <div class="ratio ratio-1x1" style="width: calc(30px + .5vw);">
                                            <img src="../img/logo-fahren-bg.jpg" class="img-fluid rounded-circle"
                                                alt="Avatar">
                                        </div>
                                    </div>
                                    <div
                                        class="flex-grow-1 overflow-hidden d-flex justify-content-between align-items-center">
                                        <h6 class="mb-1 me-2 text-truncate">Loja</h6>
                                        <span><i class="bi bi-chevron-right"></i></span>
                                    </div>
                                </li>
                            <?php endfor; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const editBtn = document.getElementById('edit-btn');
        const saveBtn = document.getElementById('save-btn');
        const cancelBtn = document.getElementById('cancel-btn');
        const fotoEditIcon = document.getElementById('foto-edit-icon');
        const sobreInput = document.getElementById('sobre-input');
        const charCount = document.getElementById('char-count');

        // Ativar edição
        editBtn.addEventListener('click', () => {
            sobreInput.readOnly = false;
            sobreInput.classList.add('border', 'border-primary');
            fotoEditIcon.classList.remove('d-none');
            editBtn.classList.add('d-none');
            saveBtn.classList.remove('d-none');
            cancelBtn.classList.remove('d-none');
            sobreInput.focus();
        });

        // Cancelar edição
        cancelBtn.addEventListener('click', () => {
            sobreInput.readOnly = true;
            sobreInput.classList.remove('border', 'border-primary');
            fotoEditIcon.classList.add('d-none');
            editBtn.classList.remove('d-none');
            saveBtn.classList.add('d-none');
            cancelBtn.classList.add('d-none');
        });

        // Salvar edição
        saveBtn.addEventListener('click', () => {
            sobreInput.readOnly = true;
            sobreInput.classList.remove('border', 'border-primary');
            fotoEditIcon.classList.add('d-none');
            editBtn.classList.remove('d-none');
            saveBtn.classList.add('d-none');
            cancelBtn.classList.add('d-none');
            alert('Salvo com sucesso!');
        });

        // Contador de caracteres
        sobreInput.addEventListener('input', function () {
            const length = this.value.length;
            charCount.textContent = length;

            charCount.classList.remove('text-warning', 'fw-bold', 'text-danger', 'fw-bolder');

            if (length >= 235 && length < 250) {
                charCount.classList.add('text-warning', 'fw-bold');
            } else if (length === 250) {
                charCount.classList.add('text-danger', 'fw-bolder');
            }
        });
    </script>
</body>

</html>