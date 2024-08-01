<?php

namespace sistema\Controlador\Admin;

use sistema\Nucleo\Controlador;
use sistema\Nucleo\Helpers;

class AdminLogin extends Controlador{

    public function __construct(){

        parent::__construct('templates/admin/views');     
    }

    public function login():void{
        echo($this->template->renderizar('login.html', []));
    }
}