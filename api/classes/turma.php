<?php
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
        function __construct(array $data)
        {
            $this->id        		= $data['id'];
            $this->nome      		= $data['nome'];
            $this->serie 			= $data['serie'];
            $this->id_utilizador 	= $data['id_utilizador'];
        }
        // Get Id
        function getId()
        {
            return $this->id;
        }
        // Get Nome
        function getNome()
        {
            return $this->nome;
        }
        // Get Serie
        function getSerie()
        {
            return $this->serie;
        }
		// Get Utilizador
        function getId_utilizador()
        {
            return $this->id_utilizador;
        }
        // Converte objecto em JSON
        public function jsonSerialize()
        {
            return get_object_vars($this);
        }
    }
?>
