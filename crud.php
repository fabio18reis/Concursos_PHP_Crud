<?php
include_once "conexao.php";

$acao = $_GET['acao'];

if (isset($_GET['id'])) {
  $id = $_GET['id'];
}

switch ($acao) {
  case 'inseririns':

    $instituicao = $_POST['instituicao'];
    $cnpj = $_POST['cnpj'];
    $concurso = $_POST['concurso'];
    $tipocargo = $_POST['tipocargo'];
    $cargo = $_POST['nomecargo'];
    $data = $_POST['data'];
    $departamento = $_POST['departamento'];

    $sql1 = "INSERT INTO instituicao(nomeInstituicao , cnpjInstituicao) 
    VALUES ('$instituicao', '$cnpj')";

    $sql2 = "INSERT INTO concurso(nomeCurso, dataConcurso)
    VALUES ('$concurso','$data')";

    $sql3 = "INSERT INTO cargos(tipoCargo, nomeCargo)
    VALUES ('$tipocargo',' $cargo')";

    $sql4 = "INSERT INTO departamentos(nomeDepartamento)
    VALUES  ('$departamento')";

    if (!mysqli_query($conexao, $sql1)) {
      die("erro ao inserir informações" . mysqli_error($conexao));
    } else if ((!mysqli_query($conexao, $sql2))) {
      die("erro ao inserir informações" . mysqli_error($conexao));
    } else if ((!mysqli_query($conexao, $sql3))) {
      die("erro ao inserir informações" . mysqli_error($conexao));
    } else if ((!mysqli_query($conexao, $sql4))) {
      die("erro ao inserir informações" . mysqli_error($conexao));
    } else {
      echo "<script language='javascript' type='text/javascript'>
        alert('Instituição cadastrada com Sucesso!!');window.location ='crud.php?acao=instituicoes'</script>
        ";
    }


    break;

  case 'montarinst':

    $id = $_GET['id'];
    echo "<link rel='stylesheet' href='css/styles.css' integrity='sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor' crossorigin='anonymous'>";
    echo "<table width='588' border ='0' align = 'center'>";

?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="stylesheet" href="css/styles.css">
      <title>Instituicao</title>
    </head>

    <body>
      <?php
      $sqlselect = "SELECT idInstituicao , nomeInstituicao ,cnpjInstituicao, nomeCurso , dataConcurso , tipoCargo, nomeCargo,nomeDepartamento  FROM instituicao i INNER JOIN concurso c ON i.idInstituicao = c.idConcurso INNER JOIN cargos x ON c.idConcurso = x.idcargo INNER JOIN departamentos d ON x.idcargo = d.idDepartamento WHERE idInstituicao = '" . $id . "'";
      $resultado = mysqli_query($conexao, $sqlselect) or die("Erro ao retornar dados");


      while ($registro = mysqli_fetch_array($resultado)) {
        echo "<div class='container'>
                <form  method = 'post' name = 'dados' action='crud.php?acao=atualizarinst' onSubmit='return Enviardados();>
                <div class='form-group'>
                    <label>ID:</label>
                    <input type='number' class= 'form-control' id='id' name= 'id' value=" . $id . " readonly>
                  </div>
                  <br>
                  <div class='container'>
                  <form method='post' action='crud.php?acao=inseririns' name = 'dadosins'  >
                    <div class='form-group'>
                      <label>Nome da Instituição:</label>
                      <input type='text' class='form-control' id='instituicao' name='instituicao' placeholder='Nome da Instituição' value='" . ($registro['nomeInstituicao']) . "'>
                    </div>
                    <br>
                    <div class='form-group'>
                      <label>CNPJ:</label>
                      <input type='number' class='form-control' id='cnpj' name= 'cnpj' placeholder='CNPJ' value='" . ($registro['cnpjInstituicao']) . "'>
                    </div>
                    <br>
                    <div class='form-group'>
                      <label>Título do Concurso:</label>
                      <input type='text' class='form-control' id='concurso' name= 'concurso' placeholder='Concurso' value='" . ($registro['nomeCurso']) . "'>
                    </div>
                    <br>
                    <div class='form-group'>
                      <label>Título do Cargo:</label>
                      <input type='text' class='form-control' id='nomecargo' name= 'nomecargo' placeholder='Título do Cargo' value='" . ($registro['nomeCargo']) . "'>
                    </div>
                    <br>
                    <div class='form-group'>
                      <label>Tipo do Cargo:</label>
                      <input type='text' class='form-control' id='tipocargo' name= 'tipocargo' placeholder='Tipo de Cargo' value='" . ($registro['tipoCargo']) . "'>
                    </div>
                    <br>
                    <div class='form-group'>
                    <label>Departamento:</label>
                    <input type='text' class='form-control' id='departamento' name= 'departamento' placeholder='Departamento' value='" . ($registro['nomeDepartamento']) . "'>
                  </div>
                  <br>
                    <div class='form-group'>
                      <label>Data:</label>
                      <input type='date' class='form-control' id='data' name= 'data' placeholder='Concurso' value='" . ($registro['dataConcurso']) . "'>
                    </div>
                    <br>
                    <hr>
                    <br>
                 
                    <div>
                      <span>
                      <button type='submit' class='btn btn-success'>Cadastrar</button>
                      </span>
                      <span>
                      <button type='submit' class='btn btn-primary' formaction='crud.php?acao=selecionar'>Voltar</button>
                      </span>
                    </div>
                </div>
                </form>
                <hr>
                </div>";



        mysqli_close($conexao);
      }
      break;


    case 'atualizarinst':

      $id = $_POST['id'];
      $nomeinst = $_POST['instituicao'];
      $cnpj = $_POST['cnpj'];
      $concurso = $_POST['concurso'];
      $cargo = $_POST['nomecargo'];
      $tipocargo = $_POST['tipocargo'];
      $data = $_POST['data'];
      $departamento = $_POST['departamento'];



      $sqlUpdate = "UPDATE instituicao AS i INNER JOIN concurso c ON i.idInstituicao = c.idConcurso INNER JOIN cargos x ON c.idConcurso = x.idCargo INNER JOIN departamentos d ON x.idCargo = d.idDepartamento  SET nomeInstituicao = '$nomeinst', cnpjInstituicao = '$cnpj', c.nomeCurso  = '$concurso', c.dataConcurso = '$data', x.tipoCargo = '$tipocargo', x.nomeCargo = '$cargo' ,d.nomeDepartamento = '$departamento' WHERE idInstituicao = '" . $id . "'";
      $resultado = mysqli_query($conexao, $sqlUpdate) or die("Erro ao retornar dados");


      if (!mysqli_query($conexao, $sqlUpdate)) {
        echo "<script language='javascript' type='text/javascript'>
                  alert('Erro!');window.location ='crud.php?acao=selecionar'</script>";
      } else {
        echo "<script language='javascript' type='text/javascript'>
                alert('Concruso Editado!');window.location ='crud.php?acao=selecionar'</script>";
      }

      break;

    case 'montarinsc':

      $id = $_GET['id'];
      echo "<link rel='stylesheet' href='css/styles.css' integrity='sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor' crossorigin='anonymous'>";
      echo "<table width='588' border ='0' align = 'center'>";

      ?>
      <!DOCTYPE html>
      <html lang="pt-br">

      <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/styles.css">
        <title>Inscrever</title>
      </head>

      <body>
      <?php
      echo "<div class='container'>
            <form  method = 'post' name = 'dados' action='crud.php?acao=inscrever' onSubmit='return Enviardados();>
            <div class='form-group'>
                <label>ID:</label>
                <input type='number' class= 'form-control' id='id' name= 'id' value=" . $id . " readonly>
              </div>
              <br>
              <div class='form-group'>
                <label>Nome:</label>
                <input type='text' class='form-control' id='nome' name='nome' placeholder='Digite Seu nome'>
              </div>
              <br>
              <div class='form-group'>
                <label>CPF:</label>
                <input type='number' class='form-control' id='cpf' name='cpf' placeholder='Digite o seu CPF'>
              </div>
              <br>
              <div class='form-group'>
                <label>RG:</label>
                <input type='number' class='form-control' id='rg' name= 'rg' placeholder='Digite os Números do RG'>
              </div>
              <br>
              <div class='form-group'>
                <label>CEP:</label>
                <input type='number' class='form-control' id='cep' name= 'cep' placeholder='Digite o CEP(somente números)'>
              </div>
              <br>
              <div class='form-group'>
                <label>Rua:</label>
                <input type='text' class='form-control' id='rua' name= 'rua' placeholder='Digite o nome da rua'>
              </div>
              <br>
              <div class='form-group'>
                <label>Número:</label>
                <input type='number' class='form-control' id='numero' name= 'numero' placeholder='Digite o Número do seu Endereço'>
              </div>
              <br>
              <div class='form-group'>
                <label>Bairro:</label>
                <input type='text' class='form-control' id='bairro' name= 'bairro' placeholder='Digite o Nome do Bairro'>
              </div>
              <br>
              <div class='form-group'>
              <label class='form-label' for='input'>Estado/UF: </label>
                        <select name='estado'>
                          <option value='AC'>AC</option>
                          <option value='AL'>AL</option>
                          <option value='AP'>AP</option>
                          <option value='AM'>AM</option>
                          <option value='BA'>BA</option>
                          <option value='CE'>CE</option>
                          <option value='DF'>DF</option>
                          <option value='ES'>ES</option>
                          <option value='GO'>GO</option>
                          <option value='MA'>MA</option>
                          <option value='MT'>MT</option>
                          <option value='MS'>MS</option>
                          <option value='MG'>MG</option>
                          <option value='PA'>PA</option>
                          <option value='PB'>PB</option>
                          <option value='PR'>PR</option>
                          <option value='PE'>PE</option>
                          <option value='PI'>PI</option>
                          <option value='RJ'>RJ</option>
                          <option value='RN'>RN</option>
                          <option value='RS'>RS</option>
                          <option value='RO'>RO</option>
                          <option value='RR'>RR</option>
                          <option value='SC'>SC</option>
                          <option value='SP'>SP</option>
                          <option value='SE'>SE</option>
                          <option value='TO'>TO</option>
                        </select>
              </div>
              <div>
              <span>
              <button type='submit' class='btn btn-success' formaction='crud.php?acao=inscrever'>Cadastrar</button>
              </span>
              <span>
              <button type='submit' class= 'btn btn-primary' formaction='crud.php?acao=selecionar'>Voltar</button>
              </span>
              </div>";


      mysqli_close($conexao);
      break;

    case 'inscrever':
      $idinstituicao = $_POST['id'];
      $nome = $_POST['nome'];
      $cpf = $_POST['cpf'];
      $rg = $_POST['rg'];
      $cep = $_POST['cep'];
      $rua = $_POST['rua'];
      $numero = $_POST['numero'];
      $bairro = $_POST['bairro'];
      $estado = $_POST['estado'];

      $sql1 = "INSERT INTO candidato(nomeCandidato , cpfCandidato , rgCandidato, fk_Candidato_instituicao) 
      VALUES ('$nome', '$cpf', '$rg' , $idinstituicao)";
      $sql2 = "INSERT INTO endereco(rua , bairro , estado , cep , numero)
      VALUES ('$rua' , '$bairro' , '$estado' , '$cep' , '$numero')";


      if (!mysqli_query($conexao, $sql1)) {
        die("erro ao inserir informações" . mysqli_error($conexao));
      } else if (!mysqli_query($conexao, $sql2)) {
        die("erro ao inserir informações" . mysqli_error($conexao));
      } else {
        echo "<script language='javascript' type='text/javascript'>
        alert('Dados Cadastrados!');window.location ='crud.php?acao=candCurso'</script>
        ";
      }



      if (!mysqli_query($conexao, $sqlUpdate)) {
        echo "<script language='javascript' type='text/javascript'>
              alert('Erro!');window.location ='crud.php?acao=selecionar'</script>";
      } else {
        echo "<script language='javascript' type='text/javascript'>
            alert('Inscrição confirmada!');window.location ='crud.php?acao=selecionar'</script>";
      }

      break;

    case 'deletar':

      $sql = "DELETE i , c , x , d FROM instituicao i INNER JOIN concurso c ON i.idInstituicao = c.idConcurso INNER JOIN cargos x ON c.idConcurso = x.idcargo INNER JOIN departamentos d ON x.idcargo = d.idDepartamento WHERE idInstituicao = '" . $id . "'";

      if (!mysqli_query($conexao, $sql)) {
        die("erro ao inserir informações" . mysqli_error($conexao));
      } else {
        echo "<script language='javascript' type='text/javascript'>
        alert('Vaga deletada!')
        window.location.href='crud.php?acao=selecionar'</script>";
      }
      mysqli_close($conexao);



      break;


    case 'deletarcad':

      $sql = "DELETE c , e FROM candidato c INNER JOIN endereco e ON c.idcandidato = e.idEnd WHERE idcandidato = '" . $id . "'";

      if (!mysqli_query($conexao, $sql)) {
        die("erro ao inserir informações" . mysqli_error($conexao));
      } else {
        echo "<script language='javascript' type='text/javascript'>
            alert('Dados do Usuário deletado!')
            window.location.href='crud.php?acao=selecionarcand'</script>";
      }
      mysqli_close($conexao);



      break;

    case 'selecionar':

      date_default_timezone_set('America/Sao_Paulo');
      ?>
        <!DOCTYPE html>
        <html lang="pt-br">

        <head>
          <meta charset="UTF-8">
          <meta http-equiv="X-UA-Compatible" content="IE=edge">
          <meta name="viewport" content="width=device-width, initial-scale=1.0">
          <link rel="stylesheet" href="css/styles.css">
          <title>Concursos</title>
        </head>

        <body>
          <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="#">Concursos CPI</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
              <ul class="navbar-nav">
                <li class="nav-item active">
                  <a class="nav-link" href="crud.php?acao=selecionar">Vagas<span class="sr-only"></span></a>
                </li>
                <li class="nav-item active">
                  <a class="nav-link" href="crud.php?acao=instituicoes">Cadastre seu Concurso<span class="sr-only"></span></a>
                </li>
                <li class="nav-item active">
                  <a class="nav-link" href="crud.php?acao=candCurso">Vagas Preenchidas<span class="sr-only"></span></a>
                </li>
                <li class="nav-item active">
                  <a class="nav-link" href="crud.php?acao=selecionarcand">Candidatos<span class="sr-only"></span></a>
                </li>
              </ul>
            </div>
          </nav>
          <?php



          echo "<table class='table table-striped table-dark'";
          echo "thead class = 'thead-dark'";
          echo "<tr>";
          echo "<th scope='col'>ID</th>";
          echo "<th scope='col'>INSTITUIÇÃO</th>";
          echo "<th scope='col'>CONCURSO</th>";
          echo "<th scope='col'>TIPO CARGO</th>";
          echo "<th scope='col'>NOME CARGO</th>";
          echo "<th scope='col'>DEPARTAMENTO</th>";
          echo "<th scope='col'>INSCRIÇÕES ATÉ</th>";
          echo "<th scope='col'>OPÇÕES</th>";
          echo "</tr>";

          $sqlselect = "SELECT idInstituicao , nomeInstituicao , nomeCurso , dataConcurso , tipoCargo, nomeCargo,nomeDepartamento  FROM instituicao i INNER JOIN concurso c ON i.idInstituicao = c.idConcurso INNER JOIN cargos x ON c.idConcurso = x.idcargo INNER JOIN departamentos d ON x.idcargo = d.idDepartamento";
          $resultado = mysqli_query($conexao, $sqlselect) or die("Erro ao retornar dados");

          echo "<center><h1>Vagas Disponíveis</h1><br/></center>";
          echo "</br>";

          while ($registro = mysqli_fetch_array($resultado)) {

            $id = $registro['idInstituicao'];
            $instituicao = $registro['nomeInstituicao'];
            $data = $registro['dataConcurso'];
            $concurso = $registro['nomeCurso'];
            $tipocargo = $registro['tipoCargo'];
            $nomecargo = $registro['nomeCargo'];
            $departamento = $registro['nomeDepartamento'];

            echo "<tr>";
            echo "<td>" . $id . "</td>";
            echo "<td>" . $instituicao . "</td>";
            echo "<td>" . $concurso . "</td>";
            echo "<td>" . $nomecargo . "</td>";
            echo "<td>" . $tipocargo . "</td>";
            echo "<td>" . $departamento . "</td>";
            echo "<td>" . date("d/m/Y", strtotime($data)) . "</td>";
            echo "<td> <a href='crud.php?acao=deletar&id=$id' >
              <svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' fill='currentColor' class='bi bi-trash3' viewBox='0 0 16 16'>
              <path d='M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5ZM11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H2.506a.58.58 0 0 0-.01 0H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1h-.995a.59.59 0 0 0-.01 0H11Zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5h9.916Zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47ZM8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5Z'/>
              </svg>Deletar</a><br>
                       <a href='crud.php?acao=montarinst&id=$id' ><svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' fill='currentColor' class='bi bi-pencil-square' viewBox='0 0 16 16'>
                       <path d='M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z'/>
                       <path fill-rule='evenodd' d='M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z'/>
                     </svg>Editar</a><br>
                       <a href='crud.php?acao=montarinsc&id=$id'><svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' fill='currentColor' class='bi bi-file-earmark-arrow-up' viewBox='0 0 16 16'>
                       <path d='M8.5 11.5a.5.5 0 0 1-1 0V7.707L6.354 8.854a.5.5 0 1 1-.708-.708l2-2a.5.5 0 0 1 .708 0l2 2a.5.5 0 0 1-.708.708L8.5 7.707V11.5z'/>
                       <path d='M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2zM9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5v2z'/>
                     </svg>Inscrever-se</a>";
          }
          echo "</tr>";
          echo "<tr>";
          echo "</tr>";

          mysqli_close($conexao);


          break;

        case 'candCurso':

          date_default_timezone_set('America/Sao_Paulo');
          ?>
          <!DOCTYPE html>
          <html lang="en">

          <head>

          <body>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="css/styles.css">
            <title>Vagas Ocupadas</title>
            </head>

            <body>
              <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <a class="navbar-brand" href="#">Concursos CPI</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                  <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavDropdown">
                  <ul class="navbar-nav">
                    <li class="nav-item active">
                      <a class="nav-link" href="crud.php?acao=selecionar">Vagas<span class="sr-only"></span></a>
                    </li>
                    <li class="nav-item active">
                      <a class="nav-link" href="crud.php?acao=instituicoes">Cadastre seu Concurso<span class="sr-only"></span></a>
                    </li>
                    <li class="nav-item active">
                      <a class="nav-link" href="crud.php?acao=candCurso">Vagas Preenchidas<span class="sr-only"></span></a>
                    </li>
                    <li class="nav-item active">
                      <a class="nav-link" href="crud.php?acao=selecionarcand">Candidatos<span class="sr-only"></span></a>
                    </li>
                  </ul>
                </div>
              </nav>
              <?php


              echo "<table class='table table-striped table-dark'";
              echo "thead class = 'thead-dark'";
              echo "<tr>";
              echo "<th scope='col'>ID</th>";
              echo "<th scope='col'>NOME</th>";
              echo "<th scope='col'>CPF</th>";
              echo "<th scope='col'>RG</th>";
              echo "<th scope='col'>CEP</th>";
              echo "<th scope='col'>RUA</th>";
              echo "<th scope='col'>NÚMERO</th>";
              echo "<th scope='col'>BAIRRO</th>";
              echo "<th scope='col'>ESTADO</th>";
              echo "<th scope='col'>INSTITUIÇÃO</th>";
              echo "<th scope='col'>CONCURSO</th>";
              echo "<th scope='col'>TIPO DO CARGO</th>";
              echo "<th scope='col'>CARGO</th>";
              echo "<th scope='col'>DEPARTAMENTO</th>";
              echo "<th scope='col'>STATUS</th>";
              echo "<th scope='col'>OPÇÕES</th>";
              echo "</thead>";
              echo "</tr>";

              $sqlselect = "SELECT * FROM candidato c INNER JOIN endereco e ON c.idcandidato = e.idEnd INNER JOIN instituicao i ON c.fk_Candidato_instituicao = i.idInstituicao INNER JOIN concurso j ON 
              i.idInstituicao = j.idConcurso INNER JOIN cargos x ON j.idConcurso = x.idCargo INNER JOIN departamentos d ON x.idCargo = d.idDepartamento
        ";
              $resultado = mysqli_query($conexao, $sqlselect) or die("Erro ao retornar dados");

              echo "<center><h1>Vagas Ocupadas</h1><br/></center>";
              echo "</br>";

              while ($registro = mysqli_fetch_array($resultado)) {


                $id = $registro['idcandidato'];
                $nome = $registro['nomeCandidato'];
                $cpf = $registro['cpfCandidato'];
                $rg = $registro['rgCandidato'];
                $cep = $registro['CEP'];
                $rua = $registro['rua'];
                $numero = $registro['numero'];
                $bairro = $registro['bairro'];
                $estado = $registro['estado'];
                $instituicao = $registro['nomeInstituicao'];
                $concurso = $registro['nomeCurso'];
                $data = $registro['dataConcurso'];
                $tipocargo = $registro['tipoCargo'];
                $cargo = $registro['nomeCargo'];
                $status = $registro['statusCandidato'];
                $departamento = $registro['nomeDepartamento'];


                echo "<tr scope='row'>";
                echo "<td>" . $id . "</td>";
                echo "<td>" . $nome . "</td>";
                echo "<td>" . $cpf . "</td>";
                echo "<td>" . $rg . "</td>";
                echo "<td>" . $cep . "</td>";
                echo "<td>" . $rua . "</td>";
                echo "<td>" . $numero . "</td>";
                echo "<td>" . $bairro . "</td>";
                echo "<td>" . $estado . "</td>";
                echo "<td>" . $instituicao . "</td>";
                echo "<td>" . $concurso . "</td>";
                echo "<td>" . $tipocargo . "</td>";
                echo "<td>" . $cargo . "</td>";
                echo "<td>" . $departamento . "</td>";
                echo "<td>" . $status . "</td>";


                echo "<td> <a href='crud.php?acao=deletarcad&id=$id'> <svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' fill='currentColor' class='bi bi-trash3' viewBox='0 0 16 16'>
              <path d='M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5ZM11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H2.506a.58.58 0 0 0-.01 0H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1h-.995a.59.59 0 0 0-.01 0H11Zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5h9.916Zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47ZM8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5Z'/>
              </svg>Deletar</a><br>
            <a href='crud.php?acao=attstatuscandform&id=$id' ><svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' fill='currentColor' class='bi bi-check-circle' viewBox='0 0 16 16'>
              <path d='M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z'/>
              <path d='M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z'/>
            </svg>Status</a>";
              }
              echo "</tr>";
              echo "<tr>";
              echo "</tr>";
              mysqli_close($conexao);


              break;

            case 'selecionarcand':

              echo "<link rel='stylesheet' href='css/styles.css' integrity='sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor' crossorigin='anonymous'>";
              echo "<table width='588' border ='0' align = 'center'>";

              ?>
              <!DOCTYPE html>
              <html lang="pt-br">

              <head>
                <meta charset="UTF-8">
                <meta http-equiv="X-UA-Compatible" content="IE=edge">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <link rel="stylesheet" href="css/styles.css">
                <title>Candidatos</title>
              </head>

              <body>
                <nav class="navbar navbar-expand-lg navbar-light bg-light">
                  <a class="navbar-brand" href="#">Concursos CPI</a>
                  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                  </button>
                  <div class="collapse navbar-collapse" id="navbarNavDropdown">
                    <ul class="navbar-nav">
                      <li class="nav-item active">
                        <a class="nav-link" href="crud.php?acao=selecionar">Vagas<span class="sr-only"></span></a>
                      </li>
                      <li class="nav-item active">
                        <a class="nav-link" href="crud.php?acao=instituicoes">Cadastre seu Concurso<span class="sr-only"></span></a>
                      </li>
                      <li class="nav-item active">
                        <a class="nav-link" href="crud.php?acao=candCurso">Vagas Preenchidas<span class="sr-only"></span></a>
                      </li>
                      <li class="nav-item active">
                        <a class="nav-link" href="crud.php?acao=selecionarcand">Candidatos<span class="sr-only"></span></a>
                      </li>
                    </ul>
                  </div>
                </nav>

                <?php

                echo "<table class='table table-striped table-dark'";
                echo "thead class = 'thead-dark'";
                echo "<tr>";
                echo "<th>ID</th>";
                echo "<th>NOME</th>";
                echo "<th>CPF</th>";
                echo "<th>RG</th>";
                echo "<th>RUA</th>";
                echo "<th>BAIRRO</th>";
                echo "<th>ESTADO</th>";
                echo "<th>CEP</th>";
                echo "<th>NUMERO</th>";
                echo "<th>OPÇÕES</th>";
                echo "</tr>";

                $sqlselect = "SELECT * FROM candidato c INNER JOIN endereco e ON c.idcandidato = e.idEnd";
                $resultado = mysqli_query($conexao, $sqlselect) or die("Erro ao retornar dados");

                echo "<center><h1>Candidatos Cadastrados</h1><br/></center>";
                echo "</br>";

                while ($registro = mysqli_fetch_array($resultado)) {

                  $id = $registro['idcandidato'];
                  $nome = $registro['nomeCandidato'];
                  $cpf = $registro['cpfCandidato'];
                  $rg = $registro['rgCandidato'];
                  $cep = $registro['cep'];
                  $rua = $registro['rua'];
                  $numero = $registro['numero'];
                  $bairro = $registro['bairro'];
                  $estado = $registro['estado'];

                  echo "<tr>";
                  echo "<td>" . $id . "</td>";
                  echo "<td>" . $nome . "</td>";
                  echo "<td>" . $cpf . "</td>";
                  echo "<td>" . $rg . "</td>";
                  echo "<td>" . $rua . "</td>";
                  echo "<td>" . $bairro . "</td>";
                  echo "<td>" . $estado . "</td>";
                  echo "<td>" . $cep . "</td>";
                  echo "<td>" . $numero . "</td>";

                  echo "<td> <a href='crud.php?acao=deletarcad&id=$id' >
              <svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' fill='currentColor' class='bi bi-trash3' viewBox='0 0 16 16'>
              <path d='M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5ZM11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H2.506a.58.58 0 0 0-.01 0H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1h-.995a.59.59 0 0 0-.01 0H11Zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5h9.916Zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47ZM8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5Z'/>
              </svg>Deletar</a><br>
                       <a href='crud.php?acao=editarcad&id=$id' ><svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' fill='currentColor' class='bi bi-pencil-square' viewBox='0 0 16 16'>
                       <path d='M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z'/>
                       <path fill-rule='evenodd' d='M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z'/>
                     </svg>Editar</a><br>";
                }
                echo "</tr>";
                echo "<tr>";
                echo "</tr>";

                mysqli_close($conexao);

                break;



                mysqli_close($conexao);
                break;

              case 'atualizarcand':

                $id = $_POST['id'];
                $nome = $_POST['nome'];
                $cpf = $_POST['cpf'];
                $rg = $_POST['rg'];
                $cep = $_POST['cep'];
                $rua = $_POST['rua'];
                $numero = $_POST['numero'];
                $bairro = $_POST['bairro'];
                $estado = $_POST['estado'];



                $sqlUpdate = "UPDATE candidato AS c INNER JOIN endereco e ON c.idcandidato = e.idEnd SET nomeCandidato = '$nome', cpfCandidato = '$cpf', rgCandidato = '$rg', e.rua = '$rua' , e.bairro = '$bairro', e.estado = '$estado', e.CEP = '$cep', e.numero = '$numero' WHERE idcandidato = '" . $id . "'";
                $resultado = mysqli_query($conexao, $sqlUpdate) or die("Erro ao retornar dados");


                if (!mysqli_query($conexao, $sqlUpdate)) {
                  echo "<script language='javascript' type='text/javascript'>
                          alert('Erro!');window.location ='crud.php?acao=selecionar'</script>";
                } else {
                  echo "<script language='javascript' type='text/javascript'>
                        alert('Usuario Alterado!');window.location ='crud.php?acao=selecionarcand'</script>";
                }

                break;
              case 'editarcad':

                $id = $_GET['id'];
                echo "<link rel='stylesheet' href='css/styles.css' integrity='sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor' crossorigin='anonymous'>";
                echo "<table width='588' border ='0' align = 'center'>";

                ?>
                <!DOCTYPE html>
                <html lang="pt-br">

                <head>
                  <meta charset="UTF-8">
                  <meta http-equiv="X-UA-Compatible" content="IE=edge">
                  <meta name="viewport" content="width=device-width, initial-scale=1.0">
                  <link rel="stylesheet" href="css/styles.css">
                  <title>Editar Cadastro</title>
                </head>

                <body>


                  <?php

                  $sqlselect = "SELECT * FROM candidato c INNER JOIN endereco e ON c.idcandidato = e.idEnd WHERE idcandidato = '" . $id . "'";
                  $resultado = mysqli_query($conexao, $sqlselect) or die("Erro ao retornar dados");

                  while ($registro = mysqli_fetch_array($resultado)) {
                    echo "<div class='container'>
                      <form  method = 'post' name = 'dados' action='crud.php?acao=atualizarcand' onSubmit='return Enviardados();>
                      <div class='container'>
                      <div class='form-group'>
                          <label>ID:</label>
                          <input type='number' class= 'form-control' id='id' name= 'id' value=" . $id . " readonly>
                        </div>
                        <br>
                        <div class='form-group'>
                          <label>Nome:</label>
                          <input type='text' class='form-control' id='nome' name='nome' placeholder='Digite Seu nome' value='" . ($registro['nomeCandidato']) . "'>
                        </div>
                        <br>
                        <div class='form-group'>
                          <label>CPF:</label>
                          <input type='number' class='form-control' id='cpf' name='cpf' placeholder='Digite o seu CPF' value='" . ($registro['cpfCandidato']) . "'>
                        </div>
                        <br>
                        <div class='form-group'>
                          <label>RG:</label>
                          <input type='number' class='form-control' id='rg' name= 'rg' placeholder='Digite os Números do RG' value='" . ($registro['rgCandidato']) . "'>
                        </div>
                        <br>
                        <div class='form-group'>
                          <label>CEP:</label>
                          <input type='number' class='form-control' id='cep' name='cep' placeholder='Digite o CEP(somente números)' value='" . ($registro['cep']) . "'>
                        </div>
                        <br>
                        <div class='form-group'>
                          <label>Rua:</label>
                          <input type='text' class='form-control' id='rua' name='rua' placeholder='Digite o nome da rua' value='" . ($registro['rua']) . "'>
                        </div>
                        <br>
                        <div class='form-group'>
                          <label>Número:</label>
                          <input type='number' class='form-control' id='numero' name='numero' placeholder='Digite o Número do seu Endereço' value='" . ($registro['numero']) . "'>
                        </div>
                        <br>
                        <div class='form-group'>
                          <label>Bairro:</label>
                          <input type='text' class='form-control' id='bairro' name='bairro' placeholder='Digite o Nome do Bairro' value='" . ($registro['bairro']) . "'>
                        </div>
                        <br>
                        <div class='form-group'>
                        <label class='form-label' for='input'>Estado/UF: </label>
                                  <select name='estado' id ='estado' >
                                    <option value='AC'>AC</option>
                                    <option value='AL'>AL</option>
                                    <option value='AP'>AP</option>
                                    <option value='AM'>AM</option>
                                    <option value='BA'>BA</option>
                                    <option value='CE'>CE</option>
                                    <option value='DF'>DF</option>
                                    <option value='ES'>ES</option>
                                    <option value='GO'>GO</option>
                                    <option value='MA'>MA</option>
                                    <option value='MT'>MT</option>
                                    <option value='MS'>MS</option>
                                    <option value='MG'>MG</option>
                                    <option value='PA'>PA</option>
                                    <option value='PB'>PB</option>
                                    <option value='PR'>PR</option>
                                    <option value='PE'>PE</option>
                                    <option value='PI'>PI</option>
                                    <option value='RJ'>RJ</option>
                                    <option value='RN'>RN</option>
                                    <option value='RS'>RS</option>
                                    <option value='RO'>RO</option>
                                    <option value='RR'>RR</option>
                                    <option value='SC'>SC</option>
                                    <option value='SP'>SP</option>
                                    <option value='SE'>SE</option>
                                    <option value='TO'>TO</option>
                                  </select>
                        </div>
                        <div>
                        <span>
                        <button type='submit' class='btn btn-success' formaction='crud.php?acao=atualizarcand'>Confirmar</button>
                        </span>
                        <span>
                        <button type='submit' class= 'btn btn-primary' formaction='crud.php?acao=selecionarcand'>Voltar</button>
                        </span>
                        </div>
                        </div>";
                  }

                  mysqli_close($conexao);
                  break;

                case 'attstatuscandmont':

                  $id = $_POST['id'];
                  $nome = $_POST['nome'];
                  $cpf = $_POST['cpf'];
                  $rg = $_POST['rg'];
                  $cep = $_POST['cep'];
                  $rua = $_POST['rua'];
                  $numero = $_POST['numero'];
                  $bairro = $_POST['bairro'];
                  $estado = $_POST['estado'];



                  $sqlUpdate = "UPDATE candidato AS c INNER JOIN endereco e ON c.idcandidato = e.idEnd SET nomeCandidato = '$nome', cpfCandidato = '$cpf', rgCandidato = '$rg', e.rua = '$rua' , e.bairro = '$bairro', e.estado = '$estado', e.CEP = '$cep', e.numero = '$numero' WHERE idcandidato = '" . $id . "'";
                  $resultado = mysqli_query($conexao, $sqlUpdate) or die("Erro ao retornar dados");


                  if (!mysqli_query($conexao, $sqlUpdate)) {
                    echo "<script language='javascript' type='text/javascript'>
                              alert('Erro!');window.location ='crud.php?acao=selecionar'</script>";
                  } else {
                    echo "<script language='javascript' type='text/javascript'>
                            alert('Usuario Alterado!');window.location ='crud.php?acao=selecionarcand'</script>";
                  }

                  break;
                case 'attstatuscandform':

                  $id = $_GET['id'];
                  $sqlselectcand = "SELECT * FROM candidato Where idcandidato ='" . $id . "'";
                  $resultado = mysqli_query($conexao, $sqlselectcand) or die("ERRO!");
                  echo "<link rel='stylesheet' href='css/styles.css' integrity='sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor' crossorigin='anonymous'>";
                  echo "<table width='588' border ='0' align = 'center'>";

                  ?>
                  <!DOCTYPE html>
                  <html lang="pt-br">

                  <head>
                    <meta charset="UTF-8">
                    <meta http-equiv="X-UA-Compatible" content="IE=edge">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <link rel="stylesheet" href="css/styles.css">
                    <title>Status Candidato</title>
                  </head>

                  <body>
                    <?php
                    while ($registro = mysqli_fetch_array($resultado)) {
                      echo "        <div class='container'>
                          <form  method = 'post' name = 'dados' action='crud.php?acao=attsitcand' onSubmit='return Enviardados();>
                          <div class='form-group'>
                              <label>ID:</label>
                              <input type='number' class= 'form-control' id='id' name= 'id' value=" . $id . " readonly>
                            </div>
                            <br>
                            <div class='form-group'>
                              <label>Nome:</label>
                              <input type='text' class='form-control' id='nome' name='nome' value='" . ($registro['nomeCandidato']) . "' readonly>
                            </div>
                            <br>
                            <div class='form-group'>
                              <label>CPF:</label>
                              <input type='number' class='form-control' id='cpf' name='cpf' value='" . ($registro['cpfCandidato']) . "' readonly>
                            </div>
                            <br>
                            <div class='form-group'>
                              <label>RG:</label>
                              <input type='number' class='form-control' id='rg' name= 'rg' value='" . ($registro['rgCandidato']) . "' readonly>
                            </div>
                            <br>
                            <div class='form-group'>
                            <label class='form-label' for='input'>Status: </label>
                            <select class='form-control' name='status' id ='status' >
                                  <option class='form-control'>Selecione</option>
                                  <option class='form-control' value='Eliminado'>Eliminado</option>
                                  <option class='form-control' value='Classificado'>Classificado</option>
                            </select>
                            </div>
                            <br>
                            <div>
                            <span>
                            <button type='submit' class='btn btn-success' formaction='crud.php?acao=attsitcand''>Confirmar</button>
                            </span>
                            <span>
                            <button type='submit' class= 'btn btn-primary' formaction='crud.php?acao=candCurso'>Voltar</button>
                            </span>
                            </div>
                            ";
                    }

                    ?>

                  </body>

                  </html>
                <?php


                  mysqli_close($conexao);
                  break;

                case 'attsitcand':

                  $id = $_POST['id'];
                  $status = $_POST['status'];

                  $sqlUpdate = "UPDATE candidato SET statusCandidato = '$status' WHERE idcandidato = '" . $id . "'";

                  $resultado = mysqli_query($conexao, $sqlUpdate) or die("Erro ao retornar dados");


                  if (!mysqli_query($conexao, $sqlUpdate)) {
                    echo "<script language='javascript' type='text/javascript'>
                                alert('Erro!');window.location ='crud.php?acao=candCurso'</script>";
                  } else {
                    echo "<script language='javascript' type='text/javascript'>
                              alert('Status Alterado com Sucesso!');window.location ='crud.php?acao=candCurso'</script>";
                  }

                  break;

                case 'instituicoes':

                ?>
                  <!DOCTYPE html>
                  <html lang="pt-br">

                  <head>
                    <meta charset="UTF-8">
                    <meta http-equiv="X-UA-Compatible" content="IE=edge">
                    <meta name="viewport" content="width=device-width, initial-scale=1.0">
                    <link rel="stylesheet" href="css/styles.css">
                    <title>Cadastrar Instituições</title>
                  </head>

                  <body>
                    <?php
                    echo "
  <br>
  <br>
  <br>
  <hr>
  <div class ='container'>
  <center><h1>Insira as informações a baixo</h1></center>
  </div>
  <br>
  <div class='container'>
    <form method='post' action='crud.php?acao=inseririns' name = 'dadosins'>
      <div class='form-group'>
        <label>Nome da Instituição:</label>
        <input type='text' class='form-control' id='instituicao' name='instituicao' placeholder='Nome da Instituição'>
      </div>
      <br>
      <div class='form-group'>
        <label>CNPJ:</label>
        <input type='number' class='form-control' id='cnpj' name= 'cnpj' placeholder='CNPJ'>
      </div>
      <br>
      <div class='form-group'>
        <label>Título do Concurso:</label>
        <input type='text' class='form-control' id='concurso' name= 'concurso' placeholder='Concurso'>
      </div>
      <br>
      <div class='form-group'>
        <label>Título do Cargo:</label>
        <input type='text' class='form-control' id='nomecargo' name= 'nomecargo' placeholder='Título do Cargo'>
      </div>
      <br>
      <div class='form-group'>
        <label>Tipo do Cargo:</label>
        <input type='text' class='form-control' id='tipocargo' name= 'tipocargo' placeholder='Tipo de Cargo'>
      </div>
      <br>
      <div class='form-group'>
        <label>Departamento:</label>
        <input type='text' class='form-control' id='departamento' name= 'departamento' placeholder='Departamento'>
      </div>
      <br>
      <div class='form-group'>
        <label>Inscrições até:</label>
        <input type='date' class='form-control' id='data' name= 'data' placeholder='Concurso'>
      </div>
      <br>
      <hr>
      <br>
      
      <div>
        <span>
        <button type='submit' class='btn btn-success'>Cadastrar</button>
        </span>
        <span>
        <button type='submit' class='btn btn-primary' formaction='index.php'>Voltar</button>
        </span>
      </div>
  </div>
  </form>
  <hr>
  </div>";

                    ?>

                  </body>

                  </html>
              <?php
                  break;


                default:
                  header("Location:crud.php?acao=selecionar");
                  break;
              }
