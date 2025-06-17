<?php
namespace App\Model;

use Core\Library\ModelMain;

class ProjetoModel extends ModelMain
{
    protected $table = 'projeto';

    /* regras de validação – mesma assinatura do ModelMain */
    public $validationRules = [
        'titulo'       => ['label'=>'Título',    'rules'=>'required|min:5|max:100'],
        'area'         => ['label'=>'Área',      'rules'=>'required|min:3|max:50'],
        'status'       => ['label'=>'Status',    'rules'=>'required|min:3|max:20'],
        'professor_id' => ['label'=>'Professor', 'rules'=>'required|int'],
        /* campos opcionais: inicio, previsao_termino, resumo */
    ];

    /** lista projetos + nome do professor (JOIN) */
    public function listaProjeto(): array
    {
        return $this->db
            ->select('projeto.*, professor.nome AS professor')
            ->join('professor','professor.id = projeto.professor_id')
            ->orderBy('titulo')
            ->findAll();
    }
}
