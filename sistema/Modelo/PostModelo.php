<?php

namespace sistema\Modelo;

use sistema\Nucleo\Conexao;
use sistema\Nucleo\Modelo;

/**
 * Classe PostModelo
 *
 * @author Wellington Borges
 */
class PostModelo extends Modelo{
   
    public function __construct(){
        parent::__construct('posts');
    }

    /**
     * Realiza uma pesquisa de posts no banco de dados com base no termo de busca fornecido.
     *
     * @param string $busca O termo de busca a ser usado na pesquisa.
     * @return array Um array contendo os resultados da pesquisa.
     */
    public function pesquisa(string $busca): array {
        // Constrói a consulta SQL para buscar posts com base no termo de busca
        $query = "SELECT * FROM posts WHERE status = 1 AND titulo LIKE '%{$busca}%'";
        // Executa a consulta SQL usando a conexão com o banco de dados
        $stmt = Conexao::getInstancia()->query($query);
        // Obtém todos os resultados da consulta como um array associativo
        $resultado = $stmt->fetchAll();
        // Retorna os resultados da pesquisa
        return $resultado;
    }

    public function deletar(int $id):void{
        $query="DELETE FROM posts WHERE id={$id}";
        $stmt=Conexao::getInstancia()->prepare($query);
        $stmt->execute();
    }

    public function total(?string $termo=null):int{
        $termo=($termo ? "WHERE {$termo}" : "");

        $query="SELECT * FROM posts {$termo}";
        $stmt=Conexao::getInstancia()->prepare($query);
        $stmt->execute();
        
        // Retorna quantas linhas foram selecionadas
        return $stmt->rowCount();
    }
}