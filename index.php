<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sispatri</title>
    <link rel="stylesheet" href="estiloscss/patri.css">
    <link href="operacoes.php">

</head>

<body>
    <header class=topo>
        <div class="title">Sispatri</div>
        <div class=img>
            <img src="imagens/logo.png" alt="logo" class=logo>
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
        <h1>Cadastro</h1>
        <form class="formulario" method='POST' action='operacoes.php'>

            <div class="formcont">
                <label for="data"><b>Data:</b></label>
                <input type="date" name="data">
            </div>

            <div class="formcont">
                <label for="descricao"><b>Descrição:</b></label>
                <input type="text" placeholder="Digite a Descrição" name="descricao" required>
            </div>

            <div class="formcont">
                <label for="notafiscal"><b>Nota Fiscal:</b></label>
                <input type="text" name="notafiscal" required>
            </div>

            <div class="formcont">
                <label for="nomefantasia"><b>Nome Fantasia:</b></label>
                <input type="text" name="nomefantasia" required>
            </div>

            <div class="selectcont">
                <select name="setor" data-size="3" required>
                    <option value="">Selecione o setor</option>
                    <option value="AS01">ASSEIJ</option>
                    <option value="B001">Biblioteca</option>
                    <option value="C001">Cantina</option>
                    <option value="C021">COORD.Educacional</option>
                    <option value="C022">COORD.Ed Infantil</option>
                    <option value="C023">COORD.Ens Fund 1° ao 3°</option>
                    <option value="C024">COORD.Ens Fund 4° e 5°</option>
                    <option value="C025">COORD.Ens Fund Anos Finais</option>
                    <option value="C026">COORD.Ens Médio</option>
                    <option value="C027">COORD.Curso Técnico</option>
                    <option value="C028">COORD. Permanência Integral</option>
                    <option value="CC01">Centro de convenções</option>
                    <option value="CF03">CFTV</option>
                    <option value="D001">Diretoria</option>
                    <option value="DP01">Departamento Pessoal</option>
                    <option value="E018">Escola de Esportes</option>
                    <option value="M001">Museu da capela</option>
                    <option value="NC01">Núcleo de comunicação social</option>
                    <option value="NC02">Núcleo de comunicação social Marketing</option>
                    <option value="NC03">Núcleo de comunicação e Marketing da província</option>
                    <option value="O015">Orientação Educacional ED.Infantil</option>
                    <option value="O016">Orientação Educacional 1° a 5° ano</option>
                    <option value="O017">Orientação Educacional 6° ao Ens Médio</option>
                    <option value="P014">Pastoral</option>
                    <option value="PA01">PABX</option>
                    <option value="PT01">Patrimônio</option>
                    <option value="R001">Recepção</option>
                    <option value="RD01">Recursos Didáticos</option>
                    <option value="RH01">Recursos Humanos</option>
                    <option value="RP01">Reprografia</option>
                    <option value="S001">Setap</option>
                    <option value="SC01">Secretaria Curso Técnico</option>
                    <option value="SC02">Secretaria</option>
                    <option value="SE01">Sala do Educador</option>
                    <option value="SG01">Serviços Gerais</option>
                    <option value="SS01">Serviço Social</option>
                    <option value="T002">Tesouraria</option>
                    <option value="TE01">Tecnologia Educacional</option>
                    <option value="TI01">Tecnologia da Informação</option>
                    <option value="VD01">Vice-Diretoria</option>
                </select>
            </div>

            <div class="selectcont1">
                <select name="origem" required>
                    <option value="">Selecione a origem</option>
                    <option value="1">Aquisição</option>
                    <option value="2">Doação</option>
                    <option value="3">Transferência</option>
                </select>
            </div>

            <div class="selectcont2">
                <select name="situacao" required>
                    <option value="">Selecione a situação</option>
                    <option value="1">Ativo</option>
                    <option value="2">Inativo</option>
                    <option value="3">Descarte</option>
                </select>
            </div>

            <div class="selectcont3">
                <select name="identificacao">
                    <option value="">Selecione um tipo de identificação</option>
                    <option value="1">Placa</option>
                    <option value="2">Plaqueta</option>
                    <option value="3">QRCODE</option>
                    <option value="4">Barcode</option>
                </select>
            </div>



            <div class="selectcont4">
                <select name="classificacao" id="">
                    <option value="">Selecione uma classificação</option>
                    <option value="1000">Móveis</option>
                    <option value="2000">Estante</option>
                    <option value="3000">Eletrônicos</option>
                </select>
            </div>

            <div class="formcont"><button class="btncadastrar" type="submit">Cadastrar</button></div>
        </form>
</body>

</html>