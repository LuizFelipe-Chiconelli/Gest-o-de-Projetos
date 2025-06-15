<?php
/*
 |--------------------------------------------------------------
 |  Controller Reuniao
 |  Rotas automáticas
 |   /Reuniao                       → index()
 |   /Reuniao/form/insert/0         → form('insert',0)
 |   /Reuniao/insert                → insert()
 |   /Reuniao/update                → update()
 |   /Reuniao/delete                → delete()
 |--------------------------------------------------------------
*/
namespace App\Controller;

use Core\Library\ControllerMain; // classe base
use Core\Library\Redirect;

class Reuniao extends ControllerMain
{
    public function __construct()
    {
        parent::__construct();            // carrega model + helpers padrão
        $this->validaNivelAcesso();       // bloqueia quem tem nível >20 (21 é ok)

        /* se quiser restringir mais:  */
        // $this->validaNivelAcesso(11); // só super-admin e admin
        $this->loadHelper('formHelper');
    }

    /** Lista todas as reuniões ------------- */
    public function index()
    {
        // busca ordenado por data (mais recente primeiro)
        $dados = $this->model->lista('data','DESC');
        return $this->loadView('sistema/listaReuniao', $dados);
    }

    /** Formulário (novo / editar / excluir) */
    public function form($action, $id)
    {
        // $id == 0 → cadastro novo; senão, busca registro para edição
        $dados = ['data' => $this->model->getById($id)];
        return $this->loadView('sistema/formReuniao', $dados);
    }

    /** Gravar novo registro ---------------- */
    public function insert()
    {
        $ok = $this->model->insert($this->request->getPost());

        // se ok ⇒ volta para lista; senão ⇒ volta para o form
        return Redirect::page(
            $ok ? 'Reuniao' : 'Reuniao/form/insert/0',
            $ok ? ['msgSucesso' => 'Inserido com sucesso.'] : []
        );
    }

    /** Atualizar registro existente -------- */
    public function update()
    {
        $post = $this->request->getPost();
        $ok   = $this->model->update($post);

        return Redirect::page(
            $ok ? 'Reuniao' : 'Reuniao/form/update/'.$post['id'],
            $ok ? ['msgSucesso' => 'Alterado com sucesso.'] : []
        );
    }

    /** Excluir registro -------------------- */
    public function delete()
    {
        $ok = $this->model->delete($this->request->getPost());

        return Redirect::page('Reuniao',
            $ok ? ['msgSucesso' => 'Excluído.'] : []);
    }
}
