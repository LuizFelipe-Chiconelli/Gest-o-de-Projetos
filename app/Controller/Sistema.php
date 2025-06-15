<?php
namespace App\Controller;

use Core\Library\ControllerMain;

class Sistema extends ControllerMain
{
    public function __construct()
    {
        parent::__construct();     // exige login (já está no ControllerMain)
    }

    /** tela inicial pós-login */
    public function index()
    {
        // qualquer dado que queira mandar p/ a view vai aqui:
        $dados = [
            'nome'   => \Core\Library\Session::get('userNome'),
            'nivel'  => (int)\Core\Library\Session::get('userNivel')
        ];

        return $this->loadView('sistema/home', $dados);
    }
}
