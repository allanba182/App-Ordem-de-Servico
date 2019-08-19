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

            $prestadores = $this->recuperar();

            foreach ($prestadores as $indice => $prestador) 
            {
                if($prestador->fantasia == $this->prestador->__get('fantasia'))
                {
                    $this->prestador->__set('id_prestador',$prestador->id_prestador);
                }
            }
            

            $query =
            '
                insert into tb_email_prestador(email,id_prestador) values (:email,:id)
            ';

            
            $stmt = $this->conexao->prepare($query);
            $stmt->bindValue(':email', $this->prestador->__get('email'));
            $stmt->bindValue(':id', $this->prestador->__get('id_prestador'));
            $stmt->execute();

        }

        public function recuperar()
        {
            $query =
            '
                select * from tb_prestador
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

        }

        public function remover()
        {

        }
    }

?>