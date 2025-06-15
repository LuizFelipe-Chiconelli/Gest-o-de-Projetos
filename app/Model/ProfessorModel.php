<?php
namespace App\Model;

use Core\Library\ModelMain;

/**
 * Model da tabela Professor
 * Herdamos tudo de ModelMain (conexão, insert, update, delete, validação)
 * 
 */

class ProfessorModel extends ModelMain
{
    //Nome exato da tabela no MySQL
    protected $table = 'professor';

    //Regras de validação (o validator do core usa isso antes de gravar)
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
        
        // Status: 1 = ativo, 2 = inativo
        'statusRegistro' => [
            'label' => 'Status',
            'rules' => 'required|int'
        ]
        
    ];
}