<?php
// app/Controller/Projeto.php
namespace App\Controller;

use Core\Library\ControllerMain;     // classe-mãe (helpers + loadView)
use Core\Library\Redirect;           // redireciona mantendo mensagens
use App\Model\ProjetoAlunoModel;     // model da tabela pivot

/**
 * CRUD Projeto
 *  /Projeto                → index()
 *  /Projeto/form/insert/0  → form(insert,0)
 *  /Projeto/insert         → insert()
 *  /Projeto/update         → update()
 *  /Projeto/delete         → delete()
 */
class Projeto extends ControllerMain
{
    public function __construct()
    {
        parent::__construct();            // carrega model + helpers padrão
        $this->validaNivelAcesso();       // bloqueia quem tem nível >20 (21 é ok)

        /* se quiser restringir mais:  */
        // $this->validaNivelAcesso(11); // só super-admin e admin
        $this->loadHelper('formHelper');
    }

    /* ============================ LISTA ============================ */
    public function index()
    {
        // lista ordenada por título
        $dados = $this->model->lista('titulo');
        return $this->loadView('sistema/listaProjeto', $dados);
    }

    /* ============================ FORM ============================= */
    public function form($action, $id)
    {
        // carrega dados do projeto (ou vazio para "novo")
        $dados = ['data' => $this->model->getById($id)];
        return $this->loadView('sistema/formProjeto', $dados);
    }

    /* ============================ INSERT =========================== */
    public function insert()
    {
        /* -----------------------------------------------------------------
         | 1. Separa dados:
         |    - $alunos contém o array de checkbox   alunos_id[]
         |    - $post   contém somente colunas da tabela projeto
         *-----------------------------------------------------------------*/
        $post   = $this->request->getPost();
        $alunos = $post['alunos_id'] ?? [];
        unset($post['alunos_id']);                 // tira do insert principal

        /* 2. Validação + grava no BD PROJETO
         | -------------------------------------------------------------- */
        $idProjeto = $this->model->db->insert($post);   // retorna novo id

        if ($idProjeto > 0) {
            /* 3. Grava vínculos na tabela PIVOT projeto_aluno */
            $pivot = new ProjetoAlunoModel();
            foreach ($alunos as $idAluno) {
                $pivot->insert([
                    'projeto_id' => $idProjeto,
                    'aluno_id'   => $idAluno
                    // 'funcao' => 'Participante'  // opcional
                ]);
            }
            /* 4. OK → volta para lista */
            return Redirect::page('Projeto', ['msgSucesso'=>'Inserido com sucesso.']);
        }

        /* Erro de validação / insert → volta para o form */
        return Redirect::page('Projeto/form/insert/0');
    }

    /* ============================ UPDATE =========================== */
    public function update()
    {
        $post   = $this->request->getPost();
        $alunos = $post['alunos_id'] ?? [];
        unset($post['alunos_id']);

        /* 1. Atualiza dados do projeto */
        $ok = $this->model->update($post);

        /* 2. Se update OK, sincroniza tabela pivot               */
        if ($ok) {
            $idProjeto = $post['id'];
            $pivot = new ProjetoAlunoModel();

            /* remove vínculos antigos */
            $pivot->db->where('projeto_id', $idProjeto)->delete();

            /* insere novos vínculos */
            foreach ($alunos as $idAluno) {
                $pivot->insert([
                    'projeto_id' => $idProjeto,
                    'aluno_id'   => $idAluno
                ]);
            }
        }

        /* 3. Redireciona de volta */
        return Redirect::page(
            'Projeto',
            $ok ? ['msgSucesso'=>'Alterado com sucesso.'] : []
        );
    }

    /* ============================ DELETE =========================== */
    public function delete()
    {
        $post = $this->request->getPost();
        $ok   = $this->model->delete($post);   // ON DELETE CASCADE remove da pivot

        return Redirect::page(
            'Projeto',
            $ok ? ['msgSucesso'=>'Excluído.'] : []
        );
    }
}
