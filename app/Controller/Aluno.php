<?php
namespace App\Controller;

use Core\Library\ControllerMain;
use Core\Library\Redirect;

class Aluno extends ControllerMain
{
    public function __construct()
    {
        parent::__construct();            // carrega model + helpers padrão
        $this->validaNivelAcesso();       // bloqueia quem tem nível >20 (21 é ok)

        // $this->validaNivelAcesso(11); // só super-admin e admin
        $this->loadHelper('formHelper');
    }

    /** Lista */
    public function index()
    {
        return $this->loadView(
            'sistema/listaAluno',
            $this->model->lista('nome')
        );
    }

    /** Formulário */
    public function form($action, $id)
    {
        $dados = ['data' => $this->model->getById($id)];
        return $this->loadView('sistema/formAluno', $dados);
    }

    /** Inserir */
    public function insert()
    {
        $ok = $this->model->insert($this->request->getPost());
        return Redirect::page(
            $ok ? 'Aluno' : 'Aluno/form/insert/0',
            $ok ? ['msgSucesso' => 'Inserido com sucesso.'] : []
        );
    }

    /** Atualizar */
    public function update()
    {
        $post = $this->request->getPost();
        $ok   = $this->model->update($post);

        return Redirect::page(
            $ok ? 'Aluno' : 'Aluno/form/update/'.$post['id'],
            $ok ? ['msgSucesso' => 'Alterado com sucesso.'] : []
        );
    }

    /** Excluir */
    public function delete()
    {
        $ok = $this->model->delete($this->request->getPost());
        return Redirect::page('Aluno', $ok ? ['msgSucesso'=>'Excluído.'] : []);
    }
}
