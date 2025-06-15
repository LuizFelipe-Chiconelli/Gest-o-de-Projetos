<?= formTitulo('Aluno') ?>

<form method="POST" action="<?= $this->request->formAction() ?>">
  <input type="hidden" name="id" value="<?= setValor('id',0) ?>">

  <div class="row m-2">

    <div class="mb-3 col-4">
      <label class="form-label">RA *</label>
      <input type="text" name="ra" class="form-control"
             maxlength="20" value="<?= setValor('ra') ?>" required>
      <?= setMsgFilderError('ra') ?>
    </div>

    <div class="mb-3 col-8">
      <label class="form-label">Nome *</label>
      <input type="text" name="nome" class="form-control"
             maxlength="60" value="<?= setValor('nome') ?>" required>
      <?= setMsgFilderError('nome') ?>
    </div>

    <div class="mb-3 col-6">
      <label class="form-label">Curso *</label>
      <input type="text" name="curso" class="form-control"
             maxlength="100" value="<?= setValor('curso') ?>" required>
      <?= setMsgFilderError('curso') ?>
    </div>

    <div class="mb-3 col-6">
      <label class="form-label">Email *</label>
      <input type="email" name="email" class="form-control"
             maxlength="150" value="<?= setValor('email') ?>" required>
      <?= setMsgFilderError('email') ?>
    </div>

    <div class="mb-3 col-3">
      <label class="form-label">Status *</label>
      <select name="statusRegistro" class="form-select" required>
        <option value="1" <?= setValor('statusRegistro','1')=='1'?'selected':'' ?>>Ativo</option>
        <option value="2" <?= setValor('statusRegistro')=='2'?'selected':'' ?>>Inativo</option>
      </select>
      <?= setMsgFilderError('statusRegistro') ?>
    </div>

  </div>

  <div class="m-3 text-end">
    <?= formButton() ?>
  </div>
</form>
