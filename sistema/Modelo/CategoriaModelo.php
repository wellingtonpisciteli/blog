<?php

namespace sistema\Modelo;

use sistema\Nucleo\Conexao;
use sistema\Nucleo\Modelo;


 /**
 * Classe CategoriaModelo
 *
 * Esta classe fornece métodos para interagir com a tabela 'categorias' no banco de dados.
 * 
 * @author Wellington Borges
 */
class CategoriaModelo extends Modelo{
    
    public function __construct() {
        parent::__construct('categorias');
    }

    /**
     * Busca uma categoria pelo ID.
     *
     * Esta função retorna uma categoria específica com base no seu ID.
     * Se a categoria não for encontrada, retorna false.
     *
     * @param int $id O ID da categoria a ser buscada.
     * @return bool|object Retorna um objeto que representa a categoria se encontrada, ou false se não encontrada.
     */
    public function buscaPorId(int $id):bool|object{
        $query="SELECT * FROM categorias WHERE id={$id}";
        $stmt=Conexao::getInstancia()->query($query);
        // retorna uma linha por vez do db.
        $resultado=$stmt->fetch();
        return $resultado;
    }

    /**
     * Busca todos os posts de uma categoria específica.
     *
     * Esta função retorna todos os posts da tabela 'posts'
     * que pertencem à categoria especificada pelo ID, e têm o status igual a 1,
     * ordenados pelo ID em ordem decrescente.
     *
     * @param int $id O ID da categoria.
     * @return array Retorna um array de objetos que representam os posts da categoria.
     */
    public function posts(int $id):array{
        $query="SELECT * FROM posts WHERE categoria_id={$id} AND status = 1 ORDER BY id DESC";
        $stmt=Conexao::getInstancia()->query($query);
        $resultado=$stmt->fetchAll();
        return $resultado;
    }

    // public function armazenar(array $dados):void{
    //     $query="INSERT INTO categorias (titulo, texto, status) VALUES (?, ?, ?);";
    //     $stmt=Conexao::getInstancia()->prepare($query);
    //     $stmt->execute([$dados['titulo'], $dados['texto'], $dados['status']]);
    // }

    public function atualizar(array $dados, int $id):void{
        $query="UPDATE categorias SET titulo=:titulo, texto=:texto, status=:status WHERE id={$id}";
        $stmt=Conexao::getInstancia()->prepare($query);
        $stmt->execute($dados);
    }

    public function deletar(int $id):void{
        $query="DELETE FROM categorias WHERE id={$id}";
        $stmt=Conexao::getInstancia()->prepare($query);
        $stmt->execute();
    }

    public function total(?string $termo=null):int{
        $termo=($termo ? "WHERE {$termo}" : "");

        $query="SELECT * FROM categorias {$termo}";
        $stmt=Conexao::getInstancia()->prepare($query);
        $stmt->execute();
        
        // Retorna quantas linhas foram selecionadas
        return $stmt->rowCount();
    }
}