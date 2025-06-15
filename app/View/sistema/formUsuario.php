<?php
/*-----------------------------------------------------------------
 |  Formulário de Usuário
 |  – Usado tanto para insert quanto update / delete / view
 |  – Campos obrigatórios validados pelo UsuarioModel::$validationRules
 *----------------------------------------------------------------*/
?>

<?= formTitulo('Usuário') ?>

<form method="POST" action="<?= $this->request->formAction() ?>">

    <!-- id = 0 quando for “novo” -->
    <input type="hidden" id="id" name="id" value="<?= setValor('id',0) ?>">
    <input type="hidden" name="action" value="<?= $this->request->getAction() ?>">

    <div class="row m-2">

        <!-- NOME ------------------------------------------------------- -->
        <div class="mb-3 col-8">
            <label class="form-label" for="nome">Nome *</label>
            <input  type="text"
                    class="form-control"
                    id="nome"
                    name="nome"
                    maxlength="60"
                    value="<?= setValor('nome') ?>"
                    required
                    autofocus>
            <?= setMsgFilderError('nome') ?>
        </div>

        <!-- NÍVEL ------------------------------------------------------ -->
        <div class="mb-3 col-4">
            <label class="form-label" for="nivel">Nível *</label>
            <select class="form-select" id="nivel" name="nivel" required>
                <option value="">…</option>
                <option value="1"  <?= setValor('nivel')=='1' ? 'selected':'' ?>>Super-Admin</option>
                <option value="11" <?= setValor('nivel')=='11' ? 'selected':'' ?>>Administrador</option>
                <option value="21" <?= setValor('nivel','21')=='21' ? 'selected':'' ?>>Usuário</option>
            </select>
            <?= setMsgFilderError('nivel') ?>
        </div>

        <!-- E-MAIL ----------------------------------------------------- -->
        <div class="mb-3 col-8">
            <label class="form-label" for="email">E-mail *</label>
            <input  type="email"
                    class="form-control"
                    id="email"
                    name="email"
                    maxlength="150"
                    value="<?= setValor('email') ?>"
                    required>
            <?= setMsgFilderError('email') ?>
        </div>

        <!-- STATUS ----------------------------------------------------- -->
        <div class="mb-3 col-4">
            <label class="form-label" for="statusRegistro">Status *</label>
            <select class="form-select" id="statusRegistro" name="statusRegistro" required>
                <option value="1" <?= setValor('statusRegistro','1')=='1' ? 'selected':'' ?>>Ativo</option>
                <option value="2" <?= setValor('statusRegistro')=='2' ? 'selected':'' ?>>Inativo</option>
            </select>
            <?= setMsgFilderError('statusRegistro') ?>
        </div>

        <?php if (in_array($this->request->getAction(), ['insert','update'])): ?>
            <!-- SENHA (só em insert ou quando admin deseja trocar) -->
            <div class="mb-3 col-6">
                <label class="form-label" for="senha">Senha <?= $this->request->getAction()=='insert' ? '*' : '' ?></label>
                <input  type="password"
                        class="form-control"
                        id="senha"
                        name="senha"
                        placeholder="<?= $this->request->getAction()=='insert' ? 'Obrigatória' : 'Preencha para alterar' ?>"
                        <?= $this->request->getAction()=='insert' ? 'required' : '' ?>>
                <?= setMsgFilderError('senha') ?>
            </div>

            <div class="mb-3 col-6">
                <label class="form-label" for="confSenha">Confirmar senha</label>
                <input  type="password"
                        class="form-control"
                        id="confSenha"
                        name="confSenha"
                        placeholder="Confirme a senha"
                        <?= $this->request->getAction()=='insert' ? 'required' : '' ?>>
                <?= setMsgFilderError('confSenha') ?>
            </div>
        <?php endif; ?>

    </div>

    <!-- BOTÕES -------------------------------------------------------- -->
    <div class="m-3">
        <?= formButton() ?>
    </div>
</form>
