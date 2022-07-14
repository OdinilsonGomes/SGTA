<?php 
  $menu_main       = "";
  $menu_turma      = "";
  $menu_aluno       = "";
  $menu_transferencia   = "";
  $menu_utilizador = "";
  $pagina = isset($_REQUEST['url'])? $_REQUEST['url'] : 'main';
  switch($pagina) {
    case "main":$menu_main="active";
    break;
    case "turma":$menu_turma="active";
    break;
    case "aluno":$menu_aluno="active";
    break;
	case "transferencia":$menu_transferencia="active";
    break;
    case "utilizador":$menu_utilizador="active";
    break;
  }
?>
<div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom box-shadow">
    <img src="img/logo.jpg" width="100" /><h5 class="my-0 mr-md-auto font-weight-normal">Sistema de Gestão de Turmas e Alunos</h5>
      <nav class="my-2 my-md-0 mr-md-3">
        <ul class="nav nav-pills">
          <li class="nav-item">
            <a class="nav-link <?php echo $menu_main ?>" href="main">Inicio</a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?php echo $menu_turma ?>" href="turma">Turma</a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?php echo $menu_aluno ?>" href="aluno">Aluno</a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?php echo $menu_transferencia ?>" href="transferencia">Transferencia</a>
          </li>
          <li class="nav-item">
              <a href="#" class="nav-link" data-toggle="modal" data-target="#logout_modal">
                  <i class="fas fa-sign-out-alt mr-2"></i> Sair
              </a>
          </li>
         
          
          
        </ul>
      </nav>
    </div>
    