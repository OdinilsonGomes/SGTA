<?php
    // Impotação de Classes Importantes
    require_once("mysql_pdo.php");
    require_once("classes/transferencia.php");
	
    // API da Classe Transferencia
    class TransferenciaAPI
    {
        /* INICIO */

        /* Listagem de todas as transferencia na Base de Dados */
        public function fetchAllTransferencia()
        {
            try {
                // Comando SQL
                $query = "SELECT * FROM vista_transferencia order by id desc";
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
                    // Cria o objecto Transferencia
                    $transferencia = new Transferencia($row);
                    // Cria linhas da tabela
                    $tmp_data[] = array(
                        $transferencia->getAluno(),
                        $transferencia->getTurma_anterior(),
                        $transferencia->getTurma_destino(),
                        $transferencia->getData(),
                        $transferencia->getMotivo(),
                        "<div class='span12' style='text-align:center'><a href='javascript:update(".json_encode($transferencia).")' class='btn btn-info'><i class='fas fa-edit'></i></a></div>",
                        "<div class='span12' style='text-align:center'><a href='javascript:remove(".$transferencia->getId().")' class='btn btn-danger'><i class='far fa-trash-alt'></i></a></div>"
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
       
        /* Inserir nova Transferencia*/
        public function insertTransferancia()
        {
            try {
                /* Verificando se existem parametro nulos */
                if (isset($_POST["id_aluno"]) && isset($_POST["id_turma_destino"]) && isset($_POST["data"]) && isset($_POST["motivo"])) {
                   
                    // Capiturando os parametos enviados
                    $form_data = array(
                        ':data'    => $_POST["data"],
                        ':motivo' => $_POST["motivo"],
                        ':id_aluno' => $_POST["id_aluno"],
                        ':id_turma_destino' => $_POST["id_turma_destino"],
						':id_utilizador' => $_SESSION[$_SESSION['views'].'id'],
                    );
                    // Inserindo utilisando uma função mysql
                    $query = " SELECT FUNC_Inserir_transferencia(:data,:motivo,:id_aluno,:id_turma_destino,:id_utilizador) as result";
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
                    if (!isset($_POST["id_aluno"]) && !isset($_POST["id_turma_destino"]) && !isset($_POST["data"]) && !isset($_POST["motivo"])) {
                        $data[] = array('result' => 'Todos os paramêtros em falta!');
                    } elseif (!isset($_POST["id_aluno"])) {
                        $data[] = array('result' => 'Paramêtro Aluno em falta!');
                    } elseif (!isset($_POST["id_turma_destino"])) {
                        $data[] = array('result' => 'Paramêtro Turma destino em falta!');
                    } elseif (!isset($_POST["data"])) {
                        $data[] = array('result' => 'Paramêtro data em falta!');
                    } else {
                        $data[] = array('result' => 'Paramêtro motivo em falta!');
                    }
                }
                return $data;
            } catch (PDOException $e) {
                die("Mensagem de erro: " . $e->getMessage());
            }
        }
        /* Alterar Transferencia */
        public function updateTransferencia()
        {
            try {
                /* Check if for the empty or null title, abstract and date parameters */
                if (isset($_POST["id_turma_destino"]) && isset($_POST["data"]) && isset($_POST["motivo"]) && isset($_POST["id"])) {
                   
                    // Capiturando os parametos enviados
                    $form_data = array(
                        ':data'    => $_POST["data"],
                        ':motivo' => $_POST["motivo"],
                        ':id_turma_destino' => $_POST["id_turma_destino"],
                        ':id' => $_POST["id"],
						':id_utilizador' => $_SESSION[$_SESSION['views'].'id'],
                    );
                    // Inserindo utilisando uma função mysql
                    $query = " SELECT FUNC_Alterar_transferencia(:data,:motivo,:id_turma_destino,:id_utilizador,:id) as result";
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
                    if (!isset($_POST["id_turma_destino"]) && !isset($_POST["data"]) && !isset($_POST["motivo"])) {
                        $data[] = array('result' => 'Todos os paramêtros em falta');
                    } elseif (!isset($_POST["id_turma_destino"])) {
                        $data[] = array('result' => 'Paramêtro Turma destino em falta!');
                    } elseif (!isset($_POST["data"])) {
                        $data[] = array('result' => 'Paramêtro data em falta!');
                    }elseif (!isset($_POST["id"])) {
                        $data[] = array('result' => 'Paramêtro ID em falta!');
                    } else {
                        $data[] = array('result' => 'Paramêtro motivo em falta!');
                    }
                }
                return $data;
            } catch (PDOException $e) {
                die("Mensagem de erro: " . $e->getMessage());
            }
        
		}
        /* Eliminar Transferencia */
        public function removeTransferencia()
        {
            try {
                /*  Verificando se existem parametro nulos */
                if (isset($_POST["id"])) {
                     // Capiturando os parametos enviados
                    $form_data = array(
                        ':id' => $_POST["id"]
                    );
                     // Eliminando utilisando uma função mysql
                    $query = " SELECT FUNC_Eliminar_transferencia(:id) as result";
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
                    $data[] = array('result' => 'Paramêtro id em falta!!');
                }
                return $data;
            } catch (PDOException $e) {
                die("Mensagem de erro: " . $e->getMessage());
            }
        }
        /* Fim Transferencia */
        /**************************/
    }
