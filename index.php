<!doctype html>
<html lang="en">
  <head>
    <title>SGTA | Autenticação</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" type="image/png" href="../img/global/favicon.ico"/>
    <!-- Bootstrap CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">

	<!-- Font Awesome -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <!-- User Defined CSS -->
    <link rel="stylesheet" href="css/login.css" />
  </head>
  <body class="text-center">
    <div class="form-signin">
      
      <div class="card">
      <div class="login-logo">
        <img src="img/logo.jpg"  /> 
        <h3>Sistema de Gerenciamento de Turma e Alunos</h3>
         
      </div>
        <div class="card-body login-card-body">
          <p class="login-box-msg">Autenticação do utilizador</p>
          <form class="user">
            <div class="input-group mb-4">
              <input id="username_login" type="text" class="form-control" placeholder="Nome de utilizador">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-user"></span>
                </div>
              </div>
            </div>
            <div class="input-group mb-4">
              <input id="password_login" type="password" class="form-control" placeholder="Palavra passe">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-lock"></span>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-12 " style="text-align:right;margin:5px;">
                <a href="javascript:recoverShow()" >Esqueceu sua palavra passe? </a>
              </div>
              <!-- /.col -->
              <div class="col-5">
                <a href="javascript:login()" class="btn btn-success btn-user btn-block" tabindex="3">Autenticar</a>
              </div>
              <!-- /.col -->
            </div>
            <hr />
            <div id="login_state" class="d-flex justify-content-center" role="alert">
            </div>
          </form>
        </div>
        <div class="card-body recover-card-body" style="display:none;">
          <p class="login-box-msg">Recuperação de Conta</p>
          <form class="user">
            <div class="input-group mb-4">
              <input id="username_login" type="text" class="form-control" placeholder="Email de recuperação">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-envelope"></span>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-12 " style="text-align:right;margin:5px;">
                <a  href="javascript:loginShow()" >Autenticação</a>
              </div>
              <!-- /.col -->
              <div class="col-5">
                <a href="#" class="btn btn-success btn-user btn-block" tabindex="3">Recuperar</a>
              </div>
              <!-- /.col -->
            </div>
            <hr />
            <div id="recover_state" class="d-flex justify-content-center" role="alert">
            </div>
          </form>
        </div>
     
      </div>
      
     
        
     
      <?php
        require_once("cmp/footer.php");
      ?>
    </div>
        
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <!---  script src="https://code.jquery.com/jquery-3.5.1.min.js"></script -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <!-- script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script-->
	<script rel="stylesheet" href="plugins/bootstrap/js/bootstrap.js"> </script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- User Defined    JavaScript -->
    <script src="js/login.js"></script>
  </body>
</html>