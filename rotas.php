<?php

require_once 'sistema\configuracao.php';
use Pecee\SimpleRouter\SimpleRouter;
use sistema\Nucleo\Helpers;

try{
    SimpleRouter::setDefaultNamespace('sistema\Controlador');

    SimpleRouter::get(URL_SITE, 'SiteControlador@index');
    SimpleRouter::get(URL_SITE.'sobre-nos', 'SiteControlador@sobre');
    SimpleRouter::get(URL_SITE.'404', 'SiteControlador@erro404');
    SimpleRouter::get(URL_SITE.'post/{id}', 'SiteControlador@post');
    simpleRouter::get(URL_SITE.'categoria/{id}', 'SiteControlador@categoria');
    simpleRouter::post(URL_SITE.'buscar', 'SiteControlador@buscar');

    SimpleRouter::group(['namespace' => 'Admin'], function () {
        SimpleRouter::get(URL_ADMIN.'dashboard', 'AdminDashboard@dashboard');
        SimpleRouter::get(URL_ADMIN.'sair', 'AdminDashboard@sair');
        
        SimpleRouter::match(['get','post'], URL_ADMIN.'login', 'AdminLogin@login');

        SimpleRouter::get(URL_ADMIN.'posts/listar', 'AdminPosts@listar');
        SimpleRouter::match(['get','post'], URL_ADMIN.'posts/cadastrar', 'AdminPosts@cadastrar');
        SimpleRouter::match(['get','post'], URL_ADMIN.'posts/editar/{id}', 'AdminPosts@editar');
        SimpleRouter::get(URL_ADMIN.'posts/apagar/{id}', 'AdminPosts@apagar');

        
        SimpleRouter::get(URL_ADMIN.'categorias/listar', 'AdminCategorias@listar');
        SimpleRouter::match(['get','post'], URL_ADMIN.'categorias/cadastrar', 'AdminCategorias@cadastrar');
        SimpleRouter::match(['get','post'], URL_ADMIN.'categorias/editar/{id}', 'AdminCategorias@editar');
        SimpleRouter::get(URL_ADMIN.'categorias/apagar/{id}', 'AdminCategorias@apagar');
    });


    SimpleRouter::start();
    
}catch(Pecee\SimpleRouter\Exceptions\NotFoundHttpException $ex){
    if(Helpers::localhost()){
        echo($ex);
    }else{
        Helpers::redirecionar('404');
    }
}