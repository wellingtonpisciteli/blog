<?php

namespace sistema\Controlador\Admin;

use sistema\Modelo\PostModelo;
use sistema\Modelo\CategoriaModelo;
use sistema\Nucleo\Helpers;

class AdminPosts extends AdminControlador{
    public function listar():void{
        $post=new PostModelo();
        echo($this->template->renderizar('posts/listar.html', [
            'posts'=>$post->busca()->ordem('status ASC, id DESC')->resultado(true),
            'total'=>[
                'ativo'=>$post->total('status=1'),
                'inativo'=>$post->total('status=0'),
                'total'=>$post->total()
            ]
        ]));
    }

    public function cadastrar():void{
        if ($_SERVER["REQUEST_METHOD"]=="POST") {
            $dados=filter_input_array(INPUT_POST, FILTER_DEFAULT);
            if(!empty($dados["titulo"]) && !empty($dados["texto"])){
                $post=new PostModelo();

                $post->titulo=$dados['titulo'];
                $post->categoria_id=$dados['categoria_id'];
                $post->texto=$dados['texto'];
                $post->status=$dados['status'];

                if($post->salvar()){
                    $this->mensagem->sucesso('Post cadastrado com sucesso!')->flash();
                    Helpers::redirecionar('admin/posts/listar');
                }
            }
        }     
        echo($this->template->renderizar('posts/formulario.html', [
            'categorias'=>(new CategoriaModelo())->buscaAtiva('status=1')->ordem('titulo ASC')
        ]));
    }

    public function editar(int $id):void{
        $post=(new PostModelo())->buscaPorId($id);

        if ($_SERVER["REQUEST_METHOD"]=="POST") {

            $dados=filter_input_array(INPUT_POST, FILTER_DEFAULT);

            if(!empty($dados["titulo"]) && !empty($dados["texto"])){
                
                $post=(new PostModelo())->buscaPorId($id);

                $post->titulo=$dados['titulo'];
                $post->categoria_id=$dados['categoria_id'];
                $post->texto=$dados['texto'];
                $post->status=$dados['status'];

                if($post->salvar()){
                    $this->mensagem->sucesso('Post atualizado com sucesso!')->flash();
                    Helpers::redirecionar('admin/posts/listar');
                }
            }
        }     
        echo($this->template->renderizar('posts/formulario.html', [
            'posts'=>$post,
            'categorias'=>(new CategoriaModelo())->busca('status=1')->resultado(true)
        ]));
    }

    public function apagar(int $id):void{
        (new PostModelo())->deletar($id);
        $this->mensagem->sucesso('Post apagado!')->flash();
        Helpers::redirecionar('admin/posts/listar');
    }   
}