<?php
    // Iniciar Seção
    session_start();
    // verifica se o utilizador está logado
    if (isset($_SESSION) && $_SESSION['views'] == 0)
    {
        // Utilizador não logado 
            header('Location: index.php');
    }
    else
    {
        // Atribuindo seção a uma variavel
        $id = $_SESSION[$_SESSION['views'].'id'];
        $usuario = $_SESSION[$_SESSION['views'].'usuario']; 
       
    }
?>