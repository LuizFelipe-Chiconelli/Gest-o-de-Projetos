<?php
namespace App\Controller;

use Core\Library\ControllerMain;
use Core\Library\Redirect;

class Reuniao extends ControllerMain
{
    public function __construct()
    {
        parent::__construct();           // login verificado + model carregado
        $this->validaNivelAcesso();      // bloqueia nível >20
        $this->loadHelper('formHelper');
    }

    /* LISTA ---------------------------------------------------------- */
    public function index()
    {
        $dados = $this->model->db
              ->select('reuniao.*, projeto.titulo AS projeto')
              ->join('projeto','projeto.id = reuniao.projeto_id')
              ->orderBy('data','DESC')
              ->findAll();

        return $this->loadView('sistema/listaReuniao', $dados);
    }

    /* FORM ----------------------------------------------------------- */
    public function form(?string $action = null, ?int $id = null)
    {
        $ProjetoModel = $this->loadModel('Projeto');

        $dados = [
            'data'         => $this->model->getById($id),
            'listaProjeto' => $ProjetoModel->lista('titulo')
        ];

        return $this->loadView('sistema/formReuniao', $dados);
    }

    /* INSERT --------------------------------------------------------- */
    public function insert()
    {
        $ok = $this->model->insert($this->request->getPost());

        return Redirect::page(
            $ok ? 'reuniao' : 'reuniao/form/insert/0',
            $ok ? ['msgSucesso'=>'Inserida com sucesso.'] : []
        );
    }

    /* UPDATE --------------------------------------------------------- */
    public function update()
    {
        $post = $this->request->getPost();
        $ok   = $this->model->update($post);

        return Redirect::page(
            $ok ? 'reuniao' : "reuniao/form/update/{$post['id']}",
            $ok ? ['msgSucesso'=>'Alterada com sucesso.'] : []
        );
    }

    /* DELETE --------------------------------------------------------- */
    public function delete()
    {
        $ok = $this->model->delete($this->request->getPost());

        return Redirect::page('reuniao',
            $ok ? ['msgSucesso'=>'Excluída.'] : ['msgError'=>'Falha ao excluir.']
        );
    }
}
