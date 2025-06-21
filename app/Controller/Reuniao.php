<?php
/*--------------------------------------------------------------
 | Controller Reunião — CRUD
 *-------------------------------------------------------------*/
namespace App\Controller;

use Core\Library\ControllerMain;
use Core\Library\Redirect;
use Core\Library\Session;

class Reuniao extends ControllerMain
{
    public function __construct()
    {
        parent::__construct();

        /*  Admin 1-11 → total
         *  Professor 12-21 → reuniões dos seus projetos
         *  Aluno não entra                                  */
        $this->validaNivelAcesso(21);               // ← novo

        $this->loadHelper('formHelper');
    }

    /* ============ LISTA ===================================== */
    public function index()
    {
        $builder = $this->model->db
                   ->select('r.*, p.titulo AS projeto')
                   ->table('reuniao r')
                   ->join('projeto p','p.id = r.projeto_id');

        /* professor vê só seus projetos ---------------------- */
        if ((int) Session::get('userNivel') > 11) {            // ← novo
            $builder->where('p.professor_id', Session::get('userId'));
        }

        $dados = $builder->orderBy('r.data','DESC')->findAll();
        return $this->loadView('sistema/listas/listaReuniao', $dados);
    }

    /* ============ FORM ====================================== */
    public function form($action,$id)
    {
        $registro = $this->model->getById($id) ?? [];
        $profFix  = null;

        /* se professor logado, vamos travar o combo projeto --- */
        if ((int) Session::get('userNivel') > 11) {            // ← novo
            $profFix = Session::get('userId');
        }

        return $this->loadView('sistema/formularios/formReuniao',[
            'data'       => $registro,
            'profFix'    => $profFix                     // ← novo
        ]);
    }

    /* ============ INSERT ==================================== */
    public function insert()
    {
        $post = $this->request->getPost();
        $ok   = $this->model->insert($post);

        return Redirect::page(
            'reuniao',
            $ok ? ['msgSucesso'=>'Reunião registrada.']
                : ['msgError'  =>'Falha ao registrar reunião.']
        );
    }

    /* ============ UPDATE ==================================== */
    public function update()
    {
        $post = $this->request->getPost();
        $ok   = $this->model->update($post);

        return Redirect::page(
            'reuniao',
            $ok ? ['msgSucesso'=>'Reunião atualizada.']
                : ['msgError'  =>'Falha ao atualizar reunião.']
        );
    }

    /* ============ DELETE ==================================== */
    public function delete()
    {
        $ok = $this->model->delete($this->request->getPost());

        return Redirect::page(
            'reuniao',
            $ok ? ['msgSucesso'=>'Reunião excluída.']
                : ['msgError'  =>'Falha ao excluir reunião.']
        );
    }
}
