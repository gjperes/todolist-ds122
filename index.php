<?php
require 'src/lib/sanitize.php';
require 'src/db/db_credentials.php';

$conn = mysqli_connect($servername,$username,$password,$dbname);
if (!$conn) {
  die("Problemas ao conectar com o BD!<br>".
       mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_POST["nova-tarefa"])) {

    $titulo = sanitize($_POST["nova-tarefa"]);
    $titulo = mysqli_real_escape_string($conn, $titulo);
    $data_criado = date("Y-m-d H:i:s");

    $sql = "INSERT INTO $table (titulo,data_criado)
            VALUES ('$titulo', '$data_criado')";

    if(!mysqli_query($conn,$sql)){
      die("Problemas para inserir nova tarefa no BD!<br>".
           mysqli_error($conn));
    }
  }
  elseif(isset($_POST["novo-titulo-tarefa"]) && isset($_POST["id"])){

    $novo_titulo = sanitize($_POST["novo-titulo-tarefa"]);
    $id = sanitize($_POST["id"]);

    $sql = "UPDATE $table
            SET titulo='". mysqli_real_escape_string($conn, $novo_titulo) .
            "' WHERE id=" . mysqli_real_escape_string($conn, $id);

    if(!mysqli_query($conn,$sql)){
      die("Problemas para executar ação no BD!<br>".
           mysqli_error($conn));
    }
  }
}

elseif ($_SERVER["REQUEST_METHOD"] == "GET") {
  if (isset($_GET["acao"]) && isset($_GET["id"])) {
    $sql = "";

    $id = sanitize($_GET['id']);
    $id = mysqli_real_escape_string($conn, $id);

    if($_GET["acao"] == "feito"){
      $sql = "UPDATE $table
              SET feito=true
              WHERE id=" . $id;
    }
    elseif($_GET["acao"] == "desfeito"){
      $sql = "UPDATE $table
              SET feito=false
              WHERE id=" . $id;
    }
    elseif($_GET["acao"] == "remover"){
      $sql = "DELETE FROM $table
              WHERE id=" . $id;
    }

    if ($sql != "") {
      if(!mysqli_query($conn,$sql)){
        die("Problemas para executar ação no BD!<br>".
             mysqli_error($conn));
      }
    }
  }
}

$sql = "SELECT id,titulo FROM $table WHERE feito = false";
if(!($tarefas_pendentes_set = mysqli_query($conn,$sql))){
  die("Problemas para carregar tarefas do BD!<br>".
       mysqli_error($conn));
}

