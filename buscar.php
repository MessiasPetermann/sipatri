<?php
// Inclua seu arquivo de conexão com o banco de dados
include "conexao.php";

// Arrays de mapeamento para converter os valores
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

// Função para obter a chave correspondente ao valor amigável
function getKeyFromFriendlyValue($array, $value)
{
    $value = strtolower($value);
    foreach ($array as $key => $friendlyValue) {
        if (stripos($friendlyValue, $value) !== false) {
            return $key;
        }
    }
    return null;
}

// Verifica se os parâmetros foram passados via GET
if (isset($_GET['buscar']) && !empty($_GET['buscar'])) {
    $buscar = $_GET['buscar'];

    // Mapear valor amigável para chave correspondente, se aplicável
    $buscarSetor = getKeyFromFriendlyValue($setores, $buscar);
    $buscarOrigem = getKeyFromFriendlyValue($origens, $buscar);
    $buscarSituacao = getKeyFromFriendlyValue($situacoes, $buscar);
    $buscarIdentificacao = getKeyFromFriendlyValue($identificacoes, $buscar);
    $buscarClassificacao = getKeyFromFriendlyValue($classificacoes, $buscar);

    // Preparar e executar a consulta
    $sql = "SELECT * FROM tb_patrimonios WHERE 
        descricao LIKE :buscar OR 
        setor LIKE :buscarSetor OR 
        setor LIKE :buscar OR
        origem LIKE :buscarOrigem OR 
        origem LIKE :buscar OR
        situacao LIKE :buscarSituacao OR 
        situacao LIKE :buscar OR
        identificacao LIKE :buscarIdentificacao OR 
        identificacao LIKE :buscar OR
        classificacao LIKE :buscarClassificacao OR 
        classificacao LIKE :buscar OR
        notafiscal LIKE :buscar OR 
        data LIKE :buscar";
    
    $consulta = $pdo->prepare($sql);
    $busca_param = "%$buscar%";
    $consulta->bindParam(':buscar', $busca_param);
    $consulta->bindParam(':buscarSetor', $buscarSetor);
    $consulta->bindParam(':buscarOrigem', $buscarOrigem);
    $consulta->bindParam(':buscarSituacao', $buscarSituacao);
    $consulta->bindParam(':buscarIdentificacao', $buscarIdentificacao);
    $consulta->bindParam(':buscarClassificacao', $buscarClassificacao);
    $consulta->execute();
    $resultados = $consulta->fetchAll(PDO::FETCH_ASSOC);

    if ($resultados) {
        echo "<table>";
        echo "<thead><tr>";

        // Exibir os cabeçalhos das colunas em maiúsculo
        foreach ($resultados[0] as $coluna => $valor) {
            if ($coluna != 'codigo') { // Oculta a coluna "codigo"
                echo "<th>" . strtoupper(htmlspecialchars($coluna)) . "</th>";
            }
        }

        echo "</tr></thead><tbody>";

        foreach ($resultados as $linha) {
            echo "<tr>";
            foreach ($linha as $coluna => $valor) {
                if ($coluna == 'codigo') {
                    continue; // Oculta a coluna "codigo"
                }
                // Verifica e aplica a conversão para os campos necessários
                if ($coluna == 'setor' && isset($setores[$valor])) {
                    $valor = $setores[$valor];
                } elseif ($coluna == 'origem' && isset($origens[$valor])) {
                    $valor = $origens[$valor];
                } elseif ($coluna == 'situacao' && isset($situacoes[$valor])) {
                    $valor = $situacoes[$valor];
                } elseif ($coluna == 'identificacao' && isset($identificacoes[$valor])) {
                    $valor = $identificacoes[$valor];
                } elseif ($coluna == 'classificacao' && isset($classificacoes[$valor])) {
                    $valor = $classificacoes[$valor];
                } elseif ($coluna == 'data') {
                    // Converte a data para o formato brasileiro
                    $data = DateTime::createFromFormat('Y-m-d', $valor);
                    if ($data !== false) {
                        $valor = $data->format('d/m/Y');
                    }
                } elseif ($coluna == 'imagem') {
                    // Remove a parte local do caminho e cria a URL relativa
                    $relative_path = str_replace("C:\\xampp\\htdocs\\sispatri\\", "", $valor);
                    $relative_path = str_replace("\\", "/", $relative_path);
                    $url = "/sispatri/uploads/" . basename($relative_path); // Usa apenas o nome do arquivo
                    $valor = "<a href='" . htmlspecialchars($url, ENT_QUOTES, 'UTF-8') . "' target='_blank'>Ver imagem</a>";
                } else {
                    $valor = htmlspecialchars($valor, ENT_QUOTES, 'UTF-8');
                }
                echo "<td>" . $valor . "</td>";
            }
            echo "</tr>";
        }
        echo "</tbody></table>";
    } else {
        echo "Nenhum resultado encontrado.";
    }
}
?>
