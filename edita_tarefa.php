<?php
require 'src/lib/sanitize.php';
require 'src/db/db_credentials.php';

$conn = mysqli_connect($servername,$username,$db_password,$dbname);
if (!$conn) {
  die("Problemas ao conectar com o BD!<br>".
       mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
  if (isset($_GET["id"])) {

    $id = sanitize($_GET['id']);
    $id = mysqli_real_escape_string($conn, $id);

    $sql = "SELECT id,titulo FROM $tarefas WHERE id = ". $id;

    if(!($tarefa = mysqli_query($conn,$sql))){
      die("Problemas para carregar tarefas do BD!<br>".
           mysqli_error($conn));
    }
  }
}

mysqli_close($conn);

if (mysqli_num_rows($tarefa) != 1) {
  die("Id de tarefa incorreto.");
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">

    <title>Editar Tarefa - myTasks</title>
    <meta name="description" content="myTasks - A sua lista de tarefas online!">
    <link rel="shortcut icon" href="images/journal-check.svg" type="image/x-icon">
    
    <!--O estilo criado pelo myTasks original (autor: prof. Alex), PRECISA desses links-->
    <link rel="stylesheet" href="style/bootstrap.css">
    <link rel="stylesheet" href="style/index_page.css">

    <!--Assim como dos imports acima, usa as seguintes bibliotecas -->
    <script src="src/lib/js/jquery-3.2.1.min.js"></script>
    <script src="src/lib/js/bootstrap.js"></script>

</head>

<body>

<div class="container">
  <div class="row">
    <div class="col-xs-offset-3 col-xs-6">

      <h1 class="page-header">
        <img class="mb-4" src="images/journal-check.svg" alt="Logo do myTasks" width="48" height="48">
        myTasks - Edite a tarefa
      </h1>

      <form action="index.php" method="POST">
        <div class="form-group">
          <?php $tarefa = mysqli_fetch_assoc($tarefa); ?>
          <input type="hidden" name="id" value="<?php echo $tarefa["id"] ?>">
          <label class="sr-only" for="inputTarefa">Editar tarefa</label>
          <!-- <input required type="text" name="novo-titulo-tarefa" class="form-control" id="inputTarefa" value="<?php echo $tarefa["titulo"] ?>"> -->
          <input required type="text" name="novo-titulo-tarefa" class="form-control" id="inputTarefa" placeholder="Editando: '<?php echo $tarefa["titulo"] ?>'")">
          <legend id="edit-help">Pressione <kbd>Enter</kbd> para confirmar</legend>
        </div>
      </form>

    </div>
  </div>
</div>

<footer class="mt-5 mb-3 text-muted text-center">
  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-code" viewBox="0 0 16 16">
    <path d="M14 4.5V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h5.5L14 4.5zm-3 0A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4.5h-2z"/>
    <path d="M8.646 6.646a.5.5 0 0 1 .708 0l2 2a.5.5 0 0 1 0 .708l-2 2a.5.5 0 0 1-.708-.708L10.293 9 8.646 7.354a.5.5 0 0 1 0-.708zm-1.292 0a.5.5 0 0 0-.708 0l-2 2a.5.5 0 0 0 0 .708l2 2a.5.5 0 0 0 .708-.708L5.707 9l1.647-1.646a.5.5 0 0 0 0-.708z"/>
  </svg>
  Atividade Final DS122 - 2021
</footer>

</body>
</html>
