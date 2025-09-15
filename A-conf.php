<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Configuração</title>
    <link rel="icon" type="png" href="img/logo-oficial.png">
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
</head>
<body>
    <section>
        <div class="container-fluid min-vh-75 bg-black d-flex align-items-center justify-content-center position-relative overflow-hidden">
            <i class="bi bi-gear-fill position-absolute" style="top: 25%; left: 15%; font-size: 1.8rem; color: white; opacity: 0.3; 
                animation: float-rotate 12s infinite linear;">
            </i>
            <i class="bi bi-person-vcard position-absolute" style="top: 65%; left: 80%; font-size: 2.2rem; color: white; opacity: 0.3; 
                animation: float-rotate 18s infinite linear reverse;">
            </i>
            <i class="bi bi-emoji-smile position-absolute" style="top: 40%; left: 70%; font-size: 1.5rem; color: white; opacity: 0.3; 
                animation: float-rotate 15s infinite linear;">
            </i>
            <i class="bi bi-grid-3x3 position-absolute" style="top: 15%; left: 50%; font-size: 2rem; color: white; opacity: 0.3; 
                animation: float-rotate 20s infinite linear reverse;">
            </i>
            <i class="bi bi-coin position-absolute" style="top: 75%; left: 25%; font-size: 1.6rem; color: white; opacity: 0.3; 
                animation: float-rotate 14s infinite linear;">
            </i>
            <i class="bi bi-person-raised-hand position-absolute" style="top: 30%; left: 85%; font-size: 1.7rem; color: white; opacity: 0.3; 
                animation: float-rotate 16s infinite linear reverse;">
            </i>
            <i class="bi bi-shield-check position-absolute" style="top: 55%; left: 40%; font-size: 2.3rem; color: white; opacity: 0.3; 
                animation: float-rotate 22s infinite linear;">
            </i>
            <h2 class="pt-2 pb-2 display-5 text-white" style="font-weight: bolder; position: relative; z-index: 2;">
                Configuração
            </h2>
        </div>
    </section>
    <section class="container-fluid px-md-5 py-4">
        <a href="#" class="btn btn-dark"><i class="bi bi-arrow-left"></i>&nbsp;Voltar para o Menu</a>
        <br>
        <br>
        <h2 style="font-weight: bolder;">Olá, @user_fahren</h2>
        <br>
        <div class="row g-3">
            <div class="col-md-6 col-lg-4 mb-1">
                <div class="card h-100 shadow-sm">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title"><i class="bi bi-person-vcard"></i>&nbsp;Usuário</h5>
                        <p class="card-text flex-grow-1">Dados e Informações sobre a sua Conta</p>
                        <a href="B-user.php" class="btn btn-dark">
                            Acessar Configurações
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 mb-1">
                <div class="card h-100 shadow-sm">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title"><i class="bi bi-emoji-smile"></i>&nbsp;Suas Preferências</h5>
                        <p class="card-text flex-grow-1">Escolha as suas preferências</p>
                        <a href="C-pref.php" class="btn btn-dark">
                            Ajustar as Preferências
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 mb-1">
                <div class="card h-100 shadow-sm">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title"><i class="bi bi-grid-3x3"></i>&nbsp;Interface</h5>
                        <p class="card-text flex-grow-1">Escolha como seja sua interface</p>
                        <a href="D-interface.php" class="btn btn-dark">
                            Customizar Interface
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 mb-1">
                <div class="card h-100 shadow-sm">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title"><i class="bi bi-coin"></i>&nbsp;Financeiro</h5>
                        <p class="card-text flex-grow-1">Compras, Vendas, Lucros etc</p>
                        <a href="E-financeiro.php" class="btn btn-dark">
                            Gerenciar Pagamentos
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 mb-1">
                <div class="card h-100 shadow-sm">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title"><i class="bi bi-person-raised-hand"></i>Suporte</h5>
                        <p class="card-text flex-grow-1">Para qualquer dúvida e contatar-nos</p>
                        <a href="F-suporte.php" class="btn btn-dark">
                            Preciso de Ajuda
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 mb-1">
                <div class="card h-100 shadow-sm">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title"><i class="bi bi-shield-check"></i>&nbsp;Sua Proteção</h5>
                        <p class="card-text flex-grow-1">Segurança e Termos de Privacidade!</p>
                        <a href="G-sua_proteção.php" class="btn btn-dark">
                            Saiba mais
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <h5>Atalhos</h5>
        <i class="bi bi-exclamation-circle-fill">&nbsp</i><span>Solicitar <a href="#" style="text-decoration: none;">Informações e Dados sobre a minha Conta</a></span>
        <br>
        <i class="bi bi-trash3-fill"></i>&nbsp<span>Solicitar <a class="delete-account" href="#">Exclusão da minha Conta</a></span>
    </section>
    <section>
        
    </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
</body>
</html>