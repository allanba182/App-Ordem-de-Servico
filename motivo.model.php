<?php

    class Motivo
    {
        private $id_motivo;
        private $motivo;

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