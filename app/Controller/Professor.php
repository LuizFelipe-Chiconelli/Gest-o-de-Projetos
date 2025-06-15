<?php
// app/Controller/Professor.php
namespace App\Controller;

use Core\Library\ControllerMain;   // classe-mãe com helpers e loadView
use Core\Library\Redirect;

/**
 * Controller do CRUD Professor
 * Rotas automáticas:
 *   /Professor               → index()
 *   /Professor/form/insert/0 → form('insert',0)
 *   /Professor/insert        → insert()
 *   /Professor/update        → update()
 *   /Professor/delete        → delete()
 */
class Professor extends ControllerMain
{
    public function __construct()
    {
        parent::__construct();            // carrega model + helpers padrão
        $this->validaNivelAcesso();       // bloqueia quem tem nível >20 (21 é ok)

        /* se quiser restringir mais:  */
        // $this->validaNivelAcesso(11); // só super-admin e admin
    $this->loadHelper('formHelper');
    }

    /** Lista todos os professores */
    public function index()
    {
        $dados = $this->model->lista('nome');      // ordena por nome
        return $this->loadView('sistema/listaProfessor', $dados);
    }

    /** Formulário Novo / Editar / Excluir / Visualizar */
    public function form($action, $id)
    {
        $dados = ['data' => $this->model->getById($id)];
        return $this->loadView('sistema/formProfessor', $dados);
    }

    /** Grava novo registro */
    public function insert()
    {
        $post = $this->request->getPost();
        $ok   = $this->model->insert($post);

        return Redirect::page(
            $ok ? 'Professor' : 'Professor/form/insert/0',
            $ok ? ['msgSucesso' => 'Inserido com sucesso.'] : []
        );
    }

    /** Atualiza registro */
    public function update()
    {
        $post = $this->request->getPost();
        $ok   = $this->model->update($post);

        return Redirect::page(
            $ok ? 'Professor' : 'Professor/form/update/'.$post['id'],
            $ok ? ['msgSucesso' => 'Alterado com sucesso.'] : []
        );
    }

    /** Exclui registro */
    public function delete()
    {
        $post = $this->request->getPost();
        $ok   = $this->model->delete($post);

        return Redirect::page('Professor', $ok ? ['msgSucesso' => 'Excluído.'] : []);
    }
}
