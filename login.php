<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Sispatri</title>
    
    <link rel="stylesheet" href="estiloscss/main.css">
    <link href="pdoconfig.php">

</head>

<body>

    <div class=container>
        <form action="operacoes.php" method="post">
            <div class="imgcontainer">
                <img src="imagens/logo.png" alt="logo" class="logo">
            </div>
            <label for="cpf"><b>CPF</b></label>
            <input type="text" placeholder="Digite seu Cpf" name="cpf" required>

            <label for="senha"><b>Senha</b></label>
            <input type="password" placeholder="Digite sua Senha" name="senha" required>

            <button type="submit">Login</button>
    </div>
    </form>
</body>

</html>