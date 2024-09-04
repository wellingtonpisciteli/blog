<?php 

namespace sistema\Nucleo;

use Exception;
use sistema\Nucleo\Sessao;
use sistema\Modelo\PostModelo;


class Helpers {

    /**
     * Retorna e exibe a mensagem flash da sessão.
     *
     * Este método estático utiliza a classe `Sessao` para obter a mensagem
     * flash da sessão. Se uma mensagem flash estiver disponível, ela é
     * exibida usando `echo` e depois retornada como uma string. Caso contrário,
     * retorna `null`.
     *
     * @return string|null Retorna a mensagem flash se existir, ou `null` se não houver.
     */
    public static function flash():?string{
        $sessao=new Sessao();

        if($flash=$sessao->flash()){
            echo($flash);
        }
        return null;
    }

    public static function saudacao() {
        return "testando";
    }

    public static function resumirTxt(string $texto,int $limite,string $continue='...'):string{
        $texto_limpo=trim($texto);
        if(mb_strlen($texto_limpo)<=$limite){
            return $texto_limpo;
        }
        $resumir_txt=mb_substr($texto_limpo,0,mb_strrpos(mb_substr($texto_limpo,0,$limite),''));

        return $resumir_txt.$continue;
    }

    public static function url(string $url=null):string{
        $servidor=filter_input(INPUT_SERVER, 'SERVER_NAME');
        $ambiente=($servidor=='127.0.0.1'?URL_DESENVOLVIMENTO:URL_PRODUCAO);
        if(str_starts_with($url, '/')){
            return $ambiente.$url;
        }
        return $ambiente.$url;
    }

    public static function localhost():bool{
        $servidor=filter_input(INPUT_SERVER, 'SERVER_NAME');

        if($servidor=='127.0.0.1'){
            return true;
        }else{
            return false;
        }
    }

    public static function validaCPF($cpf) {
        // Remover caracteres não numéricos
        $cpf = preg_replace('/[^0-9]/', '', $cpf);
    
        // Verificar se o CPF tem 11 dígitos
        if (strlen($cpf) != 11 or preg_match('/(\d)\1{10}/', $cpf)) {
            throw new Exception("O cpf precisa ter 11 digítos");
        }
    
        // Calcular os dígitos verificadores
        for ($i = 9; $i < 11; $i++) {
            $sum = 0;
            for ($j = 0; $j < $i; $j++) {
                $sum += $cpf[$j] * (($i + 1) - $j);
            }
            $digit = (($sum * 10) % 11) % 10;
            if ($cpf[$i] != $digit) {
                throw new Exception('CPF inválido');
            }
        }
    
        // CPF válido
        return true;
    }

    public static function redirecionar(string $url=Null):void{
        header('HTTP/1.1 302 Found');
        $local=($url?self::url($url):self::url());
        header("Location: {$local}");
        exit();
    }

    public static function validarSenha(string $senha):bool{
        if(mb_strlen($senha)>=6 && mb_strlen($senha)<=50){
            return true;
        }

        return false;
    }

    public static function gerarSenha(string $senha):string{
        return password_hash($senha, PASSWORD_DEFAULT, ["cost=>10"]);
    }

    public static function verificarSenha(string $senha, string $hash):bool{
        return password_verify($senha, $hash);
    }

    public static function ultimaAtualizacao(){
        $post=(new PostModelo());
        $atualizado_em=$post->atualizado_em=date('Y-m-d H:i:s');
        $ultimaAtualizacao = strtotime($atualizado_em);
        $atualizacaoAtual=time();
        $diferencaSegundos=$atualizacaoAtual - $ultimaAtualizacao;
        $diferencaMinutos=round($diferencaSegundos/60);
        return $diferencaMinutos;
    }
}

