<?php

/**
 * Gera o conteúdo do e-mail de recuperação de senha
 *
 * @param string $cLink - Link de recuperação
 * @return array - Assunto e corpo do e-mail com HTML formatado
 */
function emailRecuperacaoSenha($cLink)
{
    return [
        'assunto' => 'Recuperação de Senha',
        'corpo' => "
            <div style='font-family: Arial, sans-serif; background-color: #f5f5f5; padding: 20px; border-radius: 8px;'>
                <h2 style='color: #1a73e8;'>Recuperação de Senha</h2>
                <p style='color: #333;'>Olá,</p>
                <p style='color: #333;'>Recebemos uma solicitação para redefinir sua senha.</p>
                <p>
                    <a href='{$cLink}' style='display: inline-block; padding: 10px 20px; background-color: #1a73e8; color: white; text-decoration: none; border-radius: 4px;'>Redefinir Senha</a>
                </p>
                <p style='color: #999; font-size: 12px;'>Se você não solicitou, ignore este e-mail.</p>
            </div>
        "
    ];
}
