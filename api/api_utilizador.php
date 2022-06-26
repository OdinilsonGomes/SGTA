<?php
    // Importando Classes importantes
    require_once("mysql_pdo.php");
    require_once("classes/utilizador.php");
    // API Utilizador
    class UtilizadorAPI
    {
        /* Utilizador */
        /* Fazer login */
        public function logIn()
        {
            try {
                /* Verificando se os parametros são nulos */
                if (isset($_POST["usuario"]) && isset($_POST["senha"])) {
                    // Capturando dados enviados
                    $form_data = array(
                        ':usuario'  => $_POST["usuario"],
                        ':senha'  => sha1(md5($_POST["senha"]))
                    );
                    // Verificando se os dados estão corecto
                   $query = "SELECT id, usuario 
                            FROM utilizador 
                            WHERE usuario = :usuario and senha = :senha
                            ";
                    // Criando objecto para conexão em PDO
                    $mysqlPDO = new MySQLPDO();
                    // Preparando a query
                    $statement = $mysqlPDO->getConnection()->prepare($query);
                    // Executando a query
                    $statement->execute($form_data);
                    // caregando resultado
                    $row = $statement->fetch(PDO::FETCH_ASSOC);
                    // Enviando resultado
                    if ($row) {
                        // Verifica se existe alguma secção
                        if (isset($_SESSION['views'])) {
                            // Incrementa tsecção + 1 
                            $_SESSION['views']++;
                        } else {
                            // Abri nova Secção
                            $_SESSION['views'] = 1;
                        }
                        // Atribuindo informações do utilizador a secção
                        $_SESSION[$_SESSION['views'].'id']       = $row['id'];
                        $_SESSION[$_SESSION['views'].'usuario']   = $row['usuario'];
                        // data[] is a associative array that return json
                        $data[] = array('result' => '1');
                    } else {
                        $data[] = array('result' => 'Credenciais incorrectas, por favor verifique o seu nome de utilizador ou a sua palavra passe!');
                    }
                } else {
                    // Verificação de parametro em falta in POST data
                    if (!isset($_POST["usuario"]) && !isset($_POST["senha"])) {
                        $data[] = array('result' => 'Todos os paramêtros em falta para a autenticação do utilizador!');
                    } elseif (!isset($_POST["usuario"])) {
                        $data[] = array('result' => 'Paramêtro nome de utilizador em falta!!');
                    } else {
                        $data[] = array('result' => 'Paramêtro senha em falta!!');
                    }
                }
                return $data;
            } catch (PDOException $e) {
                die("Mensagem de erro: " . $e->getMessage());
            }
        }
        
        /*  logout */
        public function logOut()
        {
            try {
                // Verifica se a secção está aberta
                if (isset($_SESSION['views'])) {
                    // Retirando a Secção
					
                    unset($_SESSION[$_SESSION['views'].'id']);
                    unset($_SESSION[$_SESSION['views'].'usuario']);
                    $_SESSION['views'] = $_SESSION['views'] - 1;
					unset($_SESSION['views']);
                    // Enviando resultado
                    $data[] = array('result' => '1');
                } else {
                    $data[] = array('result' => 'Não existe a tal sessão disponível!');
                }
                return $data;
            } catch (PDOException $e) {
                die("Mensagem de erro: " . $e->getMessage());
            }
        }
        /* Pesquisa todos os utilizadores da Base de dados */
        public function fetchAllUser()
        {
            try {
                // Select em mysql
                $query = "select * from utilizador";
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
                    // Cria objecto utilizador
                    $utilizador = new Utilizador($row);
                    //Cria linhas da tabela
                    $tmp_data[] = array(
                        $utilizador->getUsuario(),
                        "********",
                        "<div class='span12' style='text-align:center'><a href='javascript:update(".json_encode($utilizador).")' class='btn btn-info'><i class='fas fa-edit'></i></a></div>",
                        "<div class='span12' style='text-align:center'><a href='javascript:remove(".$utilizador->getId().")' class='btn btn-danger'><i class='far fa-trash-alt'></i></a></div>"
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
        /* Insert novo utilizador */
        public function insertUser()
        {
            try {
                /* Check if for the empty or null username, password and access parameters */
                if (isset($_POST["usuario"]) && isset($_POST["senha"])) {
                    
                    // Capiturando os parametos enviados
                    $form_data = array(
                        ':usuario' => $_POST["usuario"],
                        ':senha' => sha1(md5($_POST["senha"]))
                    );
                   $query = "Select FUNC_Inserir_utilizador(:usuario,:senha) as result";
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
                    if (!isset($_POST["usuario"]) && !isset($_POST["senha"])) {
                        $data[] = array('result' => 'Todos os paramêtros em falta para adição de um novo utilizador!');
                    } elseif (!isset($_POST["usuario"])) {
                        $data[] = array('result' => 'Paramêtro nome de utilizador em falta!');
                    } else {
                        $data[] = array('result' => 'Paramêtro senha em falta!');
                    }
                }
                return $data;
            } catch (PDOException $e) {
                die("Mensagem de erro: " . $e->getMessage());
            }
        }
        /* Alterar utilizador */
        public function updateUser()
        {
            try {
                /* Verificando se os campos são nulos */
                if (isset($_POST["usuario"]) && isset($_POST["senha"]) && isset($_POST["id_utilizador"])) {
                    
                    // Capiturando os parametos enviados
                    $form_data = array(
                        ':usuario' => $_POST["usuario"],
                        ':senha' => sha1(md5($_POST["senha"])),
						':id_utilizador' => $_POST['id_utilizador']
                    );
                   $query = "Select FUNC_Alterar_utilizador(:usuario,:senha,:id_utilizador) as result";
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
                    if (!isset($_POST["usuario"]) && !isset($_POST["senha"]) && !isset($_POST["id_utilizador"])) {
                        $data[] = array('result' => 'Todos os paramêtros em falta para adição de um novo utilizador!');
                    } elseif (!isset($_POST["usuario"])) {
                        $data[] = array('result' => 'Paramêtro nome de utilizador em falta!');
                    }elseif (!isset($_POST["id_utilizador"])) {
                        $data[] = array('result' => 'Paramêtro ID de utilizador em falta!');
                    } else {
                        $data[] = array('result' => 'Paramêtro senha em falta!');
                    }
                }
                return $data;
            } catch (PDOException $e) {
                die("Mensagem de erro: " . $e->getMessage());
            }
        }
        /* Eliminar user */
        public function removeUser()
        {
            try {
                /*  Verificando se existem parametro nulos */
                if (isset($_POST["id"])) {
                    // Capiturando os parametos enviados
                    $form_data = array(
                        ':id' => $_POST["id"]
                    );
                    // Create a SQL query to remove an existent user with passed id
                    $query = " SELECT FUNC_Eliminar_utilizador(:id) as result";
                    // Criando objecto para conexão em PDO
                    $mysqlPDO = new MySQLPDO();
                    // Preparando a query
                    $statement = $mysqlPDO->getConnection()->prepare($query);
                    // Executa a query
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
        /* Fim utilizador */
        /**************************/
    }
