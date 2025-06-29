<?php
// Define o namespace e importa as classes principais usadas
namespace App\Controller;

use Core\Library\ControllerMain;
use Core\Library\Redirect;

// Classe do controller Aluno, que herda de ControllerMain
class Aluno extends ControllerMain
{
    public function __construct()
    {
        parent::__construct(); // Chama o construtor da classe pai (ControllerMain)
        $this->validaNivelAcesso();   // Verifica se o usuário tem permissão (nível 1-20)
        $this->loadHelper('formHelper'); // Carrega o helper de formulário
    }

    /* LISTA ---------------------------------------------------------- */
    public function index()
    {
        // Busca todos os alunos ordenados pelo nome
        $dados = $this->model->lista('nome');

        // Carrega a view de listagem e envia os dados dos alunos
        return $this->loadView('sistema/listas/listaAluno', $dados);
    }

    /* FORM ----------------------------------------------------------- */
    public function form($action, $id)
    {
        // Busca os dados de um aluno pelo ID e envia para o formulário
        $dados = ['data' => $this->model->getById($id)];

        // Carrega a view do formulário de aluno
        return $this->loadView('sistema/formularios/formAluno', $dados);
    }

    /* INSERT --------------------------------------------------------- */
    public function insert()
    {
        // Tenta inserir os dados recebidos via POST
        $ok = $this->model->insert($this->request->getPost());

        // Redireciona dependendo do resultado da inserção
        return Redirect::page(
            $ok ? 'aluno' : 'aluno/form/insert/0', // Se deu certo, volta pra lista. Senão, volta para o formulário
            $ok ? ['msgSucesso'=>'Inserido com sucesso.'] : [] // Mensagem de sucesso, se aplicável
        );
    }

    /* UPDATE --------------------------------------------------------- */
    public function update()
    {
        // Recebe os dados do formulário via POST
        $post = $this->request->getPost();

        // Tenta atualizar os dados
        $ok   = $this->model->update($post);

        // Redireciona dependendo do resultado da atualização
        return Redirect::page(
            $ok ? 'aluno' : "aluno/form/update/{$post['id']}", // Volta pra lista ou formulário
            $ok ? ['msgSucesso'=>'Alterado com sucesso.'] : [] // Mensagem de sucesso, se aplicável
        );
    }

    /* DELETE --------------------------------------------------------- */
    public function delete()
    {
        // Tenta excluir os dados recebidos via POST
        $ok = $this->model->delete($this->request->getPost());

        // Redireciona de volta para a lista com mensagem, se necessário
        return Redirect::page('aluno',
            $ok ? ['msgSucesso'=>'Excluído.'] : []);
    }
}
