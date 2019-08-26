<?php

    require '../../app_ordem_servico/conexao.php';
    require '../../app_ordem_servico/prestador.model.php';
    require '../../app_ordem_servico/prestador.service.php';

    $conexao = new Conexao();
    $prestador = new Prestador();

    $acao = isset($_GET['acao'])? $acao = $_GET['acao'] : $acao = $acao;

    if($acao == 'inserir')
    {

        $envia_email = isset($_POST['envia_email'])? $envia_email = 1 : $envia_email = 2;
        
        $prestador->__set('fantasia', $_POST['fantasia']);
        $prestador->__set('email', $_POST['email']);
        $prestador->__set('envia_email', $envia_email);


        $prestadorService = new PrestadorService($conexao, $prestador);
        $prestadorService->inserir();

        header('Location: form_cadastro.php?cadastro=prestador&inclusao=1&inclusao=1');
    }

    if($acao == 'recuperar')
    {

        $prestadorService = new PrestadorService($conexao, $prestador);
        
        $prestadores = $prestadorService->recuperar();

    }

    if($acao == 'atualizar')
    {
        $envia_email = isset($_POST['envia_email'])? $envia_email = 1 : $envia_email = 2;
        
        $prestador->__set('id_prestador', $_POST['id']);
        $prestador->__set('fantasia', $_POST['fantasia']);
        $prestador->__set('email', $_POST['email']);
        $prestador->__set('envia_email', $envia_email);

        $prestadorService = new PrestadorService($conexao, $prestador);

        $prestadorService->atualizar();

        header('Location: form_cadastro.php?cadastro=prestador');

    }
?>