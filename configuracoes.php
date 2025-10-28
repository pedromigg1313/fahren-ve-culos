/* CONSERTADO O BUG de Palavras Misturadas em pequenas resoluções */
<?php
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: ../");
    exit;
}

$nome = $_SESSION['nome'] ?? '';
$sobrenome = $_SESSION['sobrenome'] ?? '';
$telefone = $_SESSION['telefone'] ?? '';
$cpf = $_SESSION['cpf'] ?? '';
$email = $_SESSION['email'] ?? '';
$data_nascimento = $_SESSION['data_nascimento'] ?? '';

// fetch avatar from DB if available
include_once '../controladores/conexao_bd.php';
$avatar = null;
if (isset($_SESSION['id'])) {
    $uid = (int) $_SESSION['id'];
    $res = mysqli_query($conexao, "SELECT avatar FROM usuarios WHERE id = $uid");
    if ($res && mysqli_num_rows($res) > 0) {
        $row = mysqli_fetch_assoc($res);
        $avatar = $row['avatar'];
    }
}
mysqli_close($conexao);

?>
<!doctype html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Configuração</title>
    <link rel="shortcut icon" href="../img/favicon.ico" type="image/x-icon">
    <link rel="icon" type="png" href="../img/logo-oficial.png">
    <link rel="stylesheet" href="../style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
</head>

