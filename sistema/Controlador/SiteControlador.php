<?php

namespace sistema\Controlador;

use sistema\Nucleo\Controlador;
use sistema\Modelo\PostModelo;
use sistema\Nucleo\Helpers;
use sistema\Modelo\CategoriaModelo;

/**
 * Controlador para a seção pública do site.
 * Responsável por manipular as requisições relacionadas às páginas do site acessíveis ao público.
 * 
 * @author Wellington Borges
 */
class SiteControlador extends Controlador{
    /**
     * Construtor da classe.
     * Define o diretório base para os arquivos de visualização do site.
     *
     * @param string $diretorio_visualizacoes O caminho para o diretório contendo os arquivos de visualização.
     */
    public function __construct(){
        parent::__construct('templates\site\views');
    }
    
    /**
     * Página inicial do site.
     * Exibe os últimos posts publicados e as categorias disponíveis.
     */
    public function index():void{
        $posts=(new PostModelo())->busca("status=1");
        $categoria=(new CategoriaModelo())->busca("status=1");

        echo($this->template->renderizar('index.html', [
            'titulo'=>'Blog PHP',
            'posts'=>$posts->resultado(true),
            'categorias'=>$categoria,
        ]));
    }

    /**
     * Executa uma busca por posts no blog com base nos dados enviados via método POST.
     *
     * Este método obtém o termo de busca do formulário de pesquisa enviado via método POST,
     * realiza uma busca por posts no banco de dados usando o modelo PostModelo e,
     * em seguida, renderiza os resultados da busca em uma página HTML usando um template.
     *
     * @return void
     */
    public function buscar(): void {
        // Obtém os dados enviados via método POST do formulário de pesquisa
        $busca=filter_input(INPUT_POST, 'busca', FILTER_DEFAULT);
        if(isset($busca)){
            // Realiza a pesquisa por posts usando o modelo PostModelo
            $posts=(new PostModelo())->busca("status = 1 AND titulo LIKE '%{$busca}%'")->resultado(true);

            if(!empty($posts)){
                foreach ($posts as $post) {
                    echo "<a href=".Helpers::url('post/').$post->id." class='text-white text-decoration-none bg-dark my-2'>$post->titulo</a>";
                }
            }else{
                echo "<p class='text-white bg-dark my-2'>Nenhum resultado encontrado para '{$busca}'</p>";
            }
        }
    }

    /**
     * Página "Sobre nós" do site.
     * Exibe informações sobre a empresa ou organização.
     */
    public function sobre():void{
        $categoria=(new CategoriaModelo())->busca("status=1");
        echo($this->template->renderizar('sobre.html', [
            'titulo'=>'Sobre nós',
            'categorias'=>$categoria,
        ]));
    }

    /**
     * Página de erro 404 (Página não encontrada).
     * Exibe uma mensagem de erro indicando que a página solicitada não foi encontrada.
     */
    public function erro404():void{
        $categoria=(new CategoriaModelo())->busca("status=1");
        echo($this->template->renderizar('404.html', [
            'titulo'=>'Página não encontrada',
            'categorias'=>$categoria,
        ]));
    }

    /**
     * Exibe um post específico.
     *
     * @param int $id O ID do post a ser exibido.
     */
    public function post(int $id):void{
        $post=(new PostModelo())->buscaPorId($id);
        $categoria=(new CategoriaModelo())->busca("status=1");

        if(!$post){
            Helpers::redirecionar('404');
        }

        echo($this->template->renderizar('post.html', [
            'post'=>$post,
            'categorias'=>$categoria,
        ]));
    }

    /**
     * Exibe todos os posts de uma categoria específica.
     *
     * @param int $id O ID da categoria.
     */
    public function categoria(int $id):void{
        $posts=(new CategoriaModelo())->posts($id);
        $categoria=(new CategoriaModelo())->busca("status=1");

        if(!$posts){
            Helpers::redirecionar('404');
        }

        echo($this->template->renderizar('categoria.html', [
            'posts'=>$posts,
            'categorias'=>$categoria,
        ]));
    }


}