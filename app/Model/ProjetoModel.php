<?php
namespace App\Model;

use Core\Library\ModelMain;

class ProjetoModel extends ModelMain
{
     protected $table = 'projeto';
    /** Validação --------------------------------------------------------- */
    public $validationRules = [
        'titulo'            => ['label'=>'Título',             'rules'=>'required|min:5|max:100'],
        'area'              => ['label'=>'Área',               'rules'=>'required|min:3|max:50'],
        'status'            => ['label'=>'Status',             'rules'=>'required|min:3|max:20'],
        'professor_id'      => ['label'=>'Professor',          'rules'=>'required|int'],
        'inicio'            => ['label'=>'Data início',        'rules'=>'required|date|callback_validaDataHoje'],
        'previsao_termino'  => ['label'=>'Previsão término',   'rules'=>'date|callback_validaDataFim'],
    ];
    /** Mensagens amigáveis (opcional) ----------------------------------- */
    public $validationMessages = [
        'inicio.validaDataHoje'           => 'A data de início não pode ser anterior a hoje.',
        'previsao_termino.validaDataFim'  => 'A previsão de término deve ser maior ou igual à data de início e no máximo 1 ano depois.',
    ];

    /** = início ≥ hoje */
    protected function validaDataHoje($attr, $value)
    {
        $data = \DateTime::createFromFormat('Y-m-d', $value);
        return $data && $data >= (new \DateTime('today'));
    }

    /** = fim ≥ início && fim ≤ início+1 ano */
    protected function validaDataFim($attr, $value, $params, $validator)
    {
        // Se campo vazio, ok (é opcional)
        if (!$value) return true;

        $dados  = $validator->getData();               // todas as entradas
        $inicio = $dados['inicio'] ?? null;

        $dtIni = \DateTime::createFromFormat('Y-m-d', $inicio);
        $dtFim = \DateTime::createFromFormat('Y-m-d', $value);

        if (!$dtIni || !$dtFim) return false;          // formato inválido

        // >= início ?
        if ($dtFim < $dtIni) return false;

        // ≤ início + 1 ano ?
        $umAnoDepois = (clone $dtIni)->modify('+1 year');
        return $dtFim <= $umAnoDepois;
    }


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
