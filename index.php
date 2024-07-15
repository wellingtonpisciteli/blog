<?php

// require './sistema/configuracao.php';
require 'vendor/autoload.php';
// require 'rotas.php';

$sessao=new sistema\Nucleo\Sessao();

$sessao->criar('usuario', [
    'idade'=>25, 
    'nome'=>'Wellington']);

var_dump($sessao->carregar());