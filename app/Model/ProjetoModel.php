<?php
namespace App\Model;

use Core\Library\ModelMain;

class ProjetoModel extends ModelMain
{
    protected $table = 'projeto';

    /** Validação */
    public $validationRules = [
        'titulo'       => ['label'=>'Título',    'rules'=>'required|min:5|max:100'],
        'area'         => ['label'=>'Área',      'rules'=>'required|min:3|max:50'],
        'status'       => ['label'=>'Status',    'rules'=>'required|min:3|max:20'],
        'professor_id' => ['label'=>'Professor', 'rules'=>'required|int'],
        // removido: 'statusRegistro'
    ];

    /** Lista projetos + nome do professor */
    public function listaProjeto(): array
    {
        return $this->db
            ->table('projeto p')
            ->select('p.*, pr.nome AS professor')
            ->join('professor pr', 'pr.id = p.professor_id', 'LEFT')
            ->orderBy('p.titulo')
            ->findAll();
    }
}
