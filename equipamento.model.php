<?php

    class Equipamento
    {
        private $id_equipamento;
        private $nome;
        private $numero_serie;
        private $id_tipo;

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