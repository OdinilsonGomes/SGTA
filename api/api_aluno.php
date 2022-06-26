<?php
    // Import the needed classes
    require_once("mysql_pdo.php");
    require_once("classes/aluno.php");
	
    // API da classe aluno
    class AlunoAPI
    {
        /* Caregando todos os alunos da escola */
        function fetchAllAluno()
        {
            try 
            {
                // Selecionando todos alunos
                $query = "SELECT * FROM vista_aluno order by nome";
                // Criando objecto para conexão em PDO
                $mysqlPDO = new MySQLPDO();
                // Preparando a query
                $statement = $mysqlPDO->getConnection()->prepare($query);
                // Executando a query sem parametro
                $statement->execute();
                // caregando resultado 
                $rows = $statement->fetchAll();
                // Atribuindo resultado
                foreach ($rows as $row) 
                {
                    // Criação do objecto Aluno
                    $aluno = new Aluno($row);
                    
                    $tmp_data[] = array
                    (
                        $aluno->getNome(),
                        $aluno->getDataNasc(),
                        $aluno->getEmail(),
                        $aluno->getTurma(),
                        "<div class='span12' style='text-align:center'><a href='javascript:transferir(".$aluno->getId().")' class='btn btn-warning btn-sm'>Transferir</a></div>",
                        "<div class='span12' style='text-align:center'><a href='javascript:update(".json_encode($aluno).")' class='btn btn-info'><i class='fas fa-edit'></i></a></div>",
                        "<div class='span12' style='text-align:center'><a href='javascript:remove(".$aluno->getId().")' class='btn btn-danger'><i class='far fa-trash-alt'></i></a></div>"
                    );  
                }
                // Convertendo para capturação em JSON
                if(isset($tmp_data) && count($tmp_data) > 0)
                {
                    $data = array
                    (
                        "data" => $tmp_data
                    );
                }
                else
                {
                    $data = array
                    (
                        "data" => array()
                    );
                }
                return $data;
            }
            catch (PDOException $e) 
            {
                die("Mensagem de erro: " . $e->getMessage());
            }
        }
        // Pesquisar alunos pela turma
		function fetchAllAlunoByTurma()
        {
            try 
            {
				if(isset($_POST['id_turma'])){
					$form_data = array(
							':id_turma'    => $_POST["id_turma"]
						);
					// Selecionando todos alunos
					$query = "SELECT * FROM vista_aluno where id_turma=:id_turma order by nome";
					// Criando objecto para conexão em PDO
                    $mysqlPDO = new MySQLPDO();
                    // Preparando a query
                    $statement = $mysqlPDO->getConnection()->prepare($query);
                    // Executando a query 
                    $statement->execute($form_data);
                    // caregando resultado 
                    $rows = $statement->fetchAll();
                    // Atribuindo resultado
					foreach ($rows as $row) 
					{
						// Criação do objecto Aluno
						$aluno = new Aluno($row);
						
						$tmp_data[] = array
						(
							$aluno->getNome(),
							$aluno->getDataNasc(),
							$aluno->getEmail(),
							$aluno->getTurma()
						);  
					}
					// Convertendo para capturação em JSON
					if(isset($tmp_data) && count($tmp_data) > 0)
					{
						$data = array
						(
							"data" => $tmp_data
						);
					}
					else
					{
						$data = array
						(
							"data" => array()
						);
					}
				}else{
					
					$data[] = array('result' => 'Paramêtro ID em falta!');
				}
                return $data;
            }
            catch (PDOException $e) 
            {
                die("Mensagem de erro: " . $e->getMessage());
            }
        }

        // Pesquisar aluno por nome e ou por turma
		function fetchAlunoByNome()
        {
            try 
            { 
				if(isset($_POST['nome'])){
					$form_data = array(
							':nome'    	   => '%'.$_POST["nome"].'%',
							':id_turma'    => isset($_POST['id_turma'])? $_POST['id_turma'] : "",
							
						);
					// Caso for enviado a turma de pesquisa
					if(isset($_POST['id_turma']))
						$query = "SELECT * FROM vista_aluno where id_turma = :id_turma and nome like :nome";
					else
						$query = "SELECT * FROM vista_aluno where nome like :nome :id_turma";
					// Criando objecto para conexão em PDO
					$mysqlPDO = new MySQLPDO();
					// Preparando a query
					$statement = $mysqlPDO->getConnection()->prepare($query);
					// Executando a query
					$statement->execute($form_data);
					// caregando resultado
					$rows = $statement->fetchAll();
					// Atribuindo resultado
					foreach ($rows as $row) 
					{
						// Criação do objecto Aluno
						$aluno = new Aluno($row);
						
						$tmp_data[] = array
						(
                            $aluno->getNome(),
							$aluno->getDataNasc(),
							$aluno->getEmail(),
							$aluno->getTurma()
                        );  
					}
					// Convertendo para capturação em JSON
					if(isset($tmp_data) && count($tmp_data) > 0)
					{
						$data = array
						(
							"data" => $tmp_data
						);
					}
					else
					{
						$data = array
						(
							"data" => array()
						);
					}
				}else{
					
					$data[] = array('result' => 'Paramêtro Nome em falta!');
				}
                return $data;
            }
            catch (PDOException $e) 
            {
                die("Mensagem de erro: " . $e->getMessage());
            }
        }
        /* Inserir  Aluno */
        function insertAluno()
        {
            try
            {
                /* Verificando se existem parametro nulos */
                 if (isset($_POST["nome"]) && isset($_POST["email"]) && isset($_POST["data_nasc"]) && isset($_POST["id_turma"])) {
                   
                    // Capiturando os parametos enviados
                    $form_data = array(
                        ':nome'    => $_POST["nome"],
                        ':email' => $_POST["email"],
                        ':data_nasc' => $_POST["data_nasc"],
                        ':id_turma' => $_POST["id_turma"],
						':id_utilizador' => $_SESSION[$_SESSION['views'].'id'],
                    );
                    // Inserindo utilisando uma função mysql
                    $query = " SELECT FUNC_Inserir_aluno(:nome,:email,:data_nasc,:id_turma,:id_utilizador) as result";
                    // Criando objecto para conexão em PDO
                    $mysqlPDO = new MySQLPDO();
                    // Preparando a query
                    $statement = $mysqlPDO->getConnection()->prepare($query);
                    // Executando a query
                    $statement->execute($form_data);
                    // Caregando resultado
                    $row = $statement->fetch(PDO::FETCH_ASSOC);
                    // Enviando resultado
                    $data[] = array('result' => $row['result']);
                    
                } else {
                    // Verificação de parametro em falta
                    if (!isset($_POST["nome"]) && !isset($_POST["email"]) && !isset($_POST["data_nasc"]) && !isset($_POST["id_turma"])) {
                        $data[] = array('result' => 'Todos os paramêtros em falta!');
                    } elseif (!isset($_POST["nome"])) {
                        $data[] = array('result' => 'Paramêtro nome em falta!');
                    } elseif (!isset($_POST["email"])) {
                        $data[] = array('result' => 'Paramêtro email em falta!');
                    } elseif (!isset($_POST["data_nasc"])) {
                        $data[] = array('result' => 'Paramêtro data nascimento em falta!');
                    }  else {
                        $data[] = array('result' => 'Paramêtro turma em falta!');
                    }
                }
                return $data;
            } 
            catch (PDOException $e) 
            {
                die("Mensagem de erro: " . $e->getMessage());
            }
        }
        /* Alterar Aluno */
        function updateAluno()
        {
            
            try
            {
                /* Verificando se existem parametro nulos */
                 if (isset($_POST["nome"]) && isset($_POST["email"]) && isset($_POST["data_nasc"]) && isset($_POST["id"])) {
                   
                    // Capiturando os parametos enviados
                    $form_data = array(
                        ':nome'    => $_POST["nome"],
                        ':email' => $_POST["email"],
                        ':data_nasc' => $_POST["data_nasc"],
                        ':id' => $_POST["id"],
						':id_utilizador' => $_SESSION[$_SESSION['views'].'id'],
                    );
                    // Alterar utilisando uma função mysql
                    $query = " SELECT FUNC_Alterar_aluno(:nome,:email,:data_nasc,:id_utilizador,:id) as result";
                    // Criando objecto para conexão em PDO
                    $mysqlPDO = new MySQLPDO();
                    // Preparando a query
                    $statement = $mysqlPDO->getConnection()->prepare($query);
                    // Executando a query
                    $statement->execute($form_data);
                    // caregando resultado
                    $row = $statement->fetch(PDO::FETCH_ASSOC);
                   
                    // Enviando resultado
                         $data[] = array('result' => $row['result']);
                    
                } else {
                    // Verificação de parametro em falta
                    if (!isset($_POST["nome"]) && !isset($_POST["email"]) && !isset($_POST["data_nasc"]) && !isset($_POST["id"])) {
                        $data[] = array('result' => 'Todos os paramêtros em falta!');
                    } elseif (!isset($_POST["nome"])) {
                        $data[] = array('result' => 'Paramêtro nome em falta!');
                    } elseif (!isset($_POST["email"])) {
                        $data[] = array('result' => 'Paramêtro email em falta!');
                    } elseif (!isset($_POST["data_nasc"])) {
                        $data[] = array('result' => 'Paramêtro data nascimento em falta!');
                    }  else {
                        $data[] = array('result' => 'Paramêtro ID em falta!');
                    }
                }
                return $data;
            } 
            catch (PDOException $e) 
            {
                die("Mensagem de erro: " . $e->getMessage());
            }
        }
        /* Remove Aluno */
        function removeAluno()
        {
            try
            {
                /* Verificando se existem parametro nulos */
                if(isset($_POST["id"]))
                {
                    // Capiturando os parametos enviados
                    $form_data = array(
                        ':id' => $_POST["id"]
                    );
                    // Eliminar utilisando uma função mysql
                    $query = "Select FUNC_Eliminar_aluno(:id) as result";
                    // Criando objecto para conexão em PDO
                    $mysqlPDO = new MySQLPDO();
                    // Preparando a query
                    $statement = $mysqlPDO->getConnection()->prepare($query);
                    // Execute the query with passed parameter id
                    $statement->execute($form_data);
                    // caregando resultado
                    $row = $statement->fetch(PDO::FETCH_ASSOC);
                    $data[] = array('result' => $row['result']);
                }
                else
                {
                    // Verificação de parametro em falta
                    $data[] = array('result' => 'Paramêtro id em falta!');
                }
                return $data;
            } 
            catch (PDOException $e) 
            {
                die("Mensagem de erro: " . $e->getMessage());
            }
        }
        /* Fim Aluno */
        /**************************/
    }
?>
