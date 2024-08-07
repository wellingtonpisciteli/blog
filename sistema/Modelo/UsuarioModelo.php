<?php

namespace sistema\Modelo;

use sistema\Nucleo\Modelo;
use sistema\Nucleo\Sessao;

class UsuarioModelo extends Modelo{

    public function __construct(){

        parent::__construct('usuarios');   
    }

    public function buscaPorEmail(string $email):?UsuarioModelo{

        $busca=$this->busca("email=:e", "e={$email}");
        return $busca->resultado();
    }

    public function login(array $dados, int $level=1){

        $usuario=(new UsuarioModelo())->buscaPorEmail($dados["email"]);

        if(!$usuario){
            $this->mensagem->erro("Os dados informados para login estão incorretos!")->flash();
            return false;
        }

        if($dados['senha']!=$usuario->senha){
            $this->mensagem->erro("Os dados informados para login estão incorretos!")->flash();
            return false;
        }

        if($usuario->status!=1){
            $this->mensagem->erro("Para fazer login, primeiro ative sua conta!")->flash();
            return false;
        }

        if($usuario->level < $level){
            $this->mensagem->erro("Usuário não permitido.")->flash();
            return false;
        }

        (new Sessao())->criar("usuarioId", $usuario->id);

        $this->mensagem->sucesso("{$usuario->nome}, seja bem vindo ao painel de controle")->flash();
        return true;
    }

}