<?php
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
        // Get Email
        function getEmail()
        {
            return $this->email;
        }
		// Get Email
        function getDataNasc()
        {
            return $this->data_nasc;
        }
		// Get Turma
        function getTurma()
        {
            return $this->turma;
        }
        // Get Turma ID
        function getId_turma()
        {
            return $this->id_turma;
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
