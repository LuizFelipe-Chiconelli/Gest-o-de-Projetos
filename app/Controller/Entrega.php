<?php
namespace App\Controller;

use Core\Library\ControllerMain;
use Core\Library\Redirect;
use Core\Library\Files;   // upload
use Core\Library\Session;

class Entrega extends ControllerMain
{
    private $files;

    public function __construct()
    {
        parent::__construct();            // carrega model + helpers padrão
        $this->validaNivelAcesso();       // bloqueia quem tem nível >20 (21 é ok)

        $this->loadHelper('formHelper');
        $this->files = new Files();  // usa pasta uploads/entrega por padrão
    }

    /* LISTA ------------------------------------------------------------ */
    public function index()
    {
        $dados = $this->model->lista('data','DESC');
        return $this->loadView('sistema/listaEntrega', $dados);
    }

    /* FORM ------------------------------------------------------------- */
    public function form($action,$id)
    {
        $dados = ['data'=>$this->model->getById($id)];
        return $this->loadView('sistema/formEntrega', $dados);
    }

    /* INSERT ----------------------------------------------------------- */
    public function insert()
    {
        $post = $this->request->getPost();

        // remove nomeArquivo caso venha vazio
        unset($post['nomeArquivo']);

        // faz upload se o usuário selecionou arquivo
        if (!empty($_FILES['arquivo']['name'])) {
            $nome = $this->files->upload($_FILES, 'entrega');  // pasta uploads/entrega
            if (!$nome) {      // se deu erro no upload
                return Redirect::page('Entrega/form/insert/0');
            }
            $post['arquivo'] = $nome[0];     // salva nome do arquivo no banco
        }

        /* 3. grava no banco */
        $ok = $this->model->insert($post);
        
        /* 4. redireciona */
        return Redirect::page(
            $ok ? 'Entrega' : 'Entrega/form/insert/0',
            $ok ? ['msgSucesso'=>'Inserido com sucesso.'] : []
        );
    }

    /* UPDATE ----------------------------------------------------------- */
    public function update()
    {
        $post = $this->request->getPost();

        if (!empty($_FILES['arquivo']['name'])) {
            // novo arquivo → faz upload
            $nome = $this->files->upload($_FILES, 'entrega');
            if (!$nome) {
                return Redirect::page('Entrega/form/update/'.$post['id']);
            }
            $post['arquivo'] = $nome[0];
        } else {
            // manteve o arquivo antigo
            $post['arquivo'] = $post['nomeArquivo'];
        }

        unset($post['nomeArquivo']);  // remove campo auxiliar

        $ok = $this->model->update($post);

        return Redirect::page(
            $ok ? 'Entrega' : 'Entrega/form/update/'.$post['id'],
            $ok ? ['msgSucesso'=>'Alterado com sucesso.'] : []
        );
    }

    /* DELETE ----------------------------------------------------------- */
    public function delete()
    {
        $post = $this->request->getPost();
        $ok   = $this->model->delete($post);

        // se excluiu e havia arquivo, remove da pasta
        if ($ok && $post['nomeArquivo']) {
            $this->files->delete($post['nomeArquivo'], 'entrega');
        }

        return Redirect::page('Entrega',
            $ok ? ['msgSucesso'=>'Excluído.'] : []);
    }
}
