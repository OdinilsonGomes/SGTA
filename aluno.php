<?php
	require_once("cmp/session.php");
?>
<!doctype html>
<html lang="en">
  <head>
    <?php
      require_once("cmp/head.php");
    ?>
    <title>SGTA | Aluno</title>
    <!-- summernote -->
    <link rel="stylesheet" href="plugins/summernote/summernote-bs4.css">
  </head>
 
  <body>
   
  <?php require_once("cmp/menu.php");?>
  
    <div class="container">
      <div class="card-deck mb-3 text-left">
        <div class="card mb-4 box-shadow">
          <div class="card-header">
            <h4 class="my-0 font-weight-normal">Aluno</h4>
          </div>
          <div class="card-body">
            <a class="btn btn-success" href="#" data-toggle="modal" data-target="#insert_modal">
                <i class="fa fa-plus fa-sm fa-fw mr-2 text-gray-400"></i>
                Novo
            </a>
            <hr />
            <div style="overflow-x:auto">
                <table id="dataTable" class="table table-striped table-bordered table-hover display">
                    <thead>
                        <tr>
                          <th>Nome</th>
                          <th>Data Nascimento</th>
                          <th>Email</th>
                          <th>Turma</th>
                          <th><div class='span12' style='text-align:center'>Transferir</div></th>
                          <th><div class='span12' style='text-align:center'>Alterar</div></th>
                          <th><div class='span12' style='text-align:center'>Eliminar</div></th>
                        </tr>
                          
                    </thead>
                    <tbody id="dataTableBody"></tbody>
                </table>
            </div>
          </div>
        </div>
      </div>
      <?php
        require_once("cmp/footer.php");
		
        require_once("cmp/modal_aluno.php");
        require_once("cmp/modal_transferencia.php");
        
		
      ?>
    </div>
    <?php
      require_once("cmp/script.php");
    ?>

    <script src="js/aluno.js"></script>
  </body>
</html>
