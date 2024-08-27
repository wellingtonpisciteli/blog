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
                if(empty($dados['senha'])) {
                    $this->mensagem->alerta('Informe uma senha para o usuário')->flash();
                }else{
                    $usuario = new UsuarioModelo();

                    $usuario->nome = $dados['nome'];
                    $usuario->email = $dados['email'];
                    $usuario->senha = Helpers::gerarSenha($dados['senha']);
                    $usuario->level = $dados['level'];
                    $usuario->status = $dados['status'];

                    if ($usuario->salvar()) {
                        $this->mensagem->sucesso('Usuário cadastrado com sucesso')->flash();
                        Helpers::redirecionar('admin/usuarios/listar');
                    } else {
                        $usuario->mensagem()->flash();
                    }
                }
            }
        }  
        echo($this->template->renderizar('usuarios/formulario.html', [
            'usuario'=> $dados
        ]));
    }

    public function editar(int $id):void{
        $usuario=(new UsuarioModelo())->buscaPorId($id);

        $dados=filter_input_array(INPUT_POST, FILTER_DEFAULT);
        
        if($_SERVER["REQUEST_METHOD"]=="POST"){
            if ($this->validarDados($dados)) {
                $usuario = (new UsuarioModelo())->buscaPorId($id);

                $usuario->nome = $dados['nome'];
                $usuario->email = $dados['email'];
                $usuario->senha = (!empty($dados['senha']) ? Helpers::gerarSenha($dados["senha"]) : $usuario->senha);
                $usuario->level = $dados['level'];
                $usuario->status = $dados['status'];
                $usuario->atualizado_em = date('Y-m-d H:i:s');

                if ($usuario->salvar()) {
                    $this->mensagem->sucesso('Usuário atualizado com sucesso')->flash();
                    Helpers::redirecionar('admin/usuarios/listar');
                } else {
                    $usuario->mensagem()->flash();
                }
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
        if(empty($dados['nome'])) {
            $this->mensagem->alerta('Informe o nome do usuário')->flash();
            return false;
        }

        if(empty($dados['email'])) {
            $this->mensagem->alerta('Informe o e-mail do usuário')->flash();
            return false;
        }
        
        if(!empty($dados['senha'])){
            if(!Helpers::validarSenha($dados['senha'])){
                $this->mensagem->alerta('A senha deve ter entre 6 e 50 caracteres!')->flash();
                return false;
            }
        }

        return true;
    }
}