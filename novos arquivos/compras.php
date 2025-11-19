<?php session_start();
include('controladores/conexao_bd.php');
$filter_check_caminho = 'estruturas/filter/filter-checkbox.php';

$id = $_SESSION['id'] ?? null;

$tipo = $_GET['tipo'] ?? 'carro';
$codicao = $_GET['codicao'] ?? 'usado';
$categoria = $_GET['categoria'] ?? null;
$vendedor = $_GET['vendedor'] ?? null;
$vendedor_img = $_GET['vendedor_img'] ?? null;
$vendedor_seg = $_GET['vendedor_seg'] ?? null;

// Get URL params for lateral filters (marca, modelo, versao)
$url_marca = $_GET['marca'] ?? '';
$url_modelo = $_GET['modelo'] ?? '';
$url_versao = $_GET['versao'] ?? '';

$page = $_GET['page'] ?? 1;

$quantidade = 3;
$quantidade = $quantidade * 12;

// sorting
$sort = $_GET['sort'] ?? 'relevancia';
$dir = $_GET['dir'] ?? 'desc';
$dir = strtolower($dir) === 'asc' ? 'asc' : 'desc';


$order_sql = '';
if ($sort === 'preco') {
  $order_sql = " ORDER BY carros.preco " . ($dir === 'asc' ? 'ASC' : 'DESC');
} elseif ($sort === 'ano') {
  // order by fabrication year, newer first by default
  $order_sql = " ORDER BY carros.ano_fabricacao " . ($dir === 'asc' ? 'ASC' : 'DESC');
} elseif ($sort === 'km') {
  $order_sql = " ORDER BY carros.quilometragem " . ($dir === 'asc' ? 'ASC' : 'DESC');
}

$whereParts = [];
$whereParts[] = "ativo = 'A'";

// optional codicao filter (accept single or comma-separated values: novo,seminovo,usado)
if (isset($_GET['codicao']) && trim($_GET['codicao']) !== '') {
  $cod_raw = trim($_GET['codicao']);
  $cod_map = [
    'novo' => 'N',
    'seminovo' => 'S',
    'usado' => 'U'
  ];
  $parts = array_filter(array_map('trim', explode(',', $cod_raw)));
  $codes = [];
  foreach ($parts as $p) {
    $pl = strtolower($p);
    if (isset($cod_map[$pl])) $codes[] = $cod_map[$pl];
  }
  if (count($codes) > 0) {
    $codes_esc = array_map(function ($c) use ($conexao) {
      return mysqli_real_escape_string($conexao, $c);
    }, $codes);
    $whereParts[] = "carros.condicao IN ('" . implode("','", $codes_esc) . "')";
  }
}

// optional exact marca filter (accept both name and value)
if (isset($_GET['marca']) && trim($_GET['marca']) !== '') {
  $m = mysqli_real_escape_string($conexao, $_GET['marca']);
  $whereParts[] = "(marcas.nome = '$m' OR marcas.value = '$m')";
}

// optional modelo filter (partial match)
if (isset($_GET['modelo']) && trim($_GET['modelo']) !== '') {
  $mo = mysqli_real_escape_string($conexao, $_GET['modelo']);
  $whereParts[] = "carros.modelo LIKE '%$mo%'";
}

// search query q: match marca, modelo or 'marca modelo' combined
// Only apply q filter if marca AND modelo are NOT explicitly set (to avoid conflicting with lateral filters)
if (isset($_GET['q']) && trim($_GET['q']) !== '' && !isset($_GET['marca']) && !isset($_GET['modelo'])) {
  $q_raw = $_GET['q'];
  $q_esc = mysqli_real_escape_string($conexao, $q_raw);
  $whereParts[] = "(marcas.nome LIKE '%$q_esc%' OR carros.modelo LIKE '%$q_esc%' OR CONCAT(marcas.nome, ' ', carros.modelo) LIKE '%$q_esc%')";
}

// optional versao filter (match with trim and case-insensitive)
if (isset($_GET['versao']) && trim($_GET['versao']) !== '') {
  $v = mysqli_real_escape_string($conexao, $_GET['versao']);
  $whereParts[] = "TRIM(carros.versao) = TRIM('$v')";
}

// optional cor filter (accept single or comma-separated color ids)
if (isset($_GET['cor']) && trim($_GET['cor']) !== '') {
  $cor_raw = trim($_GET['cor']);
  $parts_cor = array_filter(array_map('trim', explode(',', $cor_raw)));
  $cor_ids = [];
  foreach ($parts_cor as $c) {
    if (ctype_digit($c)) $cor_ids[] = $c;
  }
  if (count($cor_ids) > 0) {
    $cor_esc = array_map(function ($c) use ($conexao) {
      return mysqli_real_escape_string($conexao, $c);
    }, $cor_ids);
    $whereParts[] = "carros.cor IN ('" . implode("','", $cor_esc) . "')";
  }
}

// optional carroceria filter (accept single or comma-separated carroceria ids)
if (isset($_GET['carroceria']) && trim($_GET['carroceria']) !== '') {
  $carroceria_raw = trim($_GET['carroceria']);
  $parts_car = array_filter(array_map('trim', explode(',', $carroceria_raw)));
  $carroceria_ids = [];
  foreach ($parts_car as $c) {
    if (ctype_digit($c)) $carroceria_ids[] = $c;
  }
  if (count($carroceria_ids) > 0) {
    $carroceria_esc = array_map(function ($c) use ($conexao) {
      return mysqli_real_escape_string($conexao, $c);
    }, $carroceria_ids);
    $whereParts[] = "carros.carroceria IN ('" . implode("','", $carroceria_esc) . "')";
  }
}

// optional propulsao filter (parent categories: comb, hib, ele)
// and optional combustivel filter (subtypes: gas, alc, fle, die, gnv, hev, phe, mhe, ele)
// When both parent(s) and subtype(s) are present, combine them with OR so
// the query returns cars matching either the selected propulsao parents
// or the selected combustivel subtypes (e.g., Elétrico OR Gasolina).

$propClause = '';
$combClause = '';

if (isset($_GET['propulsao']) && trim($_GET['propulsao']) !== '') {
  $parts_prop = array_filter(array_map('trim', explode(',', $_GET['propulsao'])));
  $map = [
    'comb' => 'combustao',
    'hib' => 'hibrido',
    'ele' => 'eletrico'
  ];
  $vals = [];
  foreach ($parts_prop as $p) {
    $pl = strtolower($p);
    if (isset($map[$pl])) $vals[] = $map[$pl];
  }
  if (count($vals) > 0) {
    $vals_esc = array_map(function ($c) use ($conexao) { return mysqli_real_escape_string($conexao, $c); }, $vals);
    $propClause = "carros.propulsao IN ('" . implode("','", $vals_esc) . "')";
  }
}

if (isset($_GET['combustivel']) && trim($_GET['combustivel']) !== '') {
  $parts_comb = array_filter(array_map('trim', explode(',', $_GET['combustivel'])));
  $mapc = [
    'gas' => 'Gasolina',
    'alc' => 'Álcool',
    'fle' => 'Flex',
    'die' => 'Diesel',
    'gnv' => 'GNV',
    'hev' => 'HEV',
    'phe' => 'PHEV',
    'mhe' => 'MHEV',
    'ele' => 'Elétrico'
  ];
  $cvals = [];
  foreach ($parts_comb as $c) {
    $cl = strtolower($c);
    if (isset($mapc[$cl])) $cvals[] = $mapc[$cl];
  }
  if (count($cvals) > 0) {
    $cvals_esc = array_map(function ($c) use ($conexao) { return mysqli_real_escape_string($conexao, $c); }, $cvals);
    $combClause = "carros.combustivel IN ('" . implode("','", $cvals_esc) . "')";
  }
}

