<?php

    $path = '../../app_ordem_servico/';

    // REQUERINDO CONEXAO
    require_once $path . 'conexao.php';

    // REQUERINDO ORDEM DE SERVIÇO
    require_once $path . 'ordem_servico.service.php';
    require_once $path . 'ordem_servico.model.php';

    // REQUERINDO PRESTADOR
    require_once $path . 'prestador.model.php';
    require_once $path . 'prestador.service.php';

    // REQUERINDO TIPO EQUIPAMENTO
    require_once $path . 'tipo_equipamento.model.php';
    require_once $path . 'tipo_equipamento.service.php';

    // REQUERINDO EQUIPAMENTO
    require_once $path . 'equipamento.model.php';
    require_once $path . 'equipamento.service.php';

    //REQUERINDO MENSAGEM
    require_once $path . 'mensagem.php';

    //REQUERINDO USUARIO
    require_once $path . 'usuario.model.php';
    require_once $path . 'usuario.service.php';

    //REQUERINDO MOTIVO
    require_once $path . 'motivo.model.php';
    require_once $path . 'motivo.service.php';


    // CRIANDO UMA ACAO
    $acao = isset($_GET['acao'])? $acao = $_GET['acao'] : $acao = $acao;

    // CRIANDO CONEXAO
    $conexao = new Conexao();

?>