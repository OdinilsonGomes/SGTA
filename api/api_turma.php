<?php
    // Impotação de Classes Importantes
    require_once("mysql_pdo.php");
    require_once("classes/turma.php");
	
    // API da Classe Turma
    class TurmaAPI
    {
        /* INICIO */
        /* Listagem de turmas na Base de Dados */
        public function fetchAllTurma()
        {
            try {
                // Comando SQL
                $query = "SELECT * FROM turma order by nome asc";
				// Criação de objecto para conectar MySQL atravez do PDO
                $mysqlPDO = new MySQLPDO();
                // Prepare query
                $statement = $mysqlPDO->getConnection()->prepare($query);
                // Executando o query
                $statement->execute();
                // atribuindo o resultado a variavel rows
                $rows = $statement->fetchAll();
                // Para cada Linha do array
                foreach ($rows as $row) {
                    // Cria o objecto Turma
                    $turma = new Turma($row);
                    //Cria linhas da tabela
                    $tmp_data[] = array(
                        $turma->getNome(),
                        $turma->getSerie(),
                        "<div class='span12' style='text-align:center'><a href='javascript:fetchAllAlunoByTurma(".json_encode($turma).")' class='btn btn-warning btn-sm'>Ver alunos</a></div>",
                        "<div class='span12' style='text-align:center'><a href='javascript:update(".$turma->getId().")' class='btn btn-info'><i class='fas fa-edit'></i></a></div>",
                        "<div class='span12' style='text-align:center'><a href='javascript:remove(".$turma->getId().")' class='btn btn-danger'><i class='far fa-trash-alt'></i></a></div>"
                    );
                }
                // Convertendo para capturação em JSON
                if (isset($tmp_data) && count($tmp_data) > 0) {
                    $data = array(
                        "data" => $tmp_data
                    );
                } else {
                    $data = array(
                        "data" => array()
                    );
                }
                return $data;
            } catch (PDOException $e) {
                die("Mensagem de erro: " . $e->getMessage());
            }
        }
		
		 public function fetchAllTurmaById()
        {
            try 
            {
				if(isset($_POST['id'])){
					$form_data = array(
							':id'    	   => $_POST["id"]
						);
						
					$query = "SELECT * FROM turma where id =:id";
					
					// Criando objecto para conexão em PDO
					$mysqlPDO = new MySQLPDO();
					// Preparando a query
					$statement = $mysqlPDO->getConnection()->prepare($query);
					// Executando a query
					$statement->execute($form_data);
					// caregando resultado
					$rows = $statement->fetchAll();
					// Atribuindo resultado
					foreach ($rows as $row) {
						// Cria o objecto Turma
						$turma = new Turma($row);
						//Cria linhas da tabela
						$data =	$turma;
					}
					
				}else{
					
					$data[] = array('result' => 'Paramêtro ID em falta!');
				}
				
                return $data;
            } catch (PDOException $e) {
                die("Mensagem de erro: " . $e->getMessage());
            }
        }
		
		 public function fetchAllTurmaByNome()
        {
            try 
            {
				if(isset($_POST['nome'])){
					$form_data = array(
							':nome'    	   => '%'.$_POST["nome"].'%',
						);
						
					$query = "SELECT * FROM turma where nome like :nome";
					
					// Criando objecto para conexão em PDO
					$mysqlPDO = new MySQLPDO();
					// Preparando a query
					$statement = $mysqlPDO->getConnection()->prepare($query);
					// Executando a query
					$statement->execute($form_data);
					// caregando resultado
					$rows = $statement->fetchAll();
					// Atribuindo resultado
					foreach ($rows as $row) {
						// Cria o objecto Turma
						$turma = new Turma($row);
						//Cria linhas da tabela
						$tmp_data[] = array(
							$turma->getNome(),
							$turma->getSerie(),
							"<div class='span12' style='text-align:center'><a href='javascript:fetchAllAlunoByTurma(".json_encode($turma).")' class='btn btn-warning btn-sm'>Ver alunos</a></div>",
							"<div class='span12' style='text-align:center'><a href='javascript:update(".$turma->getId().")' class='btn btn-info'><i class='fas fa-edit'></i></a></div>",
							"<div class='span12' style='text-align:center'><a href='javascript:remove(".$turma->getId().")' class='btn btn-danger'><i class='far fa-trash-alt'></i></a></div>"
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
            } catch (PDOException $e) {
                die("Mensagem de erro: " . $e->getMessage());
            }
        }
		public function fetchAllTurmaToSelect()
        {
            try 
            {
				
					$query = "SELECT * FROM turma order by nome";
					
					// Criando objecto para conexão em PDO
					$mysqlPDO = new MySQLPDO();
					// Preparando a query
					$statement = $mysqlPDO->getConnection()->prepare($query);
					// Executando a query
					$statement->execute();
					// caregando resultado
					$rows = $statement->fetchAll();
					// Atribuindo resultado
					foreach ($rows as $row) {
						// Cria o objecto Turma
						$turma = new Turma($row);
						//Cria linhas da tabela
						$tmp_data[] = array(
							$turma->getId(),
							$turma->getNome()
							
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
            } catch (PDOException $e) {
                die("Mensagem de erro: " . $e->getMessage());
            }
        }
		 public function fetchAllTurmaBySerie()
        {
            try 
            {
				if(isset($_POST['serie'])){
					$form_data = array(
							':serie'    	   => '%'.$_POST["serie"].'%',
						);
						
					$query = "SELECT * FROM turma where serie like :serie";
					
					// Criando objecto para conexão em PDO
					$mysqlPDO = new MySQLPDO();
					// Preparando a query
					$statement = $mysqlPDO->getConnection()->prepare($query);
					// Executando a query
					$statement->execute($form_data);
					// caregando resultado
					$rows = $statement->fetchAll();
					// Atribuindo resultado
					foreach ($rows as $row) {
						// Cria o objecto Turma
						$turma = new Turma($row);
						//Cria linhas da tabela
						$tmp_data[] = array(
							$turma->getNome(),
							$turma->getSerie(),
							"<div class='span12' style='text-align:center'><a href='javascript:fetchAllAlunoByTurma(".json_encode($turma).")' class='btn btn-warning btn-sm'>Ver alunos</a></div>",
							"<div class='span12' style='text-align:center'><a href='javascript:update(".$turma->getId().")' class='btn btn-info'><i class='fas fa-edit'></i></a></div>",
							"<div class='span12' style='text-align:center'><a href='javascript:remove(".$turma->getId().")' class='btn btn-danger'><i class='far fa-trash-alt'></i></a></div>"
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
					
					$data[] = array('result' => 'Paramêtro Serie em falta!');
				}
                return $data;
            } catch (PDOException $e) {
                die("Mensagem de erro: " . $e->getMessage());
            }
        }
       
        /* Inserir nova Turma*/
        public function insertTurma()
        {
            try {
                /* Verificando se existem parametros nulos */
                if (isset($_POST["nome"]) && isset($_POST["serie"])) {
                   
                    // Capiturando os parametos enviados
                    $form_data = array(
                        ':nome'    => $_POST["nome"],
                        ':serie' => $_POST["serie"],
						':id_utilizador' => $_SESSION[$_SESSION['views'].'id'],
                    );
                    // Inserindo utilisando uma função mysql
                    $query = " SELECT FUNC_Inserir_turma(:nome,:serie,:id_utilizador) as result";
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
                    if (!isset($_POST["nome"]) && !isset($_POST["serie"])) {
                        $data[] = array('result' => 'Todos os paramêtros em falta!');
                    } elseif (!isset($_POST["nome"])) {
                        $data[] = array('result' => 'Paramêtro nome em falta!');
                    }  else {
                        $data[] = array('result' => 'Paramêtro serie em falta!');
                    }
                }
                return $data;
            } catch (PDOException $e) {
                die("Mensagem de erro: " . $e->getMessage());
            }
        }
        /* Alterar Turma */
        public function updateTurma()
        {
            try {
                /* Verificando se existem parametros nulos */
               if (isset($_POST["nome"]) && isset($_POST["id"])) {
                   
                    // Capiturando os parametos enviados
                    $form_data = array(
                        ':nome'    => $_POST["nome"],
						':id_utilizador' => $_SESSION[$_SESSION['views'].'id'],
                        ':id' => $_POST["id"],
                    );
                    // Inserindo utilisando uma função mysql
                    $query = " SELECT FUNC_Alterar_turma(:nome,:id_utilizador,:id) as result";
                    // Criando objecto para conexão em PDO
                    $mysqlPDO = new MySQLPDO();
                    // Preparando a query
                    $statement = $mysqlPDO->getConnection()->prepare($query);
                    // Executando a query
                    $statement->execute($form_data);
                    // caregando resultado
                    $row = $statement->fetch(PDO::FETCH_ASSOC);
                    // Enviando resultado
                   
                    // Enviando resultado
                         $data[] = array('result' => $row['result']);
                    
                } else {
                    // Verificação de parametro em falta
                    if (!isset($_POST["nome"]) && !isset($_POST["id"])) {
                        $data[] = array('result' => 'Todos os paramêtros em falta!');
                    } elseif (!isset($_POST["nome"])) {
                        $data[] = array('result' => 'Paramêtro nome em falta!');
                    }  else {
                        $data[] = array('result' => 'Paramêtro ID em falta!');
                    }
                }
                return $data;
            } catch (PDOException $e) {
                die("Mensagem de erro: " . $e->getMessage());
            }
        }
        /* Eliminar Turma*/
        public function removeTurma()
        {
            try {
                /*  Verificando se existem parametro nulos */
                if (isset($_POST["id"])) {
                     // Capiturando os parametos enviados
                    $form_data = array(
                        ':id' => $_POST["id"]
                    );
                    // Inserindo utilisando uma função mysql
                    $query = " SELECT FUNC_Eliminar_turma(:id) as result";
                    // Criando objecto para conexão em PDO
                    $mysqlPDO = new MySQLPDO();
                    // Preparando a query
                    $statement = $mysqlPDO->getConnection()->prepare($query);
                    // Executando a query
                    $statement->execute($form_data);
                    // caregando resultado
                    $row = $statement->fetch(PDO::FETCH_ASSOC);
                    // Enviando resultado
                   
                    // Enviando resultado
                         $data[] = array('result' => $row['result']);
                    
                } else {
                    // Verificação de parametro em falta
                    $data[] = array('result' => 'Paramêtro id em falta!!');
                }
                return $data;
            } catch (PDOException $e) {
                die("Mensagem de erro: " . $e->getMessage());
            }
        }
        /* Fim API Turma */
        /**************************/
    }
