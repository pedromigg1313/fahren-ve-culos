<?php
include 'conexao_db.php'; // conexão com o banco

// Verifica se enviou o arquivo
if(isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
    
    $nomeArquivo = $_FILES['imagem']['name'];       // nome original do arquivo
    $tmpName     = $_FILES['imagem']['tmp_name'];   // caminho temporário
    $pastaUpload = 'uploads/';                      // pasta onde será salvo

    // Garante que a pasta exista
    if(!is_dir($pastaUpload)) {
        mkdir($pastaUpload, 0777, true); // cria pasta com permissão de escrita
    }

    // Filtra extensões permitidas
    $extensao = pathinfo($nomeArquivo, PATHINFO_EXTENSION);
    $extensoesPermitidas = ['jpg','jpeg','png','gif'];
    if(!in_array(strtolower($extensao), $extensoesPermitidas)) {
        die("Tipo de arquivo não permitido. Apenas jpg, jpeg, png e gif.");
    }

    // Cria um nome único para evitar conflitos
    $novoNome = uniqid() . '_' . $nomeArquivo;
    $caminhoFinal = $pastaUpload . $novoNome;

    // Move o arquivo para a pasta
    if(move_uploaded_file($tmpName, $caminhoFinal)) {

        // Salva no banco de dados
        $sql = "INSERT INTO imagens (nome_imagem, caminho) VALUES (?, ?)";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("ss", $nomeArquivo, $caminhoFinal);
        if($stmt->execute()) {
            echo "Upload realizado com sucesso!";
        } else {
            echo "Erro ao salvar no banco de dados.";
        }

        $stmt->close();
        $conexao->close();

    } else {
        echo "Erro ao mover o arquivo para a pasta.";
    }

} else {
    echo "Nenhum arquivo enviado ou ocorreu um erro.";
}
?>
