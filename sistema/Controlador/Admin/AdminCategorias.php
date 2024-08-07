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
                'ativo'=>$categoria->busca('status=1')->total(),
                'inativo'=>$categoria->busca('status=0')->total(),
                'total'=>$categoria->busca()->total()
            ]
        ]));
    }

    public function cadastrar():void{

        if($_SERVER["REQUEST_METHOD"]=="POST"){
            $dados=filter_input_array(INPUT_POST, FILTER_DEFAULT);

            if(!empty($dados["titulo"]) && !empty($dados["texto"])){
                $categoria=new CategoriaModelo();

                $categoria->titulo=$dados['titulo'];
                $categoria->texto=$dados['texto'];
                $categoria->status=$dados['status'];

                if($categoria->salvar()){
                    $this->mensagem->sucesso('Categoria cadastrada com sucesso!')->flash();
                    Helpers::redirecionar('admin/categorias/listar');
                }
            }else{
                $this->mensagem->alerta("Preencha todos os campos!")->flash();
            }
        }  
        echo($this->template->renderizar('categorias/formulario.html', []));
    }

    public function editar(int $id):void{

        $categoria=(new CategoriaModelo())->buscaPorId($id);
        
        if($_SERVER["REQUEST_METHOD"]=="POST"){
            $dados=filter_input_array(INPUT_POST, FILTER_DEFAULT);

            if(!empty($dados["titulo"]) && !empty($dados["texto"])){
                $categoria=(new CategoriaModelo())->buscaPorId($id);

                $categoria->titulo=$dados['titulo'];
                $categoria->texto=$dados['texto'];
                $categoria->status=$dados['status'];
            
                if($categoria->salvar()){
                    $this->mensagem->sucesso('Categoria atualizada com sucesso!')->flash();
                    Helpers::redirecionar('admin/categorias/listar');
                }
            }else{
                $this->mensagem->alerta("Preencha todos os campos!")->flash();
            }
        }  
        echo($this->template->renderizar('categorias/formulario.html', [
            'categorias'=>$categoria
        ]));
    }

    public function apagar(int $id):void{
        if(is_int($id)){
            $categoria=(new CategoriaModelo())->buscaPorId($id);
            
            if(!$categoria){
                $this->mensagem->alerta("A categoria que está tentando deletar não existe.")->flash();
                Helpers::redirecionar('admin/categorias/listar');
            }else{
                if($categoria->apagar("id={$id}")){  
                    $this->mensagem->sucesso("Categoria apagada com sucesso!")->flash();
                    Helpers::redirecionar('admin/categorias/listar');
                }else{
                    $this->mensagem->erro($categoria->erro())->flash();
                    Helpers::redirecionar('admin/categorias/listar');
                }          
            }
        }
    }
}