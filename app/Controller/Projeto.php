<?php
namespace App\Controller;

use Core\Library\ControllerMain;
use Core\Library\Redirect;
use App\Model\ProjetoAlunoModel;

class Projeto extends ControllerMain
{
    public function __construct()
    {
        parent::__construct();
        $this->validaNivelAcesso();      // nível 1-20
        $this->loadHelper('formHelper');
    }

    /* LISTA ---------------------------------------------------------- */
    public function index()
    {
        $dados = $this->model->listaProjeto();   // usa JOIN
        return $this->loadView('sistema/listaProjeto', $dados);
    }

    /* FORM ----------------------------------------------------------- */
    public function form($action, $id)
    {
        $dados = ['data' => $this->model->getById($id)];
        return $this->loadView('sistema/formProjeto', $dados);
    }

    /* INSERT --------------------------------------------------------- */
    public function insert()
    {
        $post   = $this->request->getPost();
        $alunos = $post['alunos_id'] ?? [];
        unset($post['alunos_id']);

        $idProjeto = $this->model->db->insert($post);

        if ($idProjeto > 0) {
            $pivot = new ProjetoAlunoModel();
            foreach ($alunos as $aId) {
                $pivot->insert(['projeto_id'=>$idProjeto,'aluno_id'=>$aId]);
            }
            return Redirect::page('projeto',['msgSucesso'=>'Inserido com sucesso.']);
        }
        return Redirect::page('projeto/form/insert/0');
    }

    /* UPDATE --------------------------------------------------------- */
    public function update()
    {
        $post   = $this->request->getPost();
        $alunos = $post['alunos_id'] ?? [];
        unset($post['alunos_id']);

        $ok = $this->model->update($post);

        if ($ok) {
            $pivot = new ProjetoAlunoModel();
            $pivot->db->where('projeto_id',$post['id'])->delete();
            foreach ($alunos as $aId){
                $pivot->insert(['projeto_id'=>$post['id'],'aluno_id'=>$aId]);
            }
        }
        return Redirect::page('projeto',
            $ok ? ['msgSucesso'=>'Alterado com sucesso.'] : []);
    }

    /* DELETE --------------------------------------------------------- */
    public function delete()
    {
        $ok = $this->model->delete($this->request->getPost());
        return Redirect::page('projeto',
            $ok ? ['msgSucesso'=>'Excluído.'] : []);
    }
}
