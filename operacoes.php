<?php
include "conexao.php";

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    echo "Formulário recebido.<br>";

    // Diretório para armazenar as imagens
    $uploadDirectory = dirname(__FILE__)."/uploads/";
    if (!is_dir($uploadDirectory)) {
        mkdir($uploadDirectory, 0777, true);
    }
    if (!is_writable($uploadDirectory)) {
        echo "O diretório $uploadDirectory não é gravável.";
        exit();
    }

    $fileUploaded = false;
    $filePath = null;

    // Verifica se o arquivo foi enviado e se não houve erro
    if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
        echo "Nenhum erro no upload do arquivo";

        $fileTmpPath = $_FILES['file']['tmp_name'];
        $fileName = uniqid() . '-' . basename($_FILES['file']['name']);
        $filePath = $uploadDirectory . $fileName;

        // Move o arquivo para o diretório de uploads
        if (move_uploaded_file($fileTmpPath, $filePath)) {
            echo "Arquivo movido para o diretório de destino";
            $fileUploaded = true;
        } else {
            echo "Erro ao mover o arquivo para o diretório de destino.";
        }
    }

    // Verifica se a nota fiscal já existe na tabela tb_cod_nota
    $sqlCheckNota = $pdo->prepare("SELECT * FROM tb_cod_nota WHERE notafiscal = :notafiscal");
    $sqlCheckNota->execute(['notafiscal' => $_POST['notafiscal']]);

    if ($sqlCheckNota->rowCount() == 0) {
        // Se não existir insere na tabela tb_cod_nota
        $sqlCodNota = $pdo->prepare("INSERT INTO tb_cod_nota (notafiscal, nomefantasia) VALUES (:notafiscal, :nomefantasia)");
        $sqlCodNota->execute([
            'notafiscal' => $_POST['notafiscal'],
            'nomefantasia' => $_POST['nomefantasia']
        ]);
    } else {
        // Se a notafiscal existir, pega o ID da tb_cod_nota
        $sqlCodNota = $pdo->prepare("SELECT notafiscal FROM tb_cod_nota WHERE notafiscal = :notafiscal");
        $sqlCodNota->execute(['notafiscal' => $_POST['notafiscal']]);
        $resultCodNota = $sqlCodNota->fetch();
        $idCodNota = $resultCodNota['notafiscal'];
    }

    // Insere os dados na tb_patrimonios
    if ($fileUploaded) {
        $sql = $pdo->prepare("INSERT INTO tb_patrimonios (descricao, origem, setor, situacao, identificacao, data, classificacao, notafiscal, imagem) VALUES (:descricao, :origem, :setor, :situacao, :identificacao, :data, :classificacao, :notafiscal, :imagem)");
        $sql->execute([
            'descricao' => $_POST['descricao'],
            'origem' => $_POST['origem'],
            'setor' => $_POST['setor'],
            'situacao' => $_POST['situacao'],
            'identificacao' => $_POST['identificacao'],
            'data' => $_POST['data'],
            'classificacao' => $_POST['classificacao'],
            'notafiscal' => $_POST['notafiscal'],
            'imagem' => $filePath // Salva o caminho da imagem no banco de dados
        ]);
    } else {
        $sql = $pdo->prepare("INSERT INTO tb_patrimonios (descricao, origem, setor, situacao, identificacao, data, classificacao, notafiscal) VALUES (:descricao, :origem, :setor, :situacao, :identificacao, :data, :classificacao, :notafiscal)");
        $sql->execute([
            'descricao' => $_POST['descricao'],
            'origem' => $_POST['origem'],
            'setor' => $_POST['setor'],
            'situacao' => $_POST['situacao'],
            'identificacao' => $_POST['identificacao'],
            'data' => $_POST['data'],
            'classificacao' => $_POST['classificacao'],
            'notafiscal' => $_POST['notafiscal']
        ]);
    }


    $lastPatrimonioId = $pdo->lastInsertId();

    // Insere o registro na tabela de movimentação
    $sqlMovimentacao = $pdo->prepare("INSERT INTO tb_movimentacao (cod_patrimonio, origem, setor, data) VALUES (:cod_patrimonio, :origem, :setor, :data)");
    $sqlMovimentacao->execute([
        'cod_patrimonio' => $lastPatrimonioId,
        'origem' => $_POST['origem'],
        'setor' => $_POST['setor'],
        'data' => $_POST['data'],
    ]);

    header("Location: index.php");
    exit();
} else {
    echo "Método de envio do formulário inválido.";
}
?>
