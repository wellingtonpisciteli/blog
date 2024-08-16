<?php

namespace sistema\Controlador\Admin;

use sistema\Modelo\UsuarioModelo;
use sistema\Nucleo\Helpers;

class AdminUsuarios extends AdminControlador{
    
    public function listar():void{

        $usuario=new UsuarioModelo();

        echo($this->template->renderizar('usuarios/listar.html', [
            'usuarios'=>$usuario->busca()->ordem('status ASC, id DESC')->resultado(true),
            'total'=>[
                'ativo'=>$usuario->busca('status=1')->total(),
                'inativo'=>$usuario->busca('status=0')->total(),
                'total'=>$usuario->busca()->total()
            ]
        ]));
    }

    public function cadastrar():void{

        if($_SERVER["REQUEST_METHOD"]=="POST"){
            $dados=filter_input_array(INPUT_POST, FILTER_DEFAULT);

            if(!empty($dados["titulo"]) && !empty($dados["texto"])){
                $usuario=new UsuarioModelo();

                $usuario->titulo=$dados['titulo'];
                $usuario->texto=$dados['texto'];
                $usuario->status=$dados['status'];

                if($usuario->salvar()){
                    $this->mensagem->sucesso('Usuário cadastrado com sucesso!')->flash();
                    Helpers::redirecionar('admin/usuarios/listar');
                }
            }else{
                $this->mensagem->alerta("Preencha todos os campos!")->flash();
            }
        }  
        echo($this->template->renderizar('usuarios/formulario.html', []));
    }

    public function editar(int $id):void{

        $usuario=(new UsuarioModelo())->buscaPorId($id);
        
        if($_SERVER["REQUEST_METHOD"]=="POST"){
            $dados=filter_input_array(INPUT_POST, FILTER_DEFAULT);

            if(!empty($dados["titulo"]) && !empty($dados["texto"])){
                $usuario=(new UsuarioModelo())->buscaPorId($id);

                $usuario->titulo=$dados['titulo'];
                $usuario->texto=$dados['texto'];
                $usuario->status=$dados['status'];
            
                if($usuario->salvar()){
                    $this->mensagem->sucesso('Usuário atualizado com sucesso!')->flash();
                    Helpers::redirecionar('admin/usuarios/listar');
                }
            }else{
                $this->mensagem->alerta("Preencha todos os campos!")->flash();
            }
        }  
        echo($this->template->renderizar('categorias/formulario.html', [
            'categorias'=>$usuario
        ]));
    }

    public function apagar(int $id):void{
        if(is_int($id)){
            $categoria=(new UsuarioModelo())->buscaPorId($id);
            
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