// Add combined clause: if both exist, wrap with OR to avoid impossible AND
if ($propClause !== '' && $combClause !== '') {
  $whereParts[] = "(" . $propClause . " OR " . $combClause . ")";
} elseif ($propClause !== '') {
  $whereParts[] = $propClause;
} elseif ($combClause !== '') {
  $whereParts[] = $combClause;
}

$where_sql = count($whereParts) ? ' WHERE ' . implode(' AND ', $whereParts) : '';

$sql = "SELECT 
  carros.*, 
  marcas.nome AS marca_nome,
  IF(favoritos.id IS NULL, 0, 1) AS favoritado
FROM 
  anuncios_carros carros
INNER JOIN 
  marcas ON carros.marca = marcas.id
LEFT JOIN 
  favoritos ON favoritos.anuncio_id = carros.id 
         AND favoritos.usuario_id = '$id'" . $where_sql . $order_sql . "\nLIMIT $quantidade";

$resultado = mysqli_query($conexao, $sql);

if (!$resultado) {
  die("Erro na consulta SQL: " . mysqli_error($conexao));
}

$carros = [];

$qtd_resultados = mysqli_num_rows($resultado) ?? 0;

while ($linha = mysqli_fetch_array($resultado)) {
  $carros[] = $linha;
}

$sql = "SELECT value, nome FROM marcas";
$resultado = mysqli_query($conexao, $sql);

$marcas = [];

while ($linha = mysqli_fetch_array($resultado)) {
  $marcas[] = $linha;
}
// fetch available colors for sidebar filter
$sql = "SELECT id, nome FROM cores";
$resultado = mysqli_query($conexao, $sql);
$cores = [];
if ($resultado) {
  while ($linha = mysqli_fetch_array($resultado)) {
    $cores[] = $linha;
  }
}
// fetch available carrocerias for sidebar filter
$sql = "SELECT id, nome FROM carrocerias";
$resultado = mysqli_query($conexao, $sql);
$carrocerias = [];
if ($resultado) {
  while ($linha = mysqli_fetch_array($resultado)) {
    $carrocerias[] = $linha;
  }
}
// keep DB connection open to fetch fotos for each anuncio below
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="style.css">
  <title>Fahren</title>
</head>
<style>
  .accordion-button:not(.collapsed) {
    background-color: transparent;
    color: #212529;
  }

  .card-compra .carousel {
    z-index: 2;
  }

  .card-compra .favoritar-btn {
    z-index: 3;
  }

  /* ===== Mostrar filtros em telas pequenas: remover comportamento sticky/vh-100 no mobile ===== */
  @media (max-width: 991px) {
    /* deixa a coluna de filtros estática e ocupando largura completa em mobile */
    #filtros-col {
      position: static !important;
      max-height: none !important;
      height: auto !important;
      padding-top: 1rem !important;
    }

    /* permite que o conteúdo interno role sem romper layout */
    #filtros-over {
      max-height: none !important;
      overflow: visible !important;
    }
  }
</style>

