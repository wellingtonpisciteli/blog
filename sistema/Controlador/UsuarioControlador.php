<?php

namespace sistema\Controlador;

use sistema\Modelo\UsuarioModelo;
use sistema\Nucleo\Controlador;
use sistema\Nucleo\Helpers;
use sistema\Nucleo\Sessao;

/**
 * Controlador para a seção pública do site.
 * Responsável por manipular as requisições relacionadas às páginas do site acessíveis ao público.
 * 
 * @author Wellington Borges
 */
class UsuarioControlador extends Controlador{
    /**
     * Construtor da classe.
     * Define o diretório base para os arquivos de visualização do site.
     *
     * @param string $diretorio_visualizacoes O caminho para o diretório contendo os arquivos de visualização.
     */
    public function __construct(){

        parent::__construct('templates\site\views');
    }

    public static function usuario(){

        $sessao=new Sessao();
        if(!$sessao->checar('usuarioId')){
            return null;
        }

        return (new UsuarioModelo())->buscaPorId($sessao->usuarioId);

    }
}