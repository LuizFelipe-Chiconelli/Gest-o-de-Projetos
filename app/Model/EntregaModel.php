<?php
/*
 * Model Entrega, faz upload de arquivo do projeto
*/
namespace App\Model;
use Core\Library\ModelMain;

class EntregaModel extends ModelMain
{
    protected $table = 'entrega';

    public $validationRules = [
        'projeto_id' => ['label'=>'Projeto','rules'=>'required|int'],
        'descricao'  => ['label'=>'Descrição','rules'=>'required|min:3|max:120'],
        'data'       => ['label'=>'Data','rules'=>'required'],
        'status'     => ['label'=>'Status','rules'=>'required|min:3|max:20']
    ];
}
