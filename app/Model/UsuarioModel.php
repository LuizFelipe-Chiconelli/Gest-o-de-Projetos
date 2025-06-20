<?php
namespace App\Model;

use Core\Library\ModelMain;

class UsuarioModel extends ModelMain
{
    protected $table = 'usuario';

    public $validationRules = [
        'nome' => [
            'label' => 'Nome',
            'rules' => 'required|min:3|max:60'
        ],
        'email' => [
            'label'=>'E-mail',
            'rules'=>'required|email|min:5|max:150|unique:usuario,email'
        ],
        'nivel' => [
            'label' => 'Nível',
            'rules' => 'required|int'
        ],
        'statusRegistro' => [
            'label' => 'Status',
            'rules' => 'required|int'
        ]
    ];

    public function insertReturnId(array $dados): ?int
    {
        return $this->db->table($this->table)->insert($dados);
    }

    public function getUserEmail(string $email): array
    {
        return $this->db
            ->table($this->table)
            ->where('email', $email)
            ->first();
    }

    /**
     * Retorna usuários com nível de professor (21) não vinculados à tabela professor
     * ou o atual (em edição)
     */
    public function getProfessoresSemVinculoOuAtual($usuario_id = null)
    {
        // 1. Buscar todos os IDs de usuário já vinculados a professor
        $sql = "SELECT usuario_id FROM professor WHERE usuario_id IS NOT NULL";
        $rsc = $this->db->dbSelect($sql);
        $vinculados = [];

        while ($row = $this->db->dbBuscaArray($rsc)) {
            if (!empty($row['usuario_id'])) {
                $vinculados[] = $row['usuario_id'];
            }
        }

        // 2. Remove o atual, se for edição
        if ($usuario_id && in_array($usuario_id, $vinculados)) {
            $vinculados = array_diff($vinculados, [$usuario_id]);
        }

        // 3. Inicia query de busca
        $query = $this->db
            ->table($this->table)
            ->where(['nivel' => 21, 'statusRegistro' => 1]);

        // 4. Se tiver vínculos, aplica o filtro NOT IN
        if (!empty($vinculados)) {
            $query->whereNotIn('id', $vinculados);
        }

        return $query->findAll();
    }
}
