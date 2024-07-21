<?php

namespace sistema\Nucleo;

use sistema\Nucleo\Conexao;
use sistema\Nucleo\Mensagem;

class Modelo{
    protected $dados;
    protected $querry;
    protected $erros;
    protected $parametros;
    protected $tabela;
    protected $ordem;
    protected $limite;
    protected $offset;
    protected $erro;
    protected $mensagem;
    protected $id;

    public function __construct(string $tabela){
        $this->tabela=$tabela;
        $this->mensagem=(new Mensagem());
    }

    public function ordem(string $ordem){
        $this->ordem=" ORDER BY {$ordem}";
        return $this;
    }

    public function limite(string $limite){
        $this->limite=" LIMIT {$limite}";
        return $this;
    }

    public function offset(string $offset){
        $this->offset=" OFFSET {$offset}";
        return $this;
    }

    public function erro(){
        return $this->erro;
    }

    public function mensagem(){
        return $this->mensagem;
    }

    public function __set($nome, $valor){
        if(empty($this->dados)){
            $this->dados=new \stdClass();
        }

        return $this->dados->$nome=$valor;
    }


    public function busca(?string $termos=null, ?string $parametros=null, string $colunas='*'){
        if($termos){
            $this->querry="SELECT {$colunas} FROM ".$this->tabela." WHERE {$termos}";
            parse_str($parametros, $this->parametros);
            return $this;
        }
        $this->querry="SELECT {$colunas} FROM ".$this->tabela;
        return $this;
    }

    public function buscaAtiva(?string $termos=null, ?string $parametros=null, string $colunas='*'){
        if($termos){
            $this->querry="SELECT {$colunas} FROM ".$this->tabela." WHERE {$termos}";
            parse_str($parametros, $this->parametros);
            return $this;
        }
        $this->querry="SELECT {$colunas} FROM ".$this->tabela;
        return $this;
    }

    public function resultado(bool $todos=false){
        try{
            $stmt=Conexao::getInstancia()->prepare($this->querry.$this->ordem.$this->limite.$this->offset);
            $stmt->execute($this->parametros);

            if(!$stmt->rowCount()){
                return null;
            }

            if($todos){
                return $stmt->fetchAll();
            }

            return $stmt->fetchObject();
            
        }catch(\PDOException $ex){
            $this->erro=$ex;
            return null;
        }
    }

    protected function cadastrar(array $dados){
        try{
            $colunas=implode(',', array_keys($dados));
            $valores=':'.implode(',:', array_keys($dados));

            $query="INSERT INTO ".$this->tabela." ({$colunas}) VALUES ({$valores})";
            $stmt=Conexao::getInstancia()->prepare($query);
            $stmt->execute($this->filtro($dados));

            return Conexao::getInstancia()->lastInsertId();

        }catch(\PDOException $ex){
            $this->erro=$ex;
            return null;
        }
    }

    // protected function atualizar(array $dados, string $termos){
    //     try{
    //         $set=[];

    //         foreach($dados as $chave=>$valor){
    //             $set[]="{$chave} = :{$valor}";
    //         }
    //         $set=implode(',', $set);
    //         $query="UPDATE ".$this->tabela." SET {$set} WHERE {$termos}";

    //         $stmt=Conexao::getInstancia()->prepare($query);
    //         $stmt->execute($this->filtro($dados));

    //         return ($stmt->rowCount()??1);

    //     }catch(\PDOException $ex){
    //         $this->erro=$ex;
    //         return null;
    //     }
    // }

    private function filtro(array $dados){
        $filtro=[];
        foreach($dados as $chave=>$valor){
            $filtro[$chave]= is_null($valor) ? null : filter_var($valor, FILTER_DEFAULT);
        }
        return $filtro;
    }

    protected function armazenar(){
        $dados=(array) $this->dados;
        return $dados;
    }

    public function salvar(){
        if(empty($this->id)){
            $this->cadastrar($this->armazenar());
            if($this->erro){
                $this->mensagem("Erro de sistema ao tentar cadastrar os dados");
            }
        }

        return true;
    }
}