<?php

    class Conexao
    {
        private $host = 'localhost';
        private $dbname = 'db_os';
        private $usuario = 'allan';
        private $senha = 'all0211a';

        public function conectar()
        {
            try 
            {
                $conexao = new PDO(
                    "mysql:host=$this->host;dbname=$this->dbname",
                    "$this->usuario",
                    "$this->senha"
                );

                return $conexao;
            } 
            catch (PDOException $e) 
            {
                echo '<e>' . $e->getMessage() . '</e>';
            }
        }
    }
?>