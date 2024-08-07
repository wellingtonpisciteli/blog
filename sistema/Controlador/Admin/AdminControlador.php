<?php

namespace sistema\Controlador\Admin;

use sistema\Nucleo\Controlador;
use sistema\Nucleo\Helpers;
use sistema\Controlador\UsuarioControlador;
use sistema\Nucleo\Sessao;

// o objetivo é trazer o twig template do controlador para AdminControlador 

class AdminControlador extends Controlador{

    protected $usuario;

    public function __construct(){
        
        parent::__construct('templates/admin/views');

        $this->usuario=UsuarioControlador::usuario();

        if(!$this->usuario OR $this->usuario->level!=3){
            $this->mensagem->erro("Faça login para acessar o painel de controle!")->flash();

            $sessao=new Sessao();

            $sessao->limpar("usuarioId");

            Helpers::redirecionar('admin/login');
        }
    }
}