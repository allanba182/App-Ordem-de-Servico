<?php

    class OrdemServicoService
    {
        private $conexao;
        private $ordem_servico;

        public function __construct (Conexao $conexao, OrdemServico $ordem_servico)
        {
            $this->conexao = $conexao->conectar();
            $this->ordem_servico = $ordem_servico;
        }

        public function inserir()
        {
            $query =
            '
                insert into tb_os (motivo,id_equipamento,id_prestador,id_usuario) values (:motivo,:equipamento,:prestador,:usuario)
            ';

            $stmt = $this->conexao->prepare($query);

            $stmt->bindValue(':motivo', $this->ordem_servico->__get('motivo'));
            $stmt->bindValue(':equipamento', $this->ordem_servico->__get('id_equipamento'));
            $stmt->bindValue(':prestador', $this->ordem_servico->__get('id_prestador'));
            $stmt->bindValue(':usuario', $this->ordem_servico->__get('id_usuario'));

            $stmt->execute();
        }

        public function recuperarPendente()
        {
            
            $query =
            "
                SELECT O.id_os, CAST(O.data_abertura AS DATE) AS 'data_abertura', CAST(O.data_garantia AS DATE) AS 'data_garantia', O.motivo, E.numero_serie, T.tipo, P.fantasia, U.nome
                FROM tb_os O 
                LEFT JOIN tb_status S ON (O.id_status = S.id_status)
                LEFT JOIN tb_equipamento E ON (O.id_equipamento = E.id_equipamento)
                LEFT JOIN tb_tipo_equipamento T ON (E.id_tipo = T.id_tipo)
                LEFT JOIN tb_prestador P ON (O.id_prestador = P.id_prestador)
                LEFT JOIN tb_usuario U ON (O.id_usuario = U.id_usuario)
                AND O.id_status = 1
            ";
            

            $stmt = $this->conexao->prepare($query);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);


        }

        public function atualizar()
        {

        }

        public function remover()
        {
            
        }
    }

?>