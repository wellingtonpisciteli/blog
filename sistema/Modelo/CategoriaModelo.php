<?php

namespace sistema\Modelo;

use sistema\Nucleo\Modelo;

/**
 * Classe CategoriaModelo
 *
 * @author Wellington Borges
 */
class CategoriaModelo extends Modelo{

    public function __construct(){
        parent::__construct('categorias');
    }    

    public function post(int $id): ?array{
        $busca=(new PostModelo())->busca("categoria_id={$id} AND status=1");
        return $busca->resultado(true);
    }
}
