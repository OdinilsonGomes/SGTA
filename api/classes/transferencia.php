<?php
    // Classe Transferencia
    class Transferencia implements JsonSerializable
    {
        private $id;
        private $data;
        private $motivo;
        private $aluno;
        private $turma_anterior;
        private $turma_destino;
        private $id_aluno;
        private $id_turma_anterior;
        private $id_turma_destino;
        private $id_utilizador;
        /*
        Este Construtor cria um novo objecto Transferencia
        */
        public function __construct(array $data)
        {
            $this->id    				= $data['id'];
            $this->data  				= $data['data'];
            $this->motivo  				= $data['motivo'];
            $this->aluno  				= $data['aluno'];
            $this->turma_anterior  		= $data['turma_anterior'];
            $this->turma_destino  		= $data['turma_destino'];
            $this->id_aluno  			= $data['id_aluno'];
            $this->id_turma_anterior  	= $data['id_turma_anterior'];
            $this->id_turma_destino  	= $data['id_turma_destino'];
            $this->id_utilizador  		= $data['id_utilizador'];
        }
        // Get Id
        public function getId()
        {
            return $this->id;
        }
        // Get Data
        public function getData()
        {
            return $this->data;
        }
		// Get Motivo
        public function getMotivo()
        {
            return $this->motivo;
        }
		// Get Aluno ID
        public function getId_aluno()
        {
            return $this->id_aluno;
        }
		// Get Aluno
        public function getAluno()
        {
            return $this->aluno;
        }
		// Get Turma anterior ID
        public function getId_tuma_anterior()
        {
            return $this->id_turma_anterior;
        }
		// Get Turma destino ID
        public function getId_turma_destino()
        {
            return $this->id_turma_destino;
        }
		// Get Turma anterior
        public function getTurma_anterior()
        {
            return $this->turma_anterior;
        }
		// Get Turma destino
        public function getTurma_destino()
        {
            return $this->turma_destino;
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
   