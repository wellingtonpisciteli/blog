<?php

namespace sistema\Controlador\Admin;

use sistema\Nucleo\Controlador;

// o objetivo é trazer o twig template do controlador para AdminControlador 

class AdminControlador extends Controlador{
    public function __construct(){
        parent::__construct('templates/admin/views');
    }
}