<?php
namespace App\Model;

use Core\Library\ModelMain;

class EntregaModel extends ModelMain
{
    protected $table = 'entrega';

    /* lista só as entregas ligadas a um aluno (via projeto_aluno) */
    public function listarEntregasDoAluno(int $usuarioId): array
    {
        return $this->db
            ->table('entrega e')
            ->select('e.*, p.titulo AS titulo_projeto')
            ->join('projeto p',        'p.id = e.projeto_id')
            ->join('projeto_aluno pa', 'pa.projeto_id = p.id')
            ->join('aluno a',          'a.id = pa.aluno_id')
            ->where('a.usuario_id', $usuarioId)
            ->orderBy('e.data DESC')
            ->findAll();
    }
}
