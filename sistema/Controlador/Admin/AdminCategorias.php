<?php

namespace sistema\Controlador\Admin;

use sistema\Modelo\CategoriaModelo;
use sistema\Nucleo\Helpers;

class AdminCategorias extends AdminControlador{
    public function listar():void{
        echo($this->template->renderizar('categorias/listar.html', [
            'categorias'=>(new CategoriaModelo())->busca()
        ]));
    }

    public function cadastrar():void{
        if($_SERVER["REQUEST_METHOD"]=="POST"){
            $dados=filter_input_array(INPUT_POST, FILTER_DEFAULT);
            if(!empty($dados["titulo"]) && !empty($dados["texto"])){
                (new CategoriaModelo())->armazenar($dados);
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
                Helpers::redirecionar('admin/categorias/listar');
            }
        }  
        echo($this->template->renderizar('categorias/formulario.html', [
            'categorias'=>$categoria
        ]));
    }

    public function apagar(int $id):void{
        (new CategoriaModelo())->deletar($id);
        Helpers::redirecionar('admin/categorias/listar');
    }
}