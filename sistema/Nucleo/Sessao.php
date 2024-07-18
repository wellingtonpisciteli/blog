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

    /**
     * Obtém o valor de um atributo da sessão.
     *
     * Este método mágico permite acessar os atributos da sessão como se fossem
     * propriedades do objeto. Se o atributo solicitado estiver presente na
     * sessão e não estiver vazio, seu valor será retornado.
     *
     * @param string $atributo Nome do atributo a ser obtido da sessão.
     * @return mixed|null Retorna o valor do atributo se existir, caso contrário retorna null.
     */
    public function __get($atributo){
        if(!empty($_SESSION[$atributo])){
            return $_SESSION[$atributo];
        }
    }

    /**
     * Recupera e remove a mensagem flash da sessão.
     *
     * Este método verifica se existe uma mensagem flash na sessão e, se houver,
     * recupera seu valor, limpa a entrada correspondente da sessão e a retorna.
     * Se não houver mensagem flash, retorna null.
     *
     * @return Mensagem|null Retorna a mensagem flash se existir, ou null se não houver.
     */
    public function flash():?Mensagem{
        //Checando o método flash da classe Mensagem.
        if($this->checar('flash')){
            //Criando um método que só sera acessivel por causa do método mágico get.
            $flash=$this->flash;
            //limpar o flash da classe Mensagem.
            $this->limpar('flash');
            //Retorna a variavel que criamos
            return $flash;
        }
        return null;
    }
}