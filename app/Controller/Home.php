<?php
// Define o namespace e importa as bibliotecas usadas
namespace App\Controller;

use Core\Library\ControllerMain;
use Core\Library\Session;
use Core\Library\Redirect;

// Classe Home que herda de ControllerMain
class Home extends ControllerMain

{
        public function index()
    {
        // Se o usuário estiver logado (possui userId na sessão)
        if (Session::get('userId')) {
            // Redireciona para a página principal do sistema
            return Redirect::page('sistema');
        }

        // Se não estiver logado, carrega a tela pública inicial
        return $this->loadView('sistema/home/publica');
    }
}
