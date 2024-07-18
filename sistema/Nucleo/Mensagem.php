<?php

namespace sistema\Nucleo;

class Mensagem{
    private $texto;
    private $css;
    
    public function __toString()
    {
        return $this->renderizar();
    }

    /**
     * Método responsável pelas mensagens de sucesso
     * @param string $mensagem
     * @return Mensagem
     */
    public function sucesso(string $mensagem): Mensagem
    {
        $this->css='alert alert-success';
        $this->texto=$this->filtrar($mensagem);
        return $this;
    }

    /**
     * Método responsável pelas mensagens de erro
     * @param string $mensagem
     * @return Mensagem
     */
    public function erro(string $mensagem): Mensagem
    {
        $this->css='alert alert-danger';
        $this->texto=$this->filtrar($mensagem);
        return $this;
    }

    /**
     * Método responsável pelas mensagens de alerta
     * @param string $mensagem
     * @return Mensagem
     */
    public function alerta(string $mensagem): Mensagem
    {
        $this->css='alert alert-warning';
        $this->texto=$this->filtrar($mensagem);
        return $this;
    }

    /**
     * Método responsável pelas mensagens de informações
     * @param string $mensagem
     * @return Mensagem
     */
    public function informa(string $mensagem): Mensagem
    {
        $this->css='alert alert-primary';
        $this->texto=$this->filtrar($mensagem);
        return $this;
    }

    /**
     * Método responsável pela renderização das mensagens
     * @return string
     */
    public function renderizar(): string
    {
        return "<div class='{$this->css} alert-dismissible fade show'>{$this->texto} <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";
    }

    /**
     * Método responsável por filtrar as mensagens
     * @param string $mensagem
     * @return string
     */
    private function filtrar(string $mensagem): string
    {
        return filter_var($mensagem, FILTER_SANITIZE_SPECIAL_CHARS);
    }
    
    /**
     * Armazena a mensagem atual na sessão.
     *
     * Este método cria uma nova instância da classe `Sessao` e utiliza
     * o método `criar` para armazenar a mensagem (instância atual da classe)
     * na sessão sob a chave 'flash'. Isso permite que a mensagem
     * seja recuperada posteriormente, por exemplo, para exibição ao usuário
     * em uma interface de usuário.
     *
     * @return void
     */
    public function flash(): void{
        (new Sessao())->criar('flash', $this);
    }
}