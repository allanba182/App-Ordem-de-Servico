<?php

    require_once '../../app_ordem_servico/includes.php';

    $prestador = new Prestador();

    if( $acao == 'inserir' )
    {

        $envia_email = isset($_POST['envia_email'])? $envia_email = 1 : $envia_email = 2;
        
        $prestador->__set('fantasia', $_POST['fantasia']);
        $prestador->__set('email', $_POST['email']);
        $prestador->__set('envia_email', $envia_email);


        $prestadorService = new PrestadorService($conexao, $prestador);
        $prestadorService->inserir();

        header('Location: form_cadastro.php?cadastro=prestador&inclusao=1&inclusao=1');
    }

    else if( $acao == 'recuperar' )
    {

        $prestadorService = new PrestadorService($conexao, $prestador);
        
        $prestadores = $prestadorService->recuperar();

    }

    else if( $acao == 'atualizar' )
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

    else if( $acao == 'remover' )
    {
        $prestador->__set('id_prestador', $_GET['id']);
        $prestador->__set('id_status', 2);

        $prestadorService= new PrestadorService($conexao, $prestador);
        $prestadorService->remover();

        header('Location: form_cadastro.php?cadastro=prestador');
    }
?>