<?php

    class TipoEquipamentoService
    {
        private $conexao;
        private $tipoEquipamento;

        public function __construct(Conexao $conexao, TipoEquipamento $tipoEquipamento)
        {
            $this->conexao = $conexao->conectar();
            $this->tipoEquipamento = $tipoEquipamento;
        }

        public function inserir()
        {
            $query = 
            '
                insert into tb_tipo_equipamento (tipo) values (:tipo)
            ';

            $stmt = $this->conexao->prepare($query);
            
            $stmt->bindValue(':tipo', $this->tipoEquipamento->__get('tipo') );
            $stmt->execute();

        }

        public function recuperar ()
        {
            $query = 
            '
                SELECT * FROM tb_tipo_equipamento WHERE id_status = 1
            ';

            $stmt = $this->conexao->prepare($query);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        public function atualizar ()
        {
            $query =
            '
                UPDATE tb_tipo_equipamento SET tipo = :tipo WHERE id_tipo = :id
            ';

            $stmt = $this->conexao->prepare($query);

            $stmt->bindValue(':tipo', $this->tipoEquipamento->__get('tipo'));
            $stmt->bindValue(':id', $this->tipoEquipamento->__get('id_tipo'));

            $stmt->execute();
        }

        public function remover()
        {
            $query = 
            '
                UPDATE tb_tipo_equipamento SET id_status = :status WHERE id_tipo = :id
            ';

            $stmt = $this->conexao->prepare($query);
            $stmt->bindValue(':status', $this->tipoEquipamento->__get('id_status'));
            $stmt->bindValue(':id', $this->tipoEquipamento->__get('id_tipo'));
            $stmt->execute();
        }
    }
?>