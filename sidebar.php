<!-- Botão para abrir a sidebar (aparece só em telas pequenas) -->
<button class="btn btn-dark d-lg-none position-fixed top-0 start-0 m-3 z-3" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasSidebar" aria-controls="offcanvasSidebar">
  <i class="bi bi-list"></i>
</button>

<!-- Sidebar fixa (visível apenas em telas grandes) -->
<aside class="border-end d-none d-lg-flex flex-column position-fixed vh-100 bg-white" style="width: calc(200px + 5vw);">
  <a href="../index.php" class="d-flex mx-4 mt-4 mb-3 text-decoration-none text-dark">
    <img src="/TCC/img/logo-fahren.png" class="d-inline-block align-text-center" width="23" height="38" alt="logo" style="filter: invert(1);">
    <span class="fw-semibold fs-3">&nbsp;Fahren</span>
  </a>
  <hr class="mx-3">
  <nav class="sidebar nav d-flex flex-column nav-pills mx-3 flex-grow-1 small">
    <div class="my-2">
      <a class="nav-link <?php if ($selected == 'config') echo 'active'; ?>" href="configuracoes.php"><i class="bi bi-gear-fill"></i>&nbsp;Configurações</a>
      <a class="nav-link <?php if ($selected == 'compras') echo 'active'; ?>" href="compras.php"><i class="bi bi-bag-fill"></i>&nbsp;Compras</a>
      <a class="nav-link <?php if ($selected == 'fav') echo 'active'; ?>" href="favoritos.php"><i class="bi bi-heart-fill"></i>&nbsp;Favoritos</a>
      <hr class="mx-3">
      <a class="nav-link <?php if ($selected == 'ad') echo 'active'; ?>" href="anuncios.php"><i class="bi bi-megaphone-fill"></i>&nbsp;Meus anúncios</a>
      <a class="nav-link <?php if ($selected == 'mensagens') echo 'active'; ?>" href="mensagens.php"><i class="bi bi-chat-left-text-fill"></i>&nbsp;Mensagens</a>
      <hr class="mx-3">
      <a class="nav-link <?php if ($selected == 'loja') echo 'active'; ?>" href="minha-loja.php"><i class="bi bi-building-fill"></i>&nbsp;Minha loja</a>
      <a class="nav-link <?php if ($selected == 'equipe') echo 'active'; ?>" href="equipe.php"><i class="bi bi-people-fill"></i>&nbsp;Equipe</a>
    </div>
    <hr class="mx-3 mt-auto">
    <div class="footer mx-3 mb-3 d-flex justify-content-between align-content-center">
      <div class="dropdown">
        <a href="#" class="d-flex align-items-center text-dark text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
          <img src="../img/logo-fahren-bg.jpg" alt="Foto de Perfil" width="32" height="32" class="rounded-circle me-2">
          <span class="fw-semibold"><?= $_SESSION['nome'] ?></span>
        </a>
        <ul class="dropdown-menu text-small shadow">
          <li><a class="dropdown-item" href="controladores/logout.php">Sair</a></li>
        </ul>
      </div>
    </div>
  </nav>
</aside>

<!-- Sidebar offcanvas (para telas pequenas) -->
<div class="offcanvas offcanvas-start d-lg-none" tabindex="-1" id="offcanvasSidebar" aria-labelledby="offcanvasSidebarLabel">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title" id="offcanvasSidebarLabel">Menu</h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Fechar"></button>
  </div>
  <div class="offcanvas-body">
    <nav class="nav flex-column">
      <a class="nav-link <?php if ($selected == 'config') echo 'active'; ?>" href="configuracoes.php"><i class="bi bi-gear-fill"></i>&nbsp;Configurações</a>
      <a class="nav-link <?php if ($selected == 'compras') echo 'active'; ?>" href="compras.php"><i class="bi bi-bag-fill"></i>&nbsp;Compras</a>
      <a class="nav-link <?php if ($selected == 'fav') echo 'active'; ?>" href="favoritos.php"><i class="bi bi-heart-fill"></i>&nbsp;Favoritos</a>
      <a class="nav-link <?php if ($selected == 'ad') echo 'active'; ?>" href="anuncios.php"><i class="bi bi-megaphone-fill"></i>&nbsp;Meus anúncios</a>
      <a class="nav-link <?php if ($selected == 'mensagens') echo 'active'; ?>" href="mensagens.php"><i class="bi bi-chat-left-text-fill"></i>&nbsp;Mensagens</a>
      <a class="nav-link <?php if ($selected == 'loja') echo 'active'; ?>" href="minha-loja.php"><i class="bi bi-building-fill"></i>&nbsp;Minha loja</a>
      <a class="nav-link <?php if ($selected == 'equipe') echo 'active'; ?>" href="equipe.php"><i class="bi bi-people-fill"></i>&nbsp;Equipe</a>
      <hr>
      <a class="nav-link text-danger" href="controladores/logout.php"><i class="bi bi-box-arrow-right"></i>&nbsp;Sair</a>
    </nav>
  </div>
</div>
