<?php
namespace App\Controller;

use Core\Library\ControllerMain;
use Core\Library\Session;
use Core\Library\Redirect;

class Sistema extends ControllerMain
{
    public function __construct()
    {
        // ControllerMain já valida login
        parent::__construct();
    }

    /** Dashboard que decide para onde levar o usuário */
    /** dashboard pós-login */
public function index()
{
    $nivel = (int) Session::get('userNivel');

    /* ───────── ADMIN / PROFESSOR ───────── */
    if ($nivel <= 21) {
        return $this->loadView('sistema/home', [
            'nome'  => Session::get('userNome'),
            'nivel' => $nivel
        ]);
    }

    /* ───────── ALUNO ───────── */
    if ($nivel === 31) {

        $projetos = $this->loadModel('ProjetoAluno')
                         ->listarProjetosDoAluno(Session::get('userId'));

        $reunioes = $this->loadModel('ReuniaoAluno')
                         ->listarReunioesDoAluno(Session::get('userId'));

        return $this->loadView('sistema/alunoHome', [
            'projetos' => $projetos,   // ← lista de projetos
            'reunioes' => $reunioes    // ← lista de reuniões (talvez vazia)
        ]);
    }

    /* ───────── Nível inesperado ───────── */
    return Redirect::page('login/signOut');
}

}
