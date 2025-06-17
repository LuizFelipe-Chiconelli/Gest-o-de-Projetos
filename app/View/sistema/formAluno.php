<?= formTitulo('Aluno') ?>

<form method="POST" action="<?= $this->request->formAction() ?>">
  <input type="hidden" name="id" value="<?= setValor('id',0) ?>">

  <div class="row m-2">

    <div class="mb-3 col-lg-4">
      <label class="form-label">RA *</label>
      <input type="text" name="ra" maxlength="20"
             class="form-control"
             value="<?= setValor('ra') ?>" required>
      <?= setMsgFilderError('ra') ?>
    </div>

    <div class="mb-3 col-lg-8">
      <label class="form-label">Nome *</label>
      <input type="text" name="nome" maxlength="60"
             class="form-control"
             value="<?= setValor('nome') ?>" required>
      <?= setMsgFilderError('nome') ?>
    </div>

    <div class="mb-3 col-lg-6">
      <label class="form-label">Curso *</label>
      <input type="text" name="curso" maxlength="100"
             class="form-control"
             value="<?= setValor('curso') ?>" required>
      <?= setMsgFilderError('curso') ?>
    </div>

    <div class="mb-3 col-lg-6">
      <label class="form-label">Email *</label>
      <input type="email" name="email" maxlength="150"
             class="form-control"
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

  </div>

  <div class="m-3">
    <?= formButton() ?>
  </div>
</form>
