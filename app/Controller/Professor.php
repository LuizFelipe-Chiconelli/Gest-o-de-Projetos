<?php
namespace App\Controller;

use Core\Library\ControllerMain;
use Core\Library\Redirect;

/**
 * CRUD Professor
 *  /Professor                → index()
 *  /Professor/form/insert/0  → form(insert,0)
 *  /Professor/insert         → insert()
 *  /Professor/update         → update()
 *  /Professor/delete         → delete()
 */
class Professor extends ControllerMain
{
    public function __construct()
    {
        parent::__construct();
        $this->validaNivelAcesso();   // nível 1-20
        $this->loadHelper('formHelper');
    }

    /* LISTA ---------------------------------------------------------- */
    public function index()
    {
        $dados = $this->model->lista('nome');
        return $this->loadView('sistema/listas/listaProfessor', $dados);
    }

    /* FORM ----------------------------------------------------------- */
    public function form($action, $id)
    {
        $dados = ['data' => $this->model->getById($id)];
        return $this->loadView('sistema/formularios/formProfessor', $dados);
    }

    /* INSERT --------------------------------------------------------- */
    public function insert()
    {
        $ok = $this->model->insert($this->request->getPost());

        return Redirect::page(
            $ok ? 'professor' : 'professor/form/insert/0',
            $ok ? ['msgSucesso'=>'Inserido com sucesso.'] : []
        );
    }

    /* UPDATE --------------------------------------------------------- */
    public function update()
    {
        $post = $this->request->getPost();
        $ok   = $this->model->update($post);

        return Redirect::page(
            $ok ? 'professor' : "professor/form/update/{$post['id']}",
            $ok ? ['msgSucesso'=>'Alterado com sucesso.'] : []
        );
    }

    /* DELETE --------------------------------------------------------- */
    public function delete()
    {
        $ok = $this->model->delete($this->request->getPost());

        return Redirect::page('professor',
            $ok ? ['msgSucesso'=>'Excluído.'] : []);
    }
}