<body class="overflow-x-hidden">
    <?php include '../estruturas/modal/loja-modal.php';?>
    <?php include '../estruturas/alert/alert.php' ?>
    <main class="container-fluid d-flex vh-100 p-0">
        <?php $selected = 'config';
        include_once '../estruturas/sidebar/sidebar.php' ?>
        <div class="col" style="margin-left: calc(200px + 5vw);">
            <div class="container-fluid p-5">
                <div class="row">
                    <h2 class="pb-2 fw-semibold mb-0">Configurações</h2>
                    <p class="text-muted">Gerencie sua conta e suas preferências</p>
                </div>
                <div class="mb-5 d-flex flex-wrap gap-2">
                    <input type="radio" class="btn-check" name="telas" id="tela-1" autocomplete="off" checked>
                    <label class="btn btn-outline-dark w-auto rounded-pill px-3 shadow-sm" for="tela-1">Suas informações</label>
                    <input type="radio" class="btn-check" name="telas" id="tela-2" autocomplete="off">
                    <label class="btn btn-outline-dark w-auto rounded-pill px-3 shadow-sm" for="tela-2">Segurança e Privacidade</label>
                    <input type="radio" class="btn-check" name="telas" id="tela-3" autocomplete="off">
                    <label class="btn btn-outline-dark w-auto rounded-pill px-3 shadow-sm" for="tela-3">Notificações</label>
                    <input type="radio" class="btn-check" name="telas" id="tela-4" autocomplete="off">
                    <label class="btn btn-outline-dark w-auto rounded-pill px-3 shadow-sm" for="tela-4">Formas de pagamento</label>
                </div>
                <form action="../controladores/mudar-infos.php" class="row d-flex align-items-stretch" id="info-form" method="POST" enctype="multipart/form-data">
                    <div class="col-4">
                        <h5>Perfil</h5>
                        <p class="text-muted">Defina as informações da sua conta</p>
                    </div>

                    <div class="col d-flex flex-column justify-content-between">
                        <div class="row row-cols-2 row-gap-3 mb-3">
                            <div class="col">
                                <label for="nome-input" class="form-label">Nome</label>
                                <input type="text" class="form-control shadow-sm" name="nome" id="nome-input" placeholder="Nome" value="<?= $nome ?>">
                            </div>
                            <div class="col">
                                <label for="sobrenome-input" class="form-label">Sobrenome</label>
                                <input type="text" class="form-control shadow-sm" name="sobrenome" id="sobrenome-input" placeholder="Sobrenome" value="<?= $sobrenome ?>">
                            </div>
                            <div class="col">
                                <label for="telefone-input" class="form-label">Telefone</label>
                                <input type="text" class="form-control shadow-sm telefone-mask" name="telefone" id="telefone-input" placeholder="Telefone" value="<?= $telefone ?>" maxlength="15">
                            </div>
                            <div class="col">
                                <label for="cpf-input" class="form-label">CPF</label>
                                <input type="text" class="form-control shadow-sm cpf-mask" name="cpf" id="cpf-input" placeholder="CPF" value="<?= $cpf ?>" maxlength="14">
                            </div>
                            <div class="col">
                                <label for="email-input" class="form-label">Email</label>
                                <input type="email" class="form-control shadow-sm" name="email" id="email-input" placeholder="Email" value="<?= $email ?>">
                            </div>
                            <div class="col">
                                <label for="data-nascimento-input" class="form-label">Data de nascimento</label>
                                <input type="date" class="form-control shadow-sm" name="data-nascimento" id="data-nascimento-input" placeholder="dd/mm/aaaa" value="<?= $data_nascimento ?>">
                            </div>
                        </div>
                    </div>

                    <div class="col-auto d-flex flex-column justify-content-center">
                <div class="ratio ratio-1x1 mb-3">
                    <?php $avatar_src = (!empty($avatar)) ? ('../' . $avatar) : '../img/usuarios/avatares/user.png'; ?>
                    <img id="avatar-preview" src="<?= htmlspecialchars($avatar_src) ?>" alt="Foto de Perfil"
                    class="rounded-circle img-fluid mb-3 object-fit-cover">
                </div>

                            <div class="d-flex gap-2 w-100">
                                <label for="avatar-input" class="btn text-muted border rounded-pill w-100 shadow-sm mb-0 text-center" style="cursor: pointer;">Alterar foto</label>
                                <button id="avatar-clear" type="button" class="btn text-muted border rounded-pill shadow-sm"><i class="bi bi-eraser"></i></button>
                                <input type="file" name="avatar" id="avatar-input" accept="image/*" class="d-none">
                            </div>
                    </div>

                    <div class="col-12 mt-4">
                        <button type="submit" class="btn btn-dark float-end shadow-sm" disabled>Salvar alterações&nbsp;&nbsp;<i class="bi bi-floppy"></i></button>
                    </div>
                </form>
                <hr class="my-5">
                <div class="row d-flex align-items-stretch flex-wrap">
                    <div class="col-12 col-md-4 mb-3 mb-md-0">
                        <h5 class="mb-1 fw-semibold">Localização</h5>
                        <p class="text-muted small mb-0">Defina a sua localização</p>
                    </div>

                    <div class="col-12 col-md-8">
                        <div class="row row-cols-1 row-cols-md-2 g-3">
                            <div class="col">
                                <label for="estado-input" class="form-label">Estado</label>
                                <input type="text" list="estado-list" class="form-control shadow-sm" id="estado-input" placeholder="Estado">
                                <datalist id="estado-list">
                                    <option value="Acre">
                                    <option value="Alagoas">
                                    <option value="Amapá">
                                    <option value="Amazonas">
                                    <option value="Bahia">
                                    <option value="Ceará">
                                    <option value="Distrito Federal">
                                    <option value="Espírito Santo">
                                    <option value="Goiás">
                                    <option value="Maranhão">
                                    <option value="Mato Grosso">
                                    <option value="Mato Grosso do Sul">
                                    <option value="Minas Gerais">
                                    <option value="Pará">
                                    <option value="Paraíba">
                                    <option value="Paraná">
                                    <option value="Pernambuco">
                                    <option value="Piauí">
                                    <option value="Rio de Janeiro">
                                    <option value="Rio Grande do Norte">
                                    <option value="Rio Grande do Sul">
                                    <option value="Rondônia">
                                    <option value="Roraima">
                                    <option value="Santa Catarina">
                                    <option value="São Paulo">
                                    <option value="Sergipe">
                                    <option value="Tocantins">
                                </datalist>
                            </div>
                            <div class="col">
                                <label for="cidade-input" class="form-label">Cidade</label>
                                <input type="text" class="form-control shadow-sm" id="cidade-input" placeholder="Cidade">
                            </div>
                        </div>
                    </div>
                </div>
                <hr class="my-5">
                <div class="row d-flex align-items-center flex-nowrap">
                    <div class="col">
                        <h5>Deletar conta</h5>
                        <p class="text-muted">Delete a sua conta permanentemente</p>
                    </div>
                    <div class="col-auto d-flex flex-column justify-content-between">
                        <div class="row row-gap-3 mb-3">
                            <div class="col">
                                <button class="btn btn-danger shadow-sm" data-bs-toggle="modal" data-bs-target="#delete-modal">Deletar conta&nbsp;<i class="bi bi-trash"></i></button>
                                <div class="modal fade" id="delete-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <form action="../controladores/deletar-conta.php" class="modal-content" method="POST">
                                            <div class="modal-body p-5">
                                                <div class="bg-danger-subtle rounded-circle d-flex justify-content-center align-items-center mb-3 mx-auto fs-5" style="width: 60px; height: 60px;">
                                                    <i class="bi bi-trash"></i>
                                                </div>
                                                <h4 class="text-center">Deletar conta</h4>
                                                <p class="text-center small text-danger">ATENÇÃO!<br>essa ação é permanete e não poderá ser desfeita</p>
                                                <p class="mb-5 text-muted">Ao deletar sua conta, todos os seus dados e informações serão permanentemente removidos e não poderão ser recuperados</p>
                                                <label for="senha-deletar-input" class="form-label">Confirme com sua senha</label>
                                                <input type="password" class="form-control shadow-sm" id="senha-deletar-input" name="senha" placeholder="Senha" required>
                                            </div>
                                            <div class="modal-footer border-top-0">
                                                <button type="button" class="btn bg-body-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                <button id="delete-btn" type="submit" class="btn btn-danger" disabled>Deletar conta</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
