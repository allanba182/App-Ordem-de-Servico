<?php

    require '../../app_ordem_servico/conexao.php';
    require '../../app_ordem_servico/tipo_equipamento.model.php';
    require '../../app_ordem_servico/tipo_equipamento.service.php';

    $acao = isset($_GET["acao"])? $acao = $_GET["acao"] : $acao = $acao;

    if( $acao == 'inserir')
    {
        $conexao = new Conexao();
        $tipoEquipamento = new TipoEquipamento();
        $tipoEquipamento->__set('tipo',$_POST['tipo']);

        $tipoEquipamentoService = new TipoEquipamentoService($conexao,$tipoEquipamento);
        $tipoEquipamentoService->inserir();

        //CRIANDO PASTA REFERENTE AO TIPO CADASTRADO NO BANCO
        $_UP['pasta'] = '../../OS/' . $tipoEquipamento->__get('tipo') . '/';
        mkdir($_UP['pasta'], 0777,true);
        chmod($_UP['pasta'], 0777);



        //REDIRECIONANDO USUARIO PARA TELA DE CADASTRO DE TIPO
        header('Location: form_cadastro.php?cadastro=tipo&inclusao=1');


    }

    if( $acao == 'recuperar')
    {
        $conexao = new Conexao();
        $tipoEquipamento = new TipoEquipamento();

        $tipoEquipamentoService = new TipoEquipamentoService($conexao, $tipoEquipamento);
        
        $tipos = $tipoEquipamentoService->recuperar();

    }


?>