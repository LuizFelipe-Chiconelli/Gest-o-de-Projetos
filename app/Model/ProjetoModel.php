<?php
namespace App\Model;

use Core\Library\ModelMain;

/**
 * Model da tabela PROJETO
 * • Herdamos tudo de ModelMain (conexão, insert, update, delete, validação)
 */
class ProjetoModel extends ModelMain
{
    // Nome exato da tabela no MySQL
    protected $table = 'projeto';

    // Regras de validação (o Validator do core usa isso antes de gravar)
    public $validationRules = [
        'titulo' => [
            'label' => 'Título',
            'rules' => 'required|min:5|max:100'
        ],
        'area' => [
            'label' => 'Área',
            'rules' => 'required|min:3|max:50'
        ],
        'status' => [
            'label' => 'Status',
            'rules' => 'required|min:3|max:20'
        ],
        
        'professor_id' => [
        'label' => 'Professor',
        'rules' => 'required|int'
],

        // ADICIONAR OUTRAS ...(A FAZER)
    ];
}
