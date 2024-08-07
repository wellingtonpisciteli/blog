<?php

namespace sistema\Controlador\Admin;

use sistema\Controlador\UsuarioControlador;
use sistema\Nucleo\Controlador;
use sistema\Nucleo\Helpers;
use sistema\Modelo\UsuarioModelo;

class AdminLogin extends Controlador{

    public function __construct(){

        parent::__construct('templates/admin/views');     
    }

    public function login():void{

        $usuario=UsuarioControlador::usuario();
        if($usuario && $usuario->level==3){
            Helpers::redirecionar('admin/dashboard');
        }

        if($_SERVER["REQUEST_METHOD"]=="POST"){
            $dados=filter_input_array(INPUT_POST, FILTER_DEFAULT);
            if(isset($dados)){
                if($this->checarDados($dados)){
                    $usuario=(new UsuarioModelo())->login($dados, 3);
                    if($usuario){
                        Helpers::redirecionar('admin/login');
                    }
                }
            }
        }
        echo($this->template->renderizar('login.html', []));
    }

    public function checarDados(array $dados):bool{

        if(empty($dados['email']) && empty($dados['senha'])){
            $this->mensagem->erro("Preencha todos os campos!")->flash();
            return false;
        }
        
        if(empty($dados['email'])){
            $this->mensagem->erro("Campo Email é obrigátorio!")->flash();
            return false;
        }

        if(empty($dados['senha'])){
            $this->mensagem->erro("Campo Senha é obrigátorio!")->flash();
            return false;
        }

        return true;
    }
}