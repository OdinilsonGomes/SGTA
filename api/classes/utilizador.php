<?php
    // User class
    class Utilizador implements JsonSerializable
    {
        private $id;
        private $usuario;
        private $senha;
        /* 
        This constructor create a new user object
        */
        function __construct(array $data)
        {
            $this->id       	= $data['id'];
            $this->usuario 		= $data['usuario'];
            $this->senha 		= $data['senha'];
        }
        // Get Id
        function getId()
        {
            return $this->id;
        }
        // Get Usuario
        function getUsuario()
        {
            return $this->usuario;
        }
        // Get Senha
        function getSenha()
        {
            return $this->senha;
        }
        // Converte objecto em JSON
        public function jsonSerialize()
        {
            return get_object_vars($this);
        }
    }
?>
