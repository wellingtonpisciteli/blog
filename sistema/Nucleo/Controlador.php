<?php

namespace sistema\Nucleo;
use sistema\Suporte\Template;

class Controlador{
    protected Template $template;

    public function __construct(string $diretorio){
        
        // Inicializa a propriedade $template com uma nova instância de Template
        $this->template=new Template($diretorio);
    }
}
