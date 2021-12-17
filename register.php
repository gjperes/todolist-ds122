<?php
require "src\db\db_funcoes.php";

$error = false;
$success = false;
$name = $email = $password = $confirmPassword = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_POST["name"]) && isset($_POST["email"]) && isset($_POST["password"]) && isset($_POST["confirmPassword"])) {

    $conn = connect_db();

    $name = mysqli_real_escape_string($conn, $_POST["name"]);
    $email = mysqli_real_escape_string($conn, $_POST["email"]);
    $password = mysqli_real_escape_string($conn, $_POST["password"]);
    $confirmPassword = mysqli_real_escape_string($conn, $_POST["confirmPassword"]);

    if ($password == $confirmPassword) {
      $password = md5($password);

      $sql = "INSERT INTO $tabela_user 
              (nomeUser, emailUser, senhaUser) VALUES
              ('$name', '$email', '$password');";

      if (mysqli_query($conn, $sql)) {
        $success = true;
      } else {
        $error_msg = mysqli_error($conn);
        $error = true;
      }
    } else {
      $error_msg = "Senha não confere com a confirmação.";
      $error = true;
    }
  } else {
    $error_msg = "Por favor, preencha todos os dados.";
    $error = true;
  }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<!-----------------------------head------------------------------->

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta charset="UTF-8">

  <title>Cadastro - myTasks</title>
  <meta name="description" content="To Do Online List - A sua lista online!">
  <link rel="shortcut icon" href="images/journal-check.svg" type="image/x-icon">

  <!--Bootstrap CDN-->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

  <!--Bootstrap 5 Sign-in Free Theme-->
  <link rel="stylesheet" href="style/login-register.css">
</head>
<!-------------------------head termino--------------------------->

<!-----------------------------body------------------------------->

<body class="text-center gradient">

  <div id="form-checkbox" class="form-signin">
    <!---cabeçalho---->
    <header>
      <img class="mb-4" src="images/person-badge.svg" alt="Imagem de login" width="72" height="56">
      <h1 class="h3 mb-3 fw-normal">
        myTasks - Cadastro
      </h1>
    </header>
    <!---cabeçalho termino---->

    <!-----------registro------------------------------>
    <main>
      <?php if ($success) : ?>
        <h3 style="color:lightgreen;">Usuário criado com sucesso!</h3>
        <p>
          Seguir para <a href="login.php">login</a>.
        </p>
      <?php endif; ?>

      <?php if ($error) : ?>
        <h3 style="color:red;"><?php echo $error_msg; ?></h3>
      <?php endif; ?>
      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="form-signin" enctype="multipart/form-data" id="form-register">

        <!-----------Nome------------->
        <fieldset class="form-floating">

          <input required type="text" class="form-control" name="name" placeholder="Digite o seu nome" value="">
          <label for="nome-input">Nome</label>

          <!--mensagem/alerta de erro da validação front-end-->
          <div id="erro-nome" class="alerta-erro"></div>

        </fieldset>
        <!------Nome termino------------->

        <!-----------email------------->
        <fieldset class="form-floating">

          <input required type="email" class="form-control" name="email" placeholder="nome@exemplo.com" value="">
          <label for="email-input">Email</label>

          <!--mensagem/alerta de erro da validação front-end-->
          <div id="erro-email" class="alerta-erro"></div>

        </fieldset>
        <!------email termino------------->

        <!---------password--------------->
        <fieldset class="form-floating">

          <input required type="password" class="form-control" name="password" placeholder="Sua senha" value="">
          <label for="senha-input">Senha</label>

          <!--mensagem/alerta de erro da validação front-end-->
          <div id="erro-senha" class="alerta-erro"></div>

        </fieldset>
        <!---------password termino-------------->

        <!---------password confirmation(confirme-senha)------>
        <fieldset class="form-floating">

          <input required type="password" class="form-control" name="confirmPassword" placeholder="Confirme a sua senha" value="">
          <label for="confirme-senha-input">Confirme a senha</label>

          <!--mensagem/alerta de erro da validação front-end-->
          <div id="erro-confirme-senha" class="alerta-erro"></div>

        </fieldset>
        <!---------password confirmation-------------->

        <button class="w-100 btn btn-lg btn-primary" type="submit">Criar conta</button>

      </form>
      <!-----------registro termino------------------------------>
      <footer class="mt-5 mb-3 text-muted">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-code" viewBox="0 0 16 16">
          <path d="M14 4.5V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h5.5L14 4.5zm-3 0A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4.5h-2z" />
          <path d="M8.646 6.646a.5.5 0 0 1 .708 0l2 2a.5.5 0 0 1 0 .708l-2 2a.5.5 0 0 1-.708-.708L10.293 9 8.646 7.354a.5.5 0 0 1 0-.708zm-1.292 0a.5.5 0 0 0-.708 0l-2 2a.5.5 0 0 0 0 .708l2 2a.5.5 0 0 0 .708-.708L5.707 9l1.647-1.646a.5.5 0 0 0 0-.708z" />
        </svg>
        Atividade Final DS122 - 2021
      </footer>

    </main>
  </div>
  <!--jQuery e JavaScript !-->
  <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
  <script src="./src/lib/js/register_validation.js"></script>
</body>

</html>