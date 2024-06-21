<?php
include "conexao.php";

$patrimonio = null;

// Verifica se o código do patrimônio foi passado via GET
if (isset($_GET['codigo']) && !empty($_GET['codigo'])) {
    $codigo = $_GET['codigo'];

    // Consulta o patrimônio no banco de dados
    $consulta = $pdo->prepare("SELECT * FROM tb_patrimonios WHERE codigo = :codigo");
    $consulta->bindParam(':codigo', $codigo, PDO::PARAM_INT);
    $consulta->execute();
    $patrimonio = $consulta->fetch(PDO::FETCH_ASSOC);

    // Verifica se o patrimônio foi encontrado
    if (!$patrimonio) {
        echo "<p>Patrimônio não encontrado.</p>";
        exit;
    }
}

// Arrays de mapeamento
$setores = [
    'TI01' => 'Tecnologia da Informação',
    'AS01' => 'ASSEIJ',
    'B001' => 'Biblioteca',
    'C001' => 'Cantina',
    'C021' => 'COORD.Educacional',
    'C022' => 'COORD.Ed Infantil',
    'C023' => 'COORD.Ens Fund 1° ao 3°',
    'C024' => 'COORD.Ens Fund 4° e 5°',
    'C025' => 'COORD.Ens Fund Anos Finais',
    'C026' => 'COORD.Ens Médio',
    'C027' => 'COORD.Curso Técnico',
    'C028' => 'COORD. Permanência Integral',
    'CC01' => 'Centro de convenções',
    'CF03' => 'CFTV',
    'D001' => 'Diretoria',
    'DP01' => 'Departamento Pessoal',
    'E018' => 'Escola de Esportes',
    'M001' => 'Museu da capela',
    'NC01' => 'Núcleo de comunicação social',
    'NC02' => 'Núcleo de comunicação social Marketing',
    'NC03' => 'Núcleo de comunicação e Marketing da província',
    'O015' => 'Orientação Educacional ED.Infantil',
    'O016' => 'Orientação Educacional 1° a 5° ano',
    'O017' => 'Orientação Educacional 6° ao Ens Médio',
    'P014' => 'Pastoral',
    'PA01' => 'PABX',
    'PT01' => 'Patrimônio',
    'R001' => 'Recepção',
    'RD01' => 'Recursos Didáticos',
    'RH01' => 'Recursos Humanos',
    'RP01' => 'Reprografia',
    'S001' => 'Setap',
    'SC01' => 'Secretaria Curso Técnico',
    'SC02' => 'Secretaria',
    'SE01' => 'Sala do Educador',
    'SG01' => 'Serviços Gerais',
    'SS01' => 'Serviço Social',
    'T002' => 'Tesouraria',
    'TE01' => 'Tecnologia Educacional',
    'VD01' => 'Vice-Diretoria'
];

$origens = [
    '1' => 'Aquisição',
    '2' => 'Doação',
    '3' => 'Transferência'
];

$situacoes = [
    '1' => 'Ativo',
    '2' => 'Inativo',
    '3' => 'Descarte',
];

$identificacoes = [
    '1' => 'Placa',
    '2' => 'Plaqueta',
    '3' => 'QRCode',
    '4' => 'BarCode',
];

$classificacoes = [
    '1000' => 'Móveis',
    '2000' => 'Estante',
    '3000' => 'Eletrônicos',
];

// Verifica se o formulário foi submetido para atualização
if (isset($_POST['update'])) {
    // Inicializa array de erros
    $erros = [];

    // Captura e valida os dados do formulário
    $codigo = $_POST['codigo'];
    $descricao = $_POST['descricao'];
    $setor = $_POST['setor'];
    $origem = $_POST['origem'];
    $situacao = $_POST['situacao'];
    $identificacao = $_POST['identificacao'];
    $classificacao = $_POST['classificacao'];
    $data = $_POST['data'];

    // Validação de cada campo
    if (empty($descricao)) {
        $erros[] = "O campo 'Descrição' é obrigatório.";
    }
    if (empty($setor)) {
        $erros[] = "O campo 'Setor' é obrigatório.";
    }
    if (empty($origem)) {
        $erros[] = "O campo 'Origem' é obrigatório.";
    }
    if (empty($situacao)) {
        $erros[] = "O campo 'Situação' é obrigatório.";
    }
    if (empty($identificacao)) {
        $erros[] = "O campo 'Identificação' é obrigatório.";
    }
    if (empty($classificacao)) {
        $erros[] = "O campo 'Classificação' é obrigatório.";
    }
    if (empty($data)) {
        $erros[] = "O campo 'Data' é obrigatório.";
    }

    // Se não houver erros, realiza a atualização no banco de dados
    if (count($erros) === 0) {
        // Trata o upload da imagem, se houver
        $target_file = null; // mantém a imagem existente se não houver nova
        if (!empty($_FILES['imagem']['name'])) {
            $imagem = $_FILES['imagem']['name'];
            $target_dir = "uploads/";
            $target_file = $target_dir . basename($imagem);
            move_uploaded_file($_FILES['imagem']['tmp_name'], $target_file);
        }

        if ($target_file == null) {
            // Prepara e executa a consulta SQL para atualização
            $update = $pdo->prepare("UPDATE tb_patrimonios SET descricao = :descricao, setor = :setor, origem = :origem, situacao = :situacao, identificacao = :identificacao, classificacao = :classificacao, data = :data WHERE codigo = :codigo");
            $update->bindParam(':descricao', $descricao);
            $update->bindParam(':setor', $setor);
            $update->bindParam(':origem', $origem);
            $update->bindParam(':situacao', $situacao);
            $update->bindParam(':identificacao', $identificacao);
            $update->bindParam(':classificacao', $classificacao);
            $update->bindParam(':data', $data);
            $update->bindParam(':codigo', $codigo, PDO::PARAM_INT);
            $update->execute();
        } else {
            // Prepara e executa a consulta SQL para atualização
            $update = $pdo->prepare("UPDATE tb_patrimonios SET descricao = :descricao, setor = :setor, origem = :origem, situacao = :situacao, identificacao = :identificacao, classificacao = :classificacao, data = :data, imagem = :imagem WHERE codigo = :codigo");
            $update->bindParam(':descricao', $descricao);
            $update->bindParam(':setor', $setor);
            $update->bindParam(':origem', $origem);
            $update->bindParam(':situacao', $situacao);
            $update->bindParam(':identificacao', $identificacao);
            $update->bindParam(':classificacao', $classificacao);
            $update->bindParam(':data', $data);
            $update->bindParam(':imagem', $target_file);
            $update->bindParam(':codigo', $codigo, PDO::PARAM_INT);
            $update->execute();
        }

        $sqlMovimentacao = $pdo->prepare("INSERT INTO tb_movimentacao (cod_patrimonio, origem, setor, data, data_movimentacao) VALUES (:cod_patrimonio, :origem, :setor, :data, NOW())");
        $sqlMovimentacao->bindParam(':cod_patrimonio', $codigo, PDO::PARAM_INT);
        $sqlMovimentacao->bindParam(':origem', $origem);
        $sqlMovimentacao->bindParam(':setor', $setor);
        $sqlMovimentacao->bindParam('data', $data);
        $sqlMovimentacao->execute();

        header("Location: alterar.php");
        exit;
    }
}

