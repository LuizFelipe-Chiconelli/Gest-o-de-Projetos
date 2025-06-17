<?php
namespace App\Model;

use Core\Library\ModelMain;

class ReuniaoModel extends ModelMain
{
    /* Nome da tabela */
    protected $table = 'reuniao';

    /* Regras de validação — mesma assinatura do ModelMain */
    public $validationRules = [
        'projeto_id' => ['label'=>'Projeto', 'rules'=>'required|int'],
        'data'       => ['label'=>'Data',    'rules'=>'required'],
        'hora'       => ['label'=>'Hora',    'rules'=>'required'],
        'local'      => ['label'=>'Local',   'rules'=>'required|min:3|max:60'],
        'pauta'      => ['label'=>'Pauta',   'rules'=>'required|min:3|max:120']
        // observacoes → opcional
    ];

    /** Lista reunindo título do projeto */
    public function listaReuniao(): array
    {
        return $this->db
            ->select('reuniao.*, projeto.titulo')
            ->join('projeto', 'projeto.id = reuniao.projeto_id')
            ->orderBy('reuniao.data', 'DESC')
            ->findAll();
    }
}
