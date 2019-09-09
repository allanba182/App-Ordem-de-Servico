<?php

    class MotivoService
    {
        private $conexao;
        private $motivo;

        public function __construct(Conexao $conexao, Motivo $motivo)
        {
            $this->conexao = $conexao->conectar();
            $this->motivo = $motivo;
        }

        public function inserir()
        {

        }

        public function recuperar()
        {
            $query = 
            '
                SELECT * FROM tb_motivo
            ';

            $stmt = $this->conexao->prepare($query);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        public function atualizar()
        {

        }

        public function remover()
        {

        }

    }
?>