<?php
namespace App\Model;

use Core\Library\ModelMain;

/**
 * Model da tabela entrega
 * – herda CRUD + validação de ModelMain
 */
class EntregaModel extends ModelMain
{
    protected $table = 'entrega';

    /* regras para o Validator */
    public $validationRules = [
        'projeto_id' => ['label'=>'Projeto',   'rules'=>'required|int'],
        'descricao'  => ['label'=>'Descrição', 'rules'=>'required|min:3|max:120'],
        'data'       => ['label'=>'Data',       'rules'=>'required'],
        'status'     => ['label'=>'Status',     'rules'=>'required|min:3|max:20']
        /* campo arquivo não entra aqui – é opcional e tratado no controller */
    ];
}
