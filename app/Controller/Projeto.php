<?php
namespace App\Controller;

use Core\Library\ControllerMain;
use Core\Library\Redirect;
use Core\Library\Session;
use App\Model\ProjetoAlunoModel;

class Projeto extends ControllerMain
{
    public function __construct()
    {
        parent::__construct();
        $this->validaNivelAcesso(21);
        $this->loadHelper('formHelper');
    }

    public function index()
{
    $builder = $this->model->db
        ->select('projeto.id, projeto.titulo, projeto.area, projeto.status, projeto.inicio, professor.nome AS professor')
        ->table('projeto')
        ->join('professor', 'professor.id = projeto.professor_id', 'LEFT');

    if ((int) Session::get('userNivel') > 11) {
        $userId = Session::get('userId');
        $builder->where('projeto.professor_id', $userId);
    }

    $dados = $builder->orderBy('projeto.inicio','DESC')->findAll();

    return $this->loadView('sistema/listaProjeto', $dados);
    }

    public function form($action, $id)
    {
        $registro = $this->model->getById($id) ?: [];
        $profFix = ((int) Session::get('userNivel') > 11)
                   ? Session::get('userId')
                   : null;

        return $this->loadView('sistema/formProjeto', [
            'data'      => $registro,
            'profLogado'=> $profFix
        ]);
    }

    public function insert()
    {
        $post   = $this->request->getPost();
        $alunos = $post['alunos_id'] ?? [];
        unset($post['alunos_id']);

        $idProjeto = $this->model->insert($post);
        if ($idProjeto) {
            $pivot = new ProjetoAlunoModel();
            foreach ($alunos as $aId) {
                $pivot->insert([
                    'projeto_id' => $idProjeto,
                    'aluno_id'   => $aId
                ]);
            }
            return Redirect::page('projeto', ['msgSucesso'=>'Inserido com sucesso.']);
        }

        return Redirect::page('projeto/form/insert/0', ['msgError'=>'Falha ao inserir.']);
    }

    public function update()
    {
        $post   = $this->request->getPost();
        $id     = $post['id'] ?? 0;
        $alunos = $post['alunos_id'] ?? [];
        unset($post['id'], $post['alunos_id']);

        $ok = $this->model->db->where('id', $id)->update($post);

        if ($ok) {
            $pivot = new ProjetoAlunoModel();
            $pivot->db->where('projeto_id', $id)->delete();
            foreach ($alunos as $aId) {
                $pivot->insert([
                    'projeto_id' => $id,
                    'aluno_id'   => $aId
                ]);
            }
            return Redirect::page('projeto', ['msgSucesso'=>'Alterado com sucesso.']);
        }

        return Redirect::page("projeto/form/update/{$id}", ['msgError'=>'Falha ao atualizar.']);
    }

    public function delete()
    {
    $post = $this->request->getPost();
    $id   = $post['id'] ?? null;

    if (!$id) {
        return Redirect::page('projeto', ['msgError' => 'ID inválido.']);
    }

    $pivot = new \App\Model\ProjetoAlunoModel();
    $pivot->db->where('projeto_id', $id)->delete();

    $ok = $this->model->db->where('id', $id)->delete();

    return Redirect::page('projeto', $ok
        ? ['msgSucesso' => 'Excluído com sucesso.']
        : ['msgError' => 'Falha ao excluir.']
    );
    }


}
