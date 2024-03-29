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
                INSERT INTO tb_os (problema,observacao,id_motivo,id_equipamento,id_prestador,id_usuario) values (:problema,:observacao,:motivo,:equipamento,:prestador,:usuario)
            ';
            
            $stmt = $this->conexao->prepare($query);

            $stmt->bindValue(':problema', $this->ordem_servico->__get('problema'));
            $stmt->bindValue(':observacao', $this->ordem_servico->__get('observacao'));
            $stmt->bindValue(':motivo', $this->ordem_servico->__get('id_motivo'));
            $stmt->bindValue(':equipamento', $this->ordem_servico->__get('id_equipamento'));
            $stmt->bindValue(':prestador', $this->ordem_servico->__get('id_prestador'));
            $stmt->bindValue(':usuario', $this->ordem_servico->__get('id_usuario'));

            $stmt->execute();

            return $this->conexao->lastInsertId();
        }

        public function recuperarPendente()
        {
            
            $query =
            "
                SELECT O.id_os, DATE_FORMAT(O.data_abertura, '%d/%m/%Y') AS 'data_abertura', DATE_FORMAT(O.data_garantia, '%d/%m/%Y') AS 'data_garantia', O.problema, O.observacao , M.motivo, O.reparos_realizados, O.valor, O.anexo, E.nome AS 'nome_equipamento', E.numero_serie, T.tipo, P.fantasia, U.nome
                FROM tb_os O 
                LEFT JOIN tb_motivo M ON (O.id_motivo = M.id_motivo)
                LEFT JOIN tb_status S ON (O.id_status = S.id_status)
                LEFT JOIN tb_equipamento E ON (O.id_equipamento = E.id_equipamento)
                LEFT JOIN tb_tipo_equipamento T ON (E.id_tipo = T.id_tipo)
                LEFT JOIN tb_prestador P ON (O.id_prestador = P.id_prestador)
                LEFT JOIN tb_usuario U ON (O.id_usuario = U.id_usuario)
                WHERE O.id_status = 3
            ";
            

            $stmt = $this->conexao->prepare($query);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_OBJ);


        }

        public function recuperarEmGarantia()
        {
            
            $query =
            "
                SELECT O.id_os, DATE_FORMAT(O.data_abertura, '%d/%m/%Y') AS 'data_abertura', DATE_FORMAT(O.data_garantia, '%d/%m/%Y') AS 'data_garantia', O.problema, O.observacao , M.motivo, O.reparos_realizados, O.valor, O.anexo, E.nome AS 'nome_equipamento', E.numero_serie, T.tipo, P.fantasia, U.nome
                FROM tb_os O
                LEFT JOIN tb_motivo M ON (O.id_motivo = M.id_motivo)
                LEFT JOIN tb_status S ON (O.id_status = S.id_status)
                LEFT JOIN tb_equipamento E ON (O.id_equipamento = E.id_equipamento)
                LEFT JOIN tb_tipo_equipamento T ON (E.id_tipo = T.id_tipo)
                LEFT JOIN tb_prestador P ON (O.id_prestador = P.id_prestador)
                LEFT JOIN tb_usuario U ON (O.id_usuario = U.id_usuario)
                WHERE O.data_garantia >= CURDATE()
                AND O.id_status = 4
            ";
            

            $stmt = $this->conexao->prepare($query);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_OBJ);


        }

        public function recuperarPorId()
        {
            
            $query =
            "
                SELECT O.id_os, DATE_FORMAT(O.data_abertura, '%d/%m/%Y') AS 'data_abertura', DATE_FORMAT(O.data_garantia, '%d/%m/%Y') AS 'data_garantia', O.problema, O.observacao , M.motivo, O.reparos_realizados, O.valor, O.anexo, E.nome AS 'nome_equipamento', E.numero_serie, T.tipo, P.fantasia, U.nome
                FROM tb_os O 
                LEFT JOIN tb_motivo M ON (O.id_motivo = M.id_motivo)
                LEFT JOIN tb_status S ON (O.id_status = S.id_status)
                LEFT JOIN tb_equipamento E ON (O.id_equipamento = E.id_equipamento)
                LEFT JOIN tb_tipo_equipamento T ON (E.id_tipo = T.id_tipo)
                LEFT JOIN tb_prestador P ON (O.id_prestador = P.id_prestador)
                LEFT JOIN tb_usuario U ON (O.id_usuario = U.id_usuario)
                WHERE O.id_os = :id
            ";
            

            $stmt = $this->conexao->prepare($query);
            $stmt->bindValue('id', $this->ordem_servico->__get('id_os'));
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_OBJ);


        }

        public function atualizar()
        {
            $query = 
            "
                UPDATE tb_os SET data_garantia = :garantia, reparos_realizados = :reparos, valor = :valor, anexo = :anexo, id_status = :id_status WHERE id_os = :os
            ";

            $stmt = $this->conexao->prepare($query);

            $stmt->bindValue(':garantia', $this->ordem_servico->__get('data_garantia'));
            $stmt->bindValue(':reparos', $this->ordem_servico->__get('reparos_realizados'));
            $stmt->bindValue(':valor', $this->ordem_servico->__get('valor'));
            $stmt->bindValue(':anexo', $this->ordem_servico->__get('anexo'));
            $stmt->bindValue(':id_status', $this->ordem_servico->__get('id_status'));
            $stmt->bindValue(':os', $this->ordem_servico->__get('id_os'));

            
            $stmt->execute();

        }

        public function atualizarId()
        {
            $query = 
            "
                UPDATE tb_os SET id_status = :id_status WHERE id_os = :os
            ";

            $stmt = $this->conexao->prepare($query);

            $stmt->bindValue(':id_status', $this->ordem_servico->__get('id_status'));
            $stmt->bindValue(':os', $this->ordem_servico->__get('id_os'));

            
            $stmt->execute();

        }

        public function remover()
        {
            $query = 
            '
                DELETE FROM tb_os WHERE id_os = :id
            ';

            $stmt = $this->conexao->prepare($query);
            $stmt->bindValue(':id', $this->ordem_servico->__get('id_os'));
            $stmt->execute();
            
        }
    }

?>