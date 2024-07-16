<?php

namespace sistema\Nucleo;

class Sessao{
    public function __construct(){
        if(!session_id()){
            session_start();
        }
    }

    public function criar(string $chave, mixed $valor):Sessao{
        if(is_array($valor)){
            $_SESSION[$chave]=(object) $valor;
        }else{
            $_SESSION[$chave]=$valor;
        }

        return $this;
    }

    public function carregar():?object{
        return (object) $_SESSION;
    }

    public function checar(string $chave):bool{
        return isset($_SESSION[$chave]);
    }

    public function limpar(string $chave){
        unset($_SESSION[$chave]);
        return $this;
    }

    public function deletar():Sessao{
        session_destroy();
        return $this;
    }

    public function __get($atributo){
        if(!empty($_SESSION[$atributo])){
            return $_SESSION[$atributo];
        }
    }

    public function flash():?Mensagem{
        if($this->checar('flash')){
            $flash=$this->flash;
            $this->limpar('flash');
            return $flash;
        }
        return null;
    }
}