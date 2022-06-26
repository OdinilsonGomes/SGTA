<?php
    if(isset($_GET["id"])){
        ini_set('memory_limit', '1024M'); // or you could use 1G
        require('mysql_pdo.php');
        // Get the id
        $form_data = array(
            ':id' => $_GET["id"]
        );
        // Select news by id
        $query = "
                select n.title, if(length(n.doc) > 0, n.doc, null) as doc
                from tnews n
                where n.id = :id;
                ";
        
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
            // Title and doc
            $title = $row["title"];
            $doc   = base64_encode($row["doc"]);
        }
        header('Content-type: application/pdf');
        header('Content-Disposition: inline; filename=temp.pdf');
        header('Content-Transfer-Encoding: binary');
        header('Accept-Ranges: bytes');
        @readfile("data:application/pdf;base64,$doc");
    }
?>