<?php
namespace App\Controller;

use Core\Library\ControllerMain;

class Site extends ControllerMain
{
    public function quemSomos()
    {
        $this->loadView("quemSomos");
    }

    public function produtosServicos()
    {
        $this->loadView("produtosServicos");
    }
}
