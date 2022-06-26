<?php
    require_once("cmp/session.php");
?>
<!doctype html>
<html lang="en">
  <head>
    <?php
      require_once("cmp/head.php");
    ?>
    <title>SGTA | Main</title>
  </head>
  <body>
    
  <?php require_once("cmp/menu.php");?>
  
    <div class="container">
      <div class="card-deck mb-3 text-left">
        <div class="card mb-4 box-shadow">
          <div class="card-header">
            <h4 class="my-0 font-weight-normal">Bem-vindo</h4>
          </div>
          <div class="card-body">
            <p class="card-title">Bem-vindo ao Sistema Gerenciamento de Turmas e Alunos.</p>
          </div>
        </div>
      </div>
      <?php
        require_once("cmp/footer.php");
      ?>
    </div>
    <?php
      require_once("cmp/script.php");
    ?>
  </body>
</html>
