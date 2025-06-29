<?php
namespace App\Model;

use Core\Library\ModelMain;

/**
 * Model da tabela "usuariorecuperasenha"
 * Responsável por gerenciar os links de recuperação de senha enviados por e-mail
 */
class UsuarioRecuperaSenhaModel extends ModelMain
{
    // Define a tabela que será manipulada por este model
    protected $table = "usuariorecuperasenha";

    /**
     * Busca uma chave de recuperação válida e ativa no banco de dados
     *
     * @param string $chave - Código único gerado e enviado por e-mail
     * @return array - Retorna os dados da chave se válida, ou array vazio se inválida
     */
    public function getRecuperaSenhaChave($chave) 
    {
        return $this->db
            ->where([
                "statusRegistro" => 1, // Somente chaves ativas
                "chave" => $chave      // Compara o código gerado
            ])
            ->first(); // Retorna o primeiro registro encontrado
    }

    /**
     * Desativa uma chave específica (quando for usada ou expirada)
     *
     * @param int $id - ID da chave que será desativada
     * @return bool - true se atualização feita com sucesso
     */
    function desativaChave($id) 
    {
        $rs = $this->db
            ->where(["id" => $id])
            ->update([
                "statusRegistro" => 2,               // Marca como inativa
                "updated_at" => date("Y-m-d H:i:s")  // Atualiza data da ação
            ]);

        return $rs > 0;
    }

    /**
     * Desativa todas as chaves antigas de um usuário (antes de gerar uma nova)
     *
     * @param int $usuarioId - ID do usuário
     * @return bool - true se ao menos uma chave foi desativada
     */
    function desativaChaveAntigas($usuarioId) 
    {
    $rs = $this->db
        ->where([
            "usuario_id" => $usuarioId,
            "statusRegistro" => 1 // Somente as que ainda estão ativas
        ])
        ->update([
            "statusRegistro" => 2,
            "updated_at" => date("Y-m-d H:i:s")
        ]);

    return $rs > 0;
    }

}
