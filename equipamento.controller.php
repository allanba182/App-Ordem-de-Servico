<?php

    $path = '../../app_ordem_servico/';
    require '../../app_ordem_servico/conexao.php';

    require '../../app_ordem_servico/equipamento.model.php';
    require '../../app_ordem_servico/equipamento.service.php';

    require '../../app_ordem_servico/tipo_equipamento.model.php';
    require '../../app_ordem_servico/tipo_equipamento.service.php';
    
    $conexao = new Conexao();
    $equipamento = new Equipamento();

    $acao = isset($_GET['acao'])? $acao = $_GET['acao'] : $acao = $acao;

    if( $acao == 'inserir')
    {

        $equipamento->__set('nome', $_POST['nome']);
        $equipamento->__set('numero_serie', $_POST['serie']);
        $equipamento->__set('id_tipo', $_POST['tipo']);

        $equipamentoService = new EquipamentoService($conexao, $equipamento);
        $equipamentoService->inserir();

        //RECUPERANDO TIPO EQUIPAMENTO PARA CRIAÇÃO DA PASTA
        $tipo_equipamento = new TipoEquipamento();
        $tipo_equipamentoService = new TipoEquipamentoService($conexao, $tipo_equipamento);
        $tipoEquipamento = $tipo_equipamentoService->recuperar();

        foreach ($tipoEquipamento as $key => $tipo) 
        {
            if( $tipo->id_tipo == $equipamento->__get('id_tipo') )
                $tipo_equipamento->__set('tipo',$tipo->tipo);
        }
        
        //CRIANDO PASTA REFERENTE AO TIPO CADASTRADO NO BANCO
        $_UP['pasta'] = '../../OS/' . $tipo_equipamento->__get('tipo') . '/' . $equipamento->__get('numero_serie') . '/';
        mkdir($_UP['pasta'], 0777,true);
        chmod($_UP['pasta'], 0777);


        //REDIRECIONANDO USUARIO PARA TELA DE CADASTRO DE TIPO
        header('Location:form_cadastro.php?cadastro=equipamento&inclusao=1');
    }

    else if( $acao == 'recuperar')
    {

        $equipamentoService = new EquipamentoService($conexao,$equipamento);
        $equipamentos = $equipamentoService->recuperar();

        $tipo = new TipoEquipamento();
        $tipoService = new TipoEquipamentoService($conexao, $tipo);
        $tipos = $tipoService->recuperar();
    }

    else if( $acao == 'atualizar')
    {
        $equipamento->__set('id_equipamento', $_POST['id']);
        $equipamento->__set('numero_serie', $_POST['numero_serie']);

        /* ATUALIZAÇÃO DA TABELA NO BANCO */
        $equipamentoService = new EquipamentoService($conexao,$equipamento);
        $equipamentoService->atualizar();

        /* ATUALIZAÇÃO DO DIRETORIO */
        $nomeAntigo = '../../OS/' . $_POST['tipo'] . '/' . $_POST['numero_serie_antigo'];
        $nomeNovo = '../../OS/' . $_POST['tipo'] . '/' . $equipamento->__get('numero_serie');

        rename($nomeAntigo, $nomeNovo);

        header('Location:form_cadastro.php?cadastro=equipamento');

    }

?>