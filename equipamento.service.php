<?php

    class EquipamentoService
    {
        private $conexao;
        private $equipamento;

        public function __construct(Conexao $conexao, Equipamento $equipamento)
        {
            $this->conexao = $conexao->conectar();
            $this->equipamento = $equipamento;
        }

        public function inserir()
        {
            $query =
            '
                insert into tb_equipamento (numero_serie,id_tipo) values (:serie,:tipo)
            ';

            $stmt = $this->conexao->prepare($query);

            $stmt->bindValue(':serie', $this->equipamento->__get('numero_serie'));
            $stmt->bindValue(':tipo', $this->equipamento->__get('id_tipo'));

            $stmt->execute();

        }

        public function recuperar()
        {

        }

        public function recuperarPorTipo($tipo)
        {
            $query =
            '
                select * from tb_equipamento where id_tipo = :tipo
            ';

            $stmt = $this->conexao->prepare($query);
            $stmt->bindValue(':tipo', $tipo);
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