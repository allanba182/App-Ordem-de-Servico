<?php

    require_once '../../app_ordem_servico/includes.php';

    $tipoEquipamento = new TipoEquipamento();

    if( $acao == 'inserir')
    {
        $_UP['pasta'] = './OS';
        
        mkdir($_UP['pasta'], 0777,true);
        chmod($_UP['pasta'], 0777);

        $tipoEquipamento->__set('tipo',$_POST['tipo']);

        $tipoEquipamentoService = new TipoEquipamentoService($conexao,$tipoEquipamento);
        $tipoEquipamentoService->inserir();

        //CRIANDO PASTA REFERENTE AO TIPO CADASTRADO NO BANCO
        $_UP['pasta'] = './OS/' . $tipoEquipamento->__get('tipo') . '/';
        mkdir($_UP['pasta'], 0777,true);
        chmod($_UP['pasta'], 0777);

        //REDIRECIONANDO USUARIO PARA TELA DE CADASTRO DE TIPO
        header('Location: form_cadastro.php?cadastro=tipo&inclusao=1');
    }

    else if( $acao == 'recuperar')
    {

        $tipoEquipamentoService = new TipoEquipamentoService($conexao, $tipoEquipamento);
        
        $tipos = $tipoEquipamentoService->recuperar();

    }

    else if( $acao == 'atualizar')
    {
        $tipoEquipamento->__set('id_tipo',$_POST['id']);
        $tipoEquipamento->__set('tipo',$_POST['tipo']);
        
        /* ATUALIZAÇÃO DA TABELA NO BANCO */
        $tipoEquipamentoService = new TipoEquipamentoService($conexao, $tipoEquipamento);
        $tipoEquipamentoService->atualizar();

        /* ATUALIZAÇÃO DO DIRETORIO */
        $nomeAntigo = './OS/' . $_POST['tipo_antigo'];
        $nomeNovo = './OS/' . $tipoEquipamento->__get('tipo');

        rename($nomeAntigo, $nomeNovo);

        header('Location: form_cadastro.php?cadastro=tipo');
    }

    else if ( $acao == 'remover')
    {
        $tipoEquipamento->__set('id_tipo', $_GET['id']);
        $tipoEquipamento->__set('id_status', 2);

        $tipoEquipamentoService = new TipoEquipamentoService($conexao, $tipoEquipamento);
        $tipoEquipamentoService->remover();

        header('Location: form_cadastro.php?cadastro=tipo ');
    }

?>