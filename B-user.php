<!doctype html>
<html lang="pt-br">
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
    <section class="container-fluid bg-light rounded-bottom-4 mb-3 px-md-5 pt-4 text-white" style="background: linear-gradient(to left, rgba(33, 33, 33, 0.826), #141414);">
        <h2 style="font-weight: bolder;" class="pb-2"><i class="bi bi-person-vcard"></i>&nbspUsuário</h2>
    </section>
    <a href="A-conf.php" class="ms-4 voltar" style="font-size: 18px;">
        <i class="bi bi-arrow-left"></i>&nbsp;Voltar
    </a>
    <div class="container mt-4 ms-md-5">
        <div class="card border-0 p-3" style="background-color: rgba(0, 0, 0, 0.055); color: rgba(0, 0, 0, 0.712); font-weight: bolder;">
            <div class="user-profile-container">
                <div class="user-img">
                    <img src="img/logo-oficial.png" id="perfil-foto">
                    <input type="file" id="file" accept="image/*">
                    <label for="file" id="upload-btn">
                        <i class="bi bi-pencil-fill"></i>
                    </label>
                </div>
                <div class="user-info">
                    <h5>Foto de Perfil</h5>
                    <p>Clique no ícone da câmera para alterar sua foto</p>
                    <p>Formatos suportados: JPG, PNG (Máx.: 5MB)</p>
                </div>
            </div>
        </div>
    </div>
    <div class="container mt-3 ms-5">
          <div class="card border-0" style="max-width: 18rem; background-color: rgba(0, 0, 0, 0.055); color: rgba(0, 0, 0, 0.712); font-weight: bolder;">
            <div class="card-body p-2">
              Campos Obrigatórios são indicados pelo asterisco(*)
            </div>
          </div>
    </div>
    <section class="configuracao container-fluid px-md-5 py-4">
        <div class="row g-3">
          <div class="col">
              <h6><span>Nome de Usuário:</span>
                <span class="required-field" aria-hidden="true">
                  *
                </span>
              </h6>
              <div class="input-group">
                <span class="input-group-text" style="font-weight: bolder;">@</span>
                <input type="text" placeholder="Ex.: ferrejose123" class="form-control focus-ring focus-ring-dark" aria-label="Nome Usuario" style="border-color: rgba(0, 0, 0, 0.616);">
              </div>
              <div id="nome_usuario" class="form-text"></div>
          </div>
          <div class="col">
              <h6><span>E-mail:</span>
                <span class="required-field" aria-hidden="true">
                  *
                </span>
              </h6>
              <div class="input-group">
                <span class="input-group-text"><i class="bi bi-envelope-fill"></i></span>
                <input type="email" placeholder="Ex.: josefer123br@gmail.com" class="form-control focus-ring focus-ring-dark" aria-label="E-mail suario" style="border-color: rgba(0, 0, 0, 0.616);">
              </div>
              <div id="e-mail_usuario" class="form-text"></div>
          </div>
        </div>
        <br>
        <div class="row g-3">
          <div class="col">
              <h6><span>Senha:</span>
                <span class="required-field" aria-hidden="true">
                  *
                </span>
              </h6>
              <div class="input-group position-relative">
                <span class="input-group-text"><i class="bi bi-key-fill"></i></span>
                <input type="password" placeholder="Ex.: 123fahren123" class="form-control focus-ring focus-ring-dark rounded-end-2" id="senha" aria-label="Senha Usuario" style="border-color: rgba(0, 0, 0, 0.616); padding-right: 40px;">
                <i class="bi bi-eye-fill position-absolute fs-5" id="togglePassword" style="top: 50%; right: 12px; transform: translateY(-50%); cursor: pointer;"></i>
              </div>
              <div id="senha_usuario" class="form-text"></div>
          </div>
          <div class="col">
              <h6><span>Nome Completo:</span>
                <span class="required-field" aria-hidden="true">
                  *
                </span>
              </h6>
              <div class="input-group">
                <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                <input type="text" placeholder="Ex.: José Ferreira Lopes" class="form-control focus-ring focus-ring-dark" aria-label="Nome Completo Usuario" style="border-color: rgba(0, 0, 0, 0.616);">
              </div>
              <div id="nome_completo_usuario" class="form-text"></div>
          </div>
        </div>
        <br>
        <div class="row g-3">
          <div class="col">
              <h6><span>Data de Nascimento:</span>
                <span class="required-field" aria-hidden="true">
                  *
                </span>
              </h6>
              <div class="input-group">
                <span class="input-group-text"><i class="bi bi-calendar-week-fill"></i></span>
                <input type="date" class="form-control focus-ring focus-ring-dark" aria-label="Data de Nascimento Usuario" style="border-color: rgba(0, 0, 0, 0.616);">
              </div>
              <div id="data_nascimento_usuario" class="form-text"></div>
          </div>
          <div class="col">
            <h6><span>Gênero:</span>
              <span class="required-field" aria-hidden="true">
                *
              </span>
            </h6>
              <div class="mb-3">
                <div class="input-group">
                  <span class="input-group-text"><i class="bi bi-gender-ambiguous"></i></span>
                  <select id="genero_usuario" class="form-select focus-ring focus-ring-dark" style="border-color: rgba(0, 0, 0, 0.616);">
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
        <hr class="border border-1 border-dark opacity-50 my-4">
        <div class="row g-3">
          <div class="col">
              <h6><span>CEP:</span>
                <span class="required-field" aria-hidden="true">
                  *
                </span>
              </h6>
              <div class="input-group">
                <span class="input-group-text"><i class="bi bi-geo-alt-fill"></i></span>
                <input type="number" placeholder="Ex.: 22790-710" class="form-control focus-ring focus-ring-dark" aria-label="CEP Usuario" style="border-color: rgba(0, 0, 0, 0.616);">
              </div>
              <div id="cep_usuario" class="form-text"></div>
          </div>
          <div class="col">
              <h6><span>Unidade Federativa(UF):</span>
                <span class="required-field" aria-hidden="true">
                *
                </span>
              </h6>
              <div class="mb-3">
                <div class="input-group">
                  <span class="input-group-text"><i class="bi bi-geo-alt-fill"></i></span>
                  <select id="estado_usuario" class="form-select focus-ring focus-ring-dark" style="border-color: rgba(0, 0, 0, 0.616);">
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
        <br>
        <div class="row g-3">
          <div class="col">
              <h6><span>Cidade:</span>
                <span class="required-field" aria-hidden="true">
                  *
                </span>
              </h6>
              <div class="input-group">
                <span class="input-group-text"><i class="bi bi-geo-alt-fill"></i></span>
                <input type="text" class="form-control focus-ring focus-ring-dark" aria-label="CEP Usuario" style="border-color: rgba(0, 0, 0, 0.616);">
              </div>
              <div id="cep_usuario" class="form-text"></div>
          </div>
          <div class="col">
            <h6><span>Telefone:</span>
              <span class="required-field" aria-hidden="true">
                *
              </span>
            </h6>
              <div class="input-group">
                <span class="input-group-text"><i class="bi bi-telephone-fill"></i></span>
                <input type="text" inputmode="numeric" placeholder="Ex.: +55 (61) 93456-7890" maxlength="19" class="form-control focus-ring focus-ring-dark" aria-label="Telefone Usuario" max="10" style="border-color: rgba(0, 0, 0, 0.616);">
              </div>
              <div id="telefone_usuario" class="form-text"></div>
          </div>
        </div>
        <br>
        <button class="btn btn-dark d-flex align-items-center gap-1" onclick="alert('Salvo com Sucesso')" type="submit">
          <i class="bi bi-floppy"></i>
          <span>Salvar Alterações</span>
        </button>
      </section>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
      <script>
        let togglePassword = document.getElementById('togglePassword')
        let senhaInput = document.getElementById('senha')
        
        togglePassword.addEventListener('click', function() {
            let isPassword = senhaInput.type === 'password'
            senhaInput.type = isPassword ? 'text' : 'password'

            if (isPassword) {
                togglePassword.classList.remove('bi-eye-fill')
                togglePassword.classList.add('bi-eye-slash-fill')
            } else {
                togglePassword.classList.remove('bi-eye-slash-fill')
                togglePassword.classList.add('bi-eye-fill')
            }
        })     
    </script>
</body>
</html>