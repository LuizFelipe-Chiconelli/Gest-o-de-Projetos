<?php
namespace App\Model;

use Core\Library\ModelMain;

/**
 * Model da tabela aluno
 */
class AlunoModel extends ModelMain
{
    protected $table = 'aluno';

    /** Regras de validação */
    public $validationRules = [
        'ra'    => ['label'=>'RA',    'rules'=>'required|min:3|max:20'],
        'nome'  => ['label'=>'Nome',  'rules'=>'required|min:3|max:60'],
        'curso' => ['label'=>'Curso', 'rules'=>'required|min:3|max:100'],
        'email' => ['label'=>'Email', 'rules'=>'required|email|min:5|max:150'],
        'statusRegistro' => ['label'=>'Status','rules'=>'required|int']  // 1 = ativo / 2 = inativo
    ];

    /**
     * Lista alunos com o curso (curso já é coluna da própria tabela)
     */
    public function listaComCurso(string $orderBy = 'nome'): array
    {
        return $this->db
            ->table('aluno')
            ->select('id, nome, curso')   // curso está na mesma tabela
            ->orderBy($orderBy)
            ->findAll();
    }
}
