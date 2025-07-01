<?php
namespace App\Model;

use Core\Library\ModelMain;

class ProjetoAlunoModel extends ModelMain
{
    protected $table = 'projeto_aluno';

    /**
     * Retorna todos os projetos ligados ao usuário logado (aluno)
     */
    public function listarProjetosDoAluno(int $usuarioId): array
    {
        return $this->db
            ->table('projeto p')
            ->select('p.*')
            ->join('projeto_aluno pa', 'pa.projeto_id = p.id', 'INNER')
            ->join('aluno a', 'a.id = pa.aluno_id', 'INNER')
            ->where('a.usuario_id', $usuarioId)
            ->orderBy('p.titulo')
            ->findAll();
    }
}
