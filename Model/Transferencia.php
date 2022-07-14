<?php
require_once("SQL.php");

    // Classe Transferencia
    class Transferencia implements JsonSerializable
    {
        private $id;
        private $data;
        private $motivo;
        private $aluno;
        private $turma_anterior;
        private $turma_destino;
        private $id_aluno;
        private $id_turma_anterior;
        private $id_turma_destino;
        private $id_utilizador;
        /*
        Este Construtor cria um novo objecto Transferencia
        */
        /*
        public function __construct(array $data)
        {
            $this->id    				= $data['id'];
            $this->data  				= $data['data'];
            $this->motivo  				= $data['motivo'];
            $this->aluno  				= $data['aluno'];
            $this->turma_anterior  		= $data['turma_anterior'];
            $this->turma_destino  		= $data['turma_destino'];
            $this->id_aluno  			= $data['id_aluno'];
            $this->id_turma_anterior  	= $data['id_turma_anterior'];
            $this->id_turma_destino  	= $data['id_turma_destino'];
            $this->id_utilizador  		= $data['id_utilizador'];
        }
        */
          /* INICIO */
        /* Listagem de Transferencias na Base de Dados */
        public function fetchAllTransferencia()
        {
            try {
                
                // Comando SQL
                $query = "SELECT * FROM transferencia WHERE id_estado=1 ORDER BY id DESC";
				// Criação de objecto para conectar MySQL atravez do PDO
                $sql = new SQL();
                $result = $sql->SQLSelect($query);
                return $result;
               
            } catch (PDOException $e) {
                die("Mensagem de erro: " . $e->getMessage());
            }
        }
		
        public function fetchAllTransferenciaById($id)
        {
            try 
            {
                if(is_int($id)){
                    
                    $form_data = array(
                        ':id'    	   => $id
                    );
                    $query = "SELECT * FROM Transferencia WHERE id_estado=1 AND id =:id";
                
                     $sql = new SQL();
                    $result = $sql->SQLSelect($query,$form_data);
                    return $result;
                }else{
                    return json_encode(array ('status'=>'406', 'dados'=>'Parametro ID em Falta ou Invalido'));
                }
					
               
            } catch (PDOException $e) {
                die("Mensagem de erro: " . $e->getMessage());
            }
        }
		
        /* Inserir nova Transferencia*/
        public function insertTransferencia($data)
        {
            try {
                /* Verify if exist void value */
                if (array_key_exists("id_aluno",$data) && array_key_exists("id_turma_destino",$data)) {
                    // Get paramiter to check if exist
                    $check_data = array(
                        ':id_aluno' => $data["id_aluno"],
                        ':id_turma_destino' => $data["id_turma_destino"]
                    );
                    // Check if pupil class is same with transfer class
                    $query = "SELECT id 
                                FROM aluno 
                                WHERE id_estado=1 AND id_turma= :id_turma_destino AND id=:id_aluno";
                    $sql = new SQL();
                    $result = json_decode($sql->SQLSelect($query,$check_data));
                     if($result->status=="success")
                     {
                        $result= json_encode(array ('status'=>'406', 'dados'=>'Aluno ja se encontra cadastrado nessa turma'));
                        
                     }
                     else
                     {
                        // Get paramiters
                        $form_data = array(
                            ':id_aluno'    => $data["id_aluno"],
                            ':id_turma_destino' => $data["id_turma_destino"],
                            ':id_utilizador' => $_SESSION[$_SESSION['views'].'id'],
                        );
                        // Inserindo utilisando uma função mysql
                        $query = "INSERT INTO transferencia(id_aluno,id_turma_anterior,id_turma_destino,id_utilizador) 
                                  VALUE(:id_aluno,(select id_turma from aluno a where a.id=:id_aluno),:id_turma_destino,:id_utilizador);
                                  UPDATE aluno SET id_turma=:id_turma_destino 
                                  WHERE id=:id_aluno;
                                  ";
                                  /* */
                        // Criação de objecto para conectar MySQL atravez do PDO
                        $result = $sql->SQLExec($query,$form_data);

                     }
                    
                } else {
                    // Verificação de parametro em falta
                    if ($data["id_aluno"]=="" && $data["id_turma_destino"]=="") {
                        $result= json_encode(array ('status'=>'406', 'dados'=>'Todos os paramêtros em falta!'));
                    } elseif ($data["id_aluno"]=="") {
                        $result= json_encode(array ('status'=>'406', 'dados'=>'Paramêtro ID aluno em falta!'));
                    }  else {
                        $result= json_encode(array ('status'=>'406', 'dados'=>'Paramêtro ID turma destino em falta!'));
                    }
                }
                return $result;
            } catch (PDOException $e) {
                return json_encode(array ('status'=>'500', 'dados'=>'Mensagem de erro '.$e));
            } 
        }


        /*************** INICIO DO CODIGO COM POUCA PRIOLIDADE DADOS AOS REQUISITOS (AINDA POR ACABAR)  *************************/
        /* Alterar Transferencia */
        public function updateTransferencia($data)
        {
            try {
                /* Verify if exist void value */
                if ($data["id_turma_destino"]!="" && $data["id"]!="") {
                $sql = new SQL();
                // Get paramiter
                $form_data = array(
                    ':id_turma_destino' =>$data['id_turma_destino'],
                    ':id'               =>$data['id'],
                    ':id_utilizador' => $_SESSION[$_SESSION['views'].'id']
                    );
                // Comand to udate in database
                $query = "UPDATE transferencia 
                            SET id_turma_destino = :id_turma_destino, id_utilizador = :id_utilizador
                            WHERE id= :id;
                            UPDATE aluno a,transferencia t SET a.id_turma=:id_turma_destino
                            WHERE t.id=:id AND a.id=t.id_aluno;
                        ";
                // Criação de objecto para conectar MySQL atravez do PDO
                $result = $sql->SQLExec($query,$form_data);
                } else {
                    // Verificação de parametro em falta
                    if ($data["id"]=="" && $data["id_turma_destino"]=="") {
                        $result= json_encode(array ('status'=>'406', 'dados'=>'Todos os paramêtros em falta!'));
                    } elseif ($data["id"]=="") {
                        $result= json_encode(array ('status'=>'406', 'dados'=>'Paramêtro ID em falta!'));
                    }  else {
                        $result= json_encode(array ('status'=>'406', 'dados'=>'Paramêtro ID turma em falta!'));
                    }
                }
                return $result;
            } catch (PDOException $e) {
                return json_encode(array ('status'=>'500', 'dados'=>'Mensagem de erro '.$e));
            } 
        }
        /* Eliminar Transferencia*/
        public function removeTransferencia($data)
        {
            try {
                 /* Verify if exist void value */
                if ($data["id"]!="") {
                // Get paramiter
                $form_data = array(
                    ':id'           =>$data['id'],
                    ':id_utilizador' => $_SESSION[$_SESSION['views'].'id']
                );
                // Comando SQL
                $query = "UPDATE Transferencia SET id_estado=2, id_utilizador=:id_utilizador WHERE id=:id;
                          UPDATE aluno a,transferencia t SET a.id_turma=t.id_turma_anterior
                          WHERE t.id=:id AND a.id=t.id_aluno;
                ";
				// Criação de objecto para conectar MySQL atravez do PDO
                $sql = new SQL();
                $result = $sql->SQLExec($query,$form_data);
                return $result;
                } else {
                    // Verificação de parametro em falta
                    $result= json_encode(array ('status'=>'406', 'dados'=>'Parametro ID em falta!'));
                
                }
            } catch (PDOException $e) {
                return json_encode(array ('status'=>'500', 'dados'=>'Mensagem de erro '.$e));
            }
        }
        /* Fim API Transferencia */
        // Converte objecto em JSON
        public function jsonSerialize()
        {
            return get_object_vars($this);
        }
    }
   