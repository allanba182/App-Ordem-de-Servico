<?php

    class OrdemServico
    {
        private $id_os;
        private $data_abertura;
        private $data_garantia;
        private $motivo;
        private $id_equipamento;
        private $id_prestador;
        private $id_usuario;

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