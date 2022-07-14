<?php
	require_once("cmp/session.php");
?>
<!doctype html>
<html lang="en">
  <head>
    <?php
      require_once("cmp/head.php");
    ?>
    <title>SGTA | Turma</title>
    <!-- summernote -->
    <link rel="stylesheet" href="plugins/summernote/summernote-bs4.css">
  </head>
 
  <body>
   
  <?php require_once("cmp/menu.php");?>
  
    <div class="container">
      <div class="card-deck mb-3 text-left">
        <div class="card mb-4 box-shadow">
          <div class="card-header">
            <h4 class="my-0 font-weight-normal">Turma</h4>
          </div>
          <div class="card-body">
            <a class="btn btn-success" href="#" data-toggle="modal" data-target="#insert_modal">
                <i class="fa fa-plus fa-sm fa-fw mr-2 text-gray-400"></i>
                Nova
            </a>
            <hr />
            <div style="overflow-x:auto">
              <table id="dataTable" class="table table-striped table-bordered table-hover display">
                  <thead>
                      <tr>
                        <th>Nome</th>
                        <th>Serie</th>
                        <th><div class='span12' style='text-align:center'>Ver Alunos</div></th>
                        <th><div class='span12' style='text-align:center'>Alterar</div></th>
                        <th><div class='span12' style='text-align:center'>Eliminar</div></th>
                      </tr>
                      <tr>
                        <th><input id="nome_turma_filtro" onkeyUp="fetchAllTurmaByNome()" type="text" class="form-control " placeholder="Filtrar por nome"/></th>
                        <th><input id="serie_turma_filtro" onkeyUp="fetchAllTurmaBySerie()" type="text" class="form-control " placeholder="Filtrar por serie"/></th>
                        <th colspan="3"><div class='span12' style='text-align:center'></div></th>
                      </tr>
                  </thead>
                  <tbody id="dataTableBody">
                    
                  </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <?php
        require_once("cmp/footer.php");
        require_once("cmp/modal_turma.php");
      ?>
    </div>
    <?php
      require_once("cmp/script.php");
    ?>

    <script src="js/turma.js"></script>
  </body>
</html>
