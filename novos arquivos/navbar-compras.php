<header class="sticky-top">
  <nav class="navbar navbar-expand-lg bg-body shadow-sm" data-bs-theme="light">
    <div class="container-xxl px-lg-5">
      <a class="navbar-brand" href="/sites/TCC">
        <img src="/sites/TCC/img/logo-fahren.png" alt="Logo" width="15" height="20" class="d-inline-block align-text-center" style="filter: invert(1);">
        <span class="ms-1 fw-semibold">Fahren</span>
      </a>
      <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ms-auto me-3 mb-3 mb-lg-0">
          <?php include 'config/options.php' ?>
        </ul>
        <div class="col-auto">

          <div class="d-flex align-items-center position-relative">
            <i class="bi bi-search text-dark position-absolute px-3"></i>
            <input id="navbar-search" type="search" class="form-control bg-transparent ps-5 rounded-pill" placeholder="Buscar modelo ou marca" aria-label="Search">
            <div class="search-suggestions dropdown-menu p-2" style="width:320px; max-height:300px; overflow:auto; display:none; right:0; position:absolute; top:calc(100% + 6px);"></div>
          </div>
        </div>
        <div class="d-flex gap-2">
          <div class="vr ms-4"></div>
          <?php
          if (isset($_SESSION['nome'])) {
            include 'config/login.php';
          } else {
            include 'config/no-login.php';
          }
          ?>
        </div>
      </div>
    </div>
  </nav>
</header>