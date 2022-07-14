<?php

require_once("SQL.php");

    // Classe Turma
    class Turma implements JsonSerializable
    {
        private $id;
        private $nome;
        private $serie;
        private $id_utilizador;
        /* 
        Este Construtor cria um novo objecto aluno
        */
       /*
        function __construct(array $data)
        {
            $this->id        		= isset($data['id'];
            $this->nome      		= $data['nome'];
            $this->serie 			= $data['serie'];
            $this->id_utilizador 	= $data['id_utilizador'];
        }
        */
         /* INICIO */
        /* Listagem de turmas na Base de Dados */
        public function fetchAllTurma()
        {
            try {
                // Comando SQL
                $query = "SELECT * FROM turma WHERE id_estado=1 ORDER BY nome ASC";
				// Criação de objecto para conectar MySQL atravez do PDO
                $sql = new SQL();
                $result = $sql->SQLSelect($query);
                return $result;
               
            } catch (PDOException $e) {
                die("Mensagem de erro: " . $e->getMessage());
            }
        }
		
        public function fetchAllTurmaById($id)
        {
            try 
            {
                if(is_int($id)){
                    
                    $form_data = array(
                        ':id'    	   => $id
                    );
                    $query = "SELECT * FROM turma WHERE id_estado=1 AND id =:id";
                
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
		
		 public function fetchAllTurmaByAttribute($attribute,$attributevalue)
        {
               try {
                // Acessando o POST
                $form_data = array(
                    ':attributevalue'    	   => '%'.$attributevalue.'%'
                );
                // Comando SQL
                $query = "SELECT * FROM turma WHERE id_estado=1 AND $attribute LIKE :attributevalue";
				// Criação de objecto para conectar MySQL atravez do PDO
                $sql = new SQL();
                $result = $sql->SQLSelect($query,$form_data);
                return $result;
               
            } catch (PDOException $e) {
                return json_encode(array ('status'=>'500', 'dados'=>'Mensagem de erro '.$e));
            }
        }
		
       
        /* Inserir nova Turma*/
        public function insertTurma($data)
        {
            try {
                /* Verify if exist void value */
                if (array_key_exists("nome",$data) && array_key_exists("serie",$data)) {
                    // Get paramiter to check if exist
                    $check_data = array(
                        ':nome' => $data["nome"]
                    );
                    // Check for existent object with the same name in Database
                    $query = "SELECT id 
                                FROM turma 
                                WHERE id_estado=1 AND nome = :nome
                              ";
                    $sql = new SQL();
                    $result = json_decode($sql->SQLSelect($query,$check_data));
                    if($result->status=="success")
                    {
                        $result= json_encode(array ('status'=>'406', 'dados'=>'Turma com esse nome ja existe'));
                        
                    }
                    else
                    {
                        // Get paramiters
                        $form_data = array(
                            ':nome'    => $data["nome"],
                            ':serie' => $data["serie"],
                            ':id_utilizador' => $_SESSION[$_SESSION['views'].'id'],
                        );
                        // Inserindo utilisando uma função mysql
                        $query = "INSERT INTO turma(nome,serie,id_utilizador) VALUE(:nome,:serie,:id_utilizador)";
                        // Criação de objecto para conectar MySQL atravez do PDO
                    
                        $result = $sql->SQLExec($query,$form_data);

                    }
                    
                    
                } else {
                    // Verificação de parametro em falta
                    if (!array_key_exists("nome",$data) && !array_key_exists("serie",$data)) {
                        $result= json_encode(array ('status'=>'406', 'dados'=>'Todos os paramêtros em falta!'));
                    } elseif (!array_key_exists("nome",$data)) {
                        $result= json_encode(array ('status'=>'406', 'dados'=>'Paramêtro nome em falta!'));
                    }  else {
                        $result= json_encode(array ('status'=>'406', 'dados'=>'Paramêtro serie em falta!'));
                    }
                }
               
            } catch (PDOException $e) {
                //die("Mensagem de erro: " . $e->getMessage());
                $result= json_encode(array ('status'=>'error 444', 'dados'=>$e->getMessage()));
            } 
            return $result;
        }
        /* Alterar Turma */
        public function updateTurma($data)
        {
            try {
                /* Verify if exist void value */
                if (array_key_exists("nome",$data) && array_key_exists("id",$data)) {
                    // Get paramiter to check if exist
                    $check_data = array(
                        ':nome' => $data["nome"]
                    );
                    // Check for existent object with the same username in Database
                    $query = "SELECT id 
                                FROM turma 
                                WHERE id_estado=1 AND nome = :nome";
                    $sql = new SQL();
                    $result = json_decode($sql->SQLSelect($query,$check_data));
                    if($result->status=="success")
                    {
                        $result= json_encode(array ('status'=>'406', 'dados'=>'Turma com esse nome ja existe'));
                        
                    }
                    else
                    {
                        // Get paramiter
                        $form_data = array(
                            ':nome'         => $data["nome"],
                            ':id'           =>$data['id'],
                            ':id_utilizador' => $_SESSION[$_SESSION['views'].'id']
                        );
                        // Comand to udate in database
                        $query = "UPDATE turma SET nome=:nome,id_utilizador=:id_utilizador
                        WHERE id=:id";
                        // Criação de objecto para conectar MySQL atravez do PDO
                        $result = $sql->SQLExec($query,$form_data);

                    }
                    
                    
                } else {
                    // Verificação de parametro em falta
                    if (!array_key_exists("nome",$data) && !array_key_exists("id",$data)) {
                        $result= json_encode(array ('status'=>'406', 'dados'=>'Todos os paramêtros em falta!'));
                    } elseif (!array_key_exists("nome",$data)) {
                        $result= json_encode(array ('status'=>'406', 'dados'=>'Paramêtro nome em falta!'));
                    }   else {
                        $result= json_encode(array ('status'=>'406', 'dados'=>'Paramêtro ID Inexistente ou Invalido'));
                    }
                }
                return $result;
            } catch (PDOException $e) {
                return json_encode(array ('status'=>'500', 'dados'=>'Mensagem de erro '.$e));
            } 
        }
        /* Eliminar Turma*/
        public function removeTurma($data)
        {
            try {
                 /* Verify if exist void value */
                if ($data["id"]>0) {
                    // Get paramiter
                    $form_data = array(
                        ':id'           =>$data['id'],
                        ':id_utilizador' => $_SESSION[$_SESSION['views'].'id']
                    );
                    // Comando SQL
                    $query = "UPDATE turma SET id_estado=2, id_utilizador=:id_utilizador WHERE id=:id";
                    // Criação de objecto para conectar MySQL atravez do PDO
                    $sql = new SQL();
                    
                   
                    $result = $sql->SQLExec($query,$form_data);
                    return $result;
                   
                
                } else {
                    // Verificação de parametro em falta
                    $result = json_encode(array ('status'=>'406', 'dados'=>'Parametro ID Inexistente ou Invalido'));
                    return $result;
                }
            } catch (PDOException $e) {
                return json_encode(array ('status'=>'500', 'dados'=>'Mensagem de erro '.$e));
            }
        }
        /* Fim API Turma */
        /**************************/
        // Converte objecto em JSON
        public function jsonSerialize()
        {
            return get_object_vars($this);
        }
       
       
    }
?>
