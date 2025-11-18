<?php
session_start();
include('controladores/conexao_bd.php');

$sql = "SELECT value, nome FROM marcas";
$resultado = mysqli_query($conexao, $sql);

$marcas = [];

while ($linha = mysqli_fetch_array($resultado)) {
  $marcas[] = $linha;
}

$sql = "SELECT * FROM estados ORDER BY nome;";
$resultado = mysqli_query($conexao, $sql);

$estados = [];

while ($linha = mysqli_fetch_array($resultado)) {
  $estados[] = $linha;
}

$sql = "SELECT MAX(preco) as maior FROM anuncios_carros";
$resultado = mysqli_query($conexao, $sql);

$mais_caro = 0.00;

if ($resultado && mysqli_num_rows($resultado) > 0) {
  $linha = mysqli_fetch_array($resultado);
  $mais_caro = $linha['maior'];
}

mysqli_close($conexao);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
  <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <title>Fahren</title>
</head>
<style>
  .card-footer .btn {
    position: relative;
    z-index: 2;
  }
</style>

<body>
  <?php
  include 'estruturas/top-button/top-button.php' ?>
  <?php include 'estruturas/alert/alert.php' ?>
  <?php include 'estruturas/navbar/navbar-default.php' ?>
  <main class="bg-body-tertiary fs-nav">
    <div id="banner-carousel" class="carousel slide" data-bs-ride="carousel">
      <div class="carousel-inner">
        <div class="carousel-item active" data-bs-interval="7500">
          <img src="./img/banner/carousel-1.png" class="d-block w-100 object-fit-cover c-img">
        </div>
        <div class="carousel-item" data-bs-interval="7500">
          <img src="./img/banner/carousel-2.png" class="d-block w-100 object-fit-cover c-img">
        </div>
        <div class="carousel-item" data-bs-interval="7500">
          <img src="./img/banner/carousel-3.png" class="d-block w-100 object-fit-cover c-img">
        </div>
      </div>
      <button class="carousel-control-prev" style="width: 10%;" type="button" data-bs-target="#banner-carousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" style="width: 10%;" type="button" data-bs-target="#banner-carousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
    </div>
    <div class="container py-4">
      <div class="card rounded-5 border-0 shadow-sm">
        <div class="card-body px-4 py-2">
          <div id="recomendacao" class="row bg-body-tertiary shadow-sm rounded-top-4 rounded-bottom-3 px-1 py-2 align-items-center d-flex">
            <div class="col">
              <span class="small"><i class="bi bi-arrow-right me-2"></i>Recomendação: Lamborghini Aventador SVJ </span>
            </div>
            <div class="col-auto ">
              <button type="button" class="btn-close" aria-label="Close"></button>
            </div>
          </div>
            <div class="row position-relative">
            <input id="global-search" type="text" class="form-control border-0 my-3" placeholder="Encontre o modelo que você procura...">
            <button class="btn d-lg-none me-3 w-auto p-0 border-0 position-absolute translate-middle-y top-50 end-0"><i class="bi bi-search"></i></button>
            <div class="search-suggestions dropdown-menu p-2" style="width:100%; max-height:300px; overflow:auto; display:none;"></div>
          </div>
          <div class="d-lg-none d-flex">
            <button type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasBottom" aria-controls="offcanvasBottom" class="btn btn-sm border rounded-pill px-3"><i class="bi bi-funnel me-2"></i></i>Filtros</button>
            <div class="offcanvas rounded-top-5 overflow-hidden h-auto py-3 offcanvas-bottom" tabindex="-1" id="offcanvasBottom" aria-labelledby="offcanvasBottomLabel">
              <div class="offcanvas-body small d-flex flex-column gap-3">
                <div class="d-flex flex-column gap-2 mb-3">
                  <div class="col">
                    <div class="d-flex align-items-center position-relative">
                      <label for="marca-select" class="d-flex align-items-center"><i class="bi bi-buildings position-absolute px-3"></i></label>
                      <select id="marca-select" class="form-select rounded-pill bg-transparent" style="padding-left: 3rem;">
                        <option value="">Marca</option>
                        <?php foreach ($marcas as $marca): ?>
                          <option value="<?= $marca['value'] ?>"><?= $marca['nome'] ?></option>
                        <?php endforeach; ?>
                      </select>
                    </div>
                  </div>
                  <div class="col-auto">
                    <div class="d-flex align-items-center position-relative">
                      <label for="modelo-select" class="d-flex align-items-center"><i class="bi bi-car-front position-absolute px-3"></i></label>
                      <select id="modelo-select" class="form-select rounded-pill bg-transparent" disabled style="padding-left: 3rem;">
                        <option value="" selected>Modelo</option>
                        <option value="0">Audi R8 Spyder</option>
                        <option value="1">Ferrari 488</option>
                        <option value="2">Porsche Macan</option>
                        <option value="3">Mercedes-Benz AMG GT63</option>
                        <option value="4">Lamborghini Gallardo</option>
                        <option value="5">BMW X7</option>
                      </select>
                    </div>
                  </div>
                  <div class="col">
                    <div class="d-flex align-items-center position-relative">
                      <label for="estado-select" class="d-flex align-items-center"><i class="bi bi-pin-map position-absolute px-3"></i></label>
                      <select id="estado-select" class="form-select rounded-pill bg-transparent" style="padding-left: 3rem;">
                        <option value="">Estado</option>
                        <?php foreach ($estados as $estado): ?>
                          <option value="<?= $estado['uf'] ?>"><?= $estado['nome'] ?></option>
                        <?php endforeach; ?>
                      </select>
                    </div>
                  </div>
                  <div class="gap-3 d-flex">
                  <div class="col">
                    <div class="d-flex align-items-center position-relative">
                      <label for="preco-de" class="text-dark position-absolute px-3">De</label>
                      <input type="text" id="preco-de" class="form-control rounded-pill preco-input-rs" placeholder="R$--" aria-label="Preço mínimo" style="padding-left: 3rem;">
                    </div>
                  </div>
                  <div class="col">

                    <div class="d-flex align-items-center position-relative">
                      <label for="preco-ate" class="text-dark position-absolute px-3">Até</label>
                      <input type="text" id="preco-ate" class="form-control rounded-pill preco-input-rs" placeholder="R$--" aria-label="Preço máximo" style="padding-left: 3rem;" value="<?= number_format((int)$mais_caro, 0, ',', '.'); ?>">
                    </div>
                  </div>
                  </div>
                </div>
                <div class="d-flex mt-auto flex-column gap-2">
                  <button type="button" class="btn border rounded-pill px-4 me-3 w-100" data-bs-dismiss="offcanvas">Cancelar</button>
                  <button type="button" data-bs-dismiss="offcanvas" aria-label="Close" class="btn btn-dark rounded-pill px-4 w-100">Aplicar</button>
                </div>
              </div>
            </div>
          </div>
          <div class="d-lg-flex flex-wrap gap-3 gap-xl-4 align-items-center d-none">
            <div class="d-flex gap-1 gap-xl-2">
              <div class="col col-xl-auto">
                <div class="d-flex align-items-center position-relative">
                  <label for="marca-select" class="d-flex align-items-center"><i class="bi bi-buildings position-absolute px-3"></i></label>
                  <select id="marca-select" class="form-select rounded-pill shadow-sm bg-transparent" style="padding-left: 3rem;">
                    <option value="">Marca</option>
                    <?php foreach ($marcas as $marca): ?>
                      <option value="<?= $marca['value'] ?>"><?= $marca['nome'] ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>
              <div class="col col-xl-auto">
                <div class="d-flex align-items-center position-relative">
                  <label for="modelo-select" class="d-flex align-items-center"><i class="bi bi-car-front position-absolute px-3"></i></label>
                  <select id="modelo-select" class="form-select rounded-pill shadow-sm bg-transparent" disabled style="padding-left: 3rem;">
                    <option value="" selected>Modelo</option>
                    <option value="0">Audi R8 Spyder</option>
                    <option value="1">Ferrari 488</option>
                    <option value="2">Porsche Macan</option>
                    <option value="3">Mercedes-Benz AMG GT63</option>
                    <option value="4">Lamborghini Gallardo</option>
                    <option value="5">BMW X7</option>
                  </select>
                </div>
              </div>
              <div class="col col-xl-auto">
                <div class="d-flex align-items-center position-relative">
                  <label for="estado-select" class="d-flex align-items-center"><i class="bi bi-pin-map position-absolute px-3"></i></label>
                  <select id="estado-select" class="form-select rounded-pill shadow-sm bg-transparent" style="padding-left: 3rem;">
                    <option value="">Estado</option>
                    <?php foreach ($estados as $estado): ?>
                      <option value="<?= $estado['uf'] ?>"><?= $estado['nome'] ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>
              <div class="col col-xl-auto">
                <div class="input-group flex-nowrap">
                  <div class="d-flex align-items-center position-relative">
                    <label for="preco-de" class="text-dark position-absolute px-3">De</label>
                    <input type="text" id="preco-de" class="form-control shadow-sm rounded-start-5 rounded-end-0 preco-input-rs" placeholder="R$--" aria-label="Preço mínimo" style="padding-left: 3rem; width: 160px">
                  </div>
                  <div class="d-flex align-items-center position-relative">
                    <label for="preco-ate" class="text-dark position-absolute px-3">Até</label>
                    <input type="text" id="preco-ate" class="form-control shadow-sm rounded-end-5 rounded-start-0 preco-input-rs" placeholder="R$--" aria-label="Preço máximo" style="padding-left: 3rem; width: 160px" value="<?= number_format((int)$mais_caro, 0, ',', '.'); ?>">
                  </div>
                </div>
              </div>
            </div>
            <div class="col ms-auto">
              <a href="compras.php" class="btn btn-dark rounded-pill shadow-sm px-3 w-100"><i class="bi bi-search me-2"></i>Pesquisar</a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="container py-4">
      <div class="row mb-4 align-items-center">
        <h4 class="col-8 fw-semibold">Categorias</h4>
      </div>
      <div id="categorias-carousel" class="carousel carousel-dark multi-carousel multi-carousel-6 px-4">
        <div class="carousel-inner">
          <div class="carousel-item active">
            <a href="compras.php?categoria=ele" class="shadow-hover card border-0">
              <div class="card-img-overlay d-flex flex-column justify-content-end text-white">
                <h5 class="card-title fw-bold">Elétricos</h5>
              </div>
              <img src="./img/categorias/categorias-1.png" class="card-img">
            </a>
          </div>
          <div class="carousel-item">
            <a href="compras.php?categoria=sed" class="shadow-hover card border-0">
              <div class="card-img-overlay d-flex flex-column justify-content-end text-white">
                <h5 class="card-title fw-bold">Sedans</h5>
              </div>
              <img src="./img/categorias/categorias-2.png" class="card-img">
            </a>
          </div>
          <div class="carousel-item">
            <a href="compras.php?categoria=hat" class="shadow-hover card border-0">
              <div class="card-img-overlay d-flex flex-column justify-content-end text-white">
                <h5 class="card-title fw-bold">Hatchbacks</h5>
              </div>
              <img src="./img/categorias/categorias-3.png" class="card-img">
            </a>
          </div>
          <div class="carousel-item">
            <a href="compras.php?categoria=pic" class="shadow-hover card border-0">
              <div class="card-img-overlay d-flex flex-column justify-content-end text-white">
                <h5 class="card-title fw-bold">Pickups</h5>
              </div>
              <img src="./img/categorias/categorias-4.png" class="card-img">
            </a>
          </div>
          <div class="carousel-item">
            <a href="compras.php?categoria=cou" class="shadow-hover card border-0">
              <div class="card-img-overlay d-flex flex-column justify-content-end text-white">
                <h5 class="card-title fw-bold">Coupés</h5>
              </div>
              <img src="./img/categorias/categorias-5.png" class="card-img">
            </a>
          </div>
          <div class="carousel-item">
            <a href="compras.php?categoria=min" class="shadow-hover card border-0">
              <div class="card-img-overlay d-flex flex-column justify-content-end text-white">
                <h5 class="card-title fw-bold">Minivans</h5>
              </div>
              <img src="./img/categorias/categorias-6.png" class="card-img">
            </a>
          </div>
          <div class="carousel-item">
            <a href="compras.php?categoria=hib" class="shadow-hover card border-0">
              <div class="card-img-overlay d-flex flex-column justify-content-end text-white">
                <h5 class="card-title fw-bold">Híbridos</h5>
              </div>
              <img src="./img/categorias/categorias-7.png" class="card-img">
            </a>
          </div>
          <div class="carousel-item">
            <a href="compras.php?categoria=sup" class="shadow-hover card border-0">
              <div class="card-img-overlay d-flex flex-column justify-content-end text-white">
                <h5 class="card-title fw-bold">Supercarros</h5>
              </div>
              <img src="./img/categorias/categorias-8.png" class="card-img">
            </a>
          </div>
        </div>
        <button class="carousel-control-prev d-flex justify-content-start w-auto" type="button" data-bs-target="#categorias-carousel" id="categorias-prev" data-bs-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next d-flex justify-content-end w-auto" type="button" data-bs-target="#categorias-carousel" id="categorias-next" data-bs-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Next</span>
        </button>
      </div>
    </div>
    <div class="container py-4">
      <div class="row mb-4 align-items-center">
        <h4 class="col-8 fw-semibold">Principais marcas</h4>
      </div>
      <div class=" row g-3 align-items-stretch justify-content-between row-cols-3 row-cols-lg-6">
          <div class="col d-flex">
            <a href="compras.php?marca=toyota" class="bg-body shadow-hover d-flex align-items-center justify-content-center p-3 border rounded w-100" style="height: 120px;">
              <img src="./img/marcas/toyota-logo.png" alt="Toyota" class="img-fluid" style="max-height: 60px; width: auto;">
            </a>
          </div>
          <div class="col d-flex">
            <a href="compras.php?marca=honda" class="bg-body shadow-hover d-flex align-items-center justify-content-center p-3 border rounded w-100" style="height: 120px;">
              <img src="./img/marcas/honda-logo.png" alt="Honda" class="img-fluid" style="max-height: 50px; width: auto;">
            </a>
          </div>
          <div class="col d-flex">
            <a href="compras.php?marca=kia" class="bg-body shadow-hover d-flex align-items-center justify-content-center p-3 border rounded w-100" style="height: 120px;">
              <img src="./img/marcas/kia-logo.png" alt="Kia" class="img-fluid" style="max-height: 55px; width: auto;">
            </a>
          </div>
          <div class="col d-flex">
            <a href="compras.php?marca=renault" class="bg-body shadow-hover d-flex align-items-center justify-content-center p-3 border rounded w-100" style="height: 120px;">
              <img src="./img/marcas/renault-logo.png" alt="Renault" class="img-fluid" style="max-height: 65px; width: auto;">
            </a>
          </div>
          <div class="col d-flex">
            <a href="compras.php?marca=chevrolet" class="bg-body shadow-hover d-flex align-items-center justify-content-center p-3 border rounded w-100" style="height: 120px;">
              <img src="./img/marcas/chevrolet-logo.png" alt="Chevrolet" class="img-fluid" style="max-height: 45px; width: auto;">
            </a>
          </div>
          <div class="col d-flex">
            <a href="compras.php?marca=volkswagen" class="bg-body shadow-hover d-flex align-items-center justify-content-center p-3 border rounded w-100" style="height: 120px;">
              <img src="./img/marcas/volkswagen-logo.png" alt="Volkswagen" class="img-fluid" style="max-height: 70px; width: auto;">
            </a>
          </div>
      </div>
    </div>
    <div class="container py-4 d-none d-md-block">
      <div class="row mb-4 align-items-center">
        <h4 class="col-8 fw-semibold">Carros mais procurados</h4>
        <a class="col-4 link-secondary text-end link-underline link-underline-opacity-0 link-opacity-75 small link-underline-opacity-100-hover link-opacity-100-hover" href="compras.php"">
          (Ver todos os carros)
        </a>
      </div>
      <div id="populares-carousel" class="carousel carousel-dark multi-carousel multi-carousel-5 px-4">
          <div class="carousel-inner">
            <?php
            $nome = 'AUDI RS5';
            $info = '2.0 TFSI GASOLINA SPORTBACK PRESTIGE PLUS S TRONIC';
            $preco = 'R$ 100.000';
            $ano = '2020/2021';
            $km = '52.524';
            $loc = 'São Paulo - SP';
            $img = './img/carros/img-5.png';
            include 'estruturas/card-compra/card-index.php' ?>
            <?php
            $nome = 'AUDI RS4';
            $info = '2.0 TFSI GASOLINA SPORTBACK PRESTIGE PLUS S TRONIC';
            $preco = 'R$ 100.000';
            $ano = '2020/2021';
            $km = '52.524';
            $loc = 'São Paulo - SP';
            $img = './img/carros/img-4.png';
            include 'estruturas/card-compra/card-index.php' ?>
            <?php
            $nome = 'AUDI RS3';
            $info = '2.0 TFSI GASOLINA SPORTBACK PRESTIGE PLUS S TRONIC';
            $preco = 'R$ 100.000';
            $ano = '2020/2021';
            $km = '52.524';
            $loc = 'São Paulo - SP';
            $img = './img/carros/img-3.png';
            include 'estruturas/card-compra/card-index.php' ?>
            <?php
            $nome = 'AUDI RS2';
            $info = '2.0 TFSI GASOLINA SPORTBACK PRESTIGE PLUS S TRONIC';
            $preco = 'R$ 100.000';
            $ano = '2020/2021';
            $km = '52.524';
            $loc = 'São Paulo - SP';
            $img = './img/carros/img-2.png';
            include 'estruturas/card-compra/card-index.php' ?>
            <?php
            $nome = 'AUDI RS1';
            $info = '2.0 TFSI GASOLINA SPORTBACK PRESTIGE PLUS S TRONIC';
            $preco = 'R$ 100.000';
            $ano = '2020/2021';
            $km = '52.524';
            $loc = 'São Paulo - SP';
            $img = './img/carros/img-1.png';
            include 'estruturas/card-compra/card-index.php' ?>
            <?php
            $nome = 'AUDI RS5';
            $info = '2.0 TFSI GASOLINA SPORTBACK PRESTIGE PLUS S TRONIC';
            $preco = 'R$ 100.000';
            $ano = '2020/2021';
            $km = '52.524';
            $loc = 'São Paulo - SP';
            $img = './img/carros/img-5.png';
            include 'estruturas/card-compra/card-index.php' ?>
            <?php
            $nome = 'AUDI RS4';
            $info = '2.0 TFSI GASOLINA SPORTBACK PRESTIGE PLUS S TRONIC';
            $preco = 'R$ 100.000';
            $ano = '2020/2021';
            $km = '52.524';
            $loc = 'São Paulo - SP';
            $img = './img/carros/img-4.png';
            include 'estruturas/card-compra/card-index.php' ?>
            <?php
            $nome = 'AUDI RS3';
            $info = '2.0 TFSI GASOLINA SPORTBACK PRESTIGE PLUS S TRONIC';
            $preco = 'R$ 100.000';
            $ano = '2020/2021';
            $km = '52.524';
            $loc = 'São Paulo - SP';
            $img = './img/carros/img-3.png';
            include 'estruturas/card-compra/card-index.php' ?>
            <?php
            $nome = 'AUDI RS2';
            $info = '2.0 TFSI GASOLINA SPORTBACK PRESTIGE PLUS S TRONIC';
            $preco = 'R$ 100.000';
            $ano = '2020/2021';
            $km = '52.524';
            $loc = 'São Paulo - SP';
            $img = './img/carros/img-2.png';
            include 'estruturas/card-compra/card-index.php' ?>
            <?php
            $nome = 'AUDI RS1';
            $info = '2.0 TFSI GASOLINA SPORTBACK PRESTIGE PLUS S TRONIC';
            $preco = 'R$ 100.000';
            $ano = '2020/2021';
            $km = '52.524';
            $loc = 'São Paulo - SP';
            $img = './img/carros/img-1.png';
            include 'estruturas/card-compra/card-index.php' ?>
            <?php
            $nome = 'AUDI RS5';
            $info = '2.0 TFSI GASOLINA SPORTBACK PRESTIGE PLUS S TRONIC';
            $preco = 'R$ 100.000';
            $ano = '2020/2021';
            $km = '52.524';
            $loc = 'São Paulo - SP';
            $img = './img/carros/img-5.png';
            include 'estruturas/card-compra/card-index.php' ?>
            <?php
            $nome = 'AUDI RS4';
            $info = '2.0 TFSI GASOLINA SPORTBACK PRESTIGE PLUS S TRONIC';
            $preco = 'R$ 100.000';
            $ano = '2020/2021';
            $km = '52.524';
            $loc = 'São Paulo - SP';
            $img = './img/carros/img-4.png';
            include 'estruturas/card-compra/card-index.php' ?>
            <?php
            $nome = 'AUDI RS3';
            $info = '2.0 TFSI GASOLINA SPORTBACK PRESTIGE PLUS S TRONIC';
            $preco = 'R$ 100.000';
            $ano = '2020/2021';
            $km = '52.524';
            $loc = 'São Paulo - SP';
            $img = './img/carros/img-3.png';
            include 'estruturas/card-compra/card-index.php' ?>
            <?php
            $nome = 'AUDI RS2';
            $info = '2.0 TFSI GASOLINA SPORTBACK PRESTIGE PLUS S TRONIC';
            $preco = 'R$ 100.000';
            $ano = '2020/2021';
            $km = '52.524';
            $loc = 'São Paulo - SP';
            $img = './img/carros/img-2.png';
            include 'estruturas/card-compra/card-index.php' ?>
            <?php
            $nome = 'AUDI RS1';
            $info = '2.0 TFSI GASOLINA SPORTBACK PRESTIGE PLUS S TRONIC';
            $preco = 'R$ 100.000';
            $ano = '2020/2021';
            $km = '52.524';
            $loc = 'São Paulo - SP';
            $img = './img/carros/img-1.png';
            include 'estruturas/card-compra/card-index.php' ?>
          </div>
          <button class="carousel-control-prev d-flex justify-content-start w-auto" type="button" data-bs-target="#populares-carousel" id="populares-prev" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
          </button>
          <button class="carousel-control-next d-flex justify-content-end w-auto" type="button" data-bs-target="#populares-carousel" id="populares-next" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
          </button>
      </div>
    </div>
  </main>
  <?php include 'estruturas/footer/footer.php' ?>
</body>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
<script src="script.js"></script>
<script>
  $(function() {
    $("#marca-select").change(function() {
      var selectedMarca = $(this).val();
      if (selectedMarca) {
        $("#modelo-select").prop("disabled", false);
      } else {
        $("#modelo-select").prop("disabled", true);
        $("#modelo-select").val("");
      }
    });

    $("#recomendacao .btn-close").click(function() {
      $("#recomendacao").remove();
    });
  });
</script>

</html>