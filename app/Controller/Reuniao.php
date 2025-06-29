<?php
/*--------------------------------------------------------------
 | Controller Reunião — CRUD
 *-------------------------------------------------------------*/
namespace App\Controller;

// Importa as bibliotecas necessárias
use Core\Library\ControllerMain;
use Core\Library\Redirect;
use Core\Library\Session;

// Controller responsável pelo CRUD de reuniões
class Reuniao extends ControllerMain
{
    public function __construct()
    {
        parent::__construct();

        /* Controle de acesso:
         * Admin (nível 1-11): vê e edita tudo
         * Professor (nível 12-21): vê apenas reuniões dos seus projetos
         * Aluno: não tem acesso */
        $this->validaNivelAcesso(21); // Permite até nível 21 (admin e professor)

        $this->loadHelper('formHelper'); // Carrega funções auxiliares para formulários
    }

    /* ============ LISTA ===================================== */
    public function index()
    {
        // Monta consulta para buscar as reuniões com o nome do projeto
        $builder = $this->model->db
                   ->select('r.*, p.titulo AS projeto') // Seleciona dados da reunião + nome do projeto
                   ->table('reuniao r')
                   ->join('projeto p','p.id = r.projeto_id');

        // Se for professor, mostra apenas reuniões de seus próprios projetos
        if ((int) Session::get('userNivel') > 11) {
            $builder->where('p.professor_id', Session::get('userId'));
        }

        // Busca as reuniões ordenadas pela data (mais recente primeiro)
        $dados = $builder->orderBy('r.data','DESC')->findAll();

        // Carrega a view com a lista de reuniões
        return $this->loadView('sistema/listas/listaReuniao', $dados);
    }

    /* ============ FORM ====================================== */
    public function form($action, $id)
    {
        $registro = $this->model->getById($id) ?? []; // Busca os dados da reunião
        $profFix  = null;

        // Se for professor logado, guarda o ID para travar a escolha do projeto na view
        if ((int) Session::get('userNivel') > 11) {
            $profFix = Session::get('userId');
        }

        // Carrega a view do formulário e envia os dados da reunião e do professor (se aplicável)
        return $this->loadView('sistema/formularios/formReuniao', [
            'data'    => $registro,
            'profFix' => $profFix
        ]);
    }

    /* ============ INSERT ==================================== */
    public function insert()
    {
        $post = $this->request->getPost();     // Pega os dados do formulário
        $ok   = $this->model->insert($post);   // Tenta inserir no banco

        // Redireciona com mensagem de sucesso ou erro
        return Redirect::page(
            'reuniao',
            $ok ? ['msgSucesso' => 'Reunião registrada.']
                : ['msgError'  => 'Falha ao registrar reunião.']
        );
    }

    /* ============ UPDATE ==================================== */
    public function update()
    {
        $post = $this->request->getPost();     // Pega os dados do formulário
        $ok   = $this->model->update($post);   // Tenta atualizar no banco

        // Redireciona com mensagem de sucesso ou erro
        return Redirect::page(
            'reuniao',
            $ok ? ['msgSucesso' => 'Reunião atualizada.']
                : ['msgError'  => 'Falha ao atualizar reunião.']
        );
    }

    /* ============ DELETE ==================================== */
    public function delete()
    {
        $ok = $this->model->delete($this->request->getPost()); // Tenta excluir a reunião

        // Redireciona com mensagem de sucesso ou erro
        return Redirect::page(
            'reuniao',
            $ok ? ['msgSucesso' => 'Reunião excluída.']
                : ['msgError'  => 'Falha ao excluir reunião.']
        );
    }
}
