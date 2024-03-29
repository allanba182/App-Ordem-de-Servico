<?php

    class PrestadorService
    {
        private $conexao;
        private $prestador;

        public function __construct(Conexao $conexao, Prestador $prestador)
        {
            $this->conexao = $conexao->conectar();
            $this->prestador = $prestador;
        }

        public function inserir()
        {
            $query =
            '
                insert into tb_prestador(fantasia) values (:fantasia)
            ';

            $stmt = $this->conexao->prepare($query);
            $stmt->bindValue(':fantasia', $this->prestador->__get('fantasia'));
            $stmt->execute();

            $this->prestador->__set('id_prestador', $this->conexao->lastInsertId());

            
            $query =
            "
                insert into tb_email_prestador(email,id_status,id_prestador) values (:email,:enviar,:id)
            ";

            $stmt = $this->conexao->prepare($query);

            $stmt->bindValue(':email', $this->prestador->__get('email'));
            $stmt->bindValue(':enviar', $this->prestador->__get('envia_email'));
            $stmt->bindValue(':id', $this->prestador->__get('id_prestador'));
            
            $stmt->execute();

        }

        public function recuperar()
        {
            $query =
            '
                SELECT P.id_prestador, P.fantasia , E.id_email, E.email, S.status
                FROM tb_prestador P
                LEFT JOIN tb_email_prestador E ON (P.id_prestador = E.id_prestador)
                LEFT JOIN tb_status S ON (E.id_status = S.id_status)
                WHERE P.id_status = 1
            ';

            $stmt = $this->conexao->prepare($query);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_OBJ);

        }

        public function recuperarEmail($id)
        {
            $query =
            '
                SELECT * FROM tb_email_prestador WHERE id_prestador = :id
            ';

            $stmt = $this->conexao->prepare($query);
            $stmt->bindValue(':id', $id);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_OBJ);

        }

        public function atualizar()
        {
            $query = 
            '
                UPDATE tb_prestador SET fantasia = :fantasia WHERE id_prestador = :id
            ';

            $stmt = $this->conexao->prepare($query);

            $stmt->bindValue(':fantasia', $this->prestador->__get('fantasia'));
            $stmt->bindValue(':id', $this->prestador->__get('id_prestador'));

            $stmt->execute();

            $query = 
            '
                UPDATE tb_email_prestador SET email = :email, id_status=:enviar WHERE id_prestador = :id
            ';

            $stmt = $this->conexao->prepare($query);

            $stmt->bindValue(':email', $this->prestador->__get('email'));
            $stmt->bindValue(':enviar', $this->prestador->__get('envia_email'));
            $stmt->bindValue(':id', $this->prestador->__get('id_prestador'));

            $stmt->execute();
        }

        public function remover()
        {
            $query = 
            '
                UPDATE tb_prestador SET id_status = :status WHERE id_prestador = :id
            ';

            $stmt = $this->conexao->prepare($query);
            $stmt->bindValue(':status', $this->prestador->__get('id_status'));
            $stmt->bindValue(':id', $this->prestador->__get('id_prestador'));
            $stmt->execute();
        }
    }

?>