<?php

    require '../../app_ordem_servico/conexao.php';
    require '../../app_ordem_servico/prestador.model.php';
    require '../../app_ordem_servico/prestador.service.php';

    $acao = isset($_GET['acao'])? $acao = $_GET['acao'] : $acao = $acao;

    if($acao == 'inserir')
    {
        $conexao = new Conexao();
        $prestador = new Prestador();

        $prestador->__set('fantasia', $_POST['fantasia']);
        $prestador->__set('email', $_POST['email']);

        $prestadorService = new PrestadorService($conexao, $prestador);
        $prestadorService->inserir();

        header('Location: form_cadastro.php?cadastro=prestador&inclusao=1&inclusao=1');
    }

    if($acao == 'recuperar')
    {
        $conexao = new Conexao();
        $prestador = new Prestador();

        $prestadorService = new PrestadorService($conexao, $prestador);
        
        $prestadores = $prestadorService->recuperar();
    }
?>