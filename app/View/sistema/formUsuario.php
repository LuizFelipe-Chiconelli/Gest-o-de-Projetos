<?= formTitulo('Usuário') ?>

<form method="POST" action="<?= $this->request->formAction() ?>">
  <input type="hidden" name="id"     value="<?= setValor('id',0) ?>">
  <input type="hidden" name="action" value="<?= $this->request->getAction() ?>">

  <div class="row m-2">
    <div class="mb-3 col-lg-8">
      <label class="form-label">Nome *</label>
      <input type="text" name="nome" maxlength="60" class="form-control"
             value="<?= setValor('nome') ?>" required>
      <?= setMsgFilderError('nome') ?>
    </div>

    <div class="mb-3 col-lg-4">
      <label class="form-label">Nível *</label>
      <select name="nivel" class="form-select" required>
        <option value="">…</option>
        <option value="1"  <?= setValor('nivel')=='1'  ?'selected':'' ?>>Super-Admin</option>
        <option value="11" <?= setValor('nivel')=='11' ?'selected':'' ?>>Administrador</option>
        <option value="21" <?= setValor('nivel','21')=='21'?'selected':'' ?>>Usuário</option>
      </select>
      <?= setMsgFilderError('nivel') ?>
    </div>

    <div class="mb-3 col-lg-8">
      <label class="form-label">E-mail *</label>
      <input type="email" name="email" maxlength="150" class="form-control"
             value="<?= setValor('email') ?>" required>
      <?= setMsgFilderError('email') ?>
    </div>

    <div class="mb-3 col-lg-4">
      <label class="form-label">Status *</label>
      <select name="statusRegistro" class="form-select" required>
        <option value="1" <?= setValor('statusRegistro','1')=='1'?'selected':'' ?>>Ativo</option>
        <option value="2" <?= setValor('statusRegistro')=='2'?'selected':'' ?>>Inativo</option>
      </select>
      <?= setMsgFilderError('statusRegistro') ?>
    </div>

    <?php if (in_array($this->request->getAction(),['insert','update'])): ?>
      <div class="mb-3 col-lg-6">
        <label class="form-label">Senha <?= $this->request->getAction()=='insert'?'*':'' ?></label>
        <input type="password" name="senha" class="form-control"
               <?= $this->request->getAction()=='insert'?'required':'' ?>>
      </div>

      <div class="mb-3 col-lg-6">
        <label class="form-label">Confirmar senha</label>
        <input type="password" name="confSenha" class="form-control"
               <?= $this->request->getAction()=='insert'?'required':'' ?>>
      </div>
    <?php endif; ?>
  </div>

  <div class="m-3">
    <?= formButton() ?>
  </div>
</form>
