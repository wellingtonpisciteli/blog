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
        $dados=filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if($_SERVER["REQUEST_METHOD"]=="POST"){
            if($this->validarDados($dados)){
                $usuario=new UsuarioModelo();

                $usuario->nome = $dados['nome'];
                $usuario->email = $dados['email'];
                $usuario->senha = $dados['senha'];
                $usuario->level = $dados['level'];
                $usuario->status = $dados['status'];

                if($usuario->salvar()){
                    $this->mensagem->sucesso('Usuário cadastrado com sucesso!')->flash();
                    Helpers::redirecionar('admin/usuarios/listar');
                }else{
                    $this->mensagem->erro("Email '{$usuario->email}' já está em uso, tente outro!")->flash();
                }
            }else{
                $this->mensagem->alerta("Preencha todos os campos!")->flash();
            }
        }  
        echo($this->template->renderizar('usuarios/formulario.html', [
            'usuario'=> $dados
        ]));
    }

    public function editar(int $id):void{
        $usuario=(new UsuarioModelo())->buscaPorId($id);
        
        if($_SERVER["REQUEST_METHOD"]=="POST"){
            $dados=filter_input_array(INPUT_POST, FILTER_DEFAULT);

            if($this->validarDados($dados)){
                $usuario=(new UsuarioModelo())->buscaPorId($id);

                $usuario->nome = $dados['nome'];
                $usuario->email = $dados['email'];
                $usuario->senha = $dados['senha'];
                $usuario->level = $dados['level'];
                $usuario->status = $dados['status'];
            
                if($usuario->salvar()){
                    $this->mensagem->sucesso('Usuário atualizado com sucesso!')->flash();
                    Helpers::redirecionar('admin/usuarios/listar');
                }else{
                    $this->mensagem->erro("Email '{$usuario->email}' já está em uso, tente outro!")->flash();
                }
            }else{
                $this->mensagem->alerta("Preencha todos os campos!")->flash();
            }
        }  
        echo($this->template->renderizar('usuarios/formulario.html', [
            'usuario'=>$usuario
        ]));
    }

    public function apagar(int $id):void{
        if(is_int($id)){
            $usuario=(new UsuarioModelo())->buscaPorId($id);
            
            if(!$usuario){
                $this->mensagem->alerta("O usuário que está tentando deletar não existe.")->flash();
                Helpers::redirecionar('admin/usuarios/listar');
            }else{
                if($usuario->apagar("id={$id}")){  
                    $this->mensagem->sucesso("Usuário apagado com sucesso!")->flash();
                    Helpers::redirecionar('admin/usuarios/listar');
                }else{
                    $this->mensagem->erro($usuario->erro())->flash();
                    Helpers::redirecionar('admin/usuarios/listar');
                }          
            }
        }
    }

    public function validarDados(array $dados):bool{
        if(empty($dados["nome"])){
            return false;
        }

        if(empty($dados["email"])){
            return false;
        }

        if(empty($dados["senha"])){
            return false;
        }

        return true;
    }
}