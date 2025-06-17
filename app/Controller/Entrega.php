<?php
namespace App\Controller;

use Core\Library\ControllerMain;
use Core\Library\Redirect;
use Core\Library\Files;      // upload helper

class Entrega extends ControllerMain
{
    private Files $files;     // gerencia uploads

    public function __construct()
    {
        parent::__construct();
        $this->validaNivelAcesso();      // nível 1-20
        $this->loadHelper('formHelper');
        $this->files = new Files();      // usa “uploads/” como base
    }

    /* LISTA ---------------------------------------------------------- */
    public function index()
    {
         // monta a consulta já com o título do projeto
        $dados = $this->model->db
              ->select('entrega.*, projeto.titulo AS projeto')
              ->join  ('projeto', 'projeto.id = entrega.projeto_id')
              ->orderBy('data', 'DESC')
              ->findAll();

        //renderiza a view
        return $this->loadView('sistema/listaEntrega', $dados);
        
        
    }

    /* FORM ----------------------------------------------------------- */
    public function form($action,$id)
    {
        $dados = ['data'=>$this->model->getById($id)];
        return $this->loadView('sistema/formEntrega', $dados);
    }

    /* INSERT --------------------------------------------------------- */
    public function insert()
    {
        $post = $this->request->getPost();

        /* upload (opcional) */
        if (!empty($_FILES['arquivo']['name'])) {
            $nome = $this->files->upload($_FILES,'entrega');
            if (!$nome) {
                return Redirect::page('entrega/form/insert/0');   // mensagem já no helper
            }
            $post['arquivo'] = $nome[0];
        }

        $ok = $this->model->insert($post);

        return Redirect::page(
            $ok ? 'entrega' : 'entrega/form/insert/0',
            $ok ? ['msgSucesso'=>'Inserido com sucesso.'] : []
        );
    }

    /* UPDATE --------------------------------------------------------- */
    public function update()
    {
        $post = $this->request->getPost();

        /* se usuário escolheu novo arquivo, faz upload e substitui */
        if (!empty($_FILES['arquivo']['name'])) {
            $nome = $this->files->upload($_FILES,'entrega');
            if (!$nome) {
                return Redirect::page('entrega/form/update/'.$post['id']);
            }
            $post['arquivo'] = $nome[0];
        } else {
            $post['arquivo'] = $post['nomeArquivo'];   // mantém o antigo
        }

        unset($post['nomeArquivo']);

        $ok = $this->model->update($post);

        return Redirect::page(
            $ok ? 'entrega' : 'entrega/form/update/'.$post['id'],
            $ok ? ['msgSucesso'=>'Alterado com sucesso.'] : []
        );
    }

    /* DELETE --------------------------------------------------------- */
    public function delete()
    {
        $post = $this->request->getPost();
        $ok   = $this->model->delete($post);

        /* se excluiu registro e havia arquivo, remove-o da pasta */
        if ($ok && !empty($post['nomeArquivo'])) {
            $this->files->delete($post['nomeArquivo'],'entrega');
        }

        return Redirect::page('entrega',
            $ok ? ['msgSucesso'=>'Excluído.'] : []);
    }
}