<body>
  <?php
  include 'estruturas/top-button/top-button.php' ?>
  <?php
  $float = true;
  include 'estruturas/navbar/navbar-compras.php' ?>
  <main class="bg-body-tertiary fs-nav">
    <div class="container-fluid">
      <div class="row d-flex justify-content-center">
        <div class="col-12 col-lg-10 col-lg-10">
          <div class="row pt-5 pb-3 pb-lg-0">
            <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="." class="link-dark link-underline-opacity-0 link-underline-opacity-100-hover">Home</a></li>

                <?php if (isset($vendedor)) {
                  echo "<li class=\"breadcrumb-item\"><a href=\"compras.php\" class=\"link-dark link-underline-opacity-0 link-underline-opacity-100-hover\">Carros</a></li>
                <li class=\"breadcrumb-item active text-dark fw-semibold\" aria-current=\"page\">" . $vendedor . "</li>";
                } else {
                  echo "<li class=\"breadcrumb-item active text-dark fw-semibold\" aria-current=\"page\">Carros</li>";
                }; ?>
              </ol>
              <h4><?php if (isset($vendedor)) {
                    echo "Anúncios de " . $vendedor;
                  } else {
                    echo "Carros de todo o Brasil!";
                  }; ?></h4>
            </nav>
          </div>
          <div class="row g-4">
            <div id="filtros-col" class="col-12 col-lg-4 col-xl-3 col-xxl-2 pt-4 d-flex flex-column" style="max-height: 100vh;">
              <div id="filtros-over" class="overflow-y-auto rounded-2 border border-opacity-25 shadow-sm" style="max-height: 100%;">
                <div class="accordion w-100" id="accordionPanelsStayOpenExample">
                  <?php if (isset($vendedor)): ?>
                    <!-- Vendedor ⬇️ -->
                    <div class="accordion-item border-0 border-bottom">
                      <h2 class="accordion-header">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#vendedor" aria-expanded="true" aria-controls="vendedor">
                          Vendedor
                        </button>
                      </h2>
                      <div id="vendedor" class="accordion-collapse collapse show">
                        <div class="accordion-body">
                          <div class="row">
                            <div class="rounded-3 border-2">
                              <div class="row">
                                <div class="col p-2 d-flex align-items-center justify-content-center">
                                  <div class="ratio ratio-1x1">
                                    <img src="<?= $vendedor_img ?>" alt="" class="img-fluid rounded-3 shadow-sm">
                                  </div></i>
                                </div>
                                <div class="col-7 py-2">
                                  <div class="row">
                                    <p class="fw-semibold mb-0"><?= $vendedor ?></p>
                                  </div>
                                  <div class="row">
                                    <small title="Seguidores" class="fw-semibold mb-0"><i class="bi bi-person-fill me-1"></i><?= $vendedor_seg ?></small>
                                  </div>
                                </div>
                                <div class="col-3 d-inline-flex align-items-center text-nowrap">
                                  <small>Aberto <i class="bi bi-circle-fill text-success" style="font-size: 0.5rem !important; vertical-align: middle;"></i></small>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  <?php endif; ?>
                  <!-- Modelo ⬇️ -->
                  <div class="accordion-item border-0 border-bottom">
                    <h2 class="accordion-header">
                      <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#modelo" aria-expanded="true" aria-controls="modelo">
                        Modelo
                      </button>
                    </h2>
                    <div id="modelo" class="accordion-collapse collapse show">
                      <div class="accordion-body">
                        <div class="row px-1 mb-3">
                          <div class="mb-1">
                            <h6>Localização</h6>
                          </div>
                          <div class="row px-2 g-0 gap-2">
                            <input type="text" class="form-control" id="localizacao" autocomplete="off" placeholder="Informe o estado ou cidade">
                          </div>
                        </div>
                        <div class="row px-1">
                          <div class="mb-3">
                            <h6>Estado</h6>
                            <div class="row ps-3">
                              <div class="form-check">
                                <input class="form-check-input condicao-input" type="checkbox" id="usados" data-val="usado">
                                <label class="form-check-label" for="usados">
                                  Usados
                                </label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input condicao-input" type="checkbox" id="seminovos" data-val="seminovo">
                                <label class="form-check-label" for="seminovos">
                                  Seminovos
                                </label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input condicao-input" type="checkbox" id="novos" data-val="novo">
                                <label class="form-check-label" for="novos">
                                  Novos
                                </label>
                              </div>
                            </div>
                          </div>
                          <hr class="mb-4">
                          <div class="row px-1">
                            <div id="marcas-input" class="mb-3">
                              <h6>Marcas</h6>
                              <div class="input-group">
                                <select id="marca-select" name="" class="form-select">
                                  <option value="" selected>Todas as marcas</option>
                                  <?php foreach ($marcas as $marca): ?>
                                    <option value="<?= $marca['value'] ?>" <?php if ($url_marca === $marca['value']) echo 'selected'; ?>><?= $marca['nome'] ?></option>
                                  <?php endforeach; ?>
                                </select>
                                <button class="btn bg-white border <?php echo empty($url_marca) ? 'd-none' : ''; ?>">X</button>
                              </div>
                            </div>
                            <div id="modelos-input" class="mb-3 <?php echo empty($url_marca) ? 'd-none' : ''; ?>">
                              <h6>Modelos</h6>
                              <div class="input-group">
                                <select name="modelo" id="modelo-select" class="form-select">
                                  <option value="" selected>Todos os modelos</option>
                                </select>
                                <button class="btn bg-white border <?php echo empty($url_modelo) ? 'd-none' : ''; ?>">X</button>
                              </div>
                            </div>
                            <div id="versoes-input" class="mb-3 <?php echo empty($url_modelo) ? 'd-none' : ''; ?>">
                              <h6>Versões</h6>
                              <div class="input-group">
                                <select name="versao" id="versao-select" class="form-select">
                                  <option value="" selected>Todas as versões</option>
                                </select>
                                <button class="btn bg-white border <?php echo empty($url_versao) ? 'd-none' : ''; ?>">X</button>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                  </div>
                  <!-- Preço ⬇️ -->
                  <div class="accordion-item border-0 border-bottom">
                    <h2 class="accordion-header">
                      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#preco" aria-expanded="true" aria-controls="preco">
                        Preço
                      </button>
                    </h2>
                    <div id="preco" class="accordion-collapse collapse">
                      <div class="accordion-body">
                        <div class="row">
                          <div class="mb-1">
                            <h6>Intervalo de preço</h6>
                          </div>
                          <div class="row px-2 g-0 gap-2">
                            <div class="col">
                              <input type="text" class="form-control preco-input-rs" id="preco-min" placeholder="Preço mínimo">
                            </div>
                            <div class="col">
                              <input type="text" class="form-control preco-input-rs" id="preco-max" placeholder="Preço máximo">
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                  </div>
                  <!-- Ano ⬇️ -->
                  <div class="accordion-item border-0 border-bottom">
                    <h2 class="accordion-header">
                      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#ano" aria-expanded="true" aria-controls="ano">
                        Ano
                      </button>
                    </h2>
                    <div id="ano" class="accordion-collapse collapse">
                      <div class="accordion-body">
                        <div class="row">
                          <div class="mb-1">
                            <h6>Intervalo de tempo</h6>
                          </div>
                          <div class="row px-2 g-0 gap-2">
                            <div class="col">
                              <input type="text" class="form-control" id="ano-min" placeholder="Ano mínimo">
                            </div>
                            <div class="col">
                              <input type="text" class="form-control" id="ano-max" placeholder="Ano máximo">
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                  </div>
                  <!-- Quilometragem ⬇️ -->
                  <div class="accordion-item border-0 border-bottom">
                    <h2 class="accordion-header">
                      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#km" aria-expanded="true" aria-controls="km">
                        Quilometragem
                      </button>
                    </h2>
                    <div id="km" class="accordion-collapse collapse">
                      <div class="accordion-body">
                        <div class="row">
                          <div class="mb-1">
                            <h6>Intervalo de quilometragem</h6>
                          </div>
                          <div class="row px-2 g-0 gap-2">
                            <div class="col">
                              <input type="text" class="form-control" id="km-min" placeholder="km mínimo">
                            </div>
                            <div class="col">
                              <input type="text" class="form-control" id="km-max" placeholder="km máximo">
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                  </div>
                  <!-- Cor ⬇️ -->
                  <div class="accordion-item border-0 border-bottom">
                    <h2 class="accordion-header">
                      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#cor" aria-expanded="true" aria-controls="cor">
                        Cor
                      </button>
                    </h2>
                    <div id="cor" class="accordion-collapse collapse">
                      <div class="accordion-body">
                        <div class="row ps-3">
                          <?php if (!empty($cores)): ?>
                            <?php foreach ($cores as $cor): ?>
                              <div class="form-check col-12">
                                <input class="form-check-input cor-input" type="checkbox" id="cor-<?= $cor['id'] ?>" data-val="<?= $cor['id'] ?>">
                                <label class="form-check-label" for="cor-<?= $cor['id'] ?>"><?= htmlspecialchars($cor['nome']) ?></label>
                              </div>
                            <?php endforeach; ?>
                          <?php else: ?>
                            <div class="form-text">Sem cores cadastradas</div>
                          <?php endif; ?>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- Carroceria ⬇️ -->
                  <div class="accordion-item border-0 border-bottom">
                    <h2 class="accordion-header">
                      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#carroceria" aria-expanded="false" aria-controls="carroceria">
                        Carroceria
                      </button>
                    </h2>
                    <div id="carroceria" class="accordion-collapse collapse">
                      <div class="accordion-body">
                        <div class="row ps-3">
                          <?php if (!empty($carrocerias)): ?>
                            <?php foreach ($carrocerias as $carroceria): ?>
                              <div class="form-check col-12">
                                <input class="form-check-input carroceria-input" type="checkbox" id="carroceria-<?= $carroceria['id'] ?>" data-val="<?= $carroceria['id'] ?>">
                                <label class="form-check-label" for="carroceria-<?= $carroceria['id'] ?>"><?= htmlspecialchars($carroceria['nome']) ?></label>
                              </div>
                            <?php endforeach; ?>
                          <?php else: ?>
                            <div class="form-text">Sem carrocerias cadastradas</div>
                          <?php endif; ?>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- Propulsão ⬇️ -->
                  <div class="accordion-item border-0 border-bottom">
                    <h2 class="accordion-header">
                      <button class="accordion-button<?php if ($categoria != 'ele' and $categoria != 'hib') {
                                                        echo ' collapsed';
                                                      } ?>" type="button" data-bs-toggle="collapse" data-bs-target="#propulsao" aria-expanded="true" aria-controls="propulsao">
                        Propulsão
                      </button>
                    </h2>
                    <div id="propulsao" class="accordion-collapse collapse<?php if ($categoria == 'ele' or $categoria == 'hib') {
                                                                            echo ' show';
                                                                          } ?>">
                      <div class="accordion-body">
                        <div class="row ps-3">
                          <?php
                          $text = 'Combustão';
                          $id = 'comb';
                          include $filter_check_caminho ?>
                          <div id="comb-tipos" class="ps-3">
                            <?php
                            $text = 'Gasolina';
                            $id = 'gas';
                            include $filter_check_caminho;
                            ?>
                            <?php
                            $text = 'Álcool';
                            $id = 'alc';
                            include $filter_check_caminho;
                            ?>
                            <?php
                            $text = 'Flex';
                            $id = 'fle';
                            include $filter_check_caminho;
                            ?>
                            <?php
                            $text = 'Diesel';
                            $id = 'die';
                            include $filter_check_caminho;
                            ?>
                            <?php
                            $text = 'GNV';
                            $id = 'gnv';
                            include $filter_check_caminho;
                            ?>
                          </div>
                          <?php
                          $text = 'Híbrido';
                          $id = 'hib';
                          include $filter_check_caminho ?>
                          <div id="hib-tipos" class="ps-3">
                            <?php
                            $text = 'HEV';
                            $id = 'hev';
                            include $filter_check_caminho;
                            ?>
                            <?php
                            $text = 'PHEV';
                            $id = 'phe';
                            include $filter_check_caminho;
                            ?>
                            <?php
                            $text = 'MHEV';
                            $id = 'mhe';
                            include $filter_check_caminho;
                            ?>
                          </div>
                          <?php
                          $text = 'Elétrico';
                          $id = 'ele';
                          include $filter_check_caminho ?>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- Câmbio ⬇️ -->
                  <div class="accordion-item border-0 border-bottom">
                    <h2 class="accordion-header">
                      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#cambio" aria-expanded="true" aria-controls="cambio">
                        Câmbio
                      </button>
                    </h2>
                    <div id="cambio" class="accordion-collapse collapse">
                      <div class="accordion-body">
                        <div class="row ps-3">
                          <?php
                          $text = 'Automático';
                          $id = 'aut';
                          include $filter_check_caminho ?>
                          <?php
                          $text = 'Manual';
                          $id = 'man';
                          include $filter_check_caminho ?>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- Blindagem ⬇️ -->
                  <div class="accordion-item border-0 border-bottom">
                    <h2 class="accordion-header">
                      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#blindagem" aria-expanded="true" aria-controls="blindagem">
                        Blindagem
                      </button>
                    </h2>
                    <div id="blindagem" class="accordion-collapse collapse">
                      <div class="accordion-body">
                        <div class="row ps-3">
                          <?php
                          $text = 'Sim';
                          $id = 'bli';
                          include $filter_check_caminho ?>
                          <?php
                          $text = 'Não';
                          $id = 'n-bli';
                          include $filter_check_caminho ?>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col">
              <?php if (isset($vendedor)): ?>
                <div class="mt-4">
                  <img src="https://preview.redd.it/bugatti-chiron-spotted-in-same-parking-garage-back-to-back-v0-08ed1s0xv6ne1.jpg?width=640&crop=smart&auto=webp&s=ccef8f6c11ef172dbe050cd06911e0f01920d714" class="w-100 border h-auto object-fit-cover rounded-4" style="aspect-ratio: 1/.125;">
                </div>
              <?php endif ?>
              <div class="row pt-4">
                <div class="col-auto me-auto">
                  <div class="fw-semibold small py-3">
                    <?= $qtd_resultados; ?> resultados encontrados
                  </div>
                </div>
                <div class="col-auto d-flex align-items-center mb-3">
                  <button id="ordenar-btn" class="btn btn-light border me-2" disabled><i class="bi bi-filter"></i></button>
                  <div class="small">Ordenar por: </div>
                  <div class="col-auto">
                    <select id="ordenar-input" class="form-select form-select-sm bg-transparent border-0 fw-semibold">
                      <option value="relevancia" <?php if ($sort === 'relevancia') echo 'selected'; ?>>Relevância</option>
                      <option value="preco" <?php if ($sort === 'preco') echo 'selected'; ?>>Preço</option>
                      <option value="ano" <?php if ($sort === 'ano') echo 'selected'; ?>>Ano</option>
                      <option value="km" <?php if ($sort === 'km') echo 'selected'; ?>>KM</option>
                    </select>
                  </div>
                </div>
              </div>
              <div id="area-compra" class="row row-cols-2 row-cols-lg-3 row-cols-xl-4 row-cols-xxl-6 g-3 g-lg-2">
                <?php
                foreach ($carros as $carro): ?>
                  <div class="col">
                    <?php
                    $marca = $carro['marca_nome'];
                    $modelo = $carro['modelo'];
                    $versao = $carro['versao'];
                    $preco = $carro['preco'];
                    $ano = $carro['ano_fabricacao'] . '/' . $carro['ano_modelo'];
                    $km = $carro['quilometragem'];
                    $cor = $carro['cor'];
                    $troca = $carro['aceita_troca'];
                    $revisao = $carro['revisao'];
                    $id = $carro['id'];
                    $loc = $carro['cidade'] . ' - '  . $carro['estado_local'];
                    // fetch photos for this anuncio into $imgs array (no predefined img1..img6)
                    $imgs = [];
                    $qr = mysqli_query($conexao, "SELECT caminho_foto FROM fotos_carros WHERE carro_id = $id ORDER BY `ordem` ASC");
                    if ($qr && mysqli_num_rows($qr) > 0) {
                      while ($r = mysqli_fetch_assoc($qr)) {
                        $path = 'img/anuncios/carros/' . $id . '/' . $r['caminho_foto'];
                        $imgs[] = $path;
                      }
                    }
                    $favoritado = $carro['favoritado'];
                    include 'estruturas/card-compra/card-compra.php'; ?>
                  </div>
                <?php endforeach; ?>
              </div>
            </div>
          </div>
        </div>
      </div>
      <?php if (!empty($carros)): ?>
        <div class="container-fluid mt-5 pb-5">
          <div class="row">
            <div class="col-12 d-flex justify-content-center">
              <nav aria-label="Page navigation example">
                <ul class="pagination pagination-dark">
                  <?php $qs = "&sort=" . urlencode($sort) . "&dir=" . urlencode($dir); ?>
                  <li class="page-item <?php if ($page == 1) {
                                          echo 'disabled';
                                        } ?>">
                    <a class="page-link" href="compras.php?page=<?= $page - 1 ?><?= $qs ?>" tabindex="-1" aria-disabled="true"><i class="bi bi-caret-left-fill"></i></a>
                  </li>
                  <?php if ($page >= 3) {
                    echo '<li class="page-item">
                  <a class="page-link" href="compras.php?page=1' . $qs . '" tabindex="-1" aria-disabled="true">1</a>
                </li>
                <li class="page-item disabled">
                  <a class="page-link" href="#" tabindex="-1" aria-disabled="true">...</a>
                </li>';
                  }; ?>
                  <li class="page-item <?php if ($page == 1) {
                                          echo 'active';
                                        } ?>"><a class="page-link border-0" href="compras.php?page=<?php if ($page == 1) {
                                                                                                      echo $page;
                                                                                                    } else {
                                                                                                      echo $page - 1;
                                                                                                    } ?><?= $qs ?>"><?php if ($page == 1) {
                                                                                                                      echo $page;
                                                                                                                    } else {
                                                                                                                      echo $page - 1;
                                                                                                                    } ?></a></li>
                  <li class="page-item <?php if ($page != 1) {
                                          echo 'active';
                                        } ?>"><a class="page-link" href="compras.php?page=<?php if ($page == 1) {
                                                                                            echo $page + 1;
                                                                                          } else {
                                                                                            echo $page;
                                                                                          } ?><?= $qs ?>"><?php if ($page == 1) {
                                                                                                            echo $page + 1;
                                                                                                          } else {
                                                                                                            echo $page;
                                                                                                          } ?></a></li>
                  <li class="page-item"><a class="page-link" href="compras.php?page=<?php if ($page == 1) {
                                                                                      echo $page + 2;
                                                                                    } else {
                                                                                      echo $page + 1;
                                                                                    } ?><?= $qs ?>"><?php if ($page == 1) {
                                                                                                      echo $page + 2;
                                                                                                    } else {
                                                                                                      echo $page + 1;
                                                                                                    } ?></a></li>
                  <li class="page-item"><a class="page-link" href="compras.php?page=<?php if ($page == 1) {
                                                                                      echo $page + 3;
                                                                                    } else {
                                                                                      echo $page + 2;
                                                                                    } ?><?= $qs ?>"><?php if ($page == 1) {
                                                                                                      echo $page + 3;
                                                                                                    } else {
                                                                                                      echo $page + 2;
                                                                                                    } ?></a></li>
                  <li class="page-item">
                    <a class="page-link" href="compras.php?page=<?= $page + 1 ?><?= $qs ?>"><i class="bi bi-caret-right-fill"></i></a>
                  </li>
                </ul>
              </nav>
            </div>
          </div>
        </div>
      <?php endif; ?>
  </main>
  <?php include 'estruturas/footer/footer.php' ?>
