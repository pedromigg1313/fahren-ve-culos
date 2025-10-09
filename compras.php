<?php
session_start();
$selected = 'compras';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Compras - Fahren</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

  <!-- CSS principal -->
  <link rel="stylesheet" href="../style.css">

  <!-- CSS interno responsivo -->
  <style>
    /* Layout padrão */
    #conteudo-principal {
      margin-left: calc(200px + 5vw);
      transition: margin-left 0.3s ease;
    }

    /* Botão menu inicialmente escondido */
    #btn-menu {
      display: none;
      position: fixed;
      top: 15px;
      left: 15px;
      z-index: 1050;
    }

    /* Telas menores (tablets e celulares) */
    @media (max-width: 992px) {
      #conteudo-principal {
        margin-left: 0 !important;
      }

      #btn-menu {
        display: block !important;
      }

      #sidebar {
        display: none;
      }
    }

    /* Ajustes extras para telas muito pequenas (iPhone SE, etc.) */
    @media (max-width: 400px) {
      body {
        font-size: 0.9rem;
      }

      .btn {
        padding: 0.35rem 0.7rem;
      }

      .offcanvas {
        width: 85% !important;
      }
    }
  </style>
</head>

<body>
  <!-- Botão para abrir sidebar em mobile -->
  <button class="btn btn-outline-dark" id="btn-menu" data-bs-toggle="offcanvas" data-bs-target="#offcanvasSidebar">
    <i class="bi bi-list fs-4"></i>
  </button>

  <!-- Sidebar fixa (telas grandes) -->
  <aside id="sidebar" class="border-end d-flex flex-column position-fixed vh-100" style="width: calc(200px + 5vw);">
    <div class="position-relative">
      <button class="btn bg-white border position-absolute start-100 rounded-start-0 rounded-top-0"><i class="bi bi-layout-sidebar-inset"></i></button>
    </div>
    <a href="../index.php" class="d-flex mx-4 mt-4 mb-3 text-decoration-none text-dark">
      <img src="/TCC/img/logo-fahren.png" class="d-inline-block align-text-center" width="23" height="38" alt="logo" style="filter: invert(1);">
      <span class="fw-semibold fs-3">&nbsp;Fahren</span>
    </a>
    <hr class="mx-3">
    <nav class="sidebar nav d-flex flex-column nav-pills mx-3 flex-grow-1 small">
      <div class="my-2">
        <a class="nav-link <?php if ($selected == 'config') {echo 'active';}?>" href="configuracoes.php"><i class="bi bi-gear-fill"></i>&nbsp;Configurações</a>
        <a class="nav-link <?php if ($selected == 'compras') {echo 'active';}?>" href="compras.php"><i class="bi bi-bag-fill"></i>&nbsp;Compras</a>
        <a class="nav-link <?php if ($selected == 'fav') {echo 'active';}?>" href="favoritos.php"><i class="bi bi-heart-fill"></i>&nbsp;Favoritos</a>
        <hr class="mx-3">
        <a class="nav-link <?php if ($selected == 'ad') {echo 'active';}?>" href="anuncios.php"><i class="bi bi-megaphone-fill"></i>&nbsp;Meus anúncios</a>
        <a class="nav-link <?php if ($selected == 'mensagens') {echo 'active';}?>" href="mensagens.php"><i class="bi bi-chat-left-text-fill"></i>&nbsp;Mensagens</a>
        <hr class="mx-3">
        <a class="nav-link <?php if ($selected == 'loja') {echo 'active';}?>" href="minha-loja.php"><i class="bi bi-building-fill"></i>&nbsp;Minha loja</a>
        <a class="nav-link <?php if ($selected == 'equipe') {echo 'active';}?>" href="equipe.php"><i class="bi bi-people-fill"></i>&nbsp;Equipe</a>
      </div>
      <hr class="mx-3 mt-auto">
      <div class="footer mx-3 mb-3 d-flex justify-content-between align-content-center">
        <div class="dropdown">
          <a href="#" class="d-flex align-items-center text-dark text-decoration-none dropdown-toggle" data-bs-toggle="dropdown">
            <div class="position-relative">
              <img src="../img/logo-fahren-bg.jpg" alt="Foto de Perfil" width="32" height="32" class="rounded-circle me-2">
            </div>
            <span class="fw-semibold"><?= $_SESSION['nome']?></span>
          </a>
          <ul class="dropdown-menu text-small shadow">
            <li><a class="dropdown-item" href="controladores/logout.php">Sair</a></li>
          </ul>
        </div>
      </div>
    </nav>
  </aside>

  <!-- Sidebar Offcanvas (para mobile) -->
  <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasSidebar">
    <div class="offcanvas-header">
      <h5 class="offcanvas-title">Menu</h5>
      <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body p-0">
      <?php include('sidebar.php'); ?>
    </div>
  </div>

  <!-- Conteúdo principal -->
  <main id="conteudo-principal" class="p-5">
    <h1 class="mb-4">Minhas Compras</h1>
    <p>Aqui você verá suas compras recentes.</p>
  </main>

  <?php include('alert.php'); ?>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
