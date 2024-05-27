<?php
include "conexao.php";

/**
 * Insere os dados em duas tabelas do banco de dados e retorna a página principal
 */
if (isset($_POST['data'])) {
    // Verifica se a nota fiscal já existe na tabela tb_cod_nota
    $sqlCheckNota = $pdo->prepare("SELECT * FROM tb_cod_nota WHERE notafiscal = :notafiscal");
    $sqlCheckNota->execute(['notafiscal' => $_POST['notafiscal']]);

    if ($sqlCheckNota->rowCount() == 0) {
        // Se não existir insere na tabela tb_cod_nota
        $sqlCodNota = $pdo->prepare("INSERT INTO tb_cod_nota VALUES (:notafiscal, :nomefantasia)");
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
    $sql = $pdo->prepare("INSERT INTO tb_patrimonios VALUES (NULL, :descricao, :origem, :setor, :situacao, :identificacao, :data, :classificacao, :notafiscal)");
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

    header("Location: index.php");
    exit();
} else {
    echo 'Erro ao Cadastrar';
}