<script src="../script.js"></script>
<script>
    $(function() {
        // showAlert: create the same alert markup used by server-side session alerts
        function showAlert(type, text, timeout = 4500) {
            // remove any existing alert container
            $('#alert-mensagem').closest('.position-fixed').remove();

            const icon = (type === 'danger') ? 'bi-exclamation-triangle' : 'bi-check';
            const $wrap = $('<div/>', { 'class': 'position-fixed d-flex justify-content-center start-50 translate-middle-x mb-5 z-3 bottom-0' });
            const $alert = $(
                '<div id="alert-mensagem" class="alert alert-' + type + ' alert-dismissible h-100 rounded-2" role="alert">' +
                '<div><span><i class=" bi ' + icon + '"></i></span> ' + $('<div/>').text(text).html() + '</div>' +
                '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>' +
                '</div>'
            );
            $wrap.append($alert);
            $('body').append($wrap);

            if (timeout > 0) {
                setTimeout(function() {
                    try { $alert.alert('close'); } catch (e) { $wrap.remove(); }
                }, timeout);
            }
        }

        $('#senha-deletar-input').on('input', function() {
            var senha = $(this).val();
            if (senha.length > 0) {
                $('#delete-btn').prop('disabled', false);
            } else {
                $('#delete-btn').prop('disabled', true);
            }
        });
        // avatar upload on change (no need to save)
        $('#avatar-input').on('change', function(e) {
            const file = this.files && this.files[0];
            if (!file) return;

            // local preview immediately
            const reader = new FileReader();
            reader.onload = function(ev) {
                $('#avatar-preview').attr('src', ev.target.result);
            }
            reader.readAsDataURL(file);

            // upload via AJAX
            const fd = new FormData();
            fd.append('avatar', file);

            $.ajax({
                url: '../controladores/upload-avatar.php',
                type: 'POST',
                data: fd,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(res) {
                    if (res && res.success && res.avatar) {
                        // set preview to the server path (avoids caching because filename includes timestamp)
                        $('#avatar-preview').attr('src', '../' + res.avatar);
                        // update sidebar avatar if present
                        $('.footer img').attr('src', '../' + res.avatar);
                        // show instant alert using server message if provided
                        showAlert('success', res.message || 'Foto de perfil atualizada com sucesso.');
                        // ensure the Save button stays disabled unless other fields changed
                    } else {
                        showAlert('danger', (res && res.message) ? res.message : 'Falha ao enviar imagem.');
                    }
                },
                error: function() {
                    showAlert('danger', 'Erro ao enviar a imagem.');
                }
            });
        });

        $('#avatar-clear').on('click', function() {
            // request server to remove avatar and update UI
            $.post('../controladores/remover-avatar.php', {}, function(res) {
                if (res && res.success) {
                    // clear file input and reset preview
                    $('#avatar-input').val('');
                    $('#avatar-preview').attr('src', '../img/usuarios/avatares/user.png');
                    $('#info-form button[type="submit"]').prop('disabled', false);
                    // update sidebar avatar if present
                    $('.footer img').attr('src', '../img/usuarios/avatares/user.png');
                    // show instant alert
                    showAlert('success', res.message || 'Foto de perfil removida com sucesso.');
                } else {
                    showAlert('danger', (res && res.message) ? res.message : 'Não foi possível remover a foto.');
                }
            }, 'json');
        });

        function checkForm() {
            var infos = [];
            $('#info-form input').each(function() {
                infos.push($(this).val().trim());
            });
            return infos;
        };

        let InfosAtuais = checkForm();

        $('form input').on('input', function() {
            let novos = checkForm();
            let iguais = InfosAtuais.length === novos.length &&
                InfosAtuais.every((val, i) => val === novos[i]);

            if (iguais) {
                $("#info-form button[type='submit']").prop('disabled', true);
            } else {
                $("#info-form button[type='submit']").prop('disabled', false);
            }
        });
    });
</script>

</html>
