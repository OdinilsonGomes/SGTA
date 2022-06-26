<?php
    // Import the neeeded class
    require_once('../api/api_utilizador.php');
    require_once('../api/api_turma.php');
    require_once('../api/api_aluno.php');
    require_once('../api/api_transferencia.php');
	
  


    // Inicia seção
    session_start();

    // verifica se seção está aberta
    if(isset($_SESSION['views']))
    {
        $UtilizadorAPI = new UtilizadorAPI();
        $TurmaAPI = new TurmaAPI();
        $AlunoAPI = new AlunoAPI();
        $TransferenciaAPI = new TransferenciaAPI();
		
        /**********************/
        
        // Fazer Login
        if($_GET["action"] == 'logIn')
        {
            $data = $UtilizadorAPI->logIn();
            $data = $data[0];
        }
        /* Fazer LogOut*/
        else if($_GET["action"] == 'logOut')
        {
            $data = $UtilizadorAPI->logOut();
            $data = $data[0];
        }
		// Listagem de todo utilizador
        else if($_GET["action"] == 'fetchAllUser')
        {
            $data = $UtilizadorAPI->fetchAllUser();
            
        }
        // Inserir utilizador
        else if($_GET["action"] == 'insertUser')
        {
            $data = $UtilizadorAPI->insertUser();
            $data = $data[0];
        }
        // Alterar utilizador
        else if($_GET["action"] == 'updateUser')
        {
            $data = $UtilizadorAPI->updateUser();
            $data = $data[0];
        }
        // Eliminar utilizador
        else if($_GET["action"] == 'removeUser')
        {
            $data = $UtilizadorAPI->removeUser();
            $data = $data[0];
        }
        
        /* Fim utilizador */

        /*************************/
		/******** Inicio Turma *********/
          //  Listagem de todas as turmas
        else if($_GET["action"] == 'fetchAllTurma')
        {
           $data = $TurmaAPI->fetchAllTurma();
        }
		else if($_GET["action"] == 'fetchAllTurmaByNome')
        {
           $data = $TurmaAPI->fetchAllTurmaByNome();
        }
		else if($_GET["action"] == 'fetchAllTurmaById')
        {
           $data = $TurmaAPI->fetchAllTurmaById();
        }
		else if($_GET["action"] == 'fetchAllTurmaBySerie')
        {
           $data = $TurmaAPI->fetchAllTurmaBySerie();
        }
		else if($_GET["action"] == 'fetchAllTurmaToSelect')
        {
           $data = $TurmaAPI->fetchAllTurmaToSelect();
        }
        else if($_GET["action"] == 'insertTurma')
        {
			$data = $TurmaAPI->insertTurma();
			$data = $data[0];
        } 
        else if($_GET["action"] == 'updateTurma')
        {
            $data = $TurmaAPI->updateTurma();
            $data = $data[0];
        }
        else if($_GET["action"] == 'removeTurma')
        {
            $data = $TurmaAPI->removeTurma();
            $data = $data[0];
        }
		/* Fim Turma  */
		
		/*************************/
		/* ****  Aluno **********/
        
        else if($_GET["action"] == 'fetchAllAluno')
        {
            $data = $AlunoAPI->fetchAllAluno();
        }
		else if($_GET["action"] == 'fetchAllAlunoByTurma')
        {
            $data = $AlunoAPI->fetchAllAlunoByTurma();
        }
		else if($_GET["action"] == 'fetchAlunoByNome')
        {
            $data = $AlunoAPI->fetchAlunoByNome();
        }
        else if($_GET["action"] == 'insertAluno')
        {
            $data = $AlunoAPI->insertAluno();
            $data = $data[0];
        }
        else if($_GET["action"] == 'updateAluno')
        {
            $data = $AlunoAPI->updateAluno();
            $data = $data[0];
        }
        else if($_GET["action"] == 'removeAluno')
        {
            $data = $AlunoAPI->removeAluno();
            $data = $data[0];
        }
		/* Fim Aluno */
		
		/*************************/
		/* ****  Tranferencia **********/

        else if($_GET["action"] == 'fetchAllTransferencia')
        {
            $data = $TransferenciaAPI->fetchAllTransferencia();
        }
        else if($_GET["action"] == 'insertTransferancia')
        {
            $data = $TransferenciaAPI->insertTransferancia();
            $data = $data[0];
        }
        else if($_GET["action"] == 'updateTransferencia')
        {
            $data = $TransferenciaAPI->updateTransferencia();
            $data = $data[0];
        }
        else if($_GET["action"] == 'removeTransferencia')
        {
            $data = $TransferenciaAPI->removeTransferencia();
            $data = $data[0];
        }
        /* Fim Tranferencia */

        // API não encontrada
        else
        {
            $data = array('result' => 'Serviço não encontrado. Nenhuma acção realizada!');
        }

    }
    else
    {
        // Cria objecto utilidador para API
        $UtilizadorAPI = new UtilizadorAPI();

        /**********************/
        
        // Login
        if($_GET["action"] == 'logIn')
        {
            $data = $UtilizadorAPI->logIn();
            $data = $data[0];
        }
        // Recuperar senha
        else if($_GET["action"] == 'recoverPassword')
        {
            $data = $UtilizadorAPI->recoverPassword();
            $data = $data[0];
        }
        // 
        else
        {
            $data = array('result' => 'Requer sessão aberta!');
        }
    }
    // Convert data[] to json
    echo json_encode($data);
?>