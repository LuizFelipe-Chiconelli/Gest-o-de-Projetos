<?php
namespace App\Model;

use Core\Library\ModelMain;

/**
 * Model da tabela Aluno    
 * Herdamos tudo de ModelMain (conexão, insert, update, delete, validação)
 * 
 */

class AlunoModel extends ModelMain
{
    //Nome exato da tabela no MySQL
    protected $table = 'aluno';

    //Regras de validação (o validator do core usa isso antes de gravar)
    public $validationRules = [
        'ra' => [
            'label' => 'RA',
            'rules' => 'required|min:3|max:20'
        ],
        'nome' => [
            'label' => 'Nome',
            'rules' => 'required|min:3|max:60'
        ],
        'curso' => [
            'label' => 'Curso',
            'rules' => 'required|min:3|max:100'
        ],
        'email' => [
            'label' => 'Email',
            'rules' => 'required|email|min:5|max:150'
        ],
        'statusRegistro' => [
            'label' => 'Status',
            'rules' => 'required|int'
        ]
    ];
}