<?php

namespace App\Model;

use Core\Library\ModelMain;

class ReuniaoModel extends ModelMain
{
    // nome da tabela no banco
    protected $table = 'reuniao';

    // regras de validação (campo, rótulo, regras)
    public $validationRules = [
        'projeto_id' => [           // FK para o projeto
            'label' => 'Projeto',
            'rules' => 'required|int'
        ],
        'data' => [
            'label' => 'Data',
            'rules' => 'required'
        ],
        'hora' => [
            'label' => 'Hora',
            'rules' => 'required'
        ],
        'local' => [
            'label' => 'Local',
            'rules' => 'required|min:3|max:60'
        ],
        'pauta' => [
            'label' => 'Pauta',
            'rules' => 'required|min:3|max:120'
        ]
    ];
}
