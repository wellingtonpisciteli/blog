<?php

namespace sistema\Modelo;

use sistema\Nucleo\Modelo;
use sistema\Modelo\UsuarioModelo;

/**
 * Classe PostModelo
 *
 * @author Wellington Borges
 */
class PostModelo extends Modelo{
   
    public function __construct(){
        parent::__construct('posts');
    }

    public function categoria():?CategoriaModelo{
        if($this->categoria_id){
            return (new CategoriaModelo())->buscaPorId($this->categoria_id);
        }
        return null;
    }

    public function usuario():?UsuarioModelo{

        if($this->usuario_id){
            return (new UsuarioModelo())->buscaPorId($this->usuario_id);
        }
        return null;
    }
}