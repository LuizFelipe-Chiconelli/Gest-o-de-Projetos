<?php
/*  View super-simples de boas-vindas
 *  Recebe $nome e $nivel da controller
 */
use Core\Library\Session;
/* pega o nível gravado na sessão (1, 11, 21...) */
$nivel = (int) Session::get('userNivel');
?>
<div class="mt-4">
    <h4>Seja bem-vindo(a)</h4>
    <p>Este é o painel inicial do seu Site!.</p>

    <?php if ($nivel <= 10): ?>
        <p class="text-success">✦ Você é administrador – tem acesso total.</p>
    <?php else: ?>
        <p class="text-secondary">✦ Perfil de usuário comum.</p>
    <?php endif; ?>
</div>
 