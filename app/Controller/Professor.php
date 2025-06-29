<?php
namespace App\Controller;

use Core\Library\ControllerMain;
use Core\Library\Redirect;
use Core\Library\Session;

class Professor extends ControllerMain
{
    public function __construct()
    {
        parent::__construct();
        $this->validaNivelAcesso();      // até nível 20 (adm / prof)
        $this->loadHelper('formHelper');
    }

    /* LISTA --------------------------------------------------------- */
    public function index()
    {
        $dados = $this->model->lista('nome');
        return $this->loadView('sistema/listas/listaProfessor', $dados);
    }

    /* FORM ---------------------------------------------------------- */
    public function form($action, $id)
    {
        $dados = ['data' => $this->model->getById($id)];
        return $this->loadView('sistema/formularios/formProfessor', $dados);
    }

    /* INSERT -------------------------------------------------------- */
    public function insert()
    {
        $post = $this->request->getPost();

        /* 1. valida senha ----------------------------------------- */
        if (empty($post['senha']) || $post['senha'] !== $post['confSenha']) {
            Session::set('errors', ['senha' => 'Senha vazia ou não confere.']);
            Session::set('inputs', $post);
            return Redirect::page('professor/form/insert/0');
        }

        /* 2. cria usuário ----------------------------------------- */
        $usuarioId = $this->loadModel('Usuario')->insertReturnId([
            'nome'           => trim($post['nome']),
            'email'          => strtolower(trim($post['email'])),
            'senha'          => password_hash($post['senha'], PASSWORD_DEFAULT),
            'nivel'          => 21,
            'statusRegistro' => $post['statusRegistro']
        ]);

        if (!$usuarioId) {
            Session::set('errors', ['email' => 'Falha ao criar usuário.']);
            Session::set('inputs', $post);
            return Redirect::page('professor/form/insert/0');
        }

        /* 3. grava professor -------------------------------------- */
        $post['usuario_id'] = $usuarioId;
        unset($post['senha'], $post['confSenha']);

        $ok = $this->model->insert($post);

        if (!$ok) {
            $this->loadModel('Usuario')->db->where('id', $usuarioId)->delete();
        }

        return Redirect::page(
            $ok ? 'professor' : 'professor/form/insert/0',
            $ok ? ['msgSucesso' => 'Inserido com sucesso.'] : []
        );
    }

    /* UPDATE -------------------------------------------------------- */
    public function update()
    {
        $post = $this->request->getPost();
        $ok   = $this->model->update($post);

        if ($ok) {
            /* sincroniza Nome / Email / Status -------------------- */
            $this->loadModel('Usuario')->db
                 ->where('id', $post['usuario_id'])
                 ->update([
                     'nome'           => trim($post['nome']),
                     'email'          => strtolower(trim($post['email'])),
                     'statusRegistro' => $post['statusRegistro']
                 ]);
        }

        return Redirect::page(
            $ok ? 'professor' : "professor/form/update/{$post['id']}",
            $ok ? ['msgSucesso' => 'Alterado com sucesso.'] : []
        );
    }

    /* DELETE -------------------------------------------------------- */
    public function delete()
    {
        $idProf = (int) ($this->request->getPost()['id']
                      ?? ($this->request->getRotaParametros()['id'] ?? 0));

        $prof = $this->model->getById($idProf);
        if (!$prof) {
            return Redirect::page('professor', ['msgError' => 'Professor não encontrado.']);
        }

        /* 1. remove professor ------------------------------------- */
        $ok = $this->model->db->where('id', $idProf)->delete();

        /* 2. remove usuário vinculado ----------------------------- */
        if ($ok && !empty($prof['usuario_id'])) {
            $this->loadModel('Usuario')->db
                 ->where('id', $prof['usuario_id'])->delete();
        }

        return Redirect::page(
            'professor',
            $ok ? ['msgSucesso' => 'Excluído com sucesso.']
                : ['msgError'   => 'Falha ao excluir.']
        );
    }
}