$sql = "SELECT id,titulo FROM $table WHERE feito = true";
if(!($tarefas_concluidas_set = mysqli_query($conn,$sql))){
  die("Problemas para carregar tarefas do BD!<br>".
       mysqli_error($conn));
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">

    <title>myTasks</title>
    <meta name="description" content="myTasks - A sua lista de tarefas online!">
    <link rel="shortcut icon" href="images/journal-check.svg" type="image/x-icon">
    
    <!--O estilo criado pelo myTasks original (autor: prof. Alex), PRECISA desses links-->
    <link rel="stylesheet" href="style/bootstrap.css">
    <link rel="stylesheet" href="style/index_page.css">

    <!--Assim como dos imports acima, usa as seguintes bibliotecas -->
    <script src="src/lib/js/jquery-3.2.1.min.js"></script>
    <script src="src/lib/js/bootstrap.js"></script>

    <!--Script para o alerta confirmando deleção de uma tarefa -->
    <script>
      $(function(){
        $(".btn-remove-tarefa").on("click",function(){
          return confirm("Você tem certeza que deseja remover essa tarefa?");
        });
      })
    </script>

</head>

<body style="background-color: white;">
  
  <nav class="navbar navbar-inverse">
    <div class="container-fluid">

      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
          <span class="sr-only">Habilitar barra lateral</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="#">Início</a>
      </div>

      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav navbar-right">
        <li class="active"><a href="<?php ?>">Login<span class="sr-only">(selecionado)</span></a></li>
        <li><a href="<?php ?>">Cadastre-se</a></li>
      </ul>

      
    </div>
  </nav>

<!-- <?php // if($login): ?> TODO MAIS IMPORTANTE -> Essa parte precisa ser implementada para validar e só permitir o acesso por usuários logados -->
  <div class="container">
    <div class="row">
      <div class="col-xs-offset-3 col-xs-6">
        <header>
          <h1 class="page-header">
            <img class="mb-4" src="images/journal-check.svg" alt="Logo do myTasks" width="48" height="48">
            myTasks
          </h1>
        </header>

        <form action="<?php echo $_SERVER["PHP_SELF"] ?>" method="POST">
          <div class="form-group">
            <label class="sr-only" for="inputTarefa">Inserir nova tarefa</label>
            <input required type="text" name="nova-tarefa" class="form-control" id="inputTarefa" placeholder="Inserir nova tarefa">
          </div>
        </form>

        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title">
              <span class="glyphicon glyphicon-list"></span>
              Tarefas pendentes
            </h3>
          </div>
          <div class="panel-body">

            <?php if(mysqli_num_rows($tarefas_pendentes_set) > 0): ?>
              <?php while($tarefa = mysqli_fetch_assoc($tarefas_pendentes_set)): ?>
                <!-- INICIO TAREFA PENDENTE  -->
                <div class="alert alert-info" role="alert">
                  <span class="tarefa">
                    <span class="glyphicon glyphicon-chevron-right"></span>
                    <?php echo $tarefa["titulo"] ?>
                  </span>
                  <div class="pull-right">
                    <a href="<?php echo $_SERVER["PHP_SELF"] . "?id=" . $tarefa["id"] . "&" . "acao=feito" ?>">
                      <button aria-label="Feito" class="btn btn-sm btn-success" type="button">
                        <span class="glyphicon glyphicon-ok"></span> Feito!
                      </button>
                    </a>

                    <a href="edita_tarefa.php?id=<?php echo $tarefa["id"]; ?>">
                      <button aria-label="Editar" class="btn btn-sm btn-info" type="button">
                        <span class="glyphicon glyphicon-edit"></span>
                      </button>
                    </a>

                    <a class="btn-remove-tarefa" href="<?php echo $_SERVER["PHP_SELF"] . "?id=" . $tarefa["id"] . "&" . "acao=remover" ?>">
                      <button aria-label="Remover" class="btn btn-sm btn-danger" type="button">
                        <span class="glyphicon glyphicon-trash"></span>
                      </button>
                    </a>

                  </div>
                </div>
                <!-- FIM TAREFA PENDENTE -->
              <?php endwhile; ?>
            <?php else: ?>
              Não há nenhuma tarefa pendente
            <?php endif; ?>
          </div>
        </div>

        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title">
              <span class="glyphicon glyphicon-ok"></span>
              Tarefas concluídas
            </h3>
          </div>
          <div class="panel-body">
            <?php if(mysqli_num_rows($tarefas_concluidas_set) > 0): ?>
              <?php while($tarefa = mysqli_fetch_assoc($tarefas_concluidas_set)): ?>
                <!-- INICIO TAREFA CONCLUIDA -->
                <div class="alert alert-success" role="alert">
                  <span class="tarefa">
                    <span class="glyphicon glyphicon-chevron-right"></span>
                    <?php echo $tarefa["titulo"] ?>
                  </span>
                  <div class="pull-right">
                    <a href="<?php echo $_SERVER["PHP_SELF"] . "?id=" . $tarefa["id"] . "&" . "acao=desfeito" ?>">
                      <button aria-label="Desfazer" class="btn btn-sm btn-warning" type="button">
                        <span class="glyphicon glyphicon-remove"></span> Desfazer
                      </button>
                    </a>
                  </div>
                </div>
                <!-- FIM TAREFA CONCLUIDA -->
              <?php endwhile; ?>
            <?php else: ?>
              Nenhuma tarefa concluída! :(
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- <?php //else: ?> Se não estiver logado, faça: -->
    <!-- Você precisa estar <a href="#">logado</a> para acessar o myTasks! Faça já o seu <a href="#">Cadastro</a> -->
  <?php //endif; ?>

<footer class="mt-5 mb-3 text-muted text-center">
  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-code" viewBox="0 0 16 16">
    <path d="M14 4.5V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h5.5L14 4.5zm-3 0A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4.5h-2z"/>
    <path d="M8.646 6.646a.5.5 0 0 1 .708 0l2 2a.5.5 0 0 1 0 .708l-2 2a.5.5 0 0 1-.708-.708L10.293 9 8.646 7.354a.5.5 0 0 1 0-.708zm-1.292 0a.5.5 0 0 0-.708 0l-2 2a.5.5 0 0 0 0 .708l2 2a.5.5 0 0 0 .708-.708L5.707 9l1.647-1.646a.5.5 0 0 0 0-.708z"/>
  </svg>
  Atividade Final DS122 - 2021
</footer>

</body>
</html>
