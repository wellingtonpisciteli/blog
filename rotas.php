<?php

require_once 'sistema\configuracao.php';
use Pecee\SimpleRouter\SimpleRouter;
use sistema\Nucleo\Helpers;

try{
    SimpleRouter::setDefaultNamespace('sistema\Controlador');

    SimpleRouter::get(URL_SITE, 'SiteControlador@index');
    // SimpleRouter::get(URL_SITE.'index.php', 'SiteControlador@index');
    SimpleRouter::get(URL_SITE.'sobre-nos', 'SiteControlador@sobre');
    SimpleRouter::get(URL_SITE.'404', 'SiteControlador@erro404');
    SimpleRouter::get(URL_SITE.'post/{slug}/{id}', 'SiteControlador@post');
    simpleRouter::get(URL_SITE.'categoria/{slug}', 'SiteControlador@categoria');
    simpleRouter::get(URL_SITE.'cadastre-se', 'SiteControlador@cadastre-se');
    simpleRouter::post(URL_SITE.'buscar', 'SiteControlador@buscar');

    SimpleRouter::match(['get','post'], URL_SITE.'loginFront', 'SiteControlador@loginFront');
    SimpleRouter::match(['get','post'], URL_SITE.'cadastroFront', 'SiteControlador@cadastroFront');

    SimpleRouter::get(URL_SITE.'sair', 'SiteControlador@sair');

    SimpleRouter::group(['namespace' => 'Admin'], function () {
        //AdminDashboard
        SimpleRouter::get(URL_ADMIN.'dashboard', 'AdminDashboard@dashboard');
        SimpleRouter::get(URL_ADMIN.'sair', 'AdminDashboard@sair');

        //AdminUsuarios
        SimpleRouter::get(URL_ADMIN.'usuarios/listar', 'AdminUsuarios@listar');
        SimpleRouter::match(['get','post'], URL_ADMIN.'usuarios/cadastrar', 'AdminUsuarios@cadastrar');
        SimpleRouter::match(['get','post'], URL_ADMIN.'usuarios/editar/{id}', 'AdminUsuarios@editar');
        SimpleRouter::get(URL_ADMIN.'usuarios/apagar/{id}', 'AdminUsuarios@apagar');
        
        //AdminLogin
        SimpleRouter::match(['get','post'], URL_ADMIN.'login', 'AdminLogin@login');

        //AdminPosts
        SimpleRouter::get(URL_ADMIN.'posts/listar', 'AdminPosts@listar');
        SimpleRouter::match(['get','post'], URL_ADMIN.'posts/cadastrar', 'AdminPosts@cadastrar');
        SimpleRouter::match(['get','post'], URL_ADMIN.'posts/editar/{id}', 'AdminPosts@editar');
        SimpleRouter::get(URL_ADMIN.'posts/apagar/{id}', 'AdminPosts@apagar');

        //AdminCategorias
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