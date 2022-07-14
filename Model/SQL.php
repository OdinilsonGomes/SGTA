<?php

require_once("inc/mysql_pdo.php");

    // Classe Turma
    class SQL implements JsonSerializable
    {
      // Function to select in data base for all object
        public function SQLSelect($query, $parametr = [])
        {
            try {
				// Criação de objecto para conectar MySQL atravez do PDO
                $mysqlPDO = new MySQLPDO();
                // Prepare query
                $statement = $mysqlPDO->getConnection()->prepare($query);
                // Executando o query
                $statement->execute($parametr);
                // atribuindo o resultado a variavel rows
                $rows = $statement->fetchAll(\PDO::FETCH_ASSOC);
                // Converting to JSON
                if (isset($rows) && count($rows) > 0) {
                    // returning data sucess
                    return json_encode(array ('status'=>'success', 'dados'=>$rows));
                } else {
                    // returning mensage without data
                    return json_encode(array ('status'=>'501', 'dados'=>'Nenhuma Informação encontrada '));
                }
               
            } catch (PDOException $e) {
                return json_encode(array ('status'=>'500', 'dados'=>'Mensagem de erro '.$e));
            }
        }

        /* Function to execute operaction on data base */
        public function SQLExec($query, $parametr = [])
        {
            try {
                
                    // Criando objecto para conexão em PDO
                    $mysqlPDO = new MySQLPDO();
                    // Preparando a query
                    $statement = $mysqlPDO->getConnection()->prepare($query);
                    // Executando a query
                    $row =$statement->execute($parametr);
                    if ($row) {
                        return json_encode(array ('status'=>'success','dados'=>'Operação realizada com sucesso'));
                    } else {
                        //var_dump ($statement->errorInfo());
                        return json_encode(array ('status'=>'501', 'dados'=>'Não foi possivel realizar a operação'));
                    }
            } catch (PDOException $e) {
                return json_encode(array ('status'=>'500', 'dados'=>'Mensagem de erro '.$e));
            } 
        }
        /*Function to verify if object existe on database */
       public function is_OnDB($table,$id){
            try {
                $a=$id;
                $query="SELECT id FROM $table WHERE id_estado=1 AND id=$a ";   
                // Criando objecto para conexão em PDO
                $mysqlPDO = new MySQLPDO();
                // Preparando a query
                $statement = $mysqlPDO->getConnection()->prepare($query);
                // Executando a query
                $row =$statement->execute();
                
                if (isset($row) && count($row) > 0) {
                    return true;
                } else {
                    //var_dump ($statement->errorInfo());
                    return false;
                }
            } catch (PDOException $e) {
                //return json_encode(array ('status'=>'500', 'dados'=>'Mensagem de erro '.$e));
                return false;
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
