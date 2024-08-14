<?php

namespace sistema\Controlador\Admin;

use sistema\Modelo\PostModelo;
use sistema\Modelo\UsuarioModelo;
use sistema\Nucleo\Sessao;
use sistema\Nucleo\Helpers;

class AdminDashboard extends AdminControlador{
    
    public function dashboard():void{
        $post=new PostModelo();
        $usuarios=new UsuarioModelo();
        
        echo($this->template->renderizar('dashboard.html', [
            'posts'=>[
                'total'=>$post->busca()->total(),
                'ativo'=>$post->busca('status=1')->total(),
                'inativo'=>$post->busca('status=0')->total()
            ],
            'usuarios'=>[
                'total'=>$usuarios->busca()->total(),
                'ativo'=>$usuarios->busca('status=1')->total(),
                'inativo'=>$usuarios->busca('status=0')->total()
            ]
        ]));
    }

    public function sair():void{
        $sessao=new Sessao();
        $sessao->limpar("usuarioId");

        $this->mensagem->informa("Você saiu do Painel de Controle!")->flash();

        Helpers::redirecionar('admin/login');
    }
}