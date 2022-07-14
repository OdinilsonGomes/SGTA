<?php
require_once("SQL.php");
    // User class
    class Utilizador implements JsonSerializable
    {
        private $id;
        private $usuario;
        private $senha;
        /* 
        This constructor create a new user object
        */
        /*
        function __construct(array $data)
        {
            $this->id       	= $data['id'];
            $this->usuario 		= $data['usuario'];
            $this->senha 		= $data['senha'];
        }*/
        public function logIn()
        {
            try {
                $data=json_decode(file_get_contents('php://input'),true);
                //var_dump($data);
                /* Verificando se os parametros são nulos */
                if ($data["usuario"]!="" && $data["senha"]!="") {
                        $form_data = array(
                            ':usuario' => $data["usuario"],
                            ':senha' => sha1(md5($data["senha"]))
                        );
                        // Comando SQL
                        $query = "SELECT id, usuario 
                                    FROM utilizador 
                                    WHERE usuario = :usuario and senha = :senha";
                        // Criação de objecto para conectar MySQL atravez do PDO
                        $sql = new SQL();

                        $result = json_decode($sql->SQLSelect($query,$form_data));
                        if($result->status=="success"){
                            // Verifica se existe alguma secção
                            if (isset($_SESSION['views'])) {
                                // Incrementa tsecção + 1 
                                $_SESSION['views']++;
                            } else {
                                // Abri nova Secção
                                $_SESSION['views'] = 1;
                            }
                            $_SESSION[$_SESSION['views'].'id']       = $result->dados[0]->id;
                            $_SESSION[$_SESSION['views'].'usuario']   = $result->dados[0]->usuario;

                            $result= json_encode(array ('status'=>'success', 'dados'=>'Login efectuado com sucesso!'));
                        }else{
                            $result= json_encode(array ('status'=>'401', 'dados'=>'Credenciais incorrectas, por favor verifique o seu nome de utilizador ou a sua palavra passe!'));
                        }
                    } else {
                        // Verificação de parametro em falta in POST data
                        if ($data["usuario"]=="" && $data["senha"]=="") {
                            $result= json_encode(array ('status'=>'401', 'dados'=>'Todos os paramêtros em falta para a autenticação do utilizador!'));
                        } elseif ($data["usuario"]=="") {
                            $result= json_encode(array ('status'=>'401', 'dados'=>'Paramêtro nome de utilizador em falta!!'));
                        } else {
                            $result= json_encode(array ('status'=>'401', 'dados'=>'Paramêtro senha em falta!!'));
                        }
                    }
                
                return $result;
               
            } catch (PDOException $e) {
                return json_encode(array ('status'=>'500', 'dados'=>'Mensagem de erro '.$e));
            }
        }
        public function logout()
        {
            try {
                if (isset($_SESSION['views'])) {
                    // Retirando a Secção
					
                    unset($_SESSION[$_SESSION['views'].'id']);
                    unset($_SESSION[$_SESSION['views'].'usuario']);
                    $_SESSION['views'] = $_SESSION['views'] - 1;
					unset($_SESSION['views']);
                    $result= json_encode(array ('status'=>'success', 'dados'=>'Logout efectuado com sucesso!'));
                       
                } else {
                    $result= json_encode(array ('status'=>'401', 'dados'=>'Não existe a tal sessão disponível!'));     
                }
                
                return $result;
               
            } catch (PDOException $e) {
                return json_encode(array ('status'=>'500', 'dados'=>'Mensagem de erro '.$e));
            }
        }
        // Converte objecto em JSON
        public function jsonSerialize()
        {
            return get_object_vars($this);
        }
    }
?>
