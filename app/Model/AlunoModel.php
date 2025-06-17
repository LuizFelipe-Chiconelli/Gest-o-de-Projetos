<?php
namespace App\Model;

use Core\Library\ModelMain;

/**
 * Model da tabela aluno
 */
class AlunoModel extends ModelMain
{
    protected $table = 'aluno';

    /* regras p/ Validator (mesma assinatura do ModelMain) */
    public $validationRules = [
        'ra'   => ['label'=>'RA',   'rules'=>'required|min:3|max:20'],
        'nome' => ['label'=>'Nome', 'rules'=>'required|min:3|max:60'],
        'curso'=> ['label'=>'Curso','rules'=>'required|min:3|max:100'],
        'email'=> ['label'=>'Email','rules'=>'required|email|min:5|max:150'],
        /* 1 = ativo / 2 = inativo */
        'statusRegistro' => ['label'=>'Status','rules'=>'required|int']
    ];
}
