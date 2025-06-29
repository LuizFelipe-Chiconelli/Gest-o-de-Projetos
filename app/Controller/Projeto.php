<?php
// Define o namespace do controller
namespace App\Controller;

// Importa as classes necessárias
use Core\Library\ControllerMain;
use Core\Library\Redirect;
use Core\Library\Session;
use App\Model\ProjetoAlunoModel;

// Controller responsável pelas ações relacionadas ao projeto
class Projeto extends ControllerMain
{
    public function __construct()
    {
        parent::__construct();             // Chama o construtor da classe pai
        $this->validaNivelAcesso(21);      // Permite acesso a usuários com nível até 21
        $this->loadHelper('formHelper');   // Carrega o helper para formulários
    }

    // Lista os projetos cadastrados no sistema
    public function index()
    {
        // Monta a consulta para listar os projetos
        $builder = $this->model->db
            // JOIN com a tabela professor para exibir o nome do professor
            ->select('projeto.id, projeto.titulo, projeto.area, projeto.status, projeto.inicio, professor.nome AS professor')
            ->table('projeto')
            ->join('professor', 'professor.id = projeto.professor_id', 'LEFT');

        // Se o usuário logado for professor, mostra só os projetos dele
        if ((int) Session::get('userNivel') > 11) {
            $userId = Session::get('userId');
            $builder->where('projeto.professor_id', $userId);
        }

        // Ordena por data de início e busca todos os registros
        $dados = $builder->orderBy('projeto.inicio','DESC')->findAll();

        // Carrega a view da lista de projetos
        return $this->loadView('sistema/listas/listaProjeto', $dados);
    }

    // Exibe o formulário de cadastro ou edição de projeto
    // aqui nos temos dois parametros, a açao e o id do projeto
    public function form($action, $id)
    {
        $registro = $this->model->getById($id) ?: []; // Busca os dados do projeto

        // Se for professor, define o ID do professor logado
        $profFix = ((int) Session::get('userNivel') > 11)
                   ? Session::get('userId')
                   : null;

        // Carrega a view do formulário e envia os dados
        return $this->loadView('sistema/formularios/formProjeto', [
            'data'       => $registro,
            'profLogado' => $profFix
        ]);
    }

    // Insere novo projeto e vincula os alunos a ele
    public function insert()
    {
        $post   = $this->request->getPost();           // Pega os dados do formulário

        // Captura os IDs dos alunos selecionados dentro do form e remove do array principal
        $alunos = $post['alunos_id'] ?? [];
        unset($post['alunos_id']);

        // Insere os dados do projeto
        $idProjeto = $this->model->insert($post);

        if ($idProjeto) {
            $pivot = new ProjetoAlunoModel();

            // Para cada aluno selecionado, cria vínculo com o projeto
            foreach ($alunos as $aId) {
                $pivot->insert([
                    'projeto_id' => $idProjeto,
                    'aluno_id'   => $aId
                ]);
            }

            // Redireciona para a lista com mensagem de sucesso
            return Redirect::page('projeto', ['msgSucesso'=>'Inserido com sucesso.']);
        }

        // Se falhar, retorna para o formulário com erro
        return Redirect::page('projeto/form/insert/0', ['msgError'=>'Falha ao inserir.']);
    }

    // Atualiza um projeto e seus vínculos com alunos
    public function update()
    {
        $post   = $this->request->getPost();        // Dados do formulário
        $id     = $post['id'] ?? 0;                 // ID do projeto
        $alunos = $post['alunos_id'] ?? [];         // IDs dos alunos selecionados
        unset($post['id'], $post['alunos_id']);     // Remove do array antes de atualizar

        // Atualiza os dados do projeto
        $ok = $this->model->db->where('id', $id)->update($post);

        if ($ok) {
            $pivot = new ProjetoAlunoModel();

            // Remove os vínculos antigos com alunos
            $pivot->db->where('projeto_id', $id)->delete();

            // Insere os novos vínculos
            foreach ($alunos as $aId) {
                $pivot->insert([
                    'projeto_id' => $id,
                    'aluno_id'   => $aId
                ]);
            }

            // Redireciona com sucesso
            return Redirect::page('projeto', ['msgSucesso'=>'Alterado com sucesso.']);
        }

        // Se falhar, volta para o formulário de edição
        return Redirect::page("projeto/form/update/{$id}", ['msgError'=>'Falha ao atualizar.']);
    }

    // Exclui um projeto e seus vínculos com alunos
    public function delete()
    {
        $post = $this->request->getPost();    // Pega os dados enviados via POST
        $id   = $post['id'] ?? null;          // Pega o ID do projeto

        // Se o ID for inválido, retorna com erro
        if (!$id) {
            return Redirect::page('projeto', ['msgError' => 'ID inválido.']);
        }

        $pivot = new \App\Model\ProjetoAlunoModel();

        // Remove os vínculos com alunos
        $pivot->db->where('projeto_id', $id)->delete();

        // Exclui o projeto
        $ok = $this->model->db->where('id', $id)->delete();

        // Redireciona com sucesso ou erro
        return Redirect::page('projeto', $ok
            ? ['msgSucesso' => 'Excluído com sucesso.']
            : ['msgError'   => 'Falha ao excluir.']
        );
    }

    private function normalizaData($str)
{   
    // se já vier yyyy-mm-dd, mantém
    if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $str)) return $str;

    // caso  dd/mm/aaaa  →  aaaa-mm-dd
    $dt = \DateTime::createFromFormat('d/m/Y', $str);
    return $dt ? $dt->format('Y-m-d') : $str;
}
}
