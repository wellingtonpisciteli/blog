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
        // Verifica se o método da requisição é POST //teste git
        if ($_SERVER["REQUEST_METHOD"]=="POST") {
            //Coleta todos os dados enviados via método POST e os filtra usando o filtro padrão do PHP. 
            $dados=filter_input_array(INPUT_POST, FILTER_DEFAULT);
            //Verifica se os campos não estão vazios.
            if(!empty($dados["titulo"]) && !empty($dados["texto"])){
                //Armazena os dados.
                (new PostModelo())->armazenar($dados);
                $this->mensagem->sucesso('Post cadastrado com sucesso!')->flash();
                Helpers::redirecionar('admin/posts/listar');
            }
        }     
        // Renderiza o template com as categorias
        echo($this->template->renderizar('posts/formulario.html', [
            //Categorias = Array associativo que recebe o res do método busca().
            'categorias'=>(new CategoriaModelo())->buscaAtiva('status=1')->ordem('titulo ASC')->resultado(true)
        ]));
    }

    public function editar(int $id):void{
        $post=(new PostModelo())->buscaPorId($id);

        if ($_SERVER["REQUEST_METHOD"]=="POST") {
            $dados=filter_input_array(INPUT_POST, FILTER_DEFAULT);
            if(!empty($dados["titulo"]) && !empty($dados["texto"])){
                (new PostModelo())->atualizar($dados, $id);
                $this->mensagem->sucesso('Post editado com sucesso!')->flash();
                Helpers::redirecionar('admin/posts/listar');
            }
        }     
        echo($this->template->renderizar('posts/formulario.html', [
            'posts'=>$post,
            'categorias'=>(new CategoriaModelo())->buscaAtiva('status=1')->ordem('titulo ASC')->resultado(true)
        ]));
    }

    public function apagar(int $id):void{
        (new PostModelo())->deletar($id);
        $this->mensagem->sucesso('Post apagado!')->flash();
        Helpers::redirecionar('admin/posts/listar');
    }   
}