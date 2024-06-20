<?php

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

if (isset($_GET['cod_patrimonio']) && !empty($_GET['cod_patrimonio'])) {
    $cod_patrimonio = $_GET['cod_patrimonio'];

    try {
        // Preparar e executar a consulta
        $sql = "SELECT origem, setor, data, data_movimentacao FROM tb_movimentacao WHERE cod_patrimonio = :cod_patrimonio";
        $consulta = $pdo->prepare($sql);
        $consulta->bindParam(':cod_patrimonio', $cod_patrimonio);
        $consulta->execute();
        $resultados = $consulta->fetchAll(PDO::FETCH_ASSOC);

        if ($resultados) {
            // Formatar dados
            foreach ($resultados as &$resultado) {
                // Converter origem e setor
                if (isset($origens[$resultado['origem']])) {
                    $resultado['origem'] = $origens[$resultado['origem']];
                }
                if (isset($setores[$resultado['setor']])) {
                    $resultado['setor'] = $setores[$resultado['setor']];
                }

                // Formatar datas
                if (!empty($resultado['data'])) {
                    $data = DateTime::createFromFormat('Y-m-d', $resultado['data']);
                    $resultado['data'] = $data ? $data->format('d/m/Y') : 'Não informado';
                }
                if (!empty($resultado['data_movimentacao'])) {
                    $data_movimentacao = DateTime::createFromFormat('Y-m-d H:i:s', $resultado['data_movimentacao']);
                    $resultado['data_movimentacao'] = $data_movimentacao ? $data_movimentacao->format('d/m/Y H:i:s') : 'Não informado';
                }
            }
            echo json_encode($resultados);
        } else {
            echo json_encode(["error" => "Nenhum resultado encontrado."]);
        }
    } catch (Exception $e) {
        echo json_encode(["error" => $e->getMessage()]);
    }
} else {
    echo json_encode(["error" => "Código de patrimônio não informado."]);
}

?>
