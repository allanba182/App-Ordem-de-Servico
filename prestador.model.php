<?php
    
    class Prestador
    {
        private $id_prestador;
        private $fantasia;
        private $email;
        private $envia_email;
        private $id_status;

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