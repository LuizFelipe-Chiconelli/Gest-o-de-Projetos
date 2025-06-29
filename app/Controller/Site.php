<?php
namespace App\Controller;

use Core\Library\ControllerMain;

class Site extends ControllerMain
{
    /**
     * Página “Quem Somos”
     *
     * @param string|null $acao  (router envia, mas aqui é ignorado)
     * @param string|null $id    (router envia, mas aqui é ignorado)
     */
    public function quemSomos($acao = null, $id = null)
    {
        return $this->loadView('quemSomos');
    }

    /**
     * Página “Produtos e Serviços”
     */
    public function produtosServicos($acao = null, $id = null)
    {
        return $this->loadView('produtosServicos');
    }
}
