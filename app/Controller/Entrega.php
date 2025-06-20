<?php
/*--------------------------------------------------------------
 | Controller Entrega — CRUD (admin / prof / aluno)
 *-------------------------------------------------------------*/
namespace App\Controller;

use Core\Library\ControllerMain;
use Core\Library\Redirect;
use Core\Library\Session;

class Entrega extends ControllerMain
{
    public function __construct()
    {
        parent::__construct();          // exige login
        $this->validaNivelAcesso(31);   // libera níveis ≤31
        $this->loadHelper('formHelper');
    }

    /* ============ LISTA ==================================== */
    public function index()
    {
        /* monta a consulta */
        $b = $this->model->db
             ->select(
                 // alias “entrega_id” evita conflito de nomes na view
                 'e.id        AS entrega_id,
                  e.*,
                  p.titulo    AS projeto'
             )
             ->table('entrega e')
             ->join('projeto p', 'p.id = e.projeto_id');

        /* aluno vê somente as SUAS entregas ------------------ */
        if ((int) Session::get('userNivel') === 31) {
            $b->join('projeto_aluno pa','pa.projeto_id = e.projeto_id')
              ->where('pa.aluno_id', Session::get('userId'));
        }

        $entregas = $b->orderBy('e.data','DESC')->findAll();

        return $this->loadView('sistema/listaEntrega', $entregas);
    }

    /* ============ FORM ===================================== */
    public function form($action,$id)
    {
        return $this->loadView('sistema/formEntrega', [
            'data' => $this->model->getById($id)
        ]);
    }

    /* ========================================================
       INSERIR / ATUALIZAR
       -------------------------------------------------------- */
    private function espelhaStatusProjeto(array $post): void
    {
        /* altera o status do projeto se a entrega foi concluída */
        if (in_array($post['status'], ['Entregue','Finalizado'])) {
            $novo = $post['status'] === 'Finalizado' ? 'Concluído' : 'Entregue';

            $this->model->db
                 ->table('projeto')
                 ->where('id', $post['projeto_id'])
                 ->update(['status' => $novo]);
        }
    }

    public function insert()
    {
        $post            = $this->request->getPost();
        $post['arquivo'] = null;                 // upload ficará para depois

        $ok = $this->model->insert($post);
        if ($ok) $this->espelhaStatusProjeto($post);

        /* aluno volta ao dashboard, professor/admin à lista */
        $rota = (int) Session::get('userNivel') === 31 ? 'sistema' : 'entrega';

        return Redirect::page(
            $rota,
            $ok ? ['msgSucesso' => 'Entrega registrada.']
                : ['msgError'   => 'Falha ao registrar entrega.']
        );
    }

    public function update()
    {
        $post            = $this->request->getPost();
        $post['arquivo'] = null;

        $ok = $this->model->update($post);
        if ($ok) $this->espelhaStatusProjeto($post);

        $rota = (int) Session::get('userNivel') === 31 ? 'sistema' : 'entrega';

        return Redirect::page(
            $rota,
            $ok ? ['msgSucesso' => 'Entrega atualizada.']
                : ['msgError'   => 'Falha ao atualizar entrega.']
        );
    }

    /* ============ DELETE =================================== */
    public function delete()
    {
        $ok = $this->model->delete($this->request->getPost());

        return Redirect::page(
            'entrega',
            $ok ? ['msgSucesso' => 'Entrega excluída.']
                : ['msgError'   => 'Falha ao excluir entrega.']
        );
    }
}
