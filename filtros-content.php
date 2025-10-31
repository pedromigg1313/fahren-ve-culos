<!-- estruturas/filtros/filtros-content.php -->
<div class="accordion w-100" id="accordionPanelsStayOpenExample">
  <?php if (isset($vendedor)) {
    echo "<!-- Vendedor ⬇️ -->
  <div class=\"accordion-item border-0 border-bottom\">
    <h2 class=\"accordion-header\">
      <button class=\"accordion-button\" type=\"button\" data-bs-toggle=\"collapse\" data-bs-target=\"#vendedor\" aria-expanded=\"true\" aria-controls=\"vendedor\">
        Vendedor
      </button>
    </h2>
    <div id=\"vendedor\" class=\"accordion-collapse collapse show\">
      <div class=\"accordion-body\">
        <div class=\"row\">
          <div class=\"rounded-3 border-2\">
                    <div class=\"row\">
                        <div class=\"col p-2 d-flex align-items-center justify-content-center\">
                            <div class=\"ratio ratio-1x1\">
                                <img src=\"" . $vendedor_img . "\" alt=\"\" class=\"img-fluid rounded-3 shadow-sm\">
                            </div></i>
                        </div>
                        <div class=\"col-7 py-2\">
                            <div class=\"row\">
                                <p class=\"fw-semibold mb-0\">" . $vendedor . "</p>
                            </div>
                            <div class=\"row\">
                                <small class=\"fw-semibold mb-0\">" . $vendedor_est . "<i class=\"bi bi-star-fill ms-1\"></i></small>
                            </div>
                        </div>
                        <div class=\"col-3 d-inline-flex align-items-center text-nowrap\">
                            <small>Aberto <i class=\"bi bi-circle-fill text-success\" style=\"font-size: 0.5rem !important; vertical-align: middle;\"></i></small>
                        </div>
                    </div>
                </div>
        </div>
      </div>
    </div>
  </div>";
  }; ?>
  <!-- Modelo ⬇️ -->
  <div class="accordion-item border-0 border-bottom">
    <h2 class="accordion-header">
      <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#modelo" aria-expanded="true" aria-controls="modelo">
        Modelo
      </button>
    </h2>
    <div id="modelo" class="accordion-collapse collapse show">
      <div class="accordion-body">
        <div class="row mb-4">
          <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
            <input type="radio" class="btn-check" name="btnradio" id="btnradio1" autocomplete="off" <?php if ($tipo == 'carro') {
                                                                                                      echo 'checked';
                                                                                                    } ?>>
            <label class="btn btn-outline-dark rounded-start-5" for="btnradio1"><i class="bi bi-car-front-fill"></i> Carros</label>

            <input type="radio" class="btn-check" name="btnradio" id="btnradio2" autocomplete="off" <?php if ($tipo == 'moto') {
                                                                                                      echo 'checked';
                                                                                                    } ?>>
            <label class="btn btn-outline-dark rounded-end-5" for="btnradio2"><i class="bi bi-bicycle"></i> Motos</label>
          </div>
        </div>
        <div class="row px-1">
          <div class="mb-3">
            <h6>Estado</h6>
            <div class="row ps-3">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="usados" <?php if ($codicao == 'usado') {
                                                                              echo 'checked';
                                                                            } ?>>
                <label class="form-check-label" for="usados">
                  Usados
                </label>
                <small class="float-end">
                  (5421)
                </small>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" id="novos" <?php if ($codicao == 'novo') {
                                                                              echo 'checked';
                                                                            } ?>>
                <label class="form-check-label" for="novos">
                  Novos
                </label>
                <small class="float-end">
                  (815)
                </small>
              </div>
            </div>
          </div>
          <hr class="mb-4">
          <div class="row px-1">
            <div id="marcas-input" class="mb-3">
              <h6>Marcas</h6>
              <div class="input-group">
                <select id="marca-select" name="" id="" class="form-select">
                  <option value="" selected hidden>Selecione a marca</option>
                  <?php foreach ($marcas as $marca): ?>
                    <option value="<?= $marca['value'] ?>"><?= $marca['nome'] ?></option>
                  <?php endforeach; ?>
                </select>
                <button class="btn bg-white border d-none">X</button>
              </div>
            </div>
            <div id="modelos-input" class="mb-3 d-none">
              <h6>Modelos</h6>
              <div class="input-group">
                <select name="" id="" class="form-select">
                  <option value="" selected hidden>Selecione o modelo</option>
                  <option value="modelo-1">Modelo 1</option>
                  <option value="modelo-2">Modelo 2</option>
                  <option value="modelo-3">Modelo 3</option>
                  <option value="modelo-4">Modelo 4</option>
                  <option value="modelo-5">Modelo 5</option>
                  <option value="modelo-6">Modelo 6</option>
                  <option value="modelo-7">Modelo 7</option>
                  <option value="modelo-8">Modelo 8</option>
                  <option value="modelo-9">Modelo 9</option>
                  <option value="modelo-10">Modelo 10</option>
                </select>
                <button class="btn bg-white border d-none">X</button>
              </div>
            </div>
            <div id="versoes-input" class="mb-3 d-none">
              <h6>Versões</h6>
              <div class="input-group">
                <select name="" id="" class="form-select">
                  <option value="" selected hidden>Selecione a versão</option>
                  <option value="versao-1">Versão 1</option>
                  <option value="versao-2">Versão 2</option>
                  <option value="versao-3">Versão 3</option>
                  <option value="versao-4">Versão 4</option>
                  <option value="versao-5">Versão 5</option>
                  <option value="versao-6">Versão 6</option>
                  <option value="versao-7">Versão 7</option>
                  <option value="versao-8">Versão 8</option>
                  <option value="versao-9">Versão 9</option>
                  <option value="versao-10">Versão 10</option>
                </select>
                <button class="btn bg-white border d-none">X</button>
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
              <input type="text" class="form-control" id="preco-min" placeholder="Preço mínimo">
            </div>
            <div class="col">
              <input type="text" class="form-control" id="preco-max" placeholder="Preço máximo">
            </div>
          </div>
          <div class="row mt-3">
            <h6 class="small mb-0">Faixa de preço específico</h6>
            <div class="row row-cols-2 row-cols-xxl-3 gy-1">
              <div class="col">
                <button class="btn bg-secondary-subtle w-auto rounded-pill py-0 px-2">
                  <div class="small text-nowrap">≤ 50 mil</div>
                </button>
              </div>
              <div class="col">
                <button class="btn bg-secondary-subtle w-auto rounded-pill py-0 px-2">
                  <div class="small text-nowrap">≤ 75 mil</div>
                </button>
              </div>
              <div class="col">
                <button class="btn bg-secondary-subtle w-auto rounded-pill py-0 px-2">
                  <div class="small text-nowrap">≤ 100 mil</div>
                </button>
              </div>
              <div class="col">
                <button class="btn bg-secondary-subtle w-auto rounded-pill py-0 px-2">
                  <div class="small text-nowrap">≤ 150 mil</div>
                </button>
              </div>
              <div class="col">
                <button class="btn bg-secondary-subtle w-auto rounded-pill py-0 px-2">
                  <div class="small text-nowrap">≤ 250 mil</div>
                </button>
              </div>
              <div class="col">
                <button class="btn bg-secondary-subtle w-auto rounded-pill py-0 px-2">
                  <div class="small text-nowrap">≤ 500 mil</div>
                </button>
              </div>
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
          <div class="row mt-3">
            <h6 class="small mb-0">Ano específico</h6>
            <div class="row row-cols-2 row-cols-xxl-4 gy-1">
              <div class="col">
                <button class="btn bg-secondary-subtle w-auto rounded-pill py-0 px-2">
                  <div class="small text-nowrap">2025</div>
                </button>
              </div>
              <div class="col">
                <button class="btn bg-secondary-subtle w-auto rounded-pill py-0 px-2">
                  <div class="small text-nowrap">2024</div>
                </button>
              </div>
              <div class="col">
                <button class="btn bg-secondary-subtle w-auto rounded-pill py-0 px-2">
                  <div class="small text-nowrap">2023</div>
                </button>
              </div>
              <div class="col">
                <button class="btn bg-secondary-subtle w-auto rounded-pill py-0 px-2">
                  <div class="small text-nowrap">2022</div>
                </button>
              </div>
              <div class="col">
                <button class="btn bg-secondary-subtle w-auto rounded-pill py-0 px-2">
                  <div class="small text-nowrap">2021</div>
                </button>
              </div>
              <div class="col">
                <button class="btn bg-secondary-subtle w-auto rounded-pill py-0 px-2">
                  <div class="small text-nowrap">2020</div>
                </button>
              </div>
              <div class="col">
                <button class="btn bg-secondary-subtle w-auto rounded-pill py-0 px-2">
                  <div class="small text-nowrap">2019</div>
                </button>
              </div>
              <div class="col">
                <button class="btn bg-secondary-subtle w-auto rounded-pill py-0 px-2">
                  <div class="small text-nowrap">2018</div>
                </button>
              </div>
            </div>
          </div>
          <div class="row mt-3">
            <h6 class="small mb-2">Intervalos de tempo</h6>
            <div class="row row-cols-1 row-cols-md-2 ps-1 gx-0">
              <div class="col">
                <button class="btn bg-secondary-subtle w-auto rounded-pill py-0 px-2">
                  <div class="small text-nowrap">2025-2022</div>
                </button>
              </div>
              <div class="col">
                <button class="btn bg-secondary-subtle w-auto rounded-pill py-0 px-2">
                  <div class="small text-nowrap">2022-2019</div>
                </button>
              </div>
              <div class="col">
                <button class="btn bg-secondary-subtle w-auto rounded-pill py-0 px-2">
                  <div class="small text-nowrap">2019-2016</div>
                </button>
              </div>
              <div class="col">
                <button class="btn bg-secondary-subtle w-auto rounded-pill py-0 px-2">
                  <div class="small text-nowrap">2016-2013</div>
                </button>
              </div>
              <div class="col">
                <button class="btn bg-secondary-subtle w-auto rounded-pill py-0 px-2">
                  <div class="small text-nowrap">2013-2010</div>
                </button>
              </div>
              <div class="col">
                <button class="btn bg-secondary-subtle w-auto rounded-pill py-0 px-2">
                  <div class="small text-nowrap">2010-2000</div>
                </button>
              </div>
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
          <div class="row mt-3">
            <h6 class="small mb-0">Quilometragens específico</h6>
            <div class="row gy-1">
              <div class="col-6">
                <button class="btn bg-secondary-subtle w-auto rounded-pill py-0 px-2">
                  <div class="small">&lt; 20K</div>
                </button>
              </div>
              <div class="col-6">
                <button class="btn bg-secondary-subtle w-auto rounded-pill py-0 px-2">
                  <div class="small">20K-50K</div>
                </button>
              </div>
              <div class="col-6">
                <button class="btn bg-secondary-subtle w-auto rounded-pill py-0 px-2">
                  <div class="small">50K-100K</div>
                </button>
              </div>
              <div class="col-6">
                <button class="btn bg-secondary-subtle w-auto rounded-pill py-0 px-2">
                  <div class="small">&gt; 100K</div>
                </button>
              </div>
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
          <?php
          $text = 'Branco';
          $id = 'branco';
          include 'filter-checkbox.php'; ?>
          <?php
          $text = 'Preto';
          $id = 'preto';
          include 'filter-checkbox.php'; ?>
          <?php
          $text = 'Vermelho';
          $id = 'verm';
          include 'filter-checkbox.php'; ?>
          <?php
          $text = 'Azul';
          $id = 'azul';
          include 'filter-checkbox.php'; ?>
          <?php
          $text = 'Cinza';
          $id = 'cinza';
          include 'filter-checkbox.php'; ?>
          <?php
          $text = 'Prata';
          $id = 'prata';
          include 'filter-checkbox.php'; ?>
          <?php
          $text = 'Vinho';
          $id = 'vinho';
          include 'filter-checkbox.php'; ?>
          <?php
          $text = 'Marrom';
          $id = 'marrom';
          include 'filter-checkbox.php'; ?>
          <?php
          $text = 'Laranja';
          $id = 'laranja';
          include 'filter-checkbox.php'; ?>
          <?php
          $text = 'Amarelo';
          $id = 'amarelo';
          include 'filter-checkbox.php'; ?>
          <?php
          $text = 'Dourado';
          $id = 'dourado';
          include 'filter-checkbox.php'; ?>
          <?php
          $text = 'Verde';
          $id = 'verde';
          include 'filter-checkbox.php'; ?>
          <?php
          $text = 'Bege';
          $id = 'bege';
          include 'filter-checkbox.php'; ?>
        </div>
      </div>
    </div>
  </div>
  <!-- Carroceria ⬇️ -->
  <div class="accordion-item border-0 border-bottom">
    <h2 class="accordion-header">
      <button class="accordion-button <?php if ($categoria == null or $categoria == 'ele' or $categoria == 'hib') {
                                        echo ' collapsed';
                                      } ?>" type="button" data-bs-toggle="collapse" data-bs-target="#carroceria" aria-expanded="true" aria-controls="carroceria">
        Carroceria
      </button>
    </h2>
    <div id="carroceria" class="accordion-collapse collapse <?php if ($categoria != null and $categoria != 'ele' and $categoria != 'hib') {
                                                              echo 'show';
                                                            } ?>">
      <div class="accordion-body">
        <div class="row ps-3">
          <?php
          $text = 'Sedan';
          $id = 'sed';
          include 'filter-checkbox.php'; ?>
          <?php
          $text = 'Hatchback';
          $id = 'hat';
          include 'filter-checkbox.php'; ?>
          <?php
          $text = 'Pickup';
          $id = 'pic';
          include 'filter-checkbox.php'; ?>
          <?php
          $text = 'Coupé';
          $id = 'cou';
          include 'filter-checkbox.php'; ?>
          <?php
          $text = 'Minivan';
          $id = 'min';
          include 'filter-checkbox.php'; ?>
          <?php
          $text = 'Supercarro';
          $id = 'sup';
          include 'filter-checkbox.php'; ?>
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
          include 'filter-checkbox.php'; ?>
          <div id="comb-tipos" class="ps-3">
            <?php
            $text = 'Gasolina';
            $id = 'gas';
            include 'filter-checkbox.php';
            ?>
            <?php
            $text = 'Álcool';
            $id = 'alc';
            include 'filter-checkbox.php';
            ?>
            <?php
            $text = 'Flex';
            $id = 'fle';
            include 'filter-checkbox.php';
            ?>
            <?php
            $text = 'Diesel';
            $id = 'die';
            include 'filter-checkbox.php';
            ?>
            <?php
            $text = 'GNV';
            $id = 'gnv';
            include 'filter-checkbox.php';
            ?>
          </div>
          <?php
          $text = 'Híbrido';
          $id = 'hib';
          include 'filter-checkbox.php'; ?>
          <div id="hib-tipos" class="ps-3">
            <?php
            $text = 'HEV';
            $id = 'hev';
            include 'filter-checkbox.php';
            ?>
            <?php
            $text = 'PHEV';
            $id = 'phe';
            include 'filter-checkbox.php';
            ?>
            <?php
            $text = 'MHEV';
            $id = 'mhe';
            include 'filter-checkbox.php';
            ?>
          </div>
          <?php
          $text = 'Elétrico';
          $id = 'ele';
          include 'filter-checkbox.php'; ?>
          <div id="ele-tipos" class="ps-3">
            <?php
            $text = 'BEV';
            $id = 'bev';
            include 'filter-checkbox.php';
            ?>
            <?php
            $text = 'FCEV';
            $id = 'fce';
            include 'filter-checkbox.php';
            ?>
          </div>
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
          include 'filter-checkbox.php'; ?>
          <?php
          $text = 'Manual';
          $id = 'man';
          include 'filter-checkbox.php'; ?>
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
          include 'filter-checkbox.php';?>
          <?php
          $text = 'Não';
          $id = 'n-bli';
          include 'filter-checkbox.php'; ?>
        </div>
      </div>
    </div>
  </div>
</div>