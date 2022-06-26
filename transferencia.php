<?php
	require_once("cmp/session.php");
?>
<!doctype html>
<html lang="en">
  <head>
    <?php
      require_once("cmp/head.php");
    ?>
    <title>SGTA | Transferência</title>
    <!-- summernote -->
    <link rel="stylesheet" href="plugins/summernote/summernote-bs4.css">
  </head>
 
  <body>
   
  <?php require_once("cmp/menu.php");?>
  
    <div class="container">
      <div class="card-deck mb-3 text-left">
        <div class="card mb-4 box-shadow">
          <div class="card-header">
            <h4 class="my-0 font-weight-normal">Transferência</h4>
          </div>
          <div class="card-body">
            
            <hr />
            <div style="overflow-x:auto">
              <table id="dataTable" class="table table-striped table-bordered table-hover display">
                  <thead>
                      <tr>
                        <th>Aluno</th>
                        <th>Turma Anterior</th>
                        <th>Turma Destino</th>
                        <th>Data</th>
                        <th>Motivo</th>
                        <th><div class='span12' style='text-align:center'>Alterar</div></th>
                        <th><div class='span12' style='text-align:center'>Eliminar</div></th>
                      </tr>
          
                  </thead>
                  <tbody></tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <?php
        require_once("cmp/footer.php");
		     
		require_once("cmp/modal_transferencia.php");

      ?>
    </div>
    <?php
      require_once("cmp/script.php");
    ?>
    <!-- Summernote -->
    <script src="plugins/summernote/summernote-bs4.min.js"></script>
    <script src="js/summernote-config.js"></script>
    <script src="js/transferencia.js"></script>
  </body>
</html>
