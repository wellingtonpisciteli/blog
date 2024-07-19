<?php

namespace sistema\Nucleo;

use PDOException;
use sistema\Nucleo\Conexao;


class Modelo{
    protected $dados;
    protected $querry;
    protected $erros;
    protected $parametros;
    protected $tabela;
    protected $ordem;
    protected $limite;
    protected $offset;

    public function __construct(string $tabela){
        $this->tabela=$tabela;
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
        }
    }

    
}