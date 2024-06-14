<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sispatri</title>
    <link rel="stylesheet" href="estiloscss/patri.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css" rel="stylesheet">
</head>

<body>
    <header class="topo">
        <div class="title">Sipatri</div>
        <div class="img">
            <img src="imagens/logo.png" alt="logo" class="logo">
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
        <h1>Alterar</h1>
        <form class="formulario" id="formulario" method="GET" onsubmit="return false;">
            <div>
                <label for="buscar"><b>Buscar:</b></label>
                <input type="text" name="buscar" id="valor" required autocomplete="off" required onkeyup="buscaDados()">
            </div>
        </form>
        <div id="resultado"></div>
    </div>

    <script>
        function buscaDados() {
            const valor = document.getElementById('valor').value;
            $.ajax({
                url: 'edit.php',
                type: 'GET',
                data: {
                    buscar: valor
                },
                success: function(data) {
                    $('#resultado').html(data);
                }
            });
        }
    </script>
    </body>
</html>