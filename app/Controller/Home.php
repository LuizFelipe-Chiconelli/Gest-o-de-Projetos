<?php
namespace App\Controller;

use Core\Library\ControllerMain;
use Core\Library\Session;
use Core\Library\Redirect;

class Home extends ControllerMain
{
    public function index()
    {
        if (Session::get('userId')) {
            return Redirect::page('sistema');
        }

        return $this->loadView('sistema/home/publica');
    }
}

