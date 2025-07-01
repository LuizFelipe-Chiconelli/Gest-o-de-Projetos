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
            ->select('p.id, p.titulo, p.area, p.status, p.inicio, pr.nome AS professor')
            ->table('projeto p')
            ->join('professor pr', 'pr.id = p.professor_id', 'LEFT');

        if ((int) Session::get('userNivel') > 11) {
            $builder->where('p.professor_id', Session::get('userId'));
        }

        $dados = $builder->orderBy('p.inicio','DESC')->findAll();
        return $this->loadView('sistema/listas/listaProjeto', $dados);
    }

    public function form($action, $id)
    {
        $registro = $this->model->getById($id) ?: [];
        $profFix  = ((int) Session::get('userNivel') > 11)
                    ? Session::get('userId')
                    : null;

        // passo o próprio ID do projeto direto, para usar no view
        return $this->loadView('sistema/formularios/formProjeto', [
            'data'       => $registro,
            'profLogado' => $profFix,
            'projId'     => $id
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

        $pivot->db->where('projeto_id', $idProjeto)->delete();

        foreach ($alunos as $aId) {
            $pivot->insert([
                'projeto_id' => $idProjeto,
                'aluno_id'   => $aId
            ]);
        }

        return Redirect::page('projeto', [
            'msgSucesso' => 'Inserido com sucesso.'
        ]);
    }

    return Redirect::page('projeto/form/insert/0', [
        'msgError' => 'Falha ao inserir.'
    ]);
    }

    public function update()
    {
        $post   = $this->request->getPost();
        $id     = (int) ($post['id'] ?? 0);
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
            return Redirect::page('projeto', ['msgError'=>'ID inválido.']);
        }

        $pivot = new ProjetoAlunoModel();
        $pivot->db->where('projeto_id', $id)->delete();
        $ok = $this->model->db->where('id', $id)->delete();

        return Redirect::page(
            'projeto',
            $ok ? ['msgSucesso'=>'Excluído com sucesso.']
                : ['msgError'=>'Falha ao excluir.']
        );
    }

    private function normalizaData($str)
    {
        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $str)) return $str;
        $dt = \DateTime::createFromFormat('d/m/Y', $str);
        return $dt ? $dt->format('Y-m-d') : $str;
    }
}
