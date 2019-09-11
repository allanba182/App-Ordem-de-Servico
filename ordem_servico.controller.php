<?php

    require_once '../../app_ordem_servico/includes.php';

    $os = new OrdemServico();

    if($acao == 'recuperar form')
    {

        // TIPOS DE EQUIPAMENTO
        $tipo = new TipoEquipamento();
        $tipoService = new TipoEquipamentoService($conexao,$tipo);
        $tipos = $tipoService->recuperar();

        // PRESTADORES DE SERVIÇO
        $prestador = new Prestador();
        $prestadorService = new PrestadorService($conexao, $prestador);
        $prestadores = $prestadorService->recuperar();

        //MOTIVOS
        $motivo = new Motivo();
        $motivoService = new MotivoService($conexao,$motivo);
        $motivos = $motivoService->recuperar();

        if( isset($_GET['tipo']) )
        {
            //RECUPERANDO EQUIPAMENTOS BASEADO NO TIPO
            $equipamento = new Equipamento();
            $equipamentoService = new EquipamentoService($conexao, $equipamento);
            $equipamentos = $equipamentoService->recuperarPorTipo($_GET['tipo']);
        }

    }

    else if($acao == 'inserir')
    {
        session_start();

        $os = new OrdemServico();
        
        $os->__set('problema',$_POST['problema']);
        $os->__set('observacao',$_POST['observacao']);
        $os->__set('id_motivo',$_POST['motivo']);
        $os->__set('id_equipamento',$_POST['equipamento']);
        $os->__set('id_prestador',$_POST['prestador']);
        $os->__set('id_usuario',$_SESSION['id']);
        
        echo '<pre>';
        print_r($os);
        echo '</pre>';

        $osService = new OrdemServicoService($conexao, $os);
        $id_os = $osService->inserir();

          //INSTANCIANDO PRESTADOR PARA ENVIO DE EMAIL
        $prestador = new Prestador();
        $prestadorService = new PrestadorService($conexao, $prestador);

        $prestadores = $prestadorService->recuperarEmail($os->__get('id_prestador'));

        foreach ($prestadores as $indice => $prestadorOBJ) 
        {
            $prestador->__set('id_prestador',$prestadorOBJ->id_prestador);
            $prestador->__set('email',$prestadorOBJ->email);
        }
        
        //INSTANCIANDO USUARIO PARA ENVIO DE EMAIL
        $usuario = new Usuario();
        $usuario->__set('email', $_SESSION['email']);

        //INSTANCIANDO EMAIL
        $email = new Mensagem($prestador, $usuario);
        //$email->enviarEmail();


        header("Location: abrir_os.php?inclusao=1&os=$id_os");
        
    }

    else if( $acao == 'recuperar')
    {

        $osService = new OrdemServicoService($conexao, $os);

        /* O.S. PENDENTE */
        $osPendente = $osService->recuperarPendente();

        /* O.S. EM GARANTIA DE SERVIÇO */
        $osGarantia = $osService->recuperarEmGarantia();

        
    }

    else if( $acao == 'atualizar')
    {

        $os->__set('id_status','4');
        $os->__set('id_os',$_POST['id_os']);
        $os->__set('data_garantia',$_POST['data_garantia']);
        $os->__set('reparos_realizados',$_POST['reparos_realizados']);
        $os->__set('valor', $_POST['valor']);

        $data = str_replace('/','',$_POST['data_abertura']);

        /* Alterando o nome do arquivo */
        $arquivo = 'OS_' . $_POST['id_os'] . '_' . $data . '.pdf';
        
        //Diretório onde o arquivo vai ser salvo
        $diretorio = './OS/' . $_POST['tipo'] . '/' . $_POST['serie'] . '/';

        echo '<pre>';
        print_r($_FILES['anexo']);
        echo '</pre>';

        //MOVE O ARQUIVO PARA O DIRETORIO
        if( move_uploaded_file($_FILES['anexo']['tmp_name'], $diretorio.$arquivo) )
        {
            $os->__set('anexo',$arquivo);        

            $osService = new OrdemServicoService($conexao,$os);
            $osService->atualizar();

            header('Location: home.php');
        }
        else
        {
            print_r($diretorio.$arquivo);
            //header('Location: home.php?log=erro');
        }
    }

    else if( $acao == 'reabrir')
    {

        $os->__set('id_status','3');
        $os->__set('id_os',$_POST['id_os']);


        $osService = new OrdemServicoService($conexao, $os);
        $osService->atualizarId();

        header('Location: home.php');        
    }

    else if ( $acao == 'remover')
    {
        $os->__set('id_os', $_GET['id']);

        $osService = new OrdemServicoService($conexao, $os);
        $osService->remover();

        header('Location: home.php');
    }

    else if( $acao == 'download')
    {
        $os->__set('id_os',$_GET['os']);

        $osService = new OrdemServicoService($conexao, $os);
        $os = $osService->recuperarPorId();

        require_once '../../app_ordem_servico/geraPDF.php';
    }
?>