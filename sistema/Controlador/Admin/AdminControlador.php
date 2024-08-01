<?php

namespace sistema\Controlador\Admin;

use sistema\Nucleo\Controlador;
use sistema\Nucleo\Helpers;

// o objetivo é trazer o twig template do controlador para AdminControlador 

class AdminControlador extends Controlador{
    public function __construct(){
        
        parent::__construct('templates/admin/views');

        $usuario=false;

        if(!$usuario){
            $this->mensagem->erro("Usuário não existe faça login")->flash();
        }

        Helpers::redirecionar('admin/login');
    }
}