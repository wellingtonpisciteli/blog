<?php

namespace sistema\Controlador\Admin;

use sistema\Modelo\CategoriaModelo;
use sistema\Nucleo\Helpers;

class AdminCategorias extends AdminControlador{
    public function listar():void{
        $categoria=new CategoriaModelo();
        echo($this->template->renderizar('categorias/listar.html', [
            'categorias'=>$categoria->busca()->ordem('status ASC, id DESC')->resultado(true),
            'total'=>[
                'ativo'=>$categoria->total('status=1'),
                'inativo'=>$categoria->total('status=0'),
                'total'=>$categoria->total()
            ]
        ]));
    }

    public function cadastrar():void{
        if($_SERVER["REQUEST_METHOD"]=="POST"){
            $dados=filter_input_array(INPUT_POST, FILTER_DEFAULT);
            if(!empty($dados["titulo"]) && !empty($dados["texto"])){
                (new CategoriaModelo())->armazenar($dados);
                $this->mensagem->sucesso('Categoria cadastrado com sucesso!')->flash();
                Helpers::redirecionar('admin/categorias/listar');
            }
        }  
        echo($this->template->renderizar('categorias/formulario.html', []));
    }

    public function editar(int $id):void{
        $categoria=(new CategoriaModelo())->buscaPorId($id);
        
        if($_SERVER["REQUEST_METHOD"]=="POST"){
            $dados=filter_input_array(INPUT_POST, FILTER_DEFAULT);
            if(!empty($dados["titulo"]) && !empty($dados["texto"])){
                (new CategoriaModelo())->atualizar($dados, $id);
                $this->mensagem->sucesso('Categoria editado com sucesso!')->flash();
                Helpers::redirecionar('admin/categorias/listar');
            }
        }  
        echo($this->template->renderizar('categorias/formulario.html', [
            'categorias'=>$categoria
        ]));
    }

    public function apagar(int $id):void{
        (new CategoriaModelo())->deletar($id);
        $this->mensagem->sucesso('Categoria apagada!')->flash();
        Helpers::redirecionar('admin/categorias/listar');
    }
}