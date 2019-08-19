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
                select * from tb_tipo_equipamento
            ';

            $stmt = $this->conexao->prepare($query);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        public function atualizar ()
        {

        }

        public function remover()
        {

        }
    }
?>