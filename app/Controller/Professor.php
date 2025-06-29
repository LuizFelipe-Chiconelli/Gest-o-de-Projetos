<?php
// Define o namespace e importa as bibliotecas necessárias
namespace App\Controller;

use Core\Library\ControllerMain;
use Core\Library\Redirect;

/**
 * Controller responsável pelo CRUD de Professor
 *  /Professor                → index()
 *  /Professor/form/insert/0 → form(insert,0)
 *  /Professor/insert        → insert()
 *  /Professor/update        → update()
 *  /Professor/delete        → delete()
 */
class Professor extends ControllerMain
{
    public function __construct()
    {
        parent::__construct();              // Chama o construtor da classe pai
        $this->validaNivelAcesso();         // Permite acesso a usuários com nível entre 1 e 20
        $this->loadHelper('formHelper');    // Carrega o helper para formulários
    }

    /* LISTA ---------------------------------------------------------- */
    public function index()
    {
        // Busca todos os professores, ordenados por nome
        $dados = $this->model->lista('nome');

        // Carrega a view da lista de professores, passando os dados
        return $this->loadView('sistema/listas/listaProfessor', $dados);
    }

    /* FORM ----------------------------------------------------------- */
    public function form($action, $id)
    {
        // Busca os dados do professor pelo ID para preencher o formulário
        $dados = ['data' => $this->model->getById($id)];

        // Carrega o formulário com os dados
        return $this->loadView('sistema/formularios/formProfessor', $dados);
    }

    /* INSERT --------------------------------------------------------- */
    public function insert()
    {
        // Recebe os dados do formulário e tenta inserir no banco
        $ok = $this->model->insert($this->request->getPost());

        // Redireciona para a lista ou retorna ao formulário em caso de erro
        return Redirect::page(
            $ok ? 'professor' : 'professor/form/insert/0',
            $ok ? ['msgSucesso'=>'Inserido com sucesso.'] : []
        );
    }

    /* UPDATE --------------------------------------------------------- */
    public function update()
    {
        // Recebe os dados do formulário via POST
        $post = $this->request->getPost();

        // Tenta atualizar os dados no banco
        $ok   = $this->model->update($post);

        // Redireciona para a lista ou retorna ao formulário em caso de erro
        return Redirect::page(
            $ok ? 'professor' : "professor/form/update/{$post['id']}",
            $ok ? ['msgSucesso'=>'Alterado com sucesso.'] : []
        );
    }

    /* DELETE --------------------------------------------------------- */
    public function delete()
    {
        // Tenta excluir o professor com base nos dados recebidos
        $ok = $this->model->delete($this->request->getPost());

        // Redireciona de volta para a lista com mensagem de sucesso ou não
        return Redirect::page('professor',
            $ok ? ['msgSucesso'=>'Excluído.'] : []);
    }
}
