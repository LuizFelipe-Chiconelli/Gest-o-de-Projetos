<?php
namespace App\Model;

use Core\Library\ModelMain;

class ReuniaoAlunoModel extends ModelMain
{
    protected $table = 'reuniao';

    /** reuniões dos projetos onde o aluno (usuario id) participa */
    public function listarReunioesDoAluno(int $usuarioId): array
    {
        return $this->db
            ->table('reuniao r')
            ->select('r.*, p.titulo   AS titulo')   // <- alias é "titulo"
            ->join  ('projeto p',      'p.id = r.projeto_id')
            ->join  ('projeto_aluno pa','pa.projeto_id = p.id')
            ->join  ('aluno a',        'a.id = pa.aluno_id')
            ->where ('a.usuario_id',   $usuarioId)
            ->orderBy('r.data,r.hora')
            ->findAll();
    }

}
