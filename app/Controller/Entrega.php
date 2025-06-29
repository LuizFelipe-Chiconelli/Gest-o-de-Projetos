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
        parent::__construct();          // Verifica se o usuário está logado
        $this->validaNivelAcesso(31);   // Permite acesso para usuários com nível 31 ou inferior
        $this->loadHelper('formHelper'); // Carrega helper para formulários
    }

    /* ============ LISTA ==================================== */
    public function index()
    {
        // Monta a consulta para buscar as entregas com o nome do projeto
        $b = $this->model->db
             ->select(
                 // Define os campos que serão buscados (com alias para evitar conflitos)
                 'e.id        AS entrega_id,
                  e.*,
                  p.titulo    AS projeto'
             )
             ->table('entrega e') // Define a tabela principal (com alias)
             ->join('projeto p', 'p.id = e.projeto_id'); // Junta com a tabela de projeto

        // Se for um aluno (nível 31), filtra para mostrar apenas suas entregas
        if ((int) Session::get('userNivel') === 31) {
            $b->join('projeto_aluno pa','pa.projeto_id = e.projeto_id')
              ->where('pa.aluno_id', Session::get('userId'));
        }

        // Executa a busca e ordena pela data (mais recente primeiro)
        $entregas = $b->orderBy('e.data','DESC')->findAll();

        // Carrega a view da lista e envia as entregas
        return $this->loadView('sistema/listas/listaEntrega', $entregas);
    }

    /* ============ FORM ===================================== */
    public function form($action,$id)
    {
        // Carrega o formulário de entrega com os dados do ID (se houver)
        return $this->loadView('sistema/formularios/formEntrega', [
            'data' => $this->model->getById($id)
        ]);
    }

    /* ========================================================
       INSERIR / ATUALIZAR
       -------------------------------------------------------- */

    // Atualiza o status do projeto com base no status da entrega
    private function espelhaStatusProjeto(array $post): void
    {
        // Se a entrega for marcada como "Entregue" ou "Finalizado"
        if (in_array($post['status'], ['Entregue','Finalizado'])) {
            // Define o novo status do projeto com base no status da entrega
            $novo = $post['status'] === 'Finalizado' ? 'Concluído' : 'Entregue';

            // Atualiza o status na tabela projeto
            $this->model->db
                 ->table('projeto')
                 ->where('id', $post['projeto_id'])
                 ->update(['status' => $novo]);
        }
    }

    public function insert()
    {
        $post            = $this->request->getPost(); // Pega os dados do formulário
        $post['arquivo'] = null; // O upload do arquivo será feito depois

        $ok = $this->model->insert($post); // Tenta inserir no banco
        if ($ok) $this->espelhaStatusProjeto($post); // Atualiza o status do projeto se deu certo

        // Define a rota de retorno com base no nível do usuário
        $rota = (int) Session::get('userNivel') === 31 ? 'sistema' : 'entrega';

        // Redireciona com mensagem de sucesso ou erro
        return Redirect::page(
            $rota,
            $ok ? ['msgSucesso' => 'Entrega registrada.']
                : ['msgError'   => 'Falha ao registrar entrega.']
        );
    }

    public function update()
    {
        $post            = $this->request->getPost(); // Pega os dados do formulário
        $post['arquivo'] = null;

        $ok = $this->model->update($post); // Tenta atualizar os dados
        if ($ok) $this->espelhaStatusProjeto($post); // Atualiza o status do projeto se necessário

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
        // Tenta excluir o registro com base nos dados enviados por POST
        $ok = $this->model->delete($this->request->getPost());

        // Redireciona com mensagem de sucesso ou erro
        return Redirect::page(
            'entrega',
            $ok ? ['msgSucesso' => 'Entrega excluída.']
                : ['msgError'   => 'Falha ao excluir entrega.']
        );
    }
}
