<?php session_start();
include('controladores/conexao_bd.php');
$filter_check_caminho = 'estruturas/filter/filter-checkbox.php';

$id = $_SESSION['id'] ?? null;

$tipo = $_GET['tipo'] ?? 'carro';
$codicao = $_GET['codicao'] ?? 'usado';
$categoria = $_GET['categoria'] ?? null;
$vendedor = $_GET['vendedor'] ?? null;
$vendedor_img = $_GET['vendedor_img'] ?? null;
$vendedor_est = $_GET['vendedor_est'] ?? null;

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
         AND favoritos.usuario_id = '$id'
WHERE ativo = 'A'" . $order_sql . "\nLIMIT $quantidade";

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

  .filtros-mobile-navbar {
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    background: white;
    border-top: 1px solid #dee2e6;
    z-index: 1030;
    padding: 0.5rem;
    box-shadow: 0 -2px 10px rgba(0,0,0,0.1);
  }
  
  .filtros-offcanvas {
    max-height: 80vh;
    overflow-y: auto;
  }
  
  /* Ajuste para não sobrepor conteúdo com a navbar mobile */
  @media (max-width: 767.98px) {
    main {
      padding-bottom: 70px;
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
          <div class="row pt-5">
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
            <div id="filtros-col" class="col-4 col-xl-3 col-xxl-2 vh-100 position-sticky top-0 pt-4 d-flex flex-column d-none d-md-block" style="max-height: 100vh;">
              <div id="filtros-over" class="overflow-y-auto rounded-2 border border-opacity-25 shadow-sm" style="max-height: 100%;">
                <?php include 'estruturas/filter/filtros-content.php'; ?>
              </div>
            </div>
            <div class="col">
              <div class="row pt-4">
                <div class="col-auto me-auto">
                  <div class="fw-semibold small py-3">
                    <?= $qtd_resultados; ?> resultados encontrados
                  </div>
                </div>
                <div class="col-auto d-flex align-items-center">
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
                    $loc = 'São José dos Campos - SP';
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
  <!-- Offcanvas para Filtros Mobile -->
<div class="offcanvas offcanvas-bottom d-md-none filtros-offcanvas" tabindex="-1" id="filtrosOffcanvas" aria-labelledby="filtrosOffcanvasLabel" style="height: 70vh;">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title" id="filtrosOffcanvasLabel">Filtros</h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">
    <?php include 'estruturas/filter/filtros-content.php'; ?>
  </div>
</div>

<!-- Navbar Mobile para Filtros -->
<nav class="navbar navbar-light bg-light fixed-bottom d-md-none filtros-mobile-navbar">
  <div class="container-fluid justify-content-center">
    <button class="btn btn-dark w-100" type="button" data-bs-toggle="offcanvas" data-bs-target="#filtrosOffcanvas">
      <i class="bi bi-funnel me-2"></i>Filtros
    </button>
  </div>
</nav>
  <?php include 'estruturas/footer/footer.php' ?>
</body>
<?php if (isset($conexao)) { mysqli_close($conexao); } ?>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
<script src="script.js"></script>
<script>
  $(function() {
    <?php if (isset($_GET['marca'])): ?>
      const marca = <?= json_encode($_GET['marca']) ?>;

      $('#marca-select option[selected]').prop('selected', false);
      $('#marca-select option[value="' + marca + '"]').prop('selected', true);
    <?php endif; ?>
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

    $('.propulsao:checked').each(function() {
      $("#" + $(this).attr('id') + "-tipos").children().each(function(i, e) {
        $(e).find('input').prop('checked', true);
      });
    });

    $('.propulsao').each(function() {
      $(this).on("change", function() {
        const propu = this;
        $("#" + $(this).attr('id') + "-tipos").children().each(function(i, e) {
          $(e).find('input').prop('checked', $(propu).prop('checked'));
        });
      })
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

    marcasInput.find("select").on("change", function() {
      if ($(this).val()) {
        modelosInput.removeClass("d-none");
        marcasInput.find("button").removeClass("d-none");
      } else {
        modelosInput.addClass("d-none");
        marcasInput.find("button").addClass("d-none");
      }
    });

    modelosInput.find("select").on("change", function() {
      if ($(this).val()) {
        versoesInput.removeClass("d-none");
        modelosInput.find("button").removeClass("d-none");
      } else {
        versoesInput.addClass("d-none");
        modelosInput.find("button").addClass("d-none");
      }
    });

    versoesInput.find("select").on("change", function() {
      if ($(this).val()) {
        versoesInput.find("button").removeClass("d-none");
      } else {
        versoesInput.find("button").addClass("d-none");
      }
    });

    marcasInput.find("button").on("click", function() {
      marcasInput.find("select").val("");
      marcasInput.find("button").addClass("d-none");
      modelosInput.find("button").addClass("d-none");
      versoesInput.find("button").addClass("d-none");
      modelosInput.addClass("d-none");
      modelosInput.find("select").val("");
      versoesInput.addClass("d-none");
      versoesInput.find("select").val("");
    });

    modelosInput.find("button").on("click", function() {
      modelosInput.find("select").val("");
      modelosInput.find("button").addClass("d-none");
      versoesInput.find("button").addClass("d-none");
      versoesInput.addClass("d-none");
      versoesInput.find("select").val("");
    });

    versoesInput.find("button").on("click", function() {
      versoesInput.find("select").val("");
      versoesInput.find("button").addClass("d-none");
    });
  });

  $(document).on('click', 'button.favoritar', function() {
    let anuncioID = $(this).data('anuncio');

    console.log(anuncioID)

    $.post('controladores/veiculos/favoritar-veiculo.php', {
      usuario: <?= $_SESSION['id'] ?>,
      anuncio: anuncioID
    }, function(resposta) {
      console.log("Resposta do servidor:", resposta);
    });
  });
</script>

</html>