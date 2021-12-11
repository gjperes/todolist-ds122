<!DOCTYPE html>
<html lang="pt-BR">

<!-----------------------------head------------------------------->
<head>    
    <link rel="shortcut icon" href="images/journal-check.svg" type="image/x-icon">
    
    <!--Bootstrap CDN-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    
    <!--Bootstrap 5 Sign-in Free Theme-->
    <link rel="stylesheet" href="style/login.css">
</head>
<!-------------------------head termino--------------------------->

<!-----------------------------body------------------------------->

<body class="text-center gradient">

  <div id="form" class="form-signin">
    <!---cabeçalho---->
    <header>
      <h1 class="h2 mb-3 fw-normal">
        Criação de Conta
      </h1>
    </header>
    <!---cabeçalho termino---->

    <!-----------registro------------------------------>
    <main>
      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="form-signin" enctype="multipart/form-data">
        
        
        <!-----------Nome------------->
        <fieldset class="form-floating">
          
            <input required type="text" class="form-control" id="nome-input" placeholder="Digite o seu nome">

            <label for="nome-input">Nome</label>

            <!--mensagem/alerta de erro da validação front-end-->
            <div id="erro-nome"></div> 

        </fieldset>
        <!------Nome termino------------->

        <!-----------email------------->
        <fieldset class="form-floating">
          
            <input required type="email" class="form-control" id="email-input" placeholder="nome@exemplo.com">

            <label for="email-input">Email</label>

            <!--mensagem/alerta de erro da validação front-end-->
            <div id="erro-email"></div> 

        </fieldset>
        <!------email termino------------->

        <!---------password--------------->
        <fieldset class="form-floating">

          <input required type="password" class="form-control" id="senha-input" placeholder="Sua senha">

          <label for="senha-input">Senha</label>

          <!--mensagem/alerta de erro da validação front-end-->
          <div id="erro-senha"></div>

        </fieldset>
        <!---------password termino-------------->

        <!---------password confirmation(confirme-senha)------>
        <fieldset class="form-floating">

          <input required type="password" class="form-control" id="confirme-senha-input" placeholder="Confirme a sua senha">

          <label for="confirme-senha-input">Confirme a senha</label>

          <!--mensagem/alerta de erro da validação front-end-->
          <div id="erro-confirme-senha"></div>

        </fieldset>
        <!---------password confirmation-------------->

        <button class="w-100 btn btn-lg btn-primary" type="submit">Criar conta</button>
      </form>
      <!-----------registro termino------------------------------>

    </main>
  </div>
  <!--jQuery e JavaScript !-->
  <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
  <script src="src/lib/js/login_validation.js"></script>
</body>
</html>