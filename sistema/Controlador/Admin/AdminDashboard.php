<?php

namespace sistema\Controlador\Admin;

use sistema\Modelo\CategoriaModelo;
use sistema\Modelo\PostModelo;
use sistema\Modelo\UsuarioModelo;
use sistema\Nucleo\Sessao;
use sistema\Nucleo\Helpers;

class AdminDashboard extends AdminControlador{
    
    public function dashboard():void{
        $post=new PostModelo();
        $usuarios=new UsuarioModelo();
        $categorias=new CategoriaModelo();
        
        echo($this->template->renderizar('dashboard.html', [
            'posts'=>[
                'posts'=>$post->busca()->ordem('id DESC')->limite(3)->resultado(true),
                'total'=>$post->busca()->total(),
                'ativo'=>$post->busca('status=1')->total(),
                'inativo'=>$post->busca('status=0')->total(),
            ],
            
            'categorias'=>[
                'categorias'=>$categorias->busca()->ordem('id DESC')->limite(5)->resultado(true),
                'total'=>$categorias->busca()->total(),
                'ativo'=>$categorias->busca('status=1')->total(),
                'inativo'=>$categorias->busca('status=0')->total(),
            ],
            'usuarios'=>[
                'usuarios'=>$usuarios->busca('level!=3')->ordem('ultimo_login DESC')->limite(3)->resultado(true),
                'total'=>$usuarios->busca('level!=3')->total(),
                'ativo'=>$usuarios->busca('status=1 AND level!=3')->total(),
                'inativo'=>$usuarios->busca('status=0 AND level!=3')->total()
            ],
            'admin'=>[
                'admin'=>$usuarios->busca('level=3')->ordem('ultimo_login DESC')->limite(3)->resultado(true),
                'total'=>$usuarios->busca('level=3')->total(),
                'ativo'=>$usuarios->busca('status=1 AND level=3')->total(),
                'inativo'=>$usuarios->busca('status=0 AND level=3')->total(),
            ],
        ]));
    }

    public function sair():void{
        $sessao=new Sessao();
        $sessao->limpar("adminUsuario");

        $this->mensagem->informa("Você saiu do Painel de Controle!")->flash();

        Helpers::redirecionar('admin/login');
    }
}