?>
<!DOCTYPE html>
<html>

<head>
    <title>Editar Patrimônio</title>
    <link rel="stylesheet" href="estiloscss/edit.css">
</head>

<body>
    <?php
    $erros = [];
    if (isset($_POST['update']) && count($erros) > 0) {
        echo "<ul>";
        foreach ($erros as $erro) {
            echo "<li>$erro</li>";
        }
        echo "</ul>";
    }
    ?>
    <div class="form-container">
        <form method="POST" action="editar.php" enctype="multipart/form-data">
            <input type="hidden" name="codigo" value="<?php echo htmlspecialchars($patrimonio['codigo'] ?? ''); ?>">

            <label for="descricao">Descrição:</label>
            <input type="text" id="descricao" name="descricao" value="<?php echo htmlspecialchars($patrimonio['descricao'] ?? ''); ?>" required><br>

            <label for="setor">Setor:</label>
            <select id="setor" name="setor" required>
                <?php
                foreach ($setores as $key => $value) {
                    echo "<option value='$key' " . (($patrimonio['setor'] ?? '') == $key ? 'selected' : '') . ">$value</option>";
                }
                ?>
            </select><br>

            <label for="origem">Origem:</label>
            <select id="origem" name="origem" required>
                <?php
                foreach ($origens as $key => $value) {
                    echo "<option value='$key' " . (($patrimonio['origem'] ?? '') == $key ? 'selected' : '') . ">$value</option>";
                }
                ?>
            </select><br>

            <label for="situacao">Situação:</label>
            <select id="situacao" name="situacao" required>
                <?php
                foreach ($situacoes as $key => $value) {
                    echo "<option value='$key' " . (($patrimonio['situacao'] ?? '') == $key ? 'selected' : '') . ">$value</option>";
                }
                ?>
            </select><br>

            <label for="identificacao">Identificação:</label>
            <select id="identificacao" name="identificacao" required>
                <?php
                foreach ($identificacoes as $key => $value) {
                    echo "<option value='$key' " . (($patrimonio['identificacao'] ?? '') == $key ? 'selected' : '') . ">$value</option>";
                }
                ?>
            </select><br>

            <label for="classificacao">Classificação:</label>
            <select id="classificacao" name="classificacao" required>
                <?php
                foreach ($classificacoes as $key => $value) {
                    echo "<option value='$key' " . (($patrimonio['classificacao'] ?? '') == $key ? 'selected' : '') . ">$value</option>";
                }
                ?>
            </select><br>

            <label for="data">Data:</label>
            <input type="date" id="data" name="data" value="<?php echo htmlspecialchars($patrimonio['data'] ?? ''); ?>" required><br>

            <label for="imagem">Imagem:</label>
        <input type="file" id="imagem" name="imagem"><br>
        <?php 
            if (!empty($patrimonio['imagem'])){
                echo '<img id="previewImage" src="'.htmlspecialchars($patrimonio['imagem']).'" alt="Imagem Selecionada" style="display: block;">';
            }else{
                echo '<p>Nenhuma imagem selecionada.</p>';
            }
        ?>
            <button type="submit" name="update">Atualizar</button>
        </form>
    </div>
    <button ><a href="alterar.php" class="btn-voltar">Voltar</a></button>
</body>

</html>

<script>
    const imageInput = document.getElementById('imagem');
    const previewImage = document.getElementById('previewImage');

    imageInput.addEventListener('change', function() {
        if (this.files && this.files[0]) {
            const reader = new FileReader();

            reader.onload = function(e) {
                previewImage.src = e.target.result;
                previewImage.style.display = 'block';
            };

            reader.readAsDataURL(this.files[0]);
        }
    });
</script>
