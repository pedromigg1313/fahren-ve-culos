<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Suas Preferências</title>
    <link rel="icon" type="png" href="img/logo-oficial.png">
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
</head>
<body>
    <!-- CABEÇALHO -->
    <section class="container-fluid rounded-bottom-4 mb-3 px-md-5 pt-4 text-black" style="background-color: rgba(0, 0, 0, 0.1);">
        <h1 style="font-weight: bolder;" class="pb-2"><i class="bi bi-emoji-smile" style="font-size: 36px;"></i>&nbsp;Suas Preferências</h1>
    </section>
    <!-- CABEÇALHO -->

    <!-- VOLTAR -->
    <a href="A-conf.php" class="ms-4 voltar" style="font-size: 18px;">
        <i class="bi bi-arrow-left"></i>&nbsp;Voltar
    </a>
    <!-- VOLTAR -->
     
        <div class="container mt-3">
          <div class="row">
            <div class="col-md-4 mb-1">
              <section class="px-2 py-1 border border-dark rounded" style="background-color: rgba(0, 0, 0, 0.027);">
                <h5><i class="bi bi-search fs-5"></i>&nbspFiltros de Pesquisa</h5>    
                <h6>Principais Produtos:</h6>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" value="" id="ambos">
                    <label class="form-check-label" for="ambos">
                      Ambos(Padrão)
                    </label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" value="" id="carros">
                    <label class="form-check-label" for="carros">
                      Carros
                    </label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" value="" id="motos">
                    <label class="form-check-label" for="motos">
                      Motos
                    </label>
                  </div>
                  <br>
                  <h6>Remover alguma categoria na sua Pesquisa:</h6>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" value="" id="motos">
                      <label class="form-check-label" for="motos">
                        Produtos Novos
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" value="" id="motos">
                      <label class="form-check-label" for="motos">
                        Produtos Usados
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" value="" id="motos">
                      <label class="form-check-label" for="motos">
                        Produtos Populares
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" value="" id="motos">
                      <label class="form-check-label" for="motos">
                        Produtos com avaliações negativas
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" value="" id="motos">
                      <label class="form-check-label" for="motos">
                        Produtos com avaliações positivas
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" value="" id="motos">
                      <label class="form-check-label" for="motos">
                        Produtos da minha Lista de Desejos
                      </label>
                    </div>
                    <br>
                    <span>Pesquisar <a href="#" style="text-decoration: none;">Produtos na Loja</a></span> 
              </section>
            </div>
            <div class="col-md-4 mb-2">
              <section class="px-2 py-1 border border-dark rounded" style="background-color: rgba(0, 0, 0, 0.027);">
                  <h5><i class="bi bi-bookmark-heart-fill"></i>&nbspLista de Desejos</h5>    
                  <h6>Receber Notificações de oferta dos produtos de sua Lista de Desejos:</h6>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" value="" id="ambos">
                      <label class="form-check-label" for="ambos">
                        Sim(Padrão)
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" value="" id="ambos">
                      <label class="form-check-label" for="ambos">
                        Não
                      </label>
                    </div>
                    <br>
                    <h6>Visibilidade de Sua Lista de Desejos para outros:</h6>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" value="" id="ambos">
                      <label class="form-check-label" for="ambos">
                        Privado(Padrão)
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" value="" id="ambos">
                      <label class="form-check-label" for="ambos">
                        Público
                      </label>
                    </div>
                    <br>
                    <h6>Mostrar todas Informações dos Produtos na Lista de Desejos</h6>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" value="" id="ambos">
                      <label class="form-check-label" for="ambos">
                        Sim(Padrão)
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" value="" id="ambos">
                      <label class="form-check-label" for="ambos">
                        Não
                      </label>
                    </div>
                    <br>
                    <span>Analisar <a href="#" style="text-decoration: none;">Lista de Desejos</a></span>
              </section>
            </div>
              <div class="col-md-4 mb-2">
                <section class="px-2 py-1 border border-dark rounded" style="background-color: rgba(0, 0, 0, 0.027);">
                  <h5><i class="bi bi-bell-fill fs-5"></i>&nbspNotificações</h5>    
                    <h6>Receber novidades no meu e-mail:</h6>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" value="" id="receber e-mail">
                      <label class="form-check-label" for="receber e-mail">
                        Sim, quero receber novidades no meu e-mail
                      </label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" value="" id="não receber">
                      <label class="form-check-label" for="não receber">
                        Não, prefiro não receber nenhuma novidade
                      </label>
                    </div>
                </section>
              </div>
          </div>
          <button class="btn btn-dark d-flex align-items-center gap-1 my-1" onclick="alert('Salvo com Sucesso')" type="submit">
            <i class="bi bi-floppy"></i>
            <span>Salvar Alterações</span>
          </button>
        </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
</body>
</html>