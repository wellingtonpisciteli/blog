<?php

namespace sistema\Modelo;

use sistema\Nucleo\Modelo;

/**
 * Classe PostModelo
 *
 * @author Wellington Borges
 */
class PostModelo extends Modelo{
   
    public function __construct(){
        parent::__construct('posts');
    }
}