<?php
namespace App\Model;

use Core\Library\ModelMain;

/**
 * Model da tabela professor
 * –  herdamos insert / update / delete / validação de ModelMain
 */
class ProfessorModel extends ModelMain
{
    /** nome exato da tabela */
    protected $table = 'professor';

    /** regras de validação – assinatura SEM tipagem (igual ao ModelMain) */
    public $validationRules = [
        'nome' => [
            'label' => 'Nome',
            'rules' => 'required|min:3|max:60'
        ],
        'email' => [
            'label' => 'Email',
            'rules' => 'required|email|min:5|max:150'
        ],
        'especialidade' => [
            'label' => 'Especialidade',
            'rules' => 'required|min:3|max:50'
        ],
        /* campo “area” é opcional na tabela → sem “required” */
        'area' => [
            'label' => 'Área',
            'rules' => 'min:3|max:50'
        ],
        /* 1-ativo  2-inativo */
        'statusRegistro' => [
            'label' => 'Status',
            'rules' => 'required|int'
        ]
    ];
}
