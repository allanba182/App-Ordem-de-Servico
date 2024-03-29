<?php

    class OrdemServico
    {
        private $id_os;
        private $data_abertura;
        private $data_garantia;
        private $problema;
        private $reparos_realizados;
        private $valor;
        private $anexo;
        private $observacao;
        private $id_motivo;
        private $id_status;
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