</body>
<?php if (isset($conexao)) {
  mysqli_close($conexao);
} ?>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
<script src="script.js"></script>
<script>
  $(function() {
    <?php if (isset($_GET['marca'])): ?>
      const initialMarca = <?= json_encode($_GET['marca']) ?>;
    <?php endif; ?>
    <?php if (isset($_GET['modelo'])): ?>
      const initialModelo = <?= json_encode($_GET['modelo']) ?>;
    <?php endif; ?>
    <?php if (isset($_GET['versao'])): ?>
      const initialVersao = <?= json_encode($_GET['versao']) ?>;
    <?php endif; ?>
    <?php if (isset($_GET['q'])): ?>
      const searchQ = <?= json_encode($_GET['q']) ?>;
      $('#navbar-search').val(searchQ);
      $('#global-search').val(searchQ);
    <?php endif; ?>
    // expose searchQ to other handlers (mutable so search bar can update sidebar)
    let pageSearchQ = typeof searchQ !== 'undefined' ? searchQ : null;
    const cards = $('.card-compra');
    cards.each(function() {
      const card = $(this);
      const carousel = card.find('.carousel');
      const items = carousel.find('.carousel-item');
      const quant = Math.max(1, items.length);
      card.data('quant', quant);
      card.find('.max').text(quant);

      // set initial min based on active slide
      let activeIdx = carousel.find('.carousel-item.active').index();
      if (activeIdx === -1) activeIdx = 0;
      card.find('.min').text(activeIdx + 1);

      // update counter after slide finishes to avoid desync with animation
      carousel.on('slid.bs.carousel', function() {
        const idx = $(this).find('.carousel-item.active').index();
        card.find('.min').text(idx + 1);
      });

      // hide controls by default; show on hover only if there are multiple images
      if (quant <= 1) {
        card.find('.carousel-control-prev, .carousel-control-next, #img-quant').hide();
      } else {
        card.find('.carousel-control-prev, .carousel-control-next, #img-quant').hide();
      }

      card.find('.favoritar-btn').hide();

      card.on('mouseenter', function() {
        if (quant > 1) card.find('.carousel-control-prev, .carousel-control-next, #img-quant').stop(true, true).fadeIn(300);
        card.find('.favoritar-btn').stop(true, true).fadeIn(300);
      });

      card.on('mouseleave', function() {
        if (quant > 1) card.find('.carousel-control-prev, .carousel-control-next, #img-quant').stop(true, true).fadeOut(300);
        card.find('.favoritar-btn').stop(true, true).fadeOut(300);
      });
    });

    $("#ele").addClass('propulsao');
    $("#hib").addClass('propulsao');
    $("#comb").addClass('propulsao');

    // Note: do not auto-check children on page load based only on parent state.
    // Children will be initialized from the `combustivel` URL param and parents
    // will be synced from children in `initializePropulsaoCheckboxes`.

    // When a parent (comb, hib, ele) is clicked, toggle all its children to match the parent state.
    // This will be the only place children are auto-toggled; child unchecks will NOT be reverted.
    $('.propulsao').on('change', function() {
      const parentId = $(this).attr('id');
      const container = $('#' + parentId + '-tipos');
      if (container.length) {
        const isParentChecked = $(this).is(':checked');
        container.find('input').prop('checked', isParentChecked);
      }
    });

    // Initialize propulsao checkboxes from URL and wire changes to update search params
    function initializePropulsaoCheckboxes() {
      const url = new URL(window.location.href);
      const propParam = url.searchParams.get('propulsao');
      const combParam = url.searchParams.get('combustivel');
      const parents = propParam ? propParam.split(',').map(v => v.trim()) : [];
      const subs = combParam ? combParam.split(',').map(v => v.trim()) : [];

      ['comb','hib','ele'].forEach(function(id) {
        const el = $('#' + id);
        if (el.length) el.prop('checked', parents.includes(id));
      });

      // Only check actual subtype checkboxes (gas, alc, fle, die, gnv, hev, phe, mhe)
      // Do NOT check parent-only boxes (ele)
      const subtypeIds = ['gas','alc','fle','die','gnv','hev','phe','mhe'];
      subs.forEach(function(s) {
        if (subtypeIds.includes(s)) {
          const el = $('#' + s);
          if (el.length) el.prop('checked', true);
        }
      });
      // If any child subtype is checked, ensure its parent is checked as well
      const parentMap = {
        'comb': '#comb-tipos',
        'hib': '#hib-tipos',
        'ele': null
      };
      Object.keys(parentMap).forEach(function(pid) {
        const container = parentMap[pid];
        if (!container) return;
        if ($(container + ' input:checked').length > 0) {
          const pel = $('#' + pid);
          if (pel.length) pel.prop('checked', true);
        }
      });
    }
    initializePropulsaoCheckboxes();

    // Do not auto-check children on load; children are initialized from the
    // `combustivel` URL parameter and parents are synced from children.

    let propTimer = null;
    const PROP_DEBOUNCE_MS = 600;
    $(document).on('change', '.propulsao, #comb-tipos input, #hib-tipos input', function() {
      if (propTimer) clearTimeout(propTimer);
      propTimer = setTimeout(function() {
        // Sync parent states based on children: if any child is checked, parent must be checked.
        // If all children are unchecked, parent is unchecked.
        const parentContainers = { 'comb': '#comb-tipos', 'hib': '#hib-tipos' };
        Object.keys(parentContainers).forEach(function(pid) {
          const cont = parentContainers[pid];
          const anyChild = $(cont + ' input:checked').length > 0;
          const pel = $('#' + pid);
          if (pel.length) {
            if (anyChild && !pel.is(':checked')) {
              pel.prop('checked', true);
            } else if (!anyChild && pel.is(':checked')) {
              pel.prop('checked', false);
            }
          }
        });

        // Build lists from current DOM state (do not modify, only read)
        const parents = [];
        $('.propulsao:checked').each(function() { parents.push($(this).attr('id')); });
        const subs = [];
        $('#comb-tipos input:checked, #hib-tipos input:checked').each(function() { subs.push($(this).attr('id')); });

        const url = new URL(window.location.href);
        url.searchParams.delete('page');

        if (parents.length === 0) {
          url.searchParams.delete('propulsao');
        } else {
          url.searchParams.set('propulsao', parents.join(','));
        }

        if (subs.length === 0) {
          url.searchParams.delete('combustivel');
        } else {
          url.searchParams.set('combustivel', subs.join(','));
        }

        window.location.href = url.toString();
      }, PROP_DEBOUNCE_MS);
    });

    const order_btn = $('#ordenar-btn');
    const order_i = $(order_btn).find("i");
    // initial sort state from server
    const currentSort = <?= json_encode($sort) ?>;
    const currentDir = <?= json_encode($dir) ?>;

    // reflect current dir in the icon
    if (currentSort === 'relevancia') {
      $(order_i).removeClass('bi-sort-up bi-sort-down').addClass('bi-filter');
      $(order_btn).prop('disabled', true);
    } else {
      $(order_btn).prop('disabled', false);
      $(order_i).removeClass('bi-filter');
      if (currentDir === 'asc') {
        $(order_i).addClass('bi-sort-up');
      } else {
        $(order_i).addClass('bi-sort-down');
      }
    }

    $('#ordenar-input').on('change', function() {
      const val = $(this).val();
      if (val === 'relevancia') {
        // go to relevance
        const url = new URL(window.location.href);
        url.searchParams.set('sort', 'relevancia');
        url.searchParams.delete('dir');
        url.searchParams.delete('page');
        window.location.href = url.toString();
        return;
      }
      // default to desc for new sorts
      const url = new URL(window.location.href);
      url.searchParams.set('sort', val);
      url.searchParams.set('dir', 'desc');
      url.searchParams.delete('page');
      window.location.href = url.toString();
    });

    $(order_btn).on('click', function() {
      // toggle direction for current sort and reload
      const sel = $('#ordenar-input').val();
      if (sel === 'relevancia') return;
      const url = new URL(window.location.href);
      const dirNow = url.searchParams.get('dir') === 'asc' ? 'asc' : 'desc';
      const newDir = dirNow === 'asc' ? 'desc' : 'asc';
      url.searchParams.set('sort', sel);
      url.searchParams.set('dir', newDir);
      url.searchParams.delete('page');
      window.location.href = url.toString();
    });

    $(window).on("scroll", function() {
      const filtrosCol = $("#filtros-col");
      const filtrosOver = $("#filtros-over");

      if (filtrosCol.length === 0 || filtrosOver.length === 0) return;

      const rect = filtrosCol[0].getBoundingClientRect();

      if (rect.top < 0) {
        filtrosOver.addClass("mt-auto");
      } else {
        filtrosOver.removeClass("mt-auto");
      }
    });

    const marcasInput = $("#marcas-input");
    const modelosInput = $("#modelos-input");
    const versoesInput = $("#versoes-input");
    // prepare flags to distinguish programmatic preselection from user actions
    let suppressMarcaNav = false;
    let suppressModeloNav = false;

    // Helper: update button visibility based on select value
    function updateButtonVisibility() {
      const marcaVal = $('#marca-select').val();
      const modeloVal = $('#modelo-select').val();
      const versaoVal = $('#versao-select').val();

      // Show marca button only if marca is selected
      if (marcaVal) {
        marcasInput.find('button').removeClass('d-none');
      } else {
        marcasInput.find('button').addClass('d-none');
      }

      // Show modelo button only if modelo is selected
      if (modeloVal) {
        modelosInput.find('button').removeClass('d-none');
      } else {
        modelosInput.find('button').addClass('d-none');
      }

      // Show versao button only if versao is selected
      if (versaoVal) {
        versoesInput.find('button').removeClass('d-none');
      } else {
        versoesInput.find('button').addClass('d-none');
      }
    }

    // Call on page load
    updateButtonVisibility();

    // Sync: search bar -> sidebar (one-way). Debounced input will try to match a brand in sidebar
    let searchSyncTimer = null;
    const SEARCH_SYNC_MS = 600;

    function handleSearchSync(q) {
      pageSearchQ = q; // update global used by populateModels
      if (!q || q.trim() === '') return;
      const sq = q.toLowerCase();
      let matchedMarca = null;
      $('#marca-select option').each(function() {
        const val = $(this).val();
        const txt = $(this).text().toLowerCase();
        if (val && txt && sq.indexOf(txt) !== -1) {
          matchedMarca = val;
          return false; // break
        }
      });
      if (matchedMarca) {
        // programmatic set: do not navigate, populate models and let populateModels infer model from pageSearchQ
        suppressMarcaNav = true;
        $('#marca-select').val(matchedMarca).trigger('change');
      }
    }

    $('#global-search, #navbar-search').on('input', function() {
      const v = $(this).val() || '';
      if (searchSyncTimer) clearTimeout(searchSyncTimer);
      searchSyncTimer = setTimeout(function() {
        handleSearchSync(v);
      }, SEARCH_SYNC_MS);
    });

    // helper: populate models for a marca and optionally preselect modelo (does not navigate)
    function populateModels(marcaVal, preselectModelo) {
      if (!marcaVal) return;
      console.log('[populateModels] marcaVal=', marcaVal, 'preselectModelo=', preselectModelo);
      modelosInput.removeClass('d-none');
      marcasInput.find('button').removeClass('d-none');
      const $modelo = $('#modelo-select');
      $modelo.empty();
      $modelo.append($('<option>', {
        value: '',
        text: '',
        hidden: true,
        selected: true
      }));
      $.getJSON('controladores/filters/get_models.php', {
          marca: marcaVal
        })
        .done(function(data) {
          $modelo.empty();
          $modelo.append($('<option>', {
            value: '',
            text: 'Todos os modelos',
            hidden: true,
            selected: true
          }));
          if (Array.isArray(data) && data.length) {
            data.forEach(function(m) {
              $modelo.append($('<option>', {
                value: m,
                text: m
              }));
            });
          }
          modelosInput.removeClass('d-none');
          marcasInput.find('button').removeClass('d-none');
          modelosInput.find('button').removeClass('d-none');
          if (preselectModelo) {
            suppressModeloNav = true;
            $modelo.val(preselectModelo).trigger('change');
          } else if (pageSearchQ) {
            // try to infer model from q
            const sq = pageSearchQ.toLowerCase();
            let matched = null;
            $modelo.find('option').each(function() {
              const t = $(this).text().toLowerCase();
              if (t !== '' && sq.indexOf(t) !== -1) {
                matched = $(this).val();
                return false;
              }
            });
            if (matched) {
              suppressModeloNav = true;
              $modelo.val(matched).trigger('change');
            }
          }
        })
        .fail(function() {
          // on error show the modelos block so user can retry
          modelosInput.removeClass('d-none');
          marcasInput.find('button').removeClass('d-none');
        });
    }

    // helper: populate versions for marca+modelo and optionally preselect versao (does not navigate)
    function populateVersions(marcaVal, modeloVal, preselectVersao) {
      if (!marcaVal || !modeloVal) return;
      console.log('[populateVersions] marca=', marcaVal, 'modelo=', modeloVal, 'preselectVersao=', preselectVersao);
      const $versao = $('#versao-select');
      $versao.empty();
      $versao.append($('<option>', {
        value: '',
        text: 'Carregando versões...',
        hidden: true,
        selected: true
      }));
      versoesInput.removeClass('d-none');
      modelosInput.find('button').removeClass('d-none');
      $.getJSON('controladores/filters/get_versions.php', {
          marca: marcaVal,
          modelo: modeloVal
        })
        .done(function(data) {
          $versao.empty();
          $versao.append($('<option>', {
            value: '',
            text: 'Todas as versões',
            hidden: true,
            selected: true
          }));
          if (Array.isArray(data) && data.length) {
            data.forEach(function(v) {
              $versao.append($('<option>', {
                value: v,
                text: v
              }));
            });
            versoesInput.removeClass('d-none');
            versoesInput.find('button').removeClass('d-none');
          }
          if (preselectVersao) {
            $versao.val(preselectVersao);
            versoesInput.removeClass('d-none');
            versoesInput.find('button').removeClass('d-none');
          }
          modelosInput.removeClass('d-none');
          modelosInput.find('button').removeClass('d-none');
        })
        .fail(function() {
          modelosInput.removeClass('d-none');
          modelosInput.find('button').removeClass('d-none');
        });
    }

    // if the page was loaded with an explicit marca param, prepopulate models (no navigation)
    if (typeof initialMarca !== 'undefined' && initialMarca) {
      console.log('[init] initialMarca=', initialMarca, 'initialModelo=', typeof initialModelo !== 'undefined' ? initialModelo : null);
      suppressMarcaNav = true; // mark this as programmatic
      populateModels(initialMarca, typeof initialModelo !== 'undefined' ? initialModelo : null);
      setTimeout(updateButtonVisibility, 100);
    }

    // if the page search contains a brand name, try to preselect the matching brand (don't navigate)
    if (pageSearchQ) {
      const sq = pageSearchQ.toLowerCase();
      $('#marca-select option').each(function() {
        const val = $(this).val();
        const txt = $(this).text().toLowerCase();
        if (val && txt && sq.indexOf(txt) !== -1) {
          console.log('[init] pageSearchQ matched marca option', txt, val);
          suppressMarcaNav = true;
          $('#marca-select').val(val);
          populateModels(val, null);
          return false; // break loop
        }
      });
    }

    // when brand changes, fetch models for that brand and populate the modelo-select
    marcasInput.find("select").on("change", function(e) {
      const isUser = !!e.originalEvent; // true when event came from a real user action
      const marcaVal = $(this).val();
      if (!marcaVal) {
        // clear models and versions
        modelosInput.addClass("d-none");
        modelosInput.find("select").val("");
        marcasInput.find("button").addClass("d-none");
        versoesInput.addClass("d-none");
        versoesInput.find("select").val("");
        // navigate clearing marca filters when the user clicked the clear (or user manually cleared)
        if (isUser) {
          const url = new URL(window.location.href);
          url.searchParams.delete('marca');
          url.searchParams.delete('modelo');
          url.searchParams.delete('versao');
          url.searchParams.delete('q');
          url.searchParams.delete('page');
          window.location.href = url.toString();
        } else {
          // programmatic clear (from our code) — only reset suppression
          suppressMarcaNav = false;
        }
        return;
      }
      // If this change came from a real user action, always treat it as user selection and navigate immediately.
      if (isUser) {
        const url = new URL(window.location.href);
        url.searchParams.set('marca', marcaVal);
        url.searchParams.delete('modelo');
        url.searchParams.delete('versao');
        // do not update search input when selecting marca in sidebar
        url.searchParams.delete('page');
        window.location.href = url.toString();
        return;
      }

      // otherwise it was programmatic (preselection) — if suppression active, populate models without navigating
      if (suppressMarcaNav) {
        modelosInput.removeClass("d-none");
        marcasInput.find("button").removeClass("d-none");
        suppressMarcaNav = false; // clear suppression immediately so next user action behaves normally
        populateModels(marcaVal, typeof initialModelo !== 'undefined' ? initialModelo : null);
      } else {
        // defensive fallback: navigate to apply marca filter
        const url = new URL(window.location.href);
        url.searchParams.set('marca', marcaVal);
        url.searchParams.delete('modelo');
        url.searchParams.delete('versao');
        // do not update search input when navigating for marca
        url.searchParams.delete('page');
        window.location.href = url.toString();
        return;
      }

      // Mark button visibility
      if (!isUser) {
        updateButtonVisibility();
      }
    });

    // when model changes, fetch versions for selected brand+model
    modelosInput.find("select").on("change", function(e) {
      const isUser = !!e.originalEvent;
      const modeloVal = $(this).val();
      const marcaVal = $('#marca-select').val();
      if (!modeloVal) {
        versoesInput.addClass("d-none");
        versoesInput.find("select").val("");
        modelosInput.find("button").addClass("d-none");
        if (isUser) {
          // user cleared modelo: navigate and keep marca
          const url = new URL(window.location.href);
          url.searchParams.delete('modelo');
          url.searchParams.delete('versao');
          url.searchParams.delete('q');
          url.searchParams.delete('page');
          window.location.href = url.toString();
        } else {
          // programmatic clear
          suppressModeloNav = false;
        }
        return;
      }

      if (isUser) {
        // user-driven selection: navigate to apply marca+modelo filter
        const url = new URL(window.location.href);
        url.searchParams.set('marca', marcaVal);
        url.searchParams.set('modelo', modeloVal);
        // do not update search input when selecting modelo in sidebar
        url.searchParams.delete('versao');
        url.searchParams.delete('page');
        window.location.href = url.toString();
        return;
      }

      // programmatic change: populate versions without navigating
      if (suppressModeloNav) {
        modelosInput.removeClass("d-none");
        marcasInput.find("button").removeClass("d-none");
        suppressModeloNav = false; // clear suppression immediately
        populateVersions(marcaVal, modeloVal, typeof initialVersao !== 'undefined' ? initialVersao : null);
        updateButtonVisibility();
      } else {
        // defensive fallback: navigate
        const url = new URL(window.location.href);
        url.searchParams.set('marca', marcaVal);
        url.searchParams.set('modelo', modeloVal);
        // do not update search input when navigating for modelo
        url.searchParams.delete('versao');
        url.searchParams.delete('page');
        window.location.href = url.toString();
      }
    });

    versoesInput.find("select").on("change", function(e) {
      const isUser = !!e.originalEvent;
      const versaoVal = $(this).val();
      if (versaoVal) {
        // navigate to apply version filter
        const marcaVal = $('#marca-select').val();
        const modeloVal = $('#modelo-select').val();
        const url = new URL(window.location.href);
        if (marcaVal) url.searchParams.set('marca', marcaVal);
        if (modeloVal) url.searchParams.set('modelo', modeloVal);
        url.searchParams.set('versao', versaoVal);
        // do not update search input when selecting versao in sidebar
        url.searchParams.delete('page');
        window.location.href = url.toString();
      } else if (!isUser) {
        updateButtonVisibility();
      }
    });

    marcasInput.find("button").on("click", function() {
      // user clicked clear on marca: remove marca/modelo/versao from URL and reload
      // (don't manipulate selects; let PHP do the rendering on reload)
      const url = new URL(window.location.href);
      url.searchParams.delete('marca');
      url.searchParams.delete('modelo');
      url.searchParams.delete('versao');
      url.searchParams.delete('q');
      url.searchParams.delete('page');
      window.location.href = url.toString();
    });

    modelosInput.find("button").on("click", function() {
      // user clicked clear on modelo: remove modelo/versao from URL and reload
      // (don't manipulate selects; let PHP do the rendering on reload)
      const url = new URL(window.location.href);
      url.searchParams.delete('modelo');
      url.searchParams.delete('versao');
      url.searchParams.delete('q');
      url.searchParams.delete('page');
      window.location.href = url.toString();
    });

    versoesInput.find("button").on("click", function() {
      // user clicked clear on versao: remove versao from URL and reload
      // (don't manipulate selects; let PHP do the rendering on reload)
      const url = new URL(window.location.href);
      url.searchParams.delete('versao');
      url.searchParams.delete('q');
      url.searchParams.delete('page');
      window.location.href = url.toString();
    });

    // Condição checkboxes (usado / seminovo / novo)
    // Initialize checkboxes based on URL param (not server-side)
    function initializeCondicaoCheckboxes() {
      const url = new URL(window.location.href);
      const codicaoParam = url.searchParams.get('codicao') || '';
      const values = codicaoParam ? codicaoParam.split(',').map(v => v.trim()) : [];

      $('.condicao-input').each(function() {
        const val = $(this).attr('data-val');
        const isChecked = values.includes(val);
        $(this).prop('checked', isChecked);
      });
    }

    // Initialize on page load
    initializeCondicaoCheckboxes();

    // Colors filter initialization + handler
    function initializeCorCheckboxes() {
      const url = new URL(window.location.href);
      const corParam = url.searchParams.get('cor') || '';
      const values = corParam ? corParam.split(',').map(v => v.trim()) : [];
      $('.cor-input').each(function() {
        const val = $(this).attr('data-val');
        const isChecked = values.includes(val);
        $(this).prop('checked', isChecked);
      });
    }
    initializeCorCheckboxes();

    let corTimer = null;
    const COR_DEBOUNCE_MS = 800;
    $('.cor-input').on('change', function() {
      // collect checked colors
      const checked = $('.cor-input:checked').length;
      // allow zero selection meaning 'all' (no filter)
      if (corTimer) clearTimeout(corTimer);
      corTimer = setTimeout(function() {
        const vals = [];
        $('.cor-input:checked').each(function() {
          const v = $(this).attr('data-val');
          if (v) vals.push(v);
        });
        const url = new URL(window.location.href);
        url.searchParams.delete('page');
        if (vals.length === 0) {
          url.searchParams.delete('cor');
        } else if (vals.length === 1) {
          url.searchParams.set('cor', vals[0]);
        } else {
          url.searchParams.set('cor', vals.join(','));
        }
        window.location.href = url.toString();
      }, COR_DEBOUNCE_MS);
    });

    // Carroceria filter initialization and handler
    function initializeCarroceriaCheckboxes() {
      const url = new URL(window.location.href);
      const carroceriaParam = url.searchParams.get('carroceria');
      const values = carroceriaParam ? carroceriaParam.split(',').map(v => v.trim()) : [];
      $('.carroceria-input').each(function() {
        const val = $(this).attr('data-val');
        const isChecked = values.includes(val);
        $(this).prop('checked', isChecked);
      });
    }
    initializeCarroceriaCheckboxes();

    let carroceriaTimer = null;
    const CARROCERIA_DEBOUNCE_MS = 800;
    $('.carroceria-input').on('change', function() {
      if (carroceriaTimer) clearTimeout(carroceriaTimer);
      carroceriaTimer = setTimeout(function() {
        const vals = [];
        $('.carroceria-input:checked').each(function() {
          const v = $(this).attr('data-val');
          if (v) vals.push(v);
        });
        const url = new URL(window.location.href);
        url.searchParams.delete('page');
        if (vals.length === 0) {
          url.searchParams.delete('carroceria');
        } else if (vals.length === 1) {
          url.searchParams.set('carroceria', vals[0]);
        } else {
          url.searchParams.set('carroceria', vals.join(','));
        }
        window.location.href = url.toString();
      }, CARROCERIA_DEBOUNCE_MS);
    });

    // Debounce changes so user can toggle multiple boxes before navigation
    let condicaoTimer = null;
    const CONDICAO_DEBOUNCE_MS = 450; // 1.5 seconds

    $('.condicao-input').on('change', function() {
      // Prevent unchecking if it's the last one checked
      const checkedCount = $('.condicao-input:checked').length;
      if (checkedCount === 0) {
        // Revert this checkbox back to checked
        $(this).prop('checked', true);
        return;
      }

      // clear any previous timer
      if (condicaoTimer) clearTimeout(condicaoTimer);
      condicaoTimer = setTimeout(function() {
        // collect checked condicao values
        const vals = [];
        $('.condicao-input:checked').each(function() {
          const v = $(this).attr('data-val');
          if (v) vals.push(v);
        });

        const url = new URL(window.location.href);
        // remove page when changing filters
        url.searchParams.delete('page');

        if (vals.length === 1) {
          url.searchParams.set('codicao', vals[0]);
        } else if (vals.length > 1) {
          // multiple values: join with comma
          url.searchParams.set('codicao', vals.join(','));
        }

        window.location.href = url.toString();
      }, CONDICAO_DEBOUNCE_MS);
    });

    // Auto-expand/collapse accordions based on active filters
    function updateAccordionState() {
      const checkAccordion = function(accordionId, checkboxSelector) {
        const accordion = $(`#${accordionId}`);
        const button = accordion.prev().find('button');
        const hasChecked = $(checkboxSelector).is(':checked');
        
        if (hasChecked) {
          // Open accordion
          accordion.addClass('show');
          button.removeClass('collapsed').attr('aria-expanded', 'true');
        } else {
          // Close accordion
          accordion.removeClass('show');
          button.addClass('collapsed').attr('aria-expanded', 'false');
        }
      };
      
      // Check each accordion
      checkAccordion('cor', '.cor-input:checked');
      checkAccordion('carroceria', '.carroceria-input:checked');
      // propulsão accordion: consider parent or any subtype checked
      checkAccordion('propulsao', '.propulsao:checked, #comb-tipos input:checked, #hib-tipos input:checked');
      // Add more accordions here as needed
    }
    
    // Initialize on page load
    updateAccordionState();
    
    // Update when filters change (include propulsao child/parents)
    $(document).on('change', '.cor-input, .carroceria-input, .propulsao, #comb-tipos input, #hib-tipos input', function() {
      updateAccordionState();
    });

  });

  (function() {
    const currentUser = <?= isset($_SESSION['id']) ? json_encode($_SESSION['id']) : 'null' ?>;

    $(document).on('click', 'button.favoritar', function() {
      let anuncioID = $(this).data('anuncio');
      if (!currentUser) {
        // not logged in: redirect to sign-in or show message
        window.location.href = 'sign-in.php';
        return;
      }

      $.post('controladores/veiculos/favoritar-veiculo.php', {
        usuario: currentUser,
        anuncio: anuncioID
      }, function(resposta) {
        console.log("Resposta do servidor:", resposta);
      }, 'json');
    });
  })();
</script>

</html>