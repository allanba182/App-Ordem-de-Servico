<?php
    
    class Prestador
    {
        private $id_prestador;
        private $fantasia;
        private $email;

        public function __get($atributo)
        {
            return $this->$atributo;
        }

        public function __set($atributo, $valor)
        {
            $this->$atributo = $valor;
        }
    }

?>