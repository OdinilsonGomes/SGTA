<?php

require_once("SQL.php");

    // Classe Aluno
    class Aluno implements JsonSerializable
    {
        private $id;
        private $nome;
        private $email;
        private $data_nasc;
        private $turma;
        private $id_turma;
        private $id_utilizador;
        /* 
        Este Construtor cria um novo objecto aluno
        */
        /*
        function __construct(array $data)
        {
            $this->id          		= $data['id'];
            $this->nome        		= $data['nome'];
            $this->email 	   		= $data['email'];
            $this->data_nasc 	   	= $data['data_nasc'];
            $this->turma 	   		= $data['nome_turma'];
            $this->id_turma    		= $data['id_turma'];
            $this->id_utilizador    = $data['id_utilizador'];
        }
        */
           /* INICIO */
        /* Listagem de alunos na Base de Dados */
        public function fetchAllAluno()
        {
            try {
                // Comando SQL
                $query = "SELECT a.id,a.nome,a.data_nasc,a.email, a.id_turma, t.nome as turma
                            FROM aluno a , turma t
                            WHERE a.id_estado=1 AND a.id_turma=t.id ORDER BY a.nome ASC";
				// Criação de objecto para conectar MySQL atravez do PDO
                $sql = new SQL();
                $result = $sql->SQLSelect($query);
                return $result;
               
            } catch (PDOException $e) {
                return json_encode(array ('status'=>'500', 'dados'=>'Mensagem de erro '.$e));
            }
        }
		
        public function fetchAllAlunoById($id)
        {
            try 
            {
                if(($id>0)){
                    
                    $form_data = array(
                        ':id'    	   => $id
                    );
                    $query = "SELECT * FROM aluno WHERE id_estado=1 AND id =:id";
                
                     $sql = new SQL();
                    $result = $sql->SQLSelect($query,$form_data);
                    return $result;
                }else{
                    return json_encode(array ('status'=>'406', 'dados'=>'Parametro ID em Falta ou Invalido'));
                }
					
               
            } catch (PDOException $e) {
                return json_encode(array ('status'=>'500', 'dados'=>'Mensagem de erro '.$e));
            }
        }
        public function fetchAllAlunoByTurma($id)
        {
            try 
            {
                if($id>0){
                    
                    $form_data = array(
                        ':id'    	   => $id
                    );
                    $query = "SELECT * FROM aluno WHERE id_estado=1 AND id_turma =:id";
                
                     $sql = new SQL();
                    $result = $sql->SQLSelect($query,$form_data);
                    return $result;
                }else{
                    return json_encode(array ('status'=>'406', 'dados'=>'Parametro ID em Falta ou Invalido'));
                }
					
               
            } catch (PDOException $e) {
                return json_encode(array ('status'=>'500', 'dados'=>'Mensagem de erro '.$e));
            }
        }
        public function fetchAllAlunoTurmaByNome($data)
        {
            try 
            {
                if($id>0){
                    
                    $form_data = array(
                        ':id'    	   => $data['id_turma'],
                        ':nome'    	   => '%'.$data['nome'].'%'
                    );
                    $query = "SELECT * FROM aluno WHERE id_estado=1 AND id_turma =:id AND nome like :nome ORDER BY nome";
                
                     $sql = new SQL();
                    $result = $sql->SQLSelect($query,$form_data);
                    return $result;
                }else{
                    return json_encode(array ('status'=>'406', 'dados'=>'Parametro ID em Falta ou Invalido'));
                }
					
               
            } catch (PDOException $e) {
                return json_encode(array ('status'=>'500', 'dados'=>'Mensagem de erro '.$e));
            }
        }
		
		 public function fetchAllAlunoByAttribute($attribute,$attributevalue,$id_turma=null)
        {

               try {
                // Acessando o POST
                $form_data = array(
                    ':attributevalue'    	   => '%'.$attributevalue.'%',
                    ':id_turma' => $id_turma
                );
                // Comando SQL
                if($id_turma==null)
                $query = "SELECT * FROM aluno WHERE id_estado=1 AND $attribute LIKE :attributevalue";
				else
                $query = "SELECT * FROM aluno WHERE id_estado=1 AND id_turma=:id_turma AND $attribute LIKE :attributevalue";
                // Criação de objecto para conectar MySQL atravez do PDO
                $sql = new SQL();
                $result = $sql->SQLSelect($query,$form_data);
                return $result;
               
            } catch (PDOException $e) {
                return json_encode(array ('status'=>'500', 'dados'=>'Mensagem de erro '.$e));
            }
        }
		
        /* Inserir novo Aluno*/
        public function insertAluno($data)
        {
            try {
                /* Verify if exist void value */
                if (array_key_exists("nome",$data) && array_key_exists("email",$data) && 
                    array_key_exists("data_nasc",$data)&& array_key_exists("id_turma",$data)) {
                    // Get paramiter to check if exist
                    $check_data = array(
                        ':email' => $data["email"]
                    );
                    // Check for existent object with the same name in Database
                    $query = "SELECT id 
                                FROM aluno 
                                WHERE id_estado=1 AND email = :email
                              ";
                    $sql = new SQL();
                    $result = json_decode($sql->SQLSelect($query,$check_data));
                    if($result->status=="sucess")
                    {
                        $result= json_encode(array ('status'=>'406', 'dados'=>'Aluno com esse email ja existe'));
                        
                    }
                    else
                    {
                        // Get paramiters
                        $form_data = array(
                            ':nome'    => $data["nome"],
                            ':email' => $data["email"],
                            ':data_nasc' => $data["data_nasc"],
                            ':id_turma' => $data["id_turma"],
                            ':id_utilizador' => $_SESSION[$_SESSION['views'].'id'],
                        );
                        // Inserindo utilisando uma função mysql
                        $query = "INSERT INTO aluno(nome,email,data_nasc,id_turma,id_utilizador) VALUE(:nome,:email,:data_nasc,:id_turma,:id_utilizador)";
                        // Criação de objecto para conectar MySQL atravez do PDO
                    
                        $result = $sql->SQLExec($query,$form_data);

                    }
                    
                    
                } else {
                    // Verificação de parametro em falta
                    if (!array_key_exists("nome",$data) && !array_key_exists("email",$data) && 
                        !array_key_exists("data_nasc",$data) && !array_key_exists("id_turma",$data)) {
                        $result= json_encode(array ('status'=>'406', 'dados'=>'Todos os paramêtros em falta!'));
                    } elseif (!array_key_exists("nome",$data)){
                        $result= json_encode(array ('status'=>'406', 'dados'=>'Paramêtro nome em falta!'));
                    } elseif (!array_key_exists("email",$data)) {
                        $result= json_encode(array ('status'=>'406', 'dados'=>'Paramêtro email em falta!'));
                    } elseif (!array_key_exists("data_nasc",$data)) {
                        $result= json_encode(array ('status'=>'406', 'dados'=>'Paramêtro data nascimento em falta!'));
                    } else {
                        $result= json_encode(array ('status'=>'406', 'dados'=>'Paramêtro ID da Turma Inexistente ou Invalido!'));
                    }
                }
                return $result;
            } catch (PDOException $e) {
                return json_encode(array ('status'=>'500', 'dados'=>'Mensagem de erro '.$e));
            } 
        }
        /* Alterar Aluno */
        public function updateAluno($data)
        {
            try {
                /* Verify if exist void value */
                if (array_key_exists("nome",$data) && array_key_exists("email",$data) && 
                    array_key_exists("data_nasc",$data) && array_key_exists("id",$data) ) {
                    // Get paramiter to check if exist
                    $check_data = array(
                        ':email' => $data["email"]
                    );
                    // Check for existent object with the same name in Database
                    $query = "SELECT id 
                                FROM aluno 
                                WHERE id_estado=1 AND email = :email
                              ";
                    $sql = new SQL();
                    $result = json_decode($sql->SQLSelect($query,$check_data));
                    if($result->status=="sucess")
                    {
                        $result= json_encode(array ('status'=>'406', 'dados'=>'Aluno com esse email ja existe'));
                        
                    }
                    else
                    {
                        // Get paramiters
                        $form_data = array(
                            ':nome'    => $data["nome"],
                            ':email' => $data["email"],
                            ':data_nasc' => $data["data_nasc"],
                            ':id' => $data["id"],
                            ':id_utilizador' => $_SESSION[$_SESSION['views'].'id'],
                        );
                        // Inserindo utilisando uma função mysql
                        $query = "UPDATE aluno SET nome=:nome,
                                    email=:email,data_nasc=:data_nasc,
                                    id_utilizador=:id_utilizador
                                    WHERE id=:id";
                        // Criação de objecto para conectar MySQL atravez do PDO
                    
                        $result = $sql->SQLExec($query,$form_data);

                    }
                    
                    
                } else {
                     // Verificação de parametro em falta
                     if (!array_key_exists("nome",$data) && !array_key_exists("email",$data) && 
                     !array_key_exists("data_nasc",$data) && !array_key_exists("id",$data)) {
                     $result= json_encode(array ('status'=>'406', 'dados'=>'Todos os paramêtros em falta!'));
                 } elseif (!array_key_exists("nome",$data)){
                     $result= json_encode(array ('status'=>'406', 'dados'=>'Paramêtro nome em falta!'));
                 } elseif (!array_key_exists("email",$data)) {
                     $result= json_encode(array ('status'=>'406', 'dados'=>'Paramêtro email em falta!'));
                 } elseif (!array_key_exists("data_nasc",$data)) {
                     $result= json_encode(array ('status'=>'406', 'dados'=>'Paramêtro data nascimento em falta!'));
                 } else {
                     $result= json_encode(array ('status'=>'406', 'dados'=>'Paramêtro ID Inexistente ou Invalido!'));
                 }
                }
                return $result;
            } catch (PDOException $e) {
                return json_encode(array ('status'=>'500', 'dados'=>'Mensagem de erro '.$e));
            } 
        }
        /* Eliminar Aluno*/
        public function removeAluno($data)
        {
            try {
                 /* Verify if exist void value */
                if (!in_array("id",$data)) {
                // Get paramiter
                $form_data = array(
                    ':id'           =>$data['id'],
                    ':id_utilizador' => $_SESSION[$_SESSION['views'].'id']
                );
                // Comando SQL
                $query = "UPDATE aluno SET id_estado=2, id_utilizador=:id_utilizador WHERE id=:id";
				// Criação de objecto para conectar MySQL atravez do PDO
                $sql = new SQL();
                
                    $result = $sql->SQLExec($query,$form_data);
                    return $result;
                
               
                } else {
                    // Verificação de parametro em falta
                    $result= json_encode(array ('status'=>'406', 'dados'=>'Parametro ID Inexistente ou Invalido!'));
                
                }
            } catch (PDOException $e) {
                return json_encode(array ('status'=>'500', 'dados'=>'Mensagem de erro '.$e));
            }
        }
        /* Fim API Turma */
      
        // Converte objecto em JSON
        public function jsonSerialize()
        {
            return get_object_vars($this);
        }
    }
?>
