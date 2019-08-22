<?php

    class UsuarioService
    {
        private $conexao;
        private $usuario;

        public function __construct(Conexao $conexao, Usuario $usuario)
        {
            $this->conexao = $conexao->conectar();
            $this->usuario = $usuario;
        }

        public function inserir()
        {
            $query =
            '
                insert into tb_usuario(nome,email,usuario,senha) values (:nome, :email, :usuario, :senha)
            ';

            $stmt = $this->conexao->prepare($query);

            $stmt->bindValue(':nome',$this->usuario->__get('nome'));
            $stmt->bindValue('email',$this->usuario->__get('email'));
            $stmt->bindValue('usuario',$this->usuario->__get('usuario'));
            $stmt->bindValue('senha',$this->usuario->__get('senha'));

            $stmt->execute();

        }

        public function recuperar()
        {
            $query = 
            '
                SELECT * FROM tb_usuario
            ';
        
            $stmt = $this->conexao->prepare($query);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_OBJ);

        }

        public function atualizar()
        {
            $query =
            '
                UPDATE tb_usuario SET
                nome = :nome,
                email = :email,
                usuario = :usuario,
                senha = :senha
                WHERE id_usuario = :id

            ';

            $stmt = $this->conexao->prepare($query);

            $stmt->bindValue(':nome', $this->usuario->__get('nome'));
            $stmt->bindValue(':email', $this->usuario->__get('email'));
            $stmt->bindValue(':usuario', $this->usuario->__get('usuario'));
            $stmt->bindValue(':senha', $this->usuario->__get('senha'));
            $stmt->bindValue(':id', $this->usuario->__get('id_usuario'));

            $stmt->execute();
        }

        public function remover()
        {

        }
        
    }

?>