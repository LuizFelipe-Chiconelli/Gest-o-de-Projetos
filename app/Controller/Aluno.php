<?php
namespace App\Controller;

use Core\Library\ControllerMain;
use Core\Library\Redirect;
use Core\Library\Session;

class Aluno extends ControllerMain
{
    public function __construct()
    {
        parent::__construct();
        $this->validaNivelAcesso();        // até nível 20 (prof/adm)
        $this->loadHelper('formHelper');
    }

    /* LISTA --------------------------------------------------------- */
    public function index()
    {
        $dados = $this->model->lista('nome');
        return $this->loadView('sistema/listas/listaAluno', $dados);
    }

    /* FORM ---------------------------------------------------------- */
    public function form($action, $id)
    {
        $dados = ['data' => $this->model->getById($id)];
        return $this->loadView('sistema/formularios/formAluno', $dados);
    }

    /* INSERT -------------------------------------------------------- */
    public function insert()
    {
    $post = $this->request->getPost();

    /* ─── 1. valida senha ───────────────────────────── */
    if (empty($post['senha']) || $post['senha'] !== $post['confSenha']) {
        Session::set('errors', ['senha' => 'Senha vazia ou não confere.']);
        Session::set('inputs', $post);
        return Redirect::page('aluno/form/insert/0');
    }

    /* ─── 2. cria usuário ───────────────────────────── */
    $usuarioId = $this->loadModel('Usuario')->insertReturnId([
        'nome'           => trim($post['nome']),
        'email'          => strtolower(trim($post['email'])),
        'senha'          => password_hash($post['senha'], PASSWORD_DEFAULT),
        'nivel'          => 31,
        'statusRegistro' => $post['statusRegistro']
    ]);

    if (!$usuarioId) {
        Session::set('errors', ['email' => 'Falha ao criar usuário.']);
        Session::set('inputs', $post);
        return Redirect::page('aluno/form/insert/0');
    }

    /* ─── 3. gera RA aleatório e grava aluno ────────── */
    $post['usuario_id'] = $usuarioId;
    $post['ra']         = bin2hex(random_bytes(5));       // 10 caracteres

    unset($post['senha'], $post['confSenha']);            // não são colunas

    $ok = $this->model->insert($post);

    if (!$ok) { // rollback
        $this->loadModel('Usuario')->db->where('id', $usuarioId)->delete();
    }

    return Redirect::page(
        $ok ? 'aluno' : 'aluno/form/insert/0',
        $ok ? ['msgSucesso' => 'Inserido com sucesso.'] : []
    );
    }

    /* UPDATE -------------------------------------------------------- */
    public function update()
    {
        $post = $this->request->getPost();
        $ok   = $this->model->update($post);

        if ($ok) {
            /* sincroniza nome / e-mail / status no usuário ---------- */
            $this->loadModel('Usuario')->db
                 ->where('id', $post['usuario_id'])
                 ->update([
                     'nome'           => trim($post['nome']),
                     'email'          => strtolower(trim($post['email'])),
                     'statusRegistro' => $post['statusRegistro']
                 ]);
        }

        return Redirect::page(
            $ok ? 'aluno' : "aluno/form/update/{$post['id']}",
            $ok ? ['msgSucesso' => 'Alterado com sucesso.'] : []
        );
    }

    /* DELETE -------------------------------------------------------- */
    public function delete()
    {
        $idAluno = (int) ($this->request->getPost()['id']
                       ?? ($this->request->getRotaParametros()['id'] ?? 0));

        $aluno = $this->model->getById($idAluno);
        if (!$aluno) {
            return Redirect::page('aluno', ['msgError' => 'Aluno não encontrado.']);
        }

        /* 1. remove em aluno --------------------------------------- */
        $ok = $this->model->db->where('id', $idAluno)->delete();

        /* 2. remove usuário vinculado, se houver ------------------- */
        if ($ok && !empty($aluno['usuario_id'])) {
            $this->loadModel('Usuario')->db
                 ->where('id', $aluno['usuario_id'])->delete();
        }

        return Redirect::page(
            'aluno',
            $ok ? ['msgSucesso' => 'Excluído com sucesso.']
                : ['msgError'   => 'Falha ao excluir.']
        );
    }
}
