<?php
/*  Formulário - Trocar Senha
    – recebe id, nome, email a partir da sessão
-------------------------------------------------------------*/
use Core\Library\Session;
$idUsuario = Session::get('userId');
?>
<h2 class="mt-4">Trocar Senha</h2>

<form method="POST"
      action="<?= baseUrl()?>usuario/updateNovaSenha"
      class="col-md-6">

    <!-- Será usado no update -->
    <input type="hidden" name="id" value="<?= $idUsuario ?>">

    <div class="mb-3">
        <label for="senhaAtual" class="form-label">Senha atual *</label>
        <input type="password" name="senhaAtual" id="senhaAtual"
               class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="novaSenha" class="form-label">Nova senha *</label>
        <input type="password" name="novaSenha" id="novaSenha"
               class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="novaSenha2" class="form-label">Confirme a nova senha *</label>
        <input type="password" name="novaSenha2" id="novaSenha2"
               class="form-control" required>
    </div>

    <div class="d-flex gap-2">
        <button class="btn btn-primary">Atualizar</button>
        <a href="<?= baseUrl()?>sistema" class="btn btn-outline-secondary">Cancelar</a>
    </div>

    <?= exibeAlerta() /* helper para mensagens */ ?>
</form>
