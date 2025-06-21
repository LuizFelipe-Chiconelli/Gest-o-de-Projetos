<?php
namespace App\Controller;

use Core\Library\ControllerMain;
use Core\Library\Session;
use Core\Library\Redirect;

class Sistema extends ControllerMain
{
    public function __construct()
    {
        parent::__construct(); // já valida login
    }

    /** Dashboard principal pós-login */
    public function index()
    {
        $nivel = (int) Session::get('userNivel');

        if ($nivel === 11) {
            return $this->loadView('sistema/home/admin');
        }

        if ($nivel === 21) {
            return $this->loadView('sistema/home/professor', [
                'nome' => Session::get('userNome')
            ]);
        }

        if ($nivel === 31) {
            return $this->carregarDadosAluno('sistema/home/aluno');
        }

        return Redirect::page('login/signOut');
    }

    /** Página de projetos + reuniões do aluno */
    public function listaAlunoProjReuniao()
    {
        $this->validaNivelAcesso(31); // acesso exclusivo para aluno
        return $this->carregarDadosAluno('sistema/listas/listaAlunoProjReuniao');
    }

    /** Método reutilizável para carregar dados do aluno */
    private function carregarDadosAluno(string $view)
    {
        $projetos = $this->loadModel('ProjetoAluno')
                         ->listarProjetosDoAluno(Session::get('userId'));

        $reunioes = $this->loadModel('ReuniaoAluno')
                         ->listarReunioesDoAluno(Session::get('userId'));

        return $this->loadView($view, [
            'projetos' => $projetos,
            'reunioes' => $reunioes
        ]);
    }
}
