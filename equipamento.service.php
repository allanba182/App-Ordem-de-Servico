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
            $query =
            '
                SELECT E.id_equipamento, E.numero_serie, T.tipo 
                FROM  tb_equipamento E
                LEFT JOIN tb_tipo_equipamento T ON (E.id_tipo = T.id_tipo)
            ';

            $stmt = $this->conexao->prepare($query);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_OBJ);

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
            $query = 
            '
                UPDATE tb_equipamento SET numero_serie = :serie WHERE id_equipamento = :id
            ';

            $stmt = $this->conexao->prepare($query);

            $stmt->bindValue(':serie', $this->equipamento->__get('numero_serie'));
            $stmt->bindValue(':id', $this->equipamento->__get('id_equipamento'));

            $stmt->execute();
        }

        public function remover()
        {

        }
    }

?>