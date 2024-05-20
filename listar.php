<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sispatri</title>
    <link rel= "stylesheet" href="estiloscss/patri.css">
    <link href="operacoes.php">
    
</head>

<body>  
     <header class = topo>
        <div class="title">Sispatri</div>
        <div class = img>
            <img src="imagens/logo.png" alt="logo" class = logo>
        </div>
        
    </header>

    <nav class="navbar">
        <ul class="nav-itens">
           <li><a href="index.php" data-link>Cadastrar</a></li>
           <li><a href="listar.php" data-link>Listar</a></li>
           <li><a href="alterar.php" data-link>Alterar</a></li>
       </ul>
    </nav>

<div class="container">
        <h1>Listar</h1>
    <form class="formulario"  method ='POST' action = 'operacoes.php'>

    
    </form>
</body>
</html>
<?php
    include "conexao.php";

    $consulta = $pdo->prepare("SELECT * FROM tb_patrimonios");
    $consulta->execute();
    $resultados = $consulta->fetchAll(PDO::FETCH_ASSOC);

    foreach ($resultados as $linha) {
        echo "<p>";
        foreach ($linha as $coluna => $valor) {
            echo "<strong>{$coluna}:</strong> {$valor} <br>";
        }
        echo "</p>";
    }
    

?>   