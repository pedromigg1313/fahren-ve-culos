<!doctype html>
<html lang="pt-br" data-bs-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Usuário</title>
    <link rel="icon" type="png" href="img/logo-oficial.png">
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
</head>
<body>

    <!-- SOBRE -->
    <div class="container mt-3 ms-md-5">
        <div class="card border-0 p-1 mb-1">
            <div class="d-flex align-items-center">
                
                <!-- FOTO DE PERFIL -->
                <div class="position-relative me-3">
                    <form id="form-foto" action="upload.php" method="POST" enctype="multipart/form-data" class="position-relative d-inline-block">
                        <?php
                        include 'db/conexao_db.php';

                        // Pega a última imagem do usuário
                        $sql = "SELECT caminho FROM imagens ORDER BY id DESC LIMIT 1";
                        $result = $conexao->query($sql);

                        if($result->num_rows > 0) {
                            $row = $result->fetch_assoc();
                            $imagemCaminho = $row['caminho'];
                        } else {
                            $imagemCaminho = "img/logo-oficial.png"; // imagem padrão
                        }
                        ?>
                        <img src="<?= $imagemCaminho ?>" id="perfil-foto" class="rounded-circle" style="width: 120px; height: 120px; object-fit: cover;">
                        <input type="file" id="file" name="imagem" accept="image/*" class="d-none">
                        <label for="file" id="foto-edit-icon" class="position-absolute bottom-0 end-0 bg-primary text-white rounded-circle d-flex align-items-center justify-content-center d-none" style="width: 35px; height: 35px; cursor: pointer;">
                            <i class="bi bi-pencil-fill"></i>
                        </label>
                    </form>
                </div>
                <!-- FOTO DE PERFIL -->

                <!-- PERFIL -->
                <div class="flex-grow-1">
                    <h3 class="fw-bold mb-2">@user_fahren</h3>
                    <div class="row align-items-center">
                        <div class="col-md-2">
                            <div class="text-muted small">Data da criação da conta</div>
                            <div class="fw-medium">14/09/2025</div>
                        </div>
                        <div class="col-md-10 mt-2 mt-md-0">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <div class="text-muted small">Sobre:</div>
                                <div class="text-muted small">
                                    <span id="char-count">0</span>/250 caracteres
                                </div>
                            </div>
                            <div class="row g-2 align-items-center">
                                <div class="col">
                                    <input type="text" id="sobre-input" readonly class="form-control form-control-sm focus-ring focus-ring-dark" placeholder="Escreva algo sobre você..." maxlength="250" style="border-color: rgba(0, 0, 0, 0.616);">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- PERFIL -->

            </div>
        </div>
    </div>
    <!-- SOBRE -->

    <!-- CORPO -->
    <hr class="border border-1 border-dark opacity-50">
    <div class="container mt-1 ms-5">
        <div class="card border-0" style="max-width: 18rem; font-weight: bolder;">
            <div class="card-body p-2">
                Campos Obrigatórios são indicados pelo asterisco(*)
            </div>
        </div>
    </div>
    <section class="container-fluid px-md-5 py-4">
        <div class="row g-3">
            <div class="col mb-3">
                <h6><span>Nome de Usuário:</span>
                    <span class="required-field" aria-hidden="true">
                        *
                    </span>
                </h6>
                <div class="input-group mt-1">
                    <span class="input-group-text" style="font-weight: bolder;">@</span>
                    <input type="text" placeholder="Ex.: ferrejose123" readonly class="form-control focus-ring focus-ring-dark" aria-label="Nome Usuario" style="border-color: rgba(0, 0, 0, 0.616);">
                </div>
                <div id="nome_usuario" class="form-text"></div>
            </div>
            <div class="col">
                <h6><span>E-mail:</span>
                    <span class="required-field" aria-hidden="true">
                        *
                    </span>
                </h6>
                <div class="input-group mt-1">
                    <span class="input-group-text"><i class="bi bi-envelope-fill"></i></span>
                    <input type="email" placeholder="Ex.: josefer123br@gmail.com" readonly class="form-control focus-ring focus-ring-dark" aria-label="E-mail usuario" style="border-color: rgba(0, 0, 0, 0.616);">
                </div>
                <div id="e-mail_usuario" class="form-text"></div>
            </div>
        </div>
        <div class="row g-3">
            <div class="col mb-3">
                <h6><span>Apelido</span>
                </h6>
                <div class="input-group mt-1">
                    <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                    <input type="text" placeholder="Ex.: joselito" readonly class="form-control focus-ring focus-ring-dark" aria-label="Apelido" style="border-color: rgba(0, 0, 0, 0.616);">
                </div>
                <div id="nome_completo_usuario" class="form-text"></div>
            </div>
            <div class="col">
                <h6><span>Nome Completo:</span>
                    <span class="required-field" aria-hidden="true">
                        *
                    </span>
                </h6>
                <div class="input-group mt-1">
                    <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                    <input type="text" placeholder="Ex.: José Ferreira Lopes" readonly class="form-control focus-ring focus-ring-dark" aria-label="Nome Completo Usuario" style="border-color: rgba(0, 0, 0, 0.616);">
                </div>
                <div id="nome_completo_usuario" class="form-text"></div>
            </div>
        </div>
        <div class="row g-3">
            <div class="col mb-3">
                <h6"><span>Data de Nascimento:</span>
                    <span class="required-field" aria-hidden="true">
                        *
                    </span>
                </h6>
                <div class="input-group mt-1">
                    <span class="input-group-text"><i class="bi bi-calendar-week-fill"></i></span>
                    <input type="date" readonly class="form-control focus-ring focus-ring-dark" aria-label="Data de Nascimento Usuario" style="border-color: rgba(0, 0, 0, 0.616);">
                </div>
                <div id="data_nascimento_usuario" class="form-text"></div>
            </div>
            <div class="col">
                <h6><span>Gênero:</span>
                </h6>
                <div class="">
                    <div class="input-group mt-1">
                        <span class="input-group-text"><i class="bi bi-gender-ambiguous"></i></span>
                        <select id="genero_usuario" disabled class="form-select focus-ring focus-ring-dark" style="border-color: rgba(0, 0, 0, 0.616);">
                            <option value="" disabled selected>Selecione um Gênero</option>
                            <option>Feminino</option>
                            <option>Masculino</option>
                            <option>Outro</option>
                            <option>Prefiro Não Informar</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="row g-3">
            <div class="col mb-3">
                <h6><span>CEP:</span>
                    <span class="required-field" aria-hidden="true">
                        *
                    </span>
                </h6>
                <div class="input-group mt-1">
                    <span class="input-group-text"><i class="bi bi-geo-alt-fill"></i></span>
                    <input type="number" placeholder="Ex.: 22790-710" readonly class="form-control focus-ring focus-ring-dark" aria-label="CEP Usuario" style="border-color: rgba(0, 0, 0, 0.616);">
                </div>
                <div id="cep_usuario" class="form-text"></div>
            </div>
            <div class="col">
                <h6><span>Unidade Federativa(UF):</span>
                    <span class="required-field" aria-hidden="true">
                        *
                    </span>
                </h6>
                <div class="">
                    <div class="input-group mt-1">
                        <span class="input-group-text"><i class="bi bi-geo-alt-fill"></i></span>
                            <select id="estado_usuario" disabled class="form-select focus-ring focus-ring-dark" style="border-color: rgba(0, 0, 0, 0.616);">
                                <option value="" disabled selected>Selecione uma Unidade Federativa(UF)</option>
                                <option value="1">Acre</option>
                                <option value="2">Alagoas</option>
                                <option value="3">Amapá</option>
                                <option value="4">Amazonas</option>
                                <option value="5">Bahia</option>
                                <option value="6">Ceará</option>
                                <option value="7">Distrito Federal</option>
                                <option value="8">Espírito Santo</option>
                                <option value="9">Goiás</option>
                                <option value="10">Maranhão</option>
                                <option value="11">Mato Grosso</option>
                                <option value="12">Mato Grosso do Sul</option>
                                <option value="13">Minas Gerais</option>
                                <option value="14">Pará</option>
                                <option value="15">Paraíba</option>
                                <option value="16">Paraná</option>
                                <option value="17">Pernambuco</option>
                                <option value="18">Piauí</option>
                                <option value="19">Rio de Janeiro</option>
                                <option value="20">Rio Grande do Norte</option>
                                <option value="21">Rio Grande do Sul</option>
                                <option value="22">Rondônia</option>
                                <option value="23">Roraima</option>
                                <option value="24">Santa Catarina</option>
                                <option value="25">São Paulo</option>
                                <option value="26">Sergipe</option>
                                <option value="27">Tocantins</option>
                            </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="row g-3">
            <div class="col mb-4">
                <h6><span>Cidade:</span>
                    <span class="required-field" aria-hidden="true">
                        *
                    </span>
                </h6>
                <div class="input-group mt-1">
                    <span class="input-group-text"><i class="bi bi-geo-alt-fill"></i></span>
                    <input type="text" readonly class="form-control focus-ring focus-ring-dark" aria-label="Cidade Usuario" style="border-color: rgba(0, 0, 0, 0.616);">
                </div>
                <div id="cidade_usuario" class="form-text"></div>
            </div>
            <div class="col">
                <h6><span>Telefone:</span>
                    <span class="required-field" aria-hidden="true">
                        *
                    </span>
                </h6>
                <div class="input-group mt-1">
                    <span class="input-group-text"><i class="bi bi-telephone-fill"></i></span>
                    <input type="text" inputmode="numeric" readonly placeholder="Ex.: +55 (61) 93456-7890" maxlength="19" class="form-control focus-ring focus-ring-dark" aria-label="Telefone Usuario" style="border-color: rgba(0, 0, 0, 0.616);">
                </div>
                <div id="telefone_usuario" class="form-text"></div>
            </div>
        </div>
        <div class="mt-3 d-flex gap-2">
            <button class="btn btn-dark d-flex align-items-center gap-1" id="edit-btn">
                <i class="bi bi-pencil-fill"></i>
                <span>Editar Informações</span>
            </button>
            <button class="btn btn-dark d-flex align-items-center gap-1" id="toggleTheme">
                <i class="bi bi-pencil-fill"></i>
                <span>Alternar Tema</span>
            </button>
            <button class="btn btn-primary d-flex align-items-center gap-1 d-none" id="save-btn">
                <i class="bi bi-floppy"></i>
                <span>Salvar Alterações</span>
            </button>
            <button class="btn btn-danger d-flex align-items-center gap-1 d-none" id="cancel-btn">
                <i class="bi bi-x-lg"></i>
                <span>Cancelar</span>
            </button>
        </div>
    </section>
    <!-- CORPO -->
    <script src="script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
</body>
</html>