<?php

    require '../../app_ordem_servico/conexao.php';
    require '../../app_ordem_servico/usuario.model.php';
    require '../../app_ordem_servico/usuario.service.php';

    $conexao = new Conexao();
    $usuario = new Usuario();

    $acao = isset($_GET["acao"])? $acao = $_GET["acao"] : $acao = $acao;
    

    if($acao == "logar")
    {
        session_start();
        $autenticado = false;

        $usuarioService = new UsuarioService($conexao, $usuario);
        $usuarios = $usuarioService->recuperar();

        foreach ($usuarios as $indice => $user) 
        {
            if($user->usuario == $_POST['usuario'] && $user->senha == $_POST['senha'])
            {
                $autenticado = true;
                $usuario->__set('id',$user->id_usuario);
                $usuario->__set('nome',$user->nome);
                $usuario->__set('email',$user->email);
            }
        }

        if( $autenticado )
        {
            $_SESSION['autenticado'] = 'verdadeiro';
            $_SESSION['id'] = $usuario->id;
            $_SESSION['nome'] = $usuario->nome;
            $_SESSION['email'] = $usuario->email;

            header("Location:home.php");
        }
        else {
            header("Location:index.php?login=erro");
        }

        
    }

    else if($acao == 'inserir')
    {

        $usuario->__set('nome', $_POST['nome']);
        $usuario->__set('email', $_POST['email']);
        $usuario->__set('usuario', $_POST['usuario']);
        $usuario->__set('senha', $_POST['senha']);

        $usuarioService = new UsuarioService($conexao, $usuario);
        $usuarioService->inserir();

        header('Location: form_cadastro.php?cadastro=usuario&inclusao=1');

    }

    else if($acao == 'recuperar')
    {
        $conexao = new Conexao();
        $usuario = new Usuario();

        $usuarioService = new UsuarioService($conexao, $usuario);
        $usuarios = $usuarioService->recuperar();
    }

    else if($acao == 'atualizar')
    {
        $usuario->__set('id_usuario', $_POST['id']);
        $usuario->__set('nome', $_POST['nome']);
        $usuario->__set('email', $_POST['email']);
        $usuario->__set('usuario', $_POST['usuario']);
        $usuario->__set('senha', $_POST['senha']);

        $usuarioService = new UsuarioService($conexao, $usuario);
        $usuarioService->atualizar();

        header('Location: form_cadastro.php?cadastro=usuario');


    }

?>