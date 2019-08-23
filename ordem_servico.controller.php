<?php

    require '../../app_ordem_servico/conexao.php';
    require '../../app_ordem_servico/ordem_servico.service.php';
    require '../../app_ordem_servico/ordem_servico.model.php';
    // REQUERINDO PRESTADOR
    require '../../app_ordem_servico/prestador.model.php';
    require '../../app_ordem_servico/prestador.service.php';
    // REQUERINDO TIPO EQUIPAMENTO
    require '../../app_ordem_servico/tipo_equipamento.model.php';
    require '../../app_ordem_servico/tipo_equipamento.service.php';
    // REQUERINDO EQUIPAMENTO
    require '../../app_ordem_servico/equipamento.model.php';
    require '../../app_ordem_servico/equipamento.service.php';
    //REQUERINDO MENSAGEM
    require '../../app_ordem_servico/mensagem.php';

    //REQUERINDO USUARIO
    require '../../app_ordem_servico/usuario.model.php';

    $conexao = new Conexao();
    $os = new OrdemServico();

    $acao = isset($_GET['acao'])? $acao = $_GET['acao'] : $acao = $acao;

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

        $os->__set('motivo',$_POST['motivo']);
        $os->__set('id_equipamento',$_POST['equipamento']);
        $os->__set('id_prestador',$_POST['prestador']);
        $os->__set('id_usuario',$_SESSION['id']);
        
        $osService = new OrdemServicoService($conexao, $os);
        $osService->inserir();


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
        
        header('Location: abrir_os.php?inclusao=1');
    }

    else if($acao == 'recuperar')
    {

        $osService = new OrdemServicoService($conexao, $os);

        /* O.S. PENDENTE */
        $osPendente = $osService->recuperarPendente();

        /* O.S. EM GARANTIA DE SERVIÇO */
        $osGarantia = $osService->recuperarEmGarantia();

        
    }

    else if($acao == 'atualizar')
    {

        $os->__set('id_status','2');
        $os->__set('id_os',$_POST['id_os']);
        $os->__set('data_garantia',$_POST['data_garantia']);
        $os->__set('reparos_realizados',$_POST['reparos_realizados']);
        $os->__set('valor', $_POST['valor']);

        
        $arquivo = $_FILES['anexo']['size'] > 0? $_FILES['anexo'] : FALSE;

        if($arquivo)
        {
            /* Alterando o nome do arquivo */
            $arquivo['name'] = 'OS_' . $_POST['id_os'] . '_' . $_POST['data_abertura'];
            
            //Diretório onde o arquivo vai ser salvo
            $diretorio = '../../OS/' . $_POST['tipo'] . '/' . $_POST['serie'] . '/';

            //MOVE O ARQUIVO PARA O DIRETORIO
            move_uploaded_file($arquivo['tmp_name'], $diretorio.$arquivo['name']);
 
            $os->__set('anexo',$arquivo['name']);        
        }
        else
        {            
           $os->__set('anexo',null);
                       
        }

        $osService = new OrdemServicoService($conexao,$os);
        $osService->atualizar();

        header('Location: home.php');
            
    }
?>