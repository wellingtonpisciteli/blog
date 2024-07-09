<?php

namespace sistema\Modelo;
use sistema\Nucleo\Conexao;

/**
 * Classe PostModelo
 *
 * @author Wellington Borges
 */
class PostModelo{
    /**
     * Busca todos os posts ativos.
     *
     * Esta função retorna todos os posts da tabela `posts` que têm o status igual a 1 ou 0,
     * ordenados pelo campo `id` em ordem crescente.
     *
     * @return array Retorna um array de objetos que representam os posts ativos.
     */
    public function busca():array{
        $query="SELECT * FROM posts WHERE status IN (0,1) ORDER BY id ASC";
        $stmt=Conexao::getInstancia()->query($query);
        $resultado=$stmt->fetchAll();
        return $resultado;
    }

    public function buscaAtiva():array{
        $query="SELECT * FROM posts WHERE status = 1 ORDER BY id ASC";
        $stmt=Conexao::getInstancia()->query($query);
        $resultado=$stmt->fetchAll();
        return $resultado;
    }

    /**
     * Busca um post pelo ID.
     *
     * Esta função retorna um post específico baseado no seu ID. Se o post não for encontrado,
     * retorna false.
     *
     * @param int $id O ID do post a ser buscado.
     * @return bool|object Retorna um objeto que representa o post se encontrado, ou false se não encontrado.
     */
    public function buscaPorId(int $id):bool|object{
        // seleciona o post que tem o campo id igual ao valor do parâmetro $id.
        $query="SELECT * FROM posts WHERE id={$id}";
        $stmt=Conexao::getInstancia()->query($query);
        //executa o primeiro e unico parametro da querry
        $resultado=$stmt->fetch();
        return $resultado;
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

    /**
    * Armazena um novo post no banco de dados.
    *
    * @param array $dados Um array associativo contendo os dados do post a ser armazenado.
    * Deve conter as chaves 'categoria_id', 'titulo', 'texto' e 'status'.
    * @return void
    */
    public function armazenar(array $dados):void{
        // Query SQL para inserir um novo post na tabela 'posts'
        $query="INSERT INTO posts (categoria_id, titulo, texto, status) VALUES (:categoria_id, :titulo, :texto, :status)";
        // Prepara a consulta SQL usando a conexão singleton da classe Conexao
        $stmt=Conexao::getInstancia()->prepare($query);
        // Executa a consulta SQL, passando os dados como parâmetros
        $stmt->execute($dados);
    }

    public function atualizar(array $dados, int $id):void{
        $query="UPDATE posts SET categoria_id=:categoria_id, titulo=:titulo, texto=:texto, status=:status WHERE id={$id}";
        $stmt=Conexao::getInstancia()->prepare($query);
        $stmt->execute($dados);
    }

    public function deletar(int $id):void{
        $query="DELETE FROM posts WHERE id={$id}";
        $stmt=Conexao::getInstancia()->prepare($query);
        // $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }
}