<?php
namespace App\Model;

use Core\Library\ModelMain;

/**
 * Model da tabela usuário
 */
class UsuarioModel extends ModelMain
{
    protected $table = 'usuario';

    /* Regras para o Validator (note que “unique” NÃO existe no core) */
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

    /* Busca usuário pelo e-mail (login) */
    public function getUserEmail(string $email): array
    {
        return $this->db->where('email',$email)->first();
    }
}
