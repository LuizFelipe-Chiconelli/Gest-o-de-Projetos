<?php
/*
 *
 *  Model ProjetoAluno  (tabela pivot projeto × aluno)
 *
*/
namespace App\Model;

use Core\Library\ModelMain;

class ProjetoAlunoModel extends ModelMain
{

    protected $table = 'projeto_aluno';

    public $validationRules = [];